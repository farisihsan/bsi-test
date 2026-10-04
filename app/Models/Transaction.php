<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'barang_id',
        'tipe_transaksi',
        'jumlah',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $transaction): void {
            if (filter_var($transaction->jumlah, FILTER_VALIDATE_INT) === false || (int) $transaction->jumlah < 1) {
                throw ValidationException::withMessages([
                    'jumlah' => 'Jumlah transaksi harus berupa bilangan bulat minimal 1.',
                ]);
            }
        });

        static::created(function (self $transaction): void {
            $transaction->adjustStock([
                [$transaction->barang_id, $transaction->stockDelta()],
            ]);
        });

        static::updated(function (self $transaction): void {
            $transaction->adjustStock([
                [
                    $transaction->getRawOriginal('barang_id'),
                    -self::deltaFor(
                        $transaction->getRawOriginal('tipe_transaksi'),
                        (int) $transaction->getRawOriginal('jumlah'),
                    ),
                ],
                [$transaction->barang_id, $transaction->stockDelta()],
            ]);
        });

        static::deleted(function (self $transaction): void {
            $transaction->adjustStock([
                [
                    $transaction->getRawOriginal('barang_id'),
                    -self::deltaFor(
                        $transaction->getRawOriginal('tipe_transaksi'),
                        (int) $transaction->getRawOriginal('jumlah'),
                    ),
                ],
            ]);
        });
    }

    public function save(array $options = []): bool
    {
        return DB::transaction(fn (): bool => parent::save($options));
    }

    public function delete(): ?bool
    {
        return DB::transaction(fn (): ?bool => parent::delete());
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'barang_id');
    }

    private function stockDelta(): int
    {
        return self::deltaFor($this->tipe_transaksi, (int) $this->jumlah);
    }

    private static function deltaFor(string $type, int $quantity): int
    {
        return $type === 'masuk' ? $quantity : -$quantity;
    }

    /**
     * @param  array<array{0: int|string|null, 1: int}>  $changes
     */
    private function adjustStock(array $changes): void
    {
        $changesByStock = [];

        foreach ($changes as [$stockId, $change]) {
            if ($stockId === null) {
                continue;
            }

            $changesByStock[$stockId] = ($changesByStock[$stockId] ?? 0) + $change;
        }

        foreach (array_filter($changesByStock) as $stockId => $change) {
            $stockQuery = Stock::whereKey($stockId);

            if ($change < 0) {
                $stockQuery->where('stok', '>=', abs($change));
            }

            $updated = $change > 0
                ? $stockQuery->increment('stok', $change)
                : $stockQuery->decrement('stok', abs($change));

            if (! $updated) {
                throw ValidationException::withMessages([
                    'jumlah' => 'Stok keluar tidak boleh melebihi stok yang tersedia.',
                ]);
            }
        }
    }
}
