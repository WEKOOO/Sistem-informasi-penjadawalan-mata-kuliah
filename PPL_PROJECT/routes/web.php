<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JamController;
use App\Http\Controllers\PengampuController;
use App\Http\Controllers\JadwalKuliahController;

// Contoh route utama (landing page)
Route::get('/', function () {
    return view('dashboard');
});

// Resource routes
Route::resource('matakuliah', MataKuliahController::class);
Route::resource('dosen', DosenController::class);
Route::resource('prodi', ProdiController::class);
Route::resource('ruang', RuangController::class);
Route::resource('kelas', KelasController::class)->parameters([
    'kelas' => 'kelas'
]);
Route::resource('jam', JamController::class)->parameters([
    'jam' => 'jam'
]);
Route::resource('pengampu', PengampuController::class)->parameters([
    'pengampu' => 'pengampu'
]);

Route::resource('jadwal', JadwalKuliahController::class);
Route::post('jadwal/generate', [JadwalKuliahController::class, 'generateJadwal'])->name('jadwal.generate');

// Tambahan untuk navigasi
Route::get('/kelas/navigation', [KelasController::class, 'navigation'])->name('kelas.navigation');
Route::get('/prodi/navigation', [ProdiController::class, 'navigation'])->name('prodi.navigation');
Route::get('/dosen/navigation', [DosenController::class, 'navigation'])->name('dosen.navigation');
Route::get('/ruang/navigation', [RuangController::class, 'navigation'])->name('ruang.navigation');
Route::get('/jam/navigation', [JamController::class, 'navigation'])->name('jam.navigation');
Route::get('/pengampu/navigation', [PengampuController::class, 'navigation'])->name('pengampu.navigation');
