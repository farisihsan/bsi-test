<?php

namespace App\Filament\Resources\ApiKeys\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ApiKeyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                TextInput::make('key')
                    ->label('Key')
                    ->required(),
            ]);
    }
}
