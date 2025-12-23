<?php

namespace App\Filament\Resources\KontenBiasas\Pages;

use App\Filament\Resources\KontenBiasas\KontenBiasaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKontenBiasas extends ListRecords
{
    protected static string $resource = KontenBiasaResource::class;
    protected static ?string $title = 'Daftar Konten Biasa';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
