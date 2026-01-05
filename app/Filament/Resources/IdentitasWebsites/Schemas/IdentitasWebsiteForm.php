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
                ->schema([
                    FileUpload::make('header_logo')
                        ->label('Logo Header')
                        ->image()
                        ->disk('public')
                        ->directory('branding')
                        ->helperText('Logo yang akan muncul di bagian atas (Header) website'),
                    FileUpload::make('logo')
                        ->label('Logo Footer')
                        ->image()
                        ->disk('public')
                        ->directory('branding')
                        ->helperText('Logo yang akan muncul di bagian bawah (Footer) website'),
                    Textarea::make('description')
                        ->label('Deskripsi Singkat')
                        ->rows(3),
                    TextInput::make('copyright')
                        ->label('Copyright Text'),
                ]),
            
            Section::make('Informasi Kontak')
                ->schema([
                    TextInput::make('phone')
                        ->label('Nomor Telepon')
                        ->tel(),
                    TextInput::make('email')
                        ->label('Alamat Email')
                        ->email(),
                    Textarea::make('address')
                        ->label('Alamat Kantor')
                        ->rows(3),
                ])->columns(2),

            Section::make('Media Sosial')
                ->schema([
                    TextInput::make('facebook'),
                    TextInput::make('instagram'),
                    TextInput::make('twitter')
                        ->label('Twitter / X'),
                    TextInput::make('youtube'),
                ])->columns(2),

            Section::make('Tautan (Links)')
                ->schema([
                    Repeater::make('quick_links')
                        ->label('Link Cepat')
                        ->schema([
                            TextInput::make('label')->required(),
                            TextInput::make('url')->required(),
                        ])
                        ->columns(2),
                    Repeater::make('related_links')
                        ->label('Halaman Terkait')
                        ->schema([
                            TextInput::make('label')->required(),
                            TextInput::make('url')->required(),
                        ])
                        ->columns(2),
                ]),
            Section::make('Pengaturan Umum')
                ->schema([
                    Toggle::make('comments_enabled')
                        ->label('Aktifkan komentar')
                        ->helperText('Nonaktifkan untuk mematikan semua fitur komentar di website')
                        ->default(true),
                ]),
        ]);
    }
}
