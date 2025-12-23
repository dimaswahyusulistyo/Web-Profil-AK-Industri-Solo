<?php

namespace App\Filament\Resources\Pengumuman\Pages;

use App\Filament\Resources\Pengumuman\PengumumanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPengumuman extends ListRecords
{
    protected static string $resource = PengumumanResource::class;
    protected static ?string $title = 'Daftar Pengumuman';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
