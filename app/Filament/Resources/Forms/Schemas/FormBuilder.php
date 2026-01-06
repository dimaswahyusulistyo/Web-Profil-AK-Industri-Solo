<?php

namespace App\Filament\Resources\Forms\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;

class FormBuilder
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Konfigurasi Form')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Form')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', \Illuminate\Support\Str::slug($state))),
                    TextInput::make('slug')
                        ->label('Slug API')
                        ->required()
                        ->unique(ignoreRecord: true),
                    Textarea::make('description')
                        ->label('Deskripsi (Opsional)')
                        ->columnSpanFull(),
                    Toggle::make('is_active')
                        ->label('Aktifkan Form')
                        ->default(true),
                ])->columns(2),

            Section::make('Daftar Field')
                ->schema([
                    Repeater::make('fields')
                        ->relationship('fields')
                        ->schema([
                            TextInput::make('label')
                                ->label('Label Field')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($set, $get, ?string $state) {
                                    $set('name', \Illuminate\Support\Str::snake($state));
                                    
                                    // Generate placeholder
                                    if ($state) {
                                        $type = $get('type');
                                        $placeholder = match ($type) {
                                            'text' => "Masukkan {$state}...",
                                            'textarea' => "Tuliskan {$state}...",
                                            'select' => "Pilih {$state}...",
                                            'radio' => "Pilih salah satu {$state}...",
                                            'file' => "Unggah {$state}...",
                                            default => "Masukkan {$state}...",
                                        };
                                        $set('placeholder', $placeholder);
                                    }
                                }),
                            TextInput::make('name')
                                ->label('Nama Input (Key)')
                                ->required(),
                            Select::make('type')
                                ->label('Tipe Input')
                                ->options([
                                    'text' => 'Text',
                                    'textarea' => 'TextArea',
                                    'select' => 'Select (Dropdown)',
                                    'radio' => 'Radio Button',
                                    'checkbox' => 'Checkbox',
                                    'file' => 'Upload File',
                                ])
                                ->required()
                                ->live()
                                ->afterStateUpdated(function ($set, $get, ?string $state) {
                                    $label = $get('label');
                                    if ($label) {
                                        $placeholder = match ($state) {
                                            'text' => "Masukkan {$label}...",
                                            'textarea' => "Tuliskan {$label}...",
                                            'select' => "Pilih {$label}...",
                                            'radio' => "Pilih salah satu {$label}...",
                                            'file' => "Unggah {$label}...",
                                            default => "Masukkan {$label}...",
                                        };
                                        $set('placeholder', $placeholder);
                                    }
                                }),
                            TextInput::make('placeholder')
                                ->label('Placeholder'),
                            Toggle::make('is_required')
                                ->label('Wajib Diisi'),
                            Repeater::make('options')
                                ->label('Opsi Pilihan')
                                ->schema([
                                    TextInput::make('label')
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn ($set, ?string $state) => $set('value', \Illuminate\Support\Str::snake($state))),
                                    TextInput::make('value')->required(),
                                ])
                                ->visible(fn ($get) => in_array($get('type'), ['select', 'radio', 'checkbox']))
                                ->columns(2),
                        ])
                        ->orderColumn('order')
                        ->columnSpanFull()
                        ->itemLabel(fn (array $state): ?string => $state['label'] ?? null),
                ]),
        ]);
    }
}
