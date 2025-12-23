<?php

namespace App\Filament\Resources\Layanans;

use App\Filament\Resources\Layanans\Pages\CreateLayanan;
use App\Filament\Resources\Layanans\Pages\EditLayanan;
use App\Filament\Resources\Layanans\Pages\ListLayanans;
use App\Filament\Resources\Layanans\Pages\ViewLayanan;
use App\Filament\Resources\Layanans\Schemas\LayananForm;
use App\Filament\Resources\Layanans\Tables\LayanansTable;
use App\Models\Layanan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LayananResource extends Resource
{
    protected static ?string $model = Layanan::class;

    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Konten';

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Layanan';

    protected static ?string $recordTitleAttribute = 'nama_layanan';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return LayananForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LayanansTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListLayanans::route('/'),
            'create' => CreateLayanan::route('/create'),
            'view'   => ViewLayanan::route('/{record}'),
            'edit'   => EditLayanan::route('/{record}/edit'),
        ];
    }
}
