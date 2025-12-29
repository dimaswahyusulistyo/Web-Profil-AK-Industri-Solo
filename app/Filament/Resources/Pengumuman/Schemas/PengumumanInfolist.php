<?php

namespace App\Filament\Resources\Pengumuman\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Schema;

class PengumumanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('judul'),
                ImageEntry::make('thumbnail')
                    ->disk('public')
                    ->visibility('public')
                    ->url(fn ($record) => asset('storage/' . $record->thumbnail))
                    ->label('Thumbnail'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
