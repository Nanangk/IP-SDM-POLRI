<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pegawai-import', [PegawaiController::class, 'importForm'])
        ->name('pegawai.import.form');

    Route::post('/pegawai-import', [PegawaiController::class, 'import'])
        ->name('pegawai.import');

    Route::get('/pegawai-import-template', [PegawaiController::class, 'downloadTemplate'])
        ->name('pegawai.import.template');

    Route::get('/pegawai-export', [PegawaiController::class, 'export'])
        ->name('pegawai.export');

    Route::resource('pegawai', PegawaiController::class);
});

require __DIR__ . '/auth.php';
