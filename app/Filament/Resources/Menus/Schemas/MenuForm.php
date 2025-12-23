<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            Section::make('Informasi Menu')
                ->schema([

                    TextInput::make('nama_menu')
                        ->label('Nama Menu')
                        ->required()
                        ->maxLength(100),

                    Select::make('parent_id')
                        ->label('Parent Menu')
                        ->relationship('parent', 'nama_menu')
                        ->searchable()
                        ->nullable()
                        ->helperText('Kosongkan jika menu utama'),

                    TextInput::make('urutan')
                        ->label('Urutan')
                        ->numeric()
                        ->default(0)
                        ->helperText('Semakin kecil semakin di atas'),

                ])
                ->columns(2),

            Section::make('Tujuan Menu')
                ->schema([

                    Select::make('link_type')
                        ->label('Tipe Link')
                        ->required()
                        ->options([
                            'home' => 'Home',
                            'konten_biasa' => 'Halaman Statis',
                            'berita_list' => 'Daftar Berita',
                            'pengumuman_list' => 'Daftar Pengumuman',
                            'external' => 'Link External',
                        ])
                        ->live(),

                    Select::make('link_id')
                        ->label('Pilih Halaman')
                        ->relationship('page', 'judul')
                        ->searchable()
                        ->preload()
                        ->visible(fn ($get) => $get('link_type') === 'konten_biasa')
                        ->required(fn ($get) => $get('link_type') === 'konten_biasa'),

                    TextInput::make('link_url')
                        ->label('URL Tujuan')
                        ->placeholder('/berita atau https://example.com')
                        ->visible(fn ($get) => in_array(
                            $get('link_type'),
                            ['home', 'berita_list', 'pengumuman_list', 'external']
                        ))
                        ->required(fn ($get) => in_array(
                            $get('link_type'),
                            ['berita_list', 'pengumuman_list', 'external']
                        ))
                        ->helperText(fn ($get) => match ($get('link_type')) {
                            'home' => 'Gunakan "/"',
                            'berita_list' => 'Contoh: /berita',
                            'pengumuman_list' => 'Contoh: /pengumuman',
                            'external' => 'Gunakan URL lengkap (https://...)',
                            default => null,
                        }),
                ])
                ->columns(2),
        ]);
    }
}
