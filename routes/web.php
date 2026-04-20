<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Resources\IncomeResource;
use App\Filament\Resources\OutcomeResource;
use App\Models\Outcome;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('incomes', IncomeResource::class);
Route::resource('outcomes',OutcomeResource::class);

Route::get('/laporan/export-pdf', function () {

    $incomes = Income::orderBy('tanggal')->get();
    $outcomes = Outcome::orderBy('tanggal')->get();

    $pdf = Pdf::loadView('exports.laporan-keuangan', [
        'incomes' => $incomes,
        'outcomes' => $outcomes,
    ])->setPaper('a4', 'portrait');

    return $pdf->download('laporan-keuangan.pdf');
});

Route::get('/emails', function () {
    return view('emails.laporan', [
        'bulan' => 'April',
        'tahun' => '2026',
        'nama' => 'Bapak/Ibu',
        'pesan' => 'Laporan keuangan berkala Anda telah siap untuk ditinjau. Kami telah merangkum aktivitas keuangan Anda untuk periode berikut:'
    ]);
});