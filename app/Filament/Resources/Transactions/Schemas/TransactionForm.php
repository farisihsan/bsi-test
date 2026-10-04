<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Models\Stock;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class TransactionForm
{
    
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('barang_id')
                    ->relationship('stock', 'nama_barang')
                    ->required(),
                Select::make('tipe_transaksi')
                    ->options(['masuk' => 'Masuk', 'keluar' => 'Keluar'])
                    ->required(),
                DatePicker::make('tanggal')
                    ->required()
                    ->default(now()),
                TextInput::make('jumlah')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->rules([
                        fn (Get $get) => function ($attribute, $value, $fail) use ($get) {
                            $availableStock = Stock::query()
                                ->whereKey($get('barang_id'))
                                ->value('stok');

                            if (
                                $get('tipe_transaksi') === 'keluar'
                                && $availableStock !== null
                                && (int) $value > (int) $availableStock
                            ) {
                                $fail('Jumlah keluar tidak boleh melebihi stok yang tersedia.');
                            }
                        },
                    ]),
            ]);
    }
}

