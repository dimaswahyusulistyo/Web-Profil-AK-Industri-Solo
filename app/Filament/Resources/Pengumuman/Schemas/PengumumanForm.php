<?php

namespace App\Filament\Resources\Pengumuman\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;

use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class PengumumanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            TextInput::make('judul')
                ->label('Judul Pengumuman')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('url_halaman', Str::slug($state))),

            TextInput::make('url_halaman')
                ->label('Slug / URL')
                ->required()
                ->unique(ignoreRecord: true)
                ->helperText('Otomatis terisi dari judul, digunakan untuk link (Contoh: pengumuman-penting)'),

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

            \Filament\Schemas\Components\Section::make('Link Button (Opsional)')
                ->description('Tambahkan tombol klik jika pengumuman ini merujuk ke link luar atau internal tertentu.')
                ->schema([
                    TextInput::make('button_text')
                        ->label('Teks Tombol')
                        ->placeholder('Contoh: Lihat Selengkapnya'),
                    TextInput::make('button_url')
                        ->label('Link Terkait / URL Button')
                        ->placeholder('Contoh: https://google.com')
                        ->url(),
                ])
                ->columns(2),
        ]);
    }
}
