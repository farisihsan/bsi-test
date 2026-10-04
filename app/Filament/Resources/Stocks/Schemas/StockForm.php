<?php

namespace App\Filament\Resources\Stocks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_barang')
                    ->label('Kode Barang')
                    ->required(),
                TextInput::make('nama_barang')
                    ->required(),
                Select::make('kategori_id')
                    ->relationship('category', 'nama_kategori')
                    ->required(),
                TextInput::make('satuan')
                    ->label('Satuan')
                    ->required(),
                TextInput::make('stok')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->dehydrated(false)
                    ->helperText('Stok akan dihitung secara otomatis.'),
            ]);
    }
}
