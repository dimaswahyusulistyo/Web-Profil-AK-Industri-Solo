<?php

namespace App\Filament\Resources\KontenBiasas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Hidden;

class KontenBiasaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            TextInput::make('judul')
                ->label('Judul')
                ->required()
                ->live(debounce: 300)
                ->afterStateUpdated(function ($state, $set, $get) {
                    if (! $get('slug_manual')) {
                        $set('url_halaman', str($state)->slug());
                    }
                }),

            TextInput::make('url_halaman')
                ->label('Slug / URL')
                ->required()
                ->unique(ignoreRecord: true)
                ->helperText('Slug otomatis dari judul, bisa diubah manual')
                ->afterStateUpdated(fn ($set) => $set('slug_manual', true)),

            Hidden::make('slug_manual')
                ->default(false),

            RichEditor::make('konten')
                ->label('Isi Konten')
                ->columnSpanFull()
                ->dehydrated() 
                ->nullable(),

            TextInput::make('embed_url')
                ->label('Embed URL')
                ->nullable()
                ->helperText('Masukkan URL embed, misal Google forms.'),
        ]);
    }
}
