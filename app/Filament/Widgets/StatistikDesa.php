<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatistikDesa extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Penduduk', 3240)
                ->description('Total warga Desa Sumbersari')
                ->icon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Kepala Keluarga', 980)
                ->description('Jumlah KK terdaftar')
                ->icon('heroicon-o-home-modern')
                ->color('success'),

            Stat::make('Layanan Publik', 7)
                ->description('Jenis layanan aktif')
                ->icon('heroicon-o-document-text')
                ->color('warning'),

            Stat::make('Fasilitas Umum', 18)
                ->description('Fasum desa')
                ->icon('heroicon-o-building-office')
                ->color('info'),
        ];
    }
}
