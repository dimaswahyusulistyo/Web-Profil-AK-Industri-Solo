<?php

namespace App\Filament\Resources\AspirasiAduans\Pages;

use App\Filament\Resources\AspirasiAduans\AspirasiAduanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAspirasiAduan extends ViewRecord
{
    protected static string $resource = AspirasiAduanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
