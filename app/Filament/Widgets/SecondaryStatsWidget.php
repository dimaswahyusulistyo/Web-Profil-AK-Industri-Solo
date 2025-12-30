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

    protected function getStats(): array
    {
        $komentarTotal = Komentar::count();
        $komentarApproved = Komentar::where('is_approved', true)->count();
        $aspirasiTotal = AspirasiAduan::count();
        $aspirasiWithResponse = AspirasiAduan::whereNotNull('tanggapan')->count();

        return [
            Stat::make('Mitra', Mitra::count())
                ->description('Mitra kerjasama')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning'),

            Stat::make('Komentar', $komentarTotal)
                ->description("✓ Disetujui: {$komentarApproved} | ⏳ Pending: " . ($komentarTotal - $komentarApproved))
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('info'),

            Stat::make('Aspirasi & Aduan', $aspirasiTotal)
                ->description("✓ Ditanggapi: {$aspirasiWithResponse} | ⏳ Belum: " . ($aspirasiTotal - $aspirasiWithResponse))
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('danger'),
        ];
    }
}
