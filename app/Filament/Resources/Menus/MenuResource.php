<?php

namespace App\Filament\Resources\Menus;

use App\Filament\Resources\Menus\Pages\CreateMenu;
use App\Filament\Resources\Menus\Pages\EditMenu;
use App\Filament\Resources\Menus\Pages\ListMenus;
use App\Filament\Resources\Menus\Pages\ViewMenu;
use App\Filament\Resources\Menus\Schemas\MenuForm;
use App\Filament\Resources\Menus\Schemas\MenuInfolist;
use App\Filament\Resources\Menus\Tables\MenusTable;
use App\Models\Menu;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasPermission('resource.Menu') ?? false;
    }

    protected static UnitEnum|string|null $navigationGroup = 'Navigasi';

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedBars3;

    protected static ?string $navigationLabel = 'Menu';
    protected static ?string $recordTitleAttribute = 'nama_menu';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'Menu';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Daftar Menu';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema(MenuForm::schema());
    }

    public static function table(Table $table): Table
    {
        return MenusTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema(MenuInfolist::schema());
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListMenus::route('/'),
            'create' => CreateMenu::route('/create'),
            'view'   => ViewMenu::route('/{record}'),
            'edit'   => EditMenu::route('/{record}/edit'),
        ];
    }
}
