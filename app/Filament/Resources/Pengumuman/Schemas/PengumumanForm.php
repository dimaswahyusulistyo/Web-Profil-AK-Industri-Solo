<?php

namespace App\Filament\Resources\Pengumuman\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;

class PengumumanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            TextInput::make('judul')
                ->label('Judul Pengumuman')
                ->required(),

            FileUpload::make('thumbnail')
                ->label('Thumbnail')
                ->image()
                ->directory('berita')
                ->disk('public') 
                ->visibility('public')
                ->imagePreviewHeight(200)
                ->imageEditor()
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
