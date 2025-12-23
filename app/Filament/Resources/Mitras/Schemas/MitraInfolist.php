<?php

namespace App\Filament\Resources\Mitras\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MitraInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama_mitra'),
                TextEntry::make('logo'),
                TextEntry::make('url'),
                TextEntry::make('urutan')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
