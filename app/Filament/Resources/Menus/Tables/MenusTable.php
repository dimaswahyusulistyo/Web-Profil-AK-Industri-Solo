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
                    ->html()
                    ->formatStateUsing(function ($state, $record) {
                        $depth = $record->getDepth();
                        $prefix = '';
                        if ($depth > 0) {
                            $prefix = '<span class="text-gray-500 font-mono">' . str_repeat('│&nbsp;&nbsp;', $depth - 1) . '└─&nbsp;</span>';
                        }
                        $icon = $record->menu_type === 'group' ? '📁' : '📄';
                        return $prefix . $icon . ' ' . $state;
                    })
                    ->searchable(),

                TextColumn::make('menu_type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'group' => 'gray',
                        'link' => 'success',
                    }),

                TextColumn::make('parent.nama_menu')
                    ->label('Induk Path')
                    ->formatStateUsing(fn ($record) => $record->getParentPath())
                    ->placeholder('-'),

                TextColumn::make('link_type')
                    ->label('Tipe Layout')
                    ->badge(),

                TextColumn::make('urutan'),
            ])
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
