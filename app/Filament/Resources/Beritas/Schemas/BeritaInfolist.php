<?php

namespace App\Filament\Resources\Beritas\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;

class BeritaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            ImageEntry::make('thumbnail')
                ->label('Thumbnail'),

            TextEntry::make('judul')
                ->label('Judul'),

            TextEntry::make('kategori.nama_kategori')
                ->label('Kategori'),

            TextEntry::make('konten')
                ->label('Konten')
                ->html()
                ->columnSpanFull(),

            TextEntry::make('created_at')
                ->label('Diposting')
                ->dateTime('d M Y H:i'),
        ]);
    }
}
