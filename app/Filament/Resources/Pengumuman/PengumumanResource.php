<?php

namespace App\Filament\Resources\Pengumuman;

use App\Filament\Resources\Pengumuman\Pages\CreatePengumuman;
use App\Filament\Resources\Pengumuman\Pages\EditPengumuman;
use App\Filament\Resources\Pengumuman\Pages\ListPengumuman;
use App\Filament\Resources\Pengumuman\Pages\ViewPengumuman;
use App\Filament\Resources\Pengumuman\Schemas\PengumumanForm;
use App\Filament\Resources\Pengumuman\Schemas\PengumumanInfolist;
use App\Filament\Resources\Pengumuman\Tables\PengumumanTable;
use App\Models\Pengumuman;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PengumumanResource extends Resource
{
    protected static ?string $model = Pengumuman::class;

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasPermission('resource.Pengumuman') ?? false;
    }
    protected static ?string $navigationLabel = 'Pengumuman';

    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Konten';

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedMegaphone;

    protected static ?string $recordTitleAttribute = 'judul';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return 'Pengumuman';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Daftar Pengumuman';
    }

    public static function form(Schema $schema): Schema
    {
        return PengumumanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengumumanTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPengumuman::route('/'),
            'create' => CreatePengumuman::route('/create'),
            'view'   => ViewPengumuman::route('/{record}'),
            'edit'   => EditPengumuman::route('/{record}/edit'),
        ];
    }
}
