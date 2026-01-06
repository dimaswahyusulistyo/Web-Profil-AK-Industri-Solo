<?php

namespace App\Filament\Resources\KontenBiasas;

use App\Filament\Resources\KontenBiasas\Pages\CreateKontenBiasa;
use App\Filament\Resources\KontenBiasas\Pages\EditKontenBiasa;
use App\Filament\Resources\KontenBiasas\Pages\ListKontenBiasas;
use App\Filament\Resources\KontenBiasas\Pages\ViewKontenBiasa;
use App\Filament\Resources\KontenBiasas\Schemas\KontenBiasaForm;
use App\Filament\Resources\KontenBiasas\Tables\KontenBiasasTable;
use App\Models\KontenBiasa;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;
use BackedEnum;

class KontenBiasaResource extends Resource
{
    protected static ?string $model = KontenBiasa::class;

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasPermission('resource.KontenBiasa') ?? false;
    }

    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Konten';

    protected static BackedEnum|string|null $navigationIcon =
        'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Konten Biasa';
    protected static ?string $recordTitleAttribute = 'judul';
    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return 'Konten Biasa';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Daftar Konten Biasa';
    }

    public static function form(Schema $schema): Schema
    {
        return KontenBiasaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KontenBiasasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListKontenBiasas::route('/'),
            'create' => CreateKontenBiasa::route('/create'),
            'view'   => ViewKontenBiasa::route('/{record}'),
            'edit'   => EditKontenBiasa::route('/{record}/edit'),
        ];
    }
}
