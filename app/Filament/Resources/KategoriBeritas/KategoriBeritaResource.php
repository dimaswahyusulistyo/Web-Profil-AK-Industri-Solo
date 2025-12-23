<?php

namespace App\Filament\Resources\KategoriBeritas;

use App\Filament\Resources\KategoriBeritas\Pages\CreateKategoriBerita;
use App\Filament\Resources\KategoriBeritas\Pages\EditKategoriBerita;
use App\Filament\Resources\KategoriBeritas\Pages\ListKategoriBeritas;
use App\Filament\Resources\KategoriBeritas\Pages\ViewKategoriBerita;
use App\Filament\Resources\KategoriBeritas\Schemas\KategoriBeritaForm;
use App\Filament\Resources\KategoriBeritas\Schemas\KategoriBeritaInfolist;
use App\Filament\Resources\KategoriBeritas\Tables\KategoriBeritasTable;
use App\Models\KategoriBerita;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KategoriBeritaResource extends Resource
{
    protected static ?string $model = KategoriBerita::class;

    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Konten';

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedTag;

    protected static ?string $navigationLabel = 'Kategori Berita';

    protected static ?string $recordTitleAttribute = 'nama_kategori';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return KategoriBeritaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KategoriBeritasTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return KategoriBeritaInfolist::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListKategoriBeritas::route('/'),
            'create' => CreateKategoriBerita::route('/create'),
            'view'   => ViewKategoriBerita::route('/{record}'),
            'edit'   => EditKategoriBerita::route('/{record}/edit'),
        ];
    }
}
