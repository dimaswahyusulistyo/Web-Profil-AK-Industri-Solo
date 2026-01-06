<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Forms\Components\Radio;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class MenuForm
{
    public static function schema(): array
    {
        return [
            Section::make('Informasi Menu')
                ->schema([
                    TextInput::make('nama_menu')
                        ->label('Nama Menu')
                        ->required()
                        ->maxLength(100)
                        ->columnSpanFull(),

                    Select::make('parent_id')
                        ->label('Parent Menu')
                        ->options(function ($record) {
                            $query = \App\Models\Menu::query();
                            if ($record) {
                                $query->where('id', '!=', $record->id);
                            }
                            
                            // Ambil semua menu dan urutkan secara hierarki
                            $sortedIds = \App\Models\Menu::getTreeSortedIds();
                            $menus = \App\Models\Menu::when(!empty($sortedIds), function ($q) use ($sortedIds) {
                                $q->orderByRaw("FIELD(id, " . implode(',', $sortedIds) . ")");
                            })->get();

                            return $menus->mapWithKeys(function ($menu) {
                                $depth = $menu->getDepth();
                                $prefix = $depth > 0 ? '|' . str_repeat('-', $depth) . ' ' : '';
                                $icon = $menu->menu_type === 'group' ? '📁' : '📄';
                                
                                return [$menu->id => $prefix . $icon . ' ' . $menu->nama_menu];
                            });
                        })
                        ->searchable()
                        ->preload()
                        ->nullable()
                        ->helperText('Kosongkan jika menu merupakan menu utama (Top Level)')
                        ->columnSpanFull(),

                    TextInput::make('urutan')
                        ->label('Urutan')
                        ->numeric()
                        ->default(0)
                        ->helperText('Semakin kecil semakin di atas')
                        ->columnSpanFull(),

                    Radio::make('menu_type')
                        ->label('Tipe Menu')
                        ->options([
                            'group' => 'Group / Dropdown (tanpa halaman)',
                            'link' => 'Link (dengan halaman/URL)',
                        ])
                        ->default('link')
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Set $set, $state) {
                            if ($state === 'group') {
                                $set('link_type', null);
                                $set('page_id', null);
                                $set('url_halaman', null);
                            }
                        })
                        ->helperText('Group: menu induk tanpa tujuan | Link: menu dengan tujuan halaman')
                        ->columnSpanFull(),
                ]),

            Section::make('Tujuan Menu')
                ->schema([
                    Select::make('link_type')
                        ->label('Tipe Layout')
                        ->required()
                        ->options([
                            'home' => 'Home',
                            'konten_biasa' => 'Konten Biasa',
                            'berita_list' => 'Daftar Berita',
                            'pengumuman_list' => 'Daftar Pengumuman',
                            'external' => 'Link External',
                        ])
                        ->live()
                        ->afterStateUpdated(function (Set $set, $state) {
                            // Auto-fill URL for predefined types
                            $set('page_id', null);
                            $set('url_halaman', match ($state) {
                                'home' => '/',
                                'berita_list' => '/berita',
                                'pengumuman_list' => '/pengumuman',
                                default => null,
                            });
                        }),

                    Select::make('page_id')
                        ->label('Pilih Halaman')
                        ->relationship('page', 'judul')
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set, $state) {
                            if ($state) {
                                $page = \App\Models\KontenBiasa::find($state);
                                if ($page) {
                                    $set('url_halaman', '/url/' . $page->url_halaman);
                                }
                            }
                        })
                        ->visible(fn (Get $get) => $get('link_type') === 'konten_biasa')
                        ->required(fn (Get $get) => $get('link_type') === 'konten_biasa'),

                    TextInput::make('url_halaman')
                        ->label('URL Tujuan')
                        ->placeholder('/berita atau https://example.com')
                        ->readOnly(fn (Get $get) => in_array(
                            $get('link_type'),
                            ['home', 'berita_list', 'pengumuman_list']
                        ))
                        ->visible(fn (Get $get) => in_array(
                            $get('link_type'),
                            ['home', 'berita_list', 'pengumuman_list', 'external']
                        ))
                        ->required(fn (Get $get) => in_array(
                            $get('link_type'),
                            ['home', 'berita_list', 'pengumuman_list', 'external']
                        ))
                        ->helperText(fn (Get $get) => match ($get('link_type')) {
                            'home' => 'URL Tetap: /',
                            'berita_list' => 'URL Tetap: /berita',
                            'pengumuman_list' => 'URL Tetap: /pengumuman',
                            'external' => 'Masukkan URL bebas (Contoh: https://google.com)',
                            default => null,
                        }),
                ])
                ->visible(fn (Get $get) => $get('menu_type') === 'link')
                ->description('Tentukan tujuan menu ini')
                ->columns(2),
        ];
    }
}
