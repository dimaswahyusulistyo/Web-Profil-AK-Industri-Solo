<?php

namespace App\Filament\Resources\Menus\Pages;

use App\Filament\Resources\Menus\MenuResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMenus extends ListRecords
{
    protected static string $resource = MenuResource::class;
    protected static ?string $title = 'Daftar Menu';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTableQuery(): ?\Illuminate\Database\Eloquent\Builder
    {
        $ids = \App\Models\Menu::getTreeSortedIds();
        
        $query = parent::getTableQuery();

        if (!empty($ids)) {
            $query->orderByRaw("FIELD(id, " . implode(',', $ids) . ")");
        }

        return $query;
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
}
