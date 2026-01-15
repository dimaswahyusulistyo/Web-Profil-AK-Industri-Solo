<?php

namespace App\Filament\Widgets;

use App\Models\FormSubmission;
use App\Models\Form;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FormSubmissionsWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';
    
    protected function getColumns(): int
    {
        return 3; // 3 cards per row
    }

    public static function canView(): bool
    {
        return false; // Hidden - stats moved to StatsOverviewWidget
    }

    protected function getStats(): array
    {
        $stats = [];
        $user = auth()->user();

        // General Form Submission stat (if user has general access)
        if ($user && $user->hasPermission('resource.FormSubmission')) {
            $totalSubmissions = FormSubmission::count();
            
            $stats[] = Stat::make('Total Submissions', $totalSubmissions)
                ->description('Semua form submissions')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success');
        }

        // Individual form stats (if user has specific form access)
        $forms = Form::where('is_active', true)->get();
        foreach ($forms as $form) {
            if ($user && $user->hasPermission("form.{$form->id}")) {
                $formSubmissions = FormSubmission::where('form_id', $form->id)->count();
                
                $stats[] = Stat::make($form->name, $formSubmissions)
                    ->description('Submissions')
                    ->descriptionIcon('heroicon-m-inbox')
                    ->color('info');
            }
        }

        return $stats;
    }
}
