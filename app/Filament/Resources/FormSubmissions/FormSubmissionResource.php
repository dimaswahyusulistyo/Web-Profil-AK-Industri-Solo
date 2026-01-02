<?php

namespace App\Filament\Resources\FormSubmissions;

use App\Filament\Resources\FormSubmissions\Pages\ListFormSubmissions;
use App\Filament\Resources\FormSubmissions\Pages\ViewFormSubmission;
use App\Models\FormSubmission;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use UnitEnum;

class FormSubmissionResource extends Resource
{
    protected static ?string $model = FormSubmission::class;

    protected static UnitEnum|string|null $navigationGroup = 'Form Dinamis';

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedInboxArrowDown;

    protected static ?string $navigationLabel = 'Hasil Submission';

    protected static ?string $pluralModelLabel = 'Hasil Submission Form';

    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('form.name')
                    ->label('Nama Form')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dikirim Pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return \App\Filament\Resources\FormSubmissions\Schemas\FormSubmissionInfolist::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFormSubmissions::route('/'),
            'view' => ViewFormSubmission::route('/{record}'),
        ];
    }
}
