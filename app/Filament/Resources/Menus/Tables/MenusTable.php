<?php

namespace App\Filament\Resources\Menus\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class MenusTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('nama_menu')
                    ->label('Menu')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('parent.nama_menu')
                    ->label('Parent')
                    ->placeholder('-'),

                TextColumn::make('link_type')
                    ->label('Tipe')
                    ->badge(),

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
