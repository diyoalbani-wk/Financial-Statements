<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\LaporanKeuangan;
use Illuminate\Support\Facades\Mail;
use App\Mail\LaporanKeuanganMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\User;

class SendMonthlyReportJob implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        $now = Carbon::now();

        $bulan = (int) $now->subMonth()->format('m');
        $tahun = (int) $now->format('Y');

        $laporan = LaporanKeuangan::query()
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get();

        if ($laporan->isEmpty()) {
            return;
        }

        $users = User::all();

        foreach ($users as $user) {
            $formData = [
                'nama' => $user->name,
                'email' => $user->email,
                'pesan' => 'Laporan keuangan otomatis',
                'bulan' => str_pad($bulan, 2, '0', STR_PAD_LEFT),
                'tahun' => $tahun,
            ];

            Mail::to($user->email)->send(
                new LaporanKeuanganMail(
                    $bulan,
                    $tahun,
                    $formData,
                    $laporan     
                )
            );
        }
    }
}