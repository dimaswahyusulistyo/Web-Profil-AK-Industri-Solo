<?php

namespace App\Filament\Resources\Sliders;

use App\Filament\Resources\Sliders\Pages\CreateSlider;
use App\Filament\Resources\Sliders\Pages\EditSlider;
use App\Filament\Resources\Sliders\Pages\ListSliders;
use App\Filament\Resources\Sliders\Pages\ViewSlider;
use App\Filament\Resources\Sliders\Schemas\SliderForm;
use App\Filament\Resources\Sliders\Tables\SlidersTable;
use App\Models\Slider;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasPermission('resource.Slider') ?? false;
    }

    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Konten';

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'Slider';

    protected static ?string $recordTitleAttribute = 'judul';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'Slider';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Daftar Slider';
    }

    public static function form(Schema $schema): Schema
    {
        return SliderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SlidersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListSliders::route('/'),
            'create' => CreateSlider::route('/create'),
            'view'   => ViewSlider::route('/{record}'),
            'edit'   => EditSlider::route('/{record}/edit'),
        ];
    }
}
