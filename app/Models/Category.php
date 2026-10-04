<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_kategori',
        'slug',
    ];

    public function setNamaKategoriAttribute($value): void
    {
        $this->attributes['nama_kategori'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'kategori_id');
    }
}
