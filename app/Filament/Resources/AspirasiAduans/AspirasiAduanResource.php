<?php

namespace App\Filament\Resources\AspirasiAduans;

use App\Filament\Resources\AspirasiAduans\Pages\CreateAspirasiAduan;
use App\Filament\Resources\AspirasiAduans\Pages\EditAspirasiAduan;
use App\Filament\Resources\AspirasiAduans\Pages\ListAspirasiAduans;
use App\Filament\Resources\AspirasiAduans\Pages\ViewAspirasiAduan;
use App\Filament\Resources\AspirasiAduans\Schemas\AspirasiAduanForm;
use App\Filament\Resources\AspirasiAduans\Schemas\AspirasiAduanInfolist;
use App\Filament\Resources\AspirasiAduans\Tables\AspirasiAduansTable;
use App\Models\AspirasiAduan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AspirasiAduanResource extends Resource
{
    protected static ?string $model = AspirasiAduan::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static UnitEnum|string|null $navigationGroup = 'Komentar & Aspirasi';

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-clipboard-document';
    protected static ?string $navigationLabel = 'Aspirasi & Aduan';
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function getModelLabel(): string
    {
        return 'Aspirasi & Aduan';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Daftar Aspirasi & Aduan';
    }

    public static function form(Schema $schema): Schema
    {
        return AspirasiAduanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AspirasiAduanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AspirasiAduansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAspirasiAduans::route('/'),
            'create' => CreateAspirasiAduan::route('/create'),
            'view' => ViewAspirasiAduan::route('/{record}'),
            'edit' => EditAspirasiAduan::route('/{record}/edit'),
        ];
    }
}
