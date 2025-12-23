<?php

namespace App\Filament\Resources\KategoriBeritas\Pages;

use App\Filament\Resources\KategoriBeritas\KategoriBeritaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewKategoriBerita extends ViewRecord
{
    protected static string $resource = KategoriBeritaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
