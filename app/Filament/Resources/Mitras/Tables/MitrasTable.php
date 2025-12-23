<?php

namespace App\Filament\Resources\Mitras\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class MitrasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('logo')
                    ->label('Logo')
                    ->disk('public')
                    ->height(50),

                TextColumn::make('nama_mitra')
                    ->label('Mitra')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('url')
                    ->label('Website')
                    ->url(fn ($record) => $record->url)
                    ->openUrlInNewTab(),

                TextColumn::make('urutan')
                    ->sortable(),
            ])
            ->defaultSort('urutan')
            ->filters([
                
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()->requiresConfirmation(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
