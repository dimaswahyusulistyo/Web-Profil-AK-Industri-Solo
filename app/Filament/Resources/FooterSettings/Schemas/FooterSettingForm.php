<?php

namespace App\Filament\Resources\FooterSettings\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;

class FooterSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Identity')
                ->schema([
                    FileUpload::make('logo')
                        ->image()
                        ->directory('footer-logos'),
                    Textarea::make('description')
                        ->rows(3),
                    TextInput::make('copyright'),
                ]),
            
            Section::make('Contact Information')
                ->schema([
                    TextInput::make('phone')
                        ->tel(),
                    TextInput::make('email')
                        ->email(),
                    Textarea::make('address')
                        ->rows(3),
                ])->columns(2),

            Section::make('Social Media')
                ->schema([
                    TextInput::make('facebook'),
                    TextInput::make('instagram'),
                    TextInput::make('twitter')
                        ->label('Twitter / X'),
                    TextInput::make('youtube'),
                ])->columns(2),

            Section::make('Links')
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
        ]);
    }
}
