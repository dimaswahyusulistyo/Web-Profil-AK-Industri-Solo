<?php

namespace App\Filament\Resources\KontenBiasas\Pages;

use App\Filament\Resources\KontenBiasas\KontenBiasaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditKontenBiasa extends EditRecord
{
    protected static string $resource = KontenBiasaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
