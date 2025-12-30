<?php

namespace App\Filament\Widgets;

use App\Models\AspirasiAduan;
use App\Models\Berita;
use App\Models\Komentar;
use App\Models\Layanan;
use App\Models\Mitra;
use App\Models\Pengumuman;
use App\Models\Slider;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Berita', Berita::count())
                ->description('Artikel berita')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('success')
                ->chart([7, 5, 8, 6, 9]),

            Stat::make('Pengumuman', Pengumuman::count())
                ->description('Pengumuman')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('info')
                ->chart([3, 5, 4, 6, 5]),

            Stat::make('Layanan', Layanan::count())
                ->description('Layanan tersedia')
                ->descriptionIcon('heroicon-m-cog-6-tooth')
                ->color('primary'),
        ];
    }
}
