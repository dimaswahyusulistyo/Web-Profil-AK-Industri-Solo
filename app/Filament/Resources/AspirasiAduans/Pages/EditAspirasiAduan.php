<?php

namespace App\Filament\Resources\AspirasiAduans\Pages;

use App\Filament\Resources\AspirasiAduans\AspirasiAduanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAspirasiAduan extends EditRecord
{
    protected static string $resource = AspirasiAduanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
