<?php

namespace App\Filament\Resources\IdentitasWebsites;

use App\Filament\Resources\IdentitasWebsites\Pages\CreateIdentitasWebsite;
use App\Filament\Resources\IdentitasWebsites\Pages\EditIdentitasWebsite;
use App\Filament\Resources\IdentitasWebsites\Pages\ListIdentitasWebsites;
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

class IdentitasWebsiteResource extends Resource
{
    protected static ?string $model = FooterSetting::class;

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasPermission('resource.IdentitasWebsite') ?? false;
    }

    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Konten';

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-cog';
    protected static ?int $navigationSort = 8;
    
    protected static ?string $navigationLabel = 'Global Settings';
    
    protected static ?string $pluralModelLabel = 'Global Settings';
    
    protected static ?string $slug = 'global-settings';

    public static function form(Schema $schema): Schema
    {
        return \App\Filament\Resources\IdentitasWebsites\Schemas\IdentitasWebsiteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return \App\Filament\Resources\IdentitasWebsites\Tables\IdentitasWebsiteTable::configure($table);
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
            'index' => ListIdentitasWebsites::route('/'),
            'create' => CreateIdentitasWebsite::route('/create'),
            'edit' => EditIdentitasWebsite::route('/{record}/edit'),
        ];
    }
}
