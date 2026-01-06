<?php

namespace App\Filament\Resources\KategoriBeritas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;

class KategoriBeritaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('nama_kategori')
                ->label('Nama Kategori')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, $set, $get) {
                    if (! $get('slug_manual')) {
                        $set('url_halaman', str($state)->slug());
                    }
                }),

            TextInput::make('url_halaman')
                ->label('Slug / URL')
                ->required()
                ->unique(ignoreRecord: true)
                ->afterStateUpdated(fn ($set) => $set('slug_manual', true)),

            Hidden::make('slug_manual')
                ->default(false),
        ]);
    }
}
