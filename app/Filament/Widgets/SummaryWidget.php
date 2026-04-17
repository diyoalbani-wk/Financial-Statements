<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable; 
use App\Filament\Resources\LaporanResource\Pages\ManageLaporan; 

class SummaryWidget extends BaseWidget
{
    use InteractsWithPageTable; 

    protected static ?int $sort = 1;

    protected function getTablePage(): string
    {
        return ManageLaporan::class;
    }

    protected function getStats(): array
    {
        $query = $this->getPageTableQuery();

        $totalIncome = $query->clone()->where('tipe', 'income')->sum('nominal');
        $totalOutcome = $query->clone()->where('tipe', 'outcome')->sum('nominal');
        $saldo = $totalIncome - $totalOutcome;

        return [
            Stat::make('Total Pemasukan', 'IDR ' . number_format($totalIncome, 0, ',', '.'))
                ->description('Total uang masuk')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),

            Stat::make('Total Pengeluaran', 'IDR ' . number_format($totalOutcome, 0, ',', '.'))
                ->description('Total uang keluar ')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            Stat::make('Total Saldo', 'IDR ' . number_format($saldo, 0, ',', '.'))
                ->description('Total uang tersimpan')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($saldo >= 0 ? 'warning' : 'danger'),
        ];
    }
}
