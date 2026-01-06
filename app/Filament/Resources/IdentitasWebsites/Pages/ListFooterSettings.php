<?php

namespace App\Filament\Resources\FooterSettings\Pages;

use App\Filament\Resources\FooterSettings\FooterSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\FooterSetting;

class ListFooterSettings extends ListRecords
{
    protected static string $resource = FooterSettingResource::class;

    protected function getHeaderActions(): array
    {
        if (FooterSetting::count() > 0) {
            return [];
        }

        return [
            Actions\CreateAction::make(),
        ];
    }
}
