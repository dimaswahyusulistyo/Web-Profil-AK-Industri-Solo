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
                Textarea::make('tanggapan')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
