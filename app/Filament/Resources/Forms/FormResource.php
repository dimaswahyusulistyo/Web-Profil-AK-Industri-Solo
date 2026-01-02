<?php

namespace App\Filament\Resources\Forms;

use App\Filament\Resources\Forms\Pages\CreateForm;
use App\Filament\Resources\Forms\Pages\EditForm;
use App\Filament\Resources\Forms\Pages\ListForms;
use App\Models\Form;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FormResource extends Resource
{
    protected static ?string $model = Form::class;

    protected static UnitEnum|string|null $navigationGroup = 'Form Dinamis';

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $navigationLabel = 'Buat Form';

    protected static ?string $pluralModelLabel = 'Daftar Form Dinamis';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return \App\Filament\Resources\Forms\Schemas\FormBuilder::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return \App\Filament\Resources\Forms\Tables\FormTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListForms::route('/'),
            'create' => CreateForm::route('/create'),
            'edit' => EditForm::route('/{record}/edit'),
        ];
    }
}
