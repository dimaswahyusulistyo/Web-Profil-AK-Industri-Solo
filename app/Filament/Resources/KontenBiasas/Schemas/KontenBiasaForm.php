<?php

namespace App\Filament\Resources\KontenBiasas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Group;

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

            \Filament\Forms\Components\Repeater::make('embeds')
                ->label('Embeds (Google Maps / Youtube / Forms)')
                ->schema([
                    TextInput::make('url')
                        ->label('URL Embed')
                        ->required(),
                    TextInput::make('description')
                        ->label('Keterangan (Opsional)'),
                ])
                ->columnSpanFull(),

            \Filament\Schemas\Components\Group::make()
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    \Filament\Schemas\Components\Section::make('Grup Link Informasi')
                        ->description('Tambahkan grup link informasi (misal: "Institusi", "Akademik") yang berisi daftar link terkait.')
                        ->schema([
                            \Filament\Forms\Components\Repeater::make('link_groups')
                                ->label('Daftar Grup')
                                ->schema([
                                    TextInput::make('title')
                                        ->label('Judul Grup')
                                        ->placeholder('Contoh: Institusi')
                                        ->required(),
                                    
                                    \Filament\Forms\Components\Repeater::make('links')
                                        ->label('Daftar Link')
                                        ->schema([
                                            TextInput::make('text')
                                                ->label('Teks Link')
                                                ->placeholder('Contoh: Visi Misi')
                                                ->required(),
                                            TextInput::make('url')
                                                ->label('URL Link')
                                                ->placeholder('https://...')
                                                ->url()
                                                ->required(),
                                        ])
                                ])
                                ->columnSpanFull(),
                        ])
                        ->columnSpan(1),

                    \Filament\Schemas\Components\Section::make('Link Buttons')
                        ->description('Tambahkan tombol link yang relevan.')
                        ->schema([
                            \Filament\Forms\Components\Repeater::make('buttons')
                                ->label('Daftar Tombol')
                                ->schema([
                                    TextInput::make('text')
                                        ->label('Teks Tombol')
                                        ->placeholder('Contoh: Unduh Berkas')
                                        ->required(),
                                    TextInput::make('url')
                                        ->label('Link Tujuan')
                                        ->placeholder('https://...')
                                        ->url()
                                        ->required(),
                                    \Filament\Forms\Components\Select::make('color')
                                        ->label('Warna Tombol')
                                        ->options([
                                            'primary' => 'Utama (Biru)',
                                            'secondary' => 'Sekunder (Abu-abu)',
                                            'success' => 'Sukses (Hijau)',
                                            'danger' => 'Bahaya (Merah)',
                                            'warning' => 'Peringatan (Kuning)',
                                        ])
                                        ->default('primary'),
                                ])
                                ->grid(2)
                                ->columnSpanFull(),
                        ])
                        ->columnSpan(1),
                ]),

            \Filament\Forms\Components\Select::make('form_id')
                ->label('Pilih Form Dinamis (Internal)')
                ->relationship('form', 'name')
                ->searchable()
                ->preload()
                ->nullable()
                ->columnSpanFull()
                ->helperText('Pilih jika ingin menyertakan form yang dibuat di sistem internal.'),
        ]);
    }
}
