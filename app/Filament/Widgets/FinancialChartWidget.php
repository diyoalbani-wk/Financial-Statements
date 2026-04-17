<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable; 
use App\Filament\Resources\LaporanResource\Pages\ManageLaporan;
use Illuminate\Support\Carbon;

class FinancialChartWidget extends ChartWidget
{
    use InteractsWithPageTable; 

    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function getHeading(): string
    {
        return 'Grafik Tren Keuangan (Berdasarkan Filter)';
    }

    protected function getTablePage(): string
    {
        return ManageLaporan::class;
    }

   protected function getData(): array
    {
        $query = $this->getPageTableQuery()->reorder(); 

        $data = $query->clone()
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as month_group, 
                SUM(CASE WHEN tipe = 'income' THEN nominal ELSE 0 END) as total_income,
                SUM(CASE WHEN tipe = 'outcome' THEN nominal ELSE 0 END) as total_outcome")
            ->groupBy('month_group')
            ->orderBy('month_group', 'asc') 
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Pendapatan',
                    'data' => $data->pluck('total_income')->toArray(),
                    'borderColor' => 'rgba(34, 197, 94, 1)',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'fill' => 'start',
                    'tension' => 0.4, 
                    'pointRadius' => 3,
                ],
                [
                    'label' => 'Total Pengeluaran',
                    'data' => $data->pluck('total_outcome')->toArray(),
                    'borderColor' => 'rgba(239, 68, 68, 1)',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'fill' => 'start',
                    'tension' => 0.4, 
                    'pointRadius' => 3,
                ],
            ],
            'labels' => $data->map(fn($item) => \Carbon\Carbon::parse($item->month_group)->format('M Y'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
            'scales' => [
                'x' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Periode (Bulan)',
                    ],
                ],
                'y' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Nominal (IDR)',
                    ],
                ],
            ],
            'interaction' => [
                'mode' => 'nearest',
                'axis' => 'x',
                'intersect' => false,
            ],
        ];
    }
}
