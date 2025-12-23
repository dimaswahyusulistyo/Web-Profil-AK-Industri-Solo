<?php

namespace App\Filament\Resources\Beritas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Hidden;

class BeritaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            TextInput::make('judul')
                ->label('Judul Berita')
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

            Select::make('kategori_id')
                ->label('Kategori')
                ->relationship('kategori', 'nama_kategori')
                ->searchable()
                ->preload()
                ->nullable(),

            FileUpload::make('thumbnail')
                ->label('Thumbnail')
                ->image()
                ->directory('berita')
                ->imageEditor()
                ->nullable(),

            RichEditor::make('konten')
                ->label('Konten Berita')
                ->required()
                ->columnSpanFull()
                ->fileAttachmentsDisk('public')
                ->fileAttachmentsDirectory('berita/konten')
                ->fileAttachmentsVisibility('public'),

        ]);
    }
}
