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
        
        $forms = Form::where('is_active', true)
            ->orderBy('name')
            ->get();
        
        $user = auth()->user();
        if (!$user) return [];

        $isAdmin = $user->roles()->where('nama_role', 'Admin')->exists();

        foreach ($forms as $form) {
            if (!$isAdmin && !$user->hasPermission("form.{$form->id}")) {
                continue;
            }

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
