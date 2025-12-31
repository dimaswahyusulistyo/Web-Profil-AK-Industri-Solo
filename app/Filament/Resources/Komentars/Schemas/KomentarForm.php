<?php

namespace App\Filament\Resources\Komentars\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class KomentarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required()
                    ->disabled(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->default(null)
                    ->disabled(),
                Textarea::make('isi_komentar')
                    ->required()
                    ->columnSpanFull()
                    ->disabled(),
                TextInput::make('commentable_type')
                    ->required()
                    ->disabled(),
                TextInput::make('commentable_id')
                    ->required()
                    ->numeric()
                    ->disabled(),
                Textarea::make('tanggapan')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('is_approved')
                    ->required(),
            ]);
    }
}
