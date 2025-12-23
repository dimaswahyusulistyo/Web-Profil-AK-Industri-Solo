<?php

namespace App\Filament\Resources\Komentars;

use App\Filament\Resources\Komentars\Pages\CreateKomentar;
use App\Filament\Resources\Komentars\Pages\EditKomentar;
use App\Filament\Resources\Komentars\Pages\ListKomentars;
use App\Filament\Resources\Komentars\Schemas\KomentarForm;
use App\Filament\Resources\Komentars\Tables\KomentarsTable;
use App\Models\Komentar;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;
use BackedEnum;

class KomentarResource extends Resource
{
    protected static ?string $model = Komentar::class;

    protected static UnitEnum|string|null $navigationGroup = 'Komentar & Aspirasi';
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-chat-bubble-left';
    protected static ?string $navigationLabel = 'Komentar';
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return KomentarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KomentarsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListKomentars::route('/'),
            'create' => CreateKomentar::route('/create'),
            'edit'   => EditKomentar::route('/{record}/edit'),
        ];
    }
}
