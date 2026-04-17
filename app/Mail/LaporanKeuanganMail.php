<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LaporanKeuanganMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf;
    public $bulan;
    public $tahun;
    public $pesan;

    public function __construct($pdf, $data)
    {
        $this->pdf = $pdf;
        $this->bulan = $data['bulan'];
        $this->tahun = $data['tahun'];
        $this->pesan = $data['pesan'] ?? null;
    }

    public function build()
    {
        return $this->subject('Laporan Keuangan '.$this->bulan.'/'.$this->tahun)
            ->view('emails.laporan')
            ->attachData($this->pdf, 'laporan-keuangan.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}