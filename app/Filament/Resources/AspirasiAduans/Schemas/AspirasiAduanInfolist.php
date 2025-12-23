<?php

namespace App\Filament\Resources\AspirasiAduans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AspirasiAduanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
