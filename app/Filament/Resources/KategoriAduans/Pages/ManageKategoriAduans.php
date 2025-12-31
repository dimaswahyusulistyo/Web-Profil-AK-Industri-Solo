<?php

namespace App\Filament\Resources\KategoriAduans\Pages;

use App\Filament\Resources\KategoriAduans\KategoriAduanResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageKategoriAduans extends ManageRecords
{
    protected static string $resource = KategoriAduanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
