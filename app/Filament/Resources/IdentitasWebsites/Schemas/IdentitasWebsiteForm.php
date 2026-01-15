<?php

namespace App\Filament\Resources\IdentitasWebsites\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;

class IdentitasWebsiteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Logo & Deskripsi')
                ->extraAttributes(['class' => 'rounded-t-xl border bg-white'])
                ->schema([
                    FileUpload::make('header_logo')
                        ->label('Logo Header')
                        ->image()
                        ->disk('public')
                        ->directory('branding')
                        ->helperText('Logo yang akan muncul di bagian atas (Header) website'),

                    TextInput::make('website_title')
                        ->label('Judul Website (Title)')
                        ->maxLength(255)
                        ->helperText('Judul yang muncul di tab browser'),

                    FileUpload::make('favicon')
                        ->label('Favicon')
                        ->image()
                        ->disk('public')
                        ->directory('branding')
                        ->helperText('Ikon kecil di tab browser (sebaiknya rasio 1:1, .ico atau .png)'),

                    FileUpload::make('logo')
                        ->label('Logo Footer')
                        ->image()
                        ->disk('public')
                        ->directory('branding')
                        ->helperText('Logo yang akan muncul di bagian bawah (Footer) website'),

                    Textarea::make('description')
                        ->label('Deskripsi Singkat')
                        ->rows(4)
                        ->helperText('Ringkasan singkat tentang organisasi (ditampilkan di footer)'),

                    TextInput::make('copyright')
                        ->label('Copyright Text')
                        ->helperText('Teks hak cipta yang akan muncul di footer'),
                ])->columns(1)->columnSpanFull(),
            
            Section::make('Informasi Kontak')
                ->extraAttributes(['class' => '!rounded-none !mt-0 !border-0 bg-transparent shadow-none'])
                ->schema([
                    TextInput::make('phone')
                        ->label('Nomor Telepon')
                        ->tel()
                        ->placeholder('+62 812 3456 7890')
                        ->helperText('Nomor telepon utama untuk dihubungi'),

                    TextInput::make('email')
                        ->label('Alamat Email')
                        ->email()
                        ->placeholder('info@domain.tld')
                        ->helperText('Email kontak publik'),

                    Textarea::make('address')
                        ->label('Alamat Kantor')
                        ->rows(3)
                        ->helperText('Alamat lengkap kantor atau instansi'),
                ])->columns(1)->columnSpanFull(),

            Section::make('Media Sosial')
                ->extraAttributes(['class' => '!rounded-none !mt-0 !border-0 bg-transparent shadow-none'])
                ->schema([
                    TextInput::make('facebook')
                        ->placeholder('https://www.facebook.com/yourpage')
                        ->helperText('URL Facebook page'),
                    TextInput::make('instagram')
                        ->placeholder('https://www.instagram.com/yourhandle')
                        ->helperText('URL Instagram'),
                    TextInput::make('twitter')
                        ->label('Twitter / X')
                        ->placeholder('https://twitter.com/yourhandle')
                        ->helperText('URL Twitter atau X'),
                    TextInput::make('youtube')
                        ->placeholder('https://www.youtube.com/channel/...')
                        ->helperText('URL YouTube channel'),
                ])->columns(1)->columnSpanFull(),

            Section::make('Tautan (Links)')
                ->extraAttributes(['class' => '!rounded-none !mt-0 !border-0 bg-transparent shadow-none'])
                ->schema([
                    Repeater::make('quick_links')
                        ->label('Link Cepat')
                        ->schema([
                            TextInput::make('label')->required(),
                            TextInput::make('url')->required(),
                        ])
                        ->columns(1)
                        ->columnSpanFull(),
                    Repeater::make('related_links')
                        ->label('Halaman Terkait')
                        ->schema([
                            TextInput::make('label')->required(),
                            TextInput::make('url')->required(),
                        ])
                        ->columns(1)
                        ->columnSpanFull(),
                ])->columnSpanFull(),
            Section::make('Pengaturan Umum')
                ->extraAttributes(['class' => '!rounded-none !mt-0 !border-0 bg-transparent shadow-none'])
                ->schema([
                    Toggle::make('comments_enabled')
                        ->label('Aktifkan komentar')
                        ->helperText('Nonaktifkan untuk mematikan semua fitur komentar di website')
                        ->default(true),
                ])->columnSpanFull(),
        ]);
    }
}
