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
        return $schema->schema(function ($record) {
            $components = [];

            $components[] = Section::make('Informasi Submission')
                ->schema([
                    TextEntry::make('form.name')
                        ->label('Nama Form')
                        ->columnSpan(1),

                    TextEntry::make('created_at')
                        ->label('Waktu Pengiriman')
                        ->dateTime()
                        ->columnSpan(1),
                ])
                ->columns(2)
                ->columnSpanFull();


            if ($record && $record->data) {
                $formFields = $record->form?->fields ?? collect();

                foreach ($record->data as $label => $value) {
                    if ($value === null || $value === '') continue;

                    $displayValue = $value;
                    $field = $formFields->firstWhere('label', $label) ?? $formFields->firstWhere('name', $label);

                    if ($field && in_array($field->type, ['select', 'radio', 'checkbox'])) {
                        $options = $field->options ?? [];
                        if (is_array($value)) {
                            $displayValue = collect($value)->map(function($v) use ($options) {
                                $opt = collect($options)->firstWhere('value', $v);
                                return $opt['label'] ?? $v;
                            })->implode(', ');
                        } else {
                            $opt = collect($options)->firstWhere('value', $value);
                            $displayValue = $opt['label'] ?? $value;
                        }
                    }

                    $isUpload = is_string($value) && \Illuminate\Support\Str::startsWith($value, 'dynamic-form-uploads/');

                    if ($isUpload) {
                        $components[] = Section::make($label)
                            ->schema([
                                ViewEntry::make("data_view_{$label}")
                                    ->hiddenLabel()
                                    ->view('filament.components.data-dukung-preview')
                                    ->state($value)
                                    ->columnSpanFull()
                            ])
                            ->columnSpanFull();
                    } else {
                        $components[] = Section::make($label)
                            ->schema([
                                TextEntry::make("data_text_{$label}")
                                    ->hiddenLabel()
                                    ->state($displayValue)
                                    ->columnSpanFull()
                            ])
                            ->columnSpanFull();
                    }
                }
            }

            return $components;
        });
    }
}
