<?php

namespace App\Filament\Resources\Komentars\Pages;

use App\Filament\Resources\Komentars\KomentarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKomentars extends ListRecords
{
    protected static string $resource = KomentarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
