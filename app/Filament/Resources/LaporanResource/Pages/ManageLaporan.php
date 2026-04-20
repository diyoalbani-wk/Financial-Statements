<?php

namespace App\Filament\Resources\LaporanResource\Pages;

use App\Filament\Resources\LaporanResource;
use App\Filament\Widgets\SummaryWidget;
use App\Filament\Widgets\FinancialChartWidget;
use App\Models\Income;
use App\Models\Outcome;
use App\Models\LaporanKeuangan;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Jobs\SendPdfEmailJob;

class ManageLaporan extends ManageRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = LaporanResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            SummaryWidget::class,
            FinancialChartWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [

            Actions\Action::make('export_pdf_email')
                ->label('Kirim PDF ke Email')
                ->icon('heroicon-o-envelope')
                ->color('primary')
                ->modalHeading('Kirim Laporan PDF ke Email')
                ->modalWidth('2xl')
                ->form([
                    Forms\Components\Select::make('bulan')
                        ->label('Bulan')
                        ->options([
                            '01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April',
                            '05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus',
                            '09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember',
                        ])
                        ->required()
                        ->default(date('m')),

                    Forms\Components\Select::make('tahun')
                        ->label('Tahun')
                        ->options(fn () => collect(range(2024, date('Y')))
                            ->mapWithKeys(fn ($y) => [$y => $y]))
                        ->required()
                        ->default(date('Y')),

                    Forms\Components\TextInput::make('nama')
                        ->label('Nama Penerima')
                        ->required()
                        ->placeholder('Masukkan nama penerima'),

                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required(),

                    Forms\Components\Textarea::make('pesan')
                        ->default('Berikut laporan keuangan Anda.')
                ])
                ->action(fn ($data) => $this->generateAndSendPdf($data)),

            Actions\Action::make('export_pdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->url(fn () => url('/laporan/export-pdf'))
                ->openUrlInNewTab(),

            Actions\Action::make('export_excel')
                ->label('Export Excel')
                ->icon('heroicon-o-table-cells')
                ->action('exportExcel'),
        ];
    }

    protected function generateAndSendPdf(array $data): void
    {
        try {
            $count = LaporanKeuangan::query()
                ->whereYear('tanggal', $data['tahun'])
                ->whereMonth('tanggal', $data['bulan'])
                ->count();

            if ($count === 0) {
                Notification::make()->title('Data kosong')->warning()->send();
                return;
            }

            Mail::to($data['email'])
            ->send(new \App\Mail\LaporanKeuanganMail(
                (int) $data['bulan'],
                (int) $data['tahun'],
                $data
            ));

            Notification::make()
                ->title('Antrean Dimulai')
                ->body('Laporan sedang diproses dan akan dikirim ke email Anda.')
                ->success()
                ->send();

        } catch (\Exception $e) {
            Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
        }
    }

    public function exportExcel()
    {
        $incomes = Income::all();
        $outcomes = Outcome::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'LAPORAN KEUANGAN');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', 'Tanggal Export: ' . now()->format('d F Y'));

        $sheet->setCellValue('A5', 'Tanggal');
        $sheet->setCellValue('B5', 'Tipe');
        $sheet->setCellValue('C5', 'Kategori');
        $sheet->setCellValue('D5', 'Nominal');
        $sheet->setCellValue('E5', 'Keterangan');

        $row = 6;

        foreach ($incomes as $i) {
            $sheet->setCellValue("A$row", $i->tanggal);
            $sheet->setCellValue("B$row", 'Pemasukan');
            $sheet->setCellValue("C$row", $i->kategori);
            $sheet->setCellValue("D$row", $i->nominal);
            $sheet->setCellValue("E$row", $i->keterangan);
            $row++;
        }

        foreach ($outcomes as $o) {
            $sheet->setCellValue("A$row", $o->tanggal);
            $sheet->setCellValue("B$row", 'Pengeluaran');
            $sheet->setCellValue("C$row", $o->kategori);
            $sheet->setCellValue("D$row", $o->nominal);
            $sheet->setCellValue("E$row", $o->keterangan);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'laporan.xlsx');
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')->date()->sortable(),
                Tables\Columns\TextColumn::make('tipe_label')->badge(),
                Tables\Columns\TextColumn::make('kategori')->badge(),
                Tables\Columns\TextColumn::make('nominal')->money('IDR'),
            ])

            ->filters([
                Tables\Filters\SelectFilter::make('tipe')
                    ->options([
                        'income' => 'Pemasukan',
                        'outcome' => 'Pengeluaran',
                    ]),

                Tables\Filters\SelectFilter::make('kategori')
                    ->options(function () {
                        return array_merge(
                            Income::getCategories(),
                            Outcome::getCategories()
                        );
                    }),

                Tables\Filters\Filter::make('tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('from'),  
                        Forms\Components\DatePicker::make('to'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $d) => $q->whereDate('tanggal','>=',$d))
                            ->when($data['to'], fn ($q, $d) => $q->whereDate('tanggal','<=',$d));
                    }),
            ]);
    }
}