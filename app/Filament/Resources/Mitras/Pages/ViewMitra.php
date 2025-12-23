<?php

namespace App\Filament\Resources\Mitras\Pages;

use App\Filament\Resources\Mitras\MitraResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMitra extends ViewRecord
{
    protected static string $resource = MitraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
