<?php

namespace App\Filament\Resources\Menus\Schemas;


use Filament\Infolists\Components\TextEntry;

class MenuInfolist
{
    public static function schema(): array
    {
        return [
            TextEntry::make('nama_menu')
                ->label('Nama Menu'),

            TextEntry::make('menu_type')
                ->label('Tipe Menu')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'group' => 'gray',
                    'link' => 'success',
                }),

            TextEntry::make('parent.nama_menu')
                ->label('Parent'),

            TextEntry::make('link_type')
                ->label('Tipe Link')
                ->visible(fn ($record) => $record->menu_type === 'link'),

            TextEntry::make('url_halaman')
                ->label('URL')
                ->visible(fn ($record) => $record->menu_type === 'link'),

            TextEntry::make('urutan')
                ->label('Urutan'),
        ];
    }
}
