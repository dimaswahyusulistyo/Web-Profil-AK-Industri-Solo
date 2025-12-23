<?php

namespace App\Filament\Resources\Mitras\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class MitraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            TextInput::make('nama_mitra')
                ->label('Nama Mitra')
                ->required(),

            FileUpload::make('logo')
                ->label('Logo Mitra')
                ->image()
                ->directory('mitra')
                ->imagePreviewHeight('100')
                ->maxSize(2048)
                ->required(),

            TextInput::make('url')
                ->label('Website')
                ->url()
                ->placeholder('https://example.com'),

            TextInput::make('urutan')
                ->numeric()
                ->default(0),
        ]);
    }
}
