<?php

namespace App\Filament\Resources\Layanans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Schema;

class LayananInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama_layanan'),
                ImageEntry::make('ikon')
                    ->label('Ikon Layanan'),
                TextEntry::make('tautan'),
                TextEntry::make('urutan')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
