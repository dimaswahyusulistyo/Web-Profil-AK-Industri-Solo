<?php

namespace App\Filament\Widgets;

use App\Models\Berita;
use App\Models\Pengumuman;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ContentChartWidget extends ChartWidget
{
    protected ?string $heading = 'Tren Konten (3 Bulan Terakhir)';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $user = auth()->user();
        $datasets = [];
        
        $months = collect(range(2, 0))->map(function ($monthsAgo) {
            return Carbon::now()->subMonths($monthsAgo);
        });

        // Berita dataset
        if ($user && $user->hasPermission('resource.Berita')) {
            $beritaData = $months->map(function ($month) {
                return Berita::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
            });

            $datasets[] = [
                'label' => 'Berita',
                'data' => $beritaData->toArray(),
                'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                'borderColor' => 'rgb(59, 130, 246)',
            ];
        }

        // Pengumuman dataset
        if ($user && $user->hasPermission('resource.Pengumuman')) {
            $pengumumanData = $months->map(function ($month) {
                return Pengumuman::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
            });

            $datasets[] = [
                'label' => 'Pengumuman',
                'data' => $pengumumanData->toArray(),
                'backgroundColor' => 'rgba(16, 185, 129, 0.5)',
                'borderColor' => 'rgb(16, 185, 129)',
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $months->map(fn ($month) => $month->format('M Y'))->toArray(),
        ];
    }

    public static function canView(): bool
    {
        $user = auth()->user();
        
        // Show widget if user has access to at least one resource
        return $user && (
            $user->hasPermission('resource.Berita') ||
            $user->hasPermission('resource.Pengumuman')
        );
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
