<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = ['kode_barang', 'nama_barang','slug', 'kategori_id', 'satuan', 'stok'];

    public function setKodeBarangAttribute($value):void {
        $this->attributes ['kode_barang'] = $value;
        $this->attributes ['slug'] = Str::slug($value);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'barang_id');
    }
}
