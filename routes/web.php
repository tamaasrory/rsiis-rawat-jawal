<?php

use App\Http\Controllers\AsesmenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PasienController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [HomeController::class, 'index'])->name('home');

// Modul Pendaftaran — Pasien
Route::resource('pasien', PasienController::class)->only([
    'index', 'create', 'store', 'edit', 'update',
]);
Route::get('pasien/{pasien}/kunjungan', [PasienController::class, 'kunjungan'])
    ->name('pasien.kunjungan');

// Kunjungan — Batal & Tambah
Route::post('kunjungan/{kunjungan}/batal', [KunjunganController::class, 'batal'])
    ->name('kunjungan.batal');
Route::post('pasien/{pasien}/kunjungan', [KunjunganController::class, 'store'])
    ->name('kunjungan.store');

// Modul Asesmen
Route::get('asesmen', [AsesmenController::class, 'index'])->name('asesmen.index');
Route::get('asesmen/create/{kunjungan}', [AsesmenController::class, 'create'])->name('asesmen.create');
Route::post('asesmen', [AsesmenController::class, 'store'])->name('asesmen.store');
Route::get('asesmen/{asesmen}/edit', [AsesmenController::class, 'edit'])->name('asesmen.edit');
Route::put('asesmen/{asesmen}', [AsesmenController::class, 'update'])->name('asesmen.update');

// Modul Laporan (placeholder, Fase 4)
Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
