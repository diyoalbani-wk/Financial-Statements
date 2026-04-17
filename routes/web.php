<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\OutcomeController;
use App\Models\Income;
use App\Models\Outcome;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('incomes', IncomeController::class);
Route::resource('outcomes', OutcomeController::class);

Route::get('/laporan/export-pdf', function () {

    $incomes = Income::orderBy('tanggal')->get();
    $outcomes = Outcome::orderBy('tanggal')->get();

    $pdf = Pdf::loadView('exports.laporan-keuangan', [
        'incomes' => $incomes,
        'outcomes' => $outcomes,
    ])->setPaper('a4', 'portrait');

    return $pdf->download('laporan-keuangan.pdf');
});
