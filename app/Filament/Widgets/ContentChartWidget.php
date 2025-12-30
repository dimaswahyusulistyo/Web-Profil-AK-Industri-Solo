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
        $months = collect(range(2, 0))->map(function ($monthsAgo) {
            return Carbon::now()->subMonths($monthsAgo);
        });

        $beritaData = $months->map(function ($month) {
            return Berita::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        });

        $pengumumanData = $months->map(function ($month) {
            return Pengumuman::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Berita',
                    'data' => $beritaData->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => 'rgb(59, 130, 246)',
                ],
                [
                    'label' => 'Pengumuman',
                    'data' => $pengumumanData->toArray(),
                    'backgroundColor' => 'rgba(16, 185, 129, 0.5)',
                    'borderColor' => 'rgb(16, 185, 129)',
                ],
            ],
            'labels' => $months->map(fn ($month) => $month->format('M Y'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
