<?php

namespace App\Filament\Resources\Sliders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;

class SliderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('judul'),

            FileUpload::make('gambar')
                ->image()
                ->directory('sliders')
                ->required(),

            TextInput::make('url')->url(),

            TextInput::make('urutan')->numeric()->default(0),
        ]);
    }
}

