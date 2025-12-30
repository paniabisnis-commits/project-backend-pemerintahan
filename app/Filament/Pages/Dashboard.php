<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatistikDesa;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'Dashboard';

    /**
     * ✅ SATU-SATUNYA TEMPAT MENAMPILKAN WIDGET
     */
    protected function getHeaderWidgets(): array
    {
        return [
            StatistikDesa::class,
        ];
    }

    /**
     * 🔴 PENTING!
     * Pastikan Dashboard TIDAK punya widget lain
     */
    protected function getFooterWidgets(): array
    {
        return [];
    }
}
