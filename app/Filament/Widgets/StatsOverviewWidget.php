<?php

namespace App\Filament\Widgets;

use App\Models\AspirasiAduan;
use App\Models\Berita;
use App\Models\Komentar;
use App\Models\Layanan;
use App\Models\Mitra;
use App\Models\Pengumuman;
use App\Models\Slider;
use App\Models\KontenBiasa;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';
    
    protected function getColumns(): int
    {
        return 3; // 3 cards per row
    }

    
    protected function getStats(): array
    {
        $stats = [];
        $user = auth()->user();

        // Berita stat
        if ($user && $user->hasPermission('resource.Berita')) {
            $stats[] = Stat::make('Berita', Berita::count())
                ->description('Artikel berita')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('success')
                ->chart([7, 5, 8, 6, 9]);
        }

        // Pengumuman stat
        if ($user && $user->hasPermission('resource.Pengumuman')) {
            $stats[] = Stat::make('Pengumuman', Pengumuman::count())
                ->description('Pengumuman')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('info')
                ->chart([3, 5, 4, 6, 5]);
        }

        // Layanan stat
        if ($user && $user->hasPermission('resource.Layanan')) {
            $stats[] = Stat::make('Layanan', Layanan::count())
                ->description('Layanan tersedia')
                ->descriptionIcon('heroicon-m-cog-6-tooth')
                ->color('primary');
        }

        // Konten Biasa stat
        if ($user && $user->hasPermission('resource.KontenBiasa')) {
            $stats[] = Stat::make('Konten Biasa', KontenBiasa::count())
                ->description('Halaman konten')
                ->descriptionIcon('heroicon-m-document-duplicate')
                ->color('warning');
        }

        // Slider stat
        if ($user && $user->hasPermission('resource.Slider')) {
            $stats[] = Stat::make('Slider', Slider::count())
                ->description('Banner slider')
                ->descriptionIcon('heroicon-m-photo')
                ->color('danger');
        }

        // Mitra stat
        if ($user && $user->hasPermission('resource.Mitra')) {
            $stats[] = Stat::make('Mitra', Mitra::count())
                ->description('Mitra kerjasama')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning');
        }

        // Komentar stat
        if ($user && $user->hasPermission('resource.Komentar')) {
            $komentarTotal = Komentar::count();
            $komentarApproved = Komentar::where('is_approved', true)->count();
            
            $stats[] = Stat::make('Komentar', $komentarTotal)
                ->description("✓ Disetujui: {$komentarApproved} | ⏳ Pending: " . ($komentarTotal - $komentarApproved))
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('info');
        }

        // Form Submissions - General
        if ($user && $user->hasPermission('resource.FormSubmission')) {
            $totalSubmissions = \App\Models\FormSubmission::count();
            
            $stats[] = Stat::make('Total Submissions', $totalSubmissions)
                ->description('Semua form submissions')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success');
        }

        // Form Submissions - Individual forms
        $forms = \App\Models\Form::where('is_active', true)->get();
        foreach ($forms as $form) {
            if ($user && $user->hasPermission("form.{$form->id}")) {
                $formSubmissions = \App\Models\FormSubmission::where('form_id', $form->id)->count();
                
                $stats[] = Stat::make($form->name, $formSubmissions)
                    ->description('Submissions')
                    ->descriptionIcon('heroicon-m-inbox')
                    ->color('info');
            }
        }

        return $stats;
    }

    public static function canView(): bool
    {
        $user = auth()->user();
        
        if (!$user) {
            return false;
        }

        // Show widget if user has access to at least one resource
        return $user && (
            $user->hasPermission('resource.Berita') ||
            $user->hasPermission('resource.Pengumuman') ||
            $user->hasPermission('resource.Layanan') ||
            $user->hasPermission('resource.KontenBiasa') ||
            $user->hasPermission('resource.Slider') ||
            $user->hasPermission('resource.Mitra') ||
            $user->hasPermission('resource.Komentar') ||
            $user->hasPermission('resource.FormSubmission') ||
            \App\Models\Form::where('is_active', true)->get()->some(fn($form) => $user->hasPermission("form.{$form->id}"))
        );
    }
}
