<?php

namespace App\Filament\Resources\Layanans\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;

class LayananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            TextInput::make('nama_layanan')
                ->label('Nama Layanan')
                ->required(),

            FileUpload::make('ikon')
                ->label('Ikon Layanan')
                ->image()
                ->directory('layanan')
                ->disk('public') 
                ->imageEditor()
                ->nullable(),

            TextInput::make('tautan')
                ->label('Tautan / URL')
                ->placeholder('/layanan/konsultasi'),

            TextInput::make('urutan')
                ->numeric()
                ->default(0),
        ]);
    }
}
