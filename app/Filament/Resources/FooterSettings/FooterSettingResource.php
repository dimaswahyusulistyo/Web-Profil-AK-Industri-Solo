<?php

namespace App\Filament\Resources\FooterSettings;

use App\Filament\Resources\FooterSettings\Pages\CreateFooterSetting;
use App\Filament\Resources\FooterSettings\Pages\EditFooterSetting;
use App\Filament\Resources\FooterSettings\Pages\ListFooterSettings;
use App\Models\FooterSetting;
use Filament\Schemas\Schema;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use BackedEnum;
use UnitEnum;

class FooterSettingResource extends Resource
{
    protected static ?string $model = FooterSetting::class;

    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Konten';

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-cog';
    protected static ?int $navigationSort = 8;
    
    protected static ?string $navigationLabel = 'Pengaturan Footer';
    
    protected static ?string $pluralModelLabel = 'Pengaturan Footer';

    public static function form(Schema $schema): Schema
    {
        return \App\Filament\Resources\FooterSettings\Schemas\FooterSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return \App\Filament\Resources\FooterSettings\Tables\FooterSettingsTable::configure($table);
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
            'index' => ListFooterSettings::route('/'),
            'create' => CreateFooterSetting::route('/create'),
            'edit' => EditFooterSetting::route('/{record}/edit'),
        ];
    }
}
