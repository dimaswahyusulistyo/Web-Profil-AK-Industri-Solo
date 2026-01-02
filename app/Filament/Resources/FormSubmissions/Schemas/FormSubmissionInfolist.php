<?php

namespace App\Filament\Resources\FormSubmissions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\ViewEntry;

class FormSubmissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Submission')
                    ->schema([
                        TextEntry::make('form.name')
                            ->label('Nama Form'),
                        TextEntry::make('created_at')
                            ->label('Waktu Pengiriman')
                            ->dateTime(),
                    ])->columns(2),

                Section::make('Data Input')
                    ->schema([
                        ViewEntry::make('data')
                            ->label('Isi Form')
                            ->view('filament.components.submission-data-viewer')
                    ])
            ]);
    }
}
