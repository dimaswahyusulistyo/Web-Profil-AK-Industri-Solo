<?php

namespace App\Filament\Resources\AspirasiAduans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AspirasiAduanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required(),
                TextInput::make('no_telp')
                    ->label('No. Telp')
                    ->tel()
                    ->required(),
                \Filament\Forms\Components\Select::make('kategori_aduan_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'nama_kategori')
                    ->required()
                    ->searchable()
                    ->preload(),
                Textarea::make('pesan')
                    ->label('Isi Pengaduan')
                    ->required()
                    ->columnSpanFull(),
                \Filament\Forms\Components\FileUpload::make('data_dukung')
                    ->label('Data Dukung')
                    ->helperText('Format yang didukung: PDF, DOC, DOCX, JPG, JPEG, PNG (Maks. 5MB)')
                    ->disk('public')
                    ->directory('aspirasi-dukung')
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                    ->maxSize(5120)
                    ->columnSpanFull(),
                Textarea::make('tanggapan')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
