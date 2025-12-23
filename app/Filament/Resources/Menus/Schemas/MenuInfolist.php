<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;

class MenuInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            TextEntry::make('nama_menu')
                ->label('Nama Menu'),

            TextEntry::make('parent.nama_menu')
                ->label('Parent'),

            TextEntry::make('link_type')
                ->label('Tipe Link'),

            TextEntry::make('url_halaman')
                ->label('URL'),

            TextEntry::make('urutan')
                ->label('Urutan'),
        ]);
    }
}
