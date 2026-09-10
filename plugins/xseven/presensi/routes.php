<?php

use Illuminate\Support\Facades\Route;
use XSeven\Presensi\Http\Controllers\FrontendController;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () { return redirect('/presensi/login'); });
    Route::get('/presensi/login', [FrontendController::class, 'loginForm'])->name('presensi.login.form');
    Route::post('/presensi/login', [FrontendController::class, 'login'])->name('presensi.login');
    Route::get('/presensi/logout', [FrontendController::class, 'logout'])->name('presensi.logout');
    Route::get('/presensi/dashboard', [FrontendController::class, 'dashboard'])->name('presensi.dashboard');
    Route::get('/presensi/riwayat', [FrontendController::class, 'riwayat'])->name('presensi.riwayat');
    Route::post('/presensi/checkin', [FrontendController::class, 'checkin'])->name('presensi.checkin');
    Route::post('/presensi/checkout', [FrontendController::class, 'checkout'])->name('presensi.checkout');
    Route::get('/presensi/foto/{id}/{type}', [FrontendController::class, 'viewFoto'])->name('presensi.foto');
});
