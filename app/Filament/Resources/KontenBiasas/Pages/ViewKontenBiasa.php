<?php

namespace App\Filament\Resources\KontenBiasas\Pages;

use App\Filament\Resources\KontenBiasas\KontenBiasaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewKontenBiasa extends ViewRecord
{
    protected static string $resource = KontenBiasaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
