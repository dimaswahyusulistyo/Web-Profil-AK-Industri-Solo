<?php

namespace App\Filament\Resources\AspirasiAduans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AspirasiAduanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Informasi Pengirim')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextEntry::make('nama')
                            ->label('Nama Lengkap')
                            ->weight('bold'),
                        TextEntry::make('email')
                            ->label('Alamat Email')
                            ->icon('heroicon-m-envelope')
                            ->copyable(),
                        TextEntry::make('no_telp')
                            ->label('Nomor Telepon')
                            ->icon('heroicon-m-phone')
                            ->copyable(),
                        TextEntry::make('kategori.nama_kategori')
                            ->label('Kategori Aduan')
                            ->badge()
                            ->color('warning'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                
                \Filament\Schemas\Components\Section::make('Isi Pengaduan')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->schema([
                        TextEntry::make('pesan')
                            ->label('Detail Pesan / Keluhan')
                            ->prose()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                \Filament\Schemas\Components\Section::make('Lampiran Data Dukung')
                    ->icon('heroicon-o-paper-clip')
                    ->schema([
                        \Filament\Infolists\Components\ViewEntry::make('data_dukung')
                            ->view('filament.components.data-dukung-preview')
                            ->hiddenLabel()
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),

                \Filament\Schemas\Components\Section::make('Metadata Jejak Audit')
                    ->icon('heroicon-o-clock')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Dikirim Pada')
                            ->dateTime('d F Y H:i:s'),
                        TextEntry::make('updated_at')
                            ->label('Pembaruan Terakhir')
                            ->dateTime('d F Y H:i:s'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
