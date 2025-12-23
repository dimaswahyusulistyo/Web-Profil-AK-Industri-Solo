<?php

namespace App\Filament\Resources\Pengumuman\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;

class PengumumanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            TextInput::make('judul')
                ->label('Judul Pengumuman')
                ->required(),

            RichEditor::make('konten')
                ->label('Isi Pengumuman')
                ->required()
                ->columnSpanFull()
                ->fileAttachmentsDisk('public')
                ->fileAttachmentsDirectory('pengumuman')
                ->fileAttachmentsVisibility('public'),
        ]);
    }
}
