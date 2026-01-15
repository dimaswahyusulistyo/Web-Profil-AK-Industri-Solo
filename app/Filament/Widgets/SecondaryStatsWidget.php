<?php

namespace App\Filament\Widgets;

use App\Models\AspirasiAduan;
use App\Models\Komentar;
use App\Models\Mitra;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SecondaryStatsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
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

        return $stats;
    }
}
