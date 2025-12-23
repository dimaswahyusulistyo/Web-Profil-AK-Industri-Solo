<?php

namespace App\Filament\Resources\KontenBiasas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class KontenBiasaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('judul'),
                TextEntry::make('url_halaman'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
