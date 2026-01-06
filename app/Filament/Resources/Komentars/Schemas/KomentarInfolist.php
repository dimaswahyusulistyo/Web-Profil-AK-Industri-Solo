<?php

namespace App\Filament\Resources\Komentars\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class KomentarInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('commentable_type')
                    ->label('Sumber')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'App\Models\Berita' => 'Berita',
                        'App\Models\Pengumuman' => 'Pengumuman',
                        default => (string) str($state)->afterLast('\\'),
                    }),
                TextEntry::make('commentable.judul')
                    ->label('Konten'),
                IconEntry::make('is_approved')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
