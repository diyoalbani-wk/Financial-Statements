<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; 
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\LaporanKeuangan; 
use Illuminate\Support\Facades\Log;

class LaporanKeuanganMail extends Mailable implements ShouldQueue 
{
    use Queueable, SerializesModels;

    public function __construct(
        public int $bulan,
        public int $tahun,
        public array $formData
    ) {}

    public function build()
    {
        Log::info('Worker memproses email: ' . $this->formData['email']);

    $dataLaporan = LaporanKeuangan::query()
        ->whereYear('tanggal', $this->tahun)
        ->whereMonth('tanggal', $this->bulan)
        ->get();        

        $pdf = Pdf::loadView('exports.laporan-keuangan', [
            'incomes' => $dataLaporan->where('tipe', 'income'),
            'outcomes' => $dataLaporan->where('tipe', 'outcome'),

            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
        ])->output();

        return $this->subject('Laporan Keuangan - ' . $this->formData['nama'])
            ->view('emails.laporan')
            ->with([
                'pesan' => $this->formData['pesan'],
                'nama'  => $this->formData['nama'],
                'bulan' => $this->formData['bulan'], 
                'tahun' => $this->formData['tahun'], 
            ])
            ->attachData($pdf, 'Laporan_Keuangan.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}