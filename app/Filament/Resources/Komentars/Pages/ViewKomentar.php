<?php

namespace App\Filament\Resources\Komentars\Pages;

use App\Filament\Resources\Komentars\KomentarResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewKomentar extends ViewRecord
{
    protected static string $resource = KomentarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
