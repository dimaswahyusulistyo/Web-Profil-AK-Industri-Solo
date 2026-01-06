<?php

namespace App\Filament\Resources\Layanans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class LayanansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('ikon')
                    ->disk('public')
                    ->label('Ikon')
                    ->height(60),
                TextColumn::make('nama_layanan')
                    ->label('Layanan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tautan')
                    ->label('Tautan'),

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
