<?php

namespace App\Filament\Resources\IdentitasWebsites\Pages;

use App\Filament\Resources\IdentitasWebsites\IdentitasWebsiteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIdentitasWebsite extends EditRecord
{
    protected static string $resource = IdentitasWebsiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
