<?php

namespace App\Filament\Resources\Mitras;

use App\Filament\Resources\Mitras\Pages\CreateMitra;
use App\Filament\Resources\Mitras\Pages\EditMitra;
use App\Filament\Resources\Mitras\Pages\ListMitras;
use App\Filament\Resources\Mitras\Pages\ViewMitra;
use App\Filament\Resources\Mitras\Schemas\MitraForm;
use App\Filament\Resources\Mitras\Tables\MitrasTable;
use App\Models\Mitra;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MitraResource extends Resource
{
    protected static ?string $model = Mitra::class;

    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Konten';

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Mitra';
    protected static ?string $recordTitleAttribute = 'nama_mitra';

    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return 'Mitra';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Daftar Mitra';
    }

    public static function form(Schema $schema): Schema
    {
        return MitraForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MitrasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListMitras::route('/'),
            'create' => CreateMitra::route('/create'),
            'view'   => ViewMitra::route('/{record}'),
            'edit'   => EditMitra::route('/{record}/edit'),
        ];
    }
}
