<?php

namespace App\Filament\Resources\AspirasiAduans\Pages;

use App\Filament\Resources\AspirasiAduans\AspirasiAduanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAspirasiAduans extends ListRecords
{
    protected static string $resource = AspirasiAduanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
