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

            \Filament\Forms\Components\Select::make('form_id')
                ->label('Pilih Form Dinamis (Internal)')
                ->relationship('form', 'name')
                ->searchable()
                ->preload()
                ->nullable()
                ->helperText('Pilih jika ingin menyertakan form yang dibuat di sistem internal.'),

            \Filament\Schemas\Components\Section::make('Link Button (Opsional)')
                ->description('Tambahkan tombol klik jika halaman ini merujuk ke link luar atau internal tertentu.')
                ->schema([
                    TextInput::make('button_text')
                        ->label('Teks Tombol')
                        ->placeholder('Contoh: Unduh Berkas'),
                    TextInput::make('button_url')
                        ->label('Link Terkait / URL Button')
                        ->placeholder('Contoh: https://example.com')
                        ->url(),
                ])
                ->columns(2),
        ]);
    }
}
