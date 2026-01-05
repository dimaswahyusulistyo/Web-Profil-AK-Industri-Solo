<?php

namespace App\Filament\Navigation;

use App\Models\Form;
use App\Models\FormSubmission;
use Filament\Navigation\NavigationItem;

class DynamicFormNavigation
{
    public static function getItems(): array
    {
        $items = [];
        
        // Get all active forms
        $forms = Form::where('is_active', true)
            ->orderBy('name')
            ->get();
        
        foreach ($forms as $form) {
            $submissionCount = FormSubmission::where('form_id', $form->id)->count();
            
            $items[] = NavigationItem::make($form->name)
                ->url('/admin/form-submissions?tableFilters[form_id][value]=' . $form->id)
                ->icon('heroicon-o-document-text')
                ->badge($submissionCount > 0 ? $submissionCount : null)
                ->group('Management Form')
                ->sort(100 + $form->id);
        }
        
        return $items;
    }
}
