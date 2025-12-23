<?php

namespace App\Filament\Resources\KategoriBeritas\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;

class KategoriBeritaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextEntry::make('nama_kategori')
                ->label('Nama Kategori'),

            TextEntry::make('url_halaman')
                ->label('Slug'),

            TextEntry::make('created_at')
                ->label('Dibuat')
                ->dateTime('d M Y H:i'),
        ]);
    }
}
