<?php

namespace App\Filament\Resources\AspirasiAduans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AspirasiAduanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                Textarea::make('pesan')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('tanggapan')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
