<?php

namespace App\Filament\Resources\FormSubmissions;

use App\Filament\Resources\FormSubmissions\Pages\ListFormSubmissions;
use App\Filament\Resources\FormSubmissions\Pages\ViewFormSubmission;
use App\Models\Form;
use App\Models\FormSubmission;
use BackedEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Illuminate\Support\Collection;
use UnitEnum;

class FormSubmissionResource extends Resource
{
    protected static ?string $model = FormSubmission::class;

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        if (!$user) return false;

        // Admin has full access
        if ($user->roles()->where('nama_role', 'Admin')->exists()) {
            return true;
        }

        // Check if user has at least one dynamic form permission
        // We check the permissions array for any key starting with "form."
        // Or if they have a general resource permission
        return $user->roles()
            ->where(function($query) {
                $query->whereJsonContains('permissions', 'resource.FormSubmission')
                      ->orWhere('permissions', 'like', '%"form.%');
            })->exists();
    }

    // Hide from navigation since we'll use dynamic navigation items
    protected static bool $shouldRegisterNavigation = false;

    protected static UnitEnum|string|null $navigationGroup = 'Form Dinamis';

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedInboxArrowDown;

    protected static ?string $navigationLabel = 'Hasil Submission';

    protected static ?string $pluralModelLabel = 'Hasil Submission Form';

    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('form.name')
                    ->label('Nama Form')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dikirim Pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('form_id')
                    ->relationship('form', 'name')
                    ->label('Filter Form')
                    ->preload(),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                \Filament\Actions\Action::make('download_hasil')
                    ->label('Download Hasil')
                    ->icon('heroicon-o-document-arrow-down')
                    ->form([
                        Select::make('format')
                            ->label('Format File')
                            ->options([
                                'csv' => 'CSV (Excel)',
                                'pdf' => 'PDF',
                            ])
                            ->required()
                            ->default('csv'),
                    ])
                    ->action(function (array $data, Table $table): mixed {
                        $records = $table->getQuery()->get();
                        
                        if ($records->isEmpty()) {
                            Notification::make()
                                ->title('Tidak ada data untuk diunggah')
                                ->warning()
                                ->send();
                            return null;
                        }

                        // Get unique keys from JSON data
                        $headers = collect();
                        foreach ($records as $record) {
                            if (isset($record->data) && is_array($record->data)) {
                                $headers = $headers->merge(array_keys($record->data));
                            }
                        }
                        $headers = $headers->unique()->values()->all();

                        if ($data['format'] === 'csv') {
                            $filename = "submission_export_" . now()->format('Y-m-d_H-i') . ".csv";
                            
                            $callback = function() use ($records, $headers) {
                                $file = fopen('php://output', 'w');
                                
                                // Clean headers
                                $cleanHeaders = array_map(fn($h) => ucwords(str_replace('_', ' ', $h)), $headers);
                                fputcsv($file, array_merge(['ID', 'Waktu'], $cleanHeaders));

                                foreach ($records as $record) {
                                    $row = [$record->id, $record->created_at->format('Y-m-d H:i')];
                                    foreach ($headers as $header) {
                                        $val = $record->data[$header] ?? '-';
                                        if (is_array($val)) $val = implode(', ', $val);
                                        if (str_starts_with($val, 'dynamic-form-uploads/')) $val = '[FILE]';
                                        $row[] = $val;
                                    }
                                    fputcsv($file, $row);
                                }
                                fclose($file);
                            };

                            return response()->stream($callback, 200, [
                                "Content-type"        => "text/csv",
                                "Content-Disposition" => "attachment; filename=$filename",
                                "Pragma"              => "no-cache",
                                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                                "Expires"             => "0"
                            ]);
                        } else {
                            $formName = null;
                            if (request()->has('tableFilters') && isset(request('tableFilters')['form_id']['value'])) {
                                $form = Form::find(request('tableFilters')['form_id']['value']);
                                $formName = $form?->name;
                            }

                            $pdf = Pdf::loadView('exports.submission-export-pdf', [
                                'records' => $records,
                                'headers' => $headers,
                                'formName' => $formName
                            ])->setPaper('a4', 'landscape');

                            return response()->streamDownload(
                                fn () => print($pdf->output()),
                                "submission_export_" . now()->format('Y-m-d_H-i') . ".pdf"
                            );
                        }
                    }),
            ], position: \Filament\Tables\Actions\HeaderActionsPosition::Bottom)
            ->actions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\BulkAction::make('download_terpilih')
                        ->label('Export Terpilih')
                        ->icon('heroicon-o-document-arrow-down')
                        ->form([
                            Select::make('format')
                                ->label('Format File')
                                ->options([
                                    'csv' => 'CSV (Excel)',
                                    'pdf' => 'PDF',
                                ])
                                ->required()
                                ->default('csv'),
                        ])
                        ->action(function (array $data, Collection $records): mixed {
                            if ($records->isEmpty()) return null;

                            $headers = collect();
                            foreach ($records as $record) {
                                if (isset($record->data) && is_array($record->data)) {
                                    $headers = $headers->merge(array_keys($record->data));
                                }
                            }
                            $headers = $headers->unique()->values()->all();

                            if ($data['format'] === 'csv') {
                                $filename = "submission_export_selected_" . now()->format('Y-m-d_H-i') . ".csv";
                                
                                $callback = function() use ($records, $headers) {
                                    $file = fopen('php://output', 'w');
                                    $cleanHeaders = array_map(fn($h) => ucwords(str_replace('_', ' ', $h)), $headers);
                                    fputcsv($file, array_merge(['ID', 'Waktu'], $cleanHeaders));

                                    foreach ($records as $record) {
                                        $row = [$record->id, $record->created_at->format('Y-m-d H:i')];
                                        foreach ($headers as $header) {
                                            $val = $record->data[$header] ?? '-';
                                            if (is_array($val)) $val = implode(', ', $val);
                                            if (str_starts_with($val, 'dynamic-form-uploads/')) $val = '[FILE]';
                                            $row[] = $val;
                                        }
                                        fputcsv($file, $row);
                                    }
                                    fclose($file);
                                };

                                return response()->stream($callback, 200, [
                                    "Content-type"        => "text/csv",
                                    "Content-Disposition" => "attachment; filename=$filename",
                                    "Pragma"              => "no-cache",
                                    "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                                    "Expires"             => "0"
                                ]);
                            } else {
                                $pdf = Pdf::loadView('exports.submission-export-pdf', [
                                    'records' => $records,
                                    'headers' => $headers,
                                    'formName' => 'Terpilih'
                                ])->setPaper('a4', 'landscape');

                                return response()->streamDownload(
                                    fn () => print($pdf->output()),
                                    "submission_export_selected_" . now()->format('Y-m-d_H-i') . ".pdf"
                                );
                            }
                        }),
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function ($query) {
                // Auto-filter by form_id from URL parameter
                if (request()->has('tableFilters') && isset(request('tableFilters')['form_id']['value'])) {
                    $query->where('form_id', request('tableFilters')['form_id']['value']);
                }
            });
    }

    public static function infolist(Schema $schema): Schema
    {
        return \App\Filament\Resources\FormSubmissions\Schemas\FormSubmissionInfolist::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFormSubmissions::route('/'),
            'view' => ViewFormSubmission::route('/{record}'),
        ];
    }
}
