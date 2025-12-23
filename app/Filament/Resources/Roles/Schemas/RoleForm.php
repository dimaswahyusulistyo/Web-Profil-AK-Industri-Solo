<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('nama_role')
                ->label('Nama Role')
                ->required()
                ->maxLength(100),
        ]);
    }
}
