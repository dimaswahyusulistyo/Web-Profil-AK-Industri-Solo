<?php

namespace App\Filament\Resources\Forms\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

class FormTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Form')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('Slug API'),
                TextColumn::make('fields_count')
                    ->label('Jumlah Field')
                    ->counts('fields'),
                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
