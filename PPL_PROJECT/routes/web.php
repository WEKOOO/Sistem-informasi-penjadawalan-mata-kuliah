<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JamController;
use App\Http\Controllers\PengampuController;
use App\Http\Controllers\JadwalKuliahController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JadwalDosenController;
use App\Http\Controllers\JadwalMahasiswaController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index']);
});

Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/dashboard-dosen/dosen', [LoginController::class, 'index']);
});

Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/dashboard/mahasiswa', [MahasiswaController::class, 'index']);
});

// Contoh route utama (landing page)
Route::get('dashboard', function () {
    return view('dashboard');
});
Route::get('dashboard-dosen', function () {
    return view('dashboard-dosen');
});
Route::get('dashboard-mahasiswa', function () {
    return view('dashboard-mahasiswa');
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

Route::get('/jadwaldosen', [JadwalDosenController::class, 'index'])->name('jadwaldosen.index');
Route::post('/jadwaldosen/copy', [JadwalDosenController::class, 'copyToJadwalDosen'])->name('jadwaldosen.copy');

Route::get('/jadwalmahasiswa', [JadwalMahasiswaController::class, 'index'])->name('jadwalmahasiswa.index');

Route::resource('jadwal', JadwalKuliahController::class);
Route::post('jadwal/generate', [JadwalKuliahController::class, 'generateJadwal'])->name('jadwal.generate');
Route::post('jadwal/store', [JadwalKuliahController::class, 'store'])->name('jadwal.store');
Route::get('jadwal/{id}/edit', [JadwalKuliahController::class, 'edit'])->name('jadwal.edit');
Route::put('jadwal/{id}', [JadwalKuliahController::class, 'update'])->name('jadwal.update');
Route::delete('jadwal/{id}', [JadwalKuliahController::class, 'destroy'])->name('jadwal.destroy');

// Tambahan untuk navigasi
Route::get('/kelas/navigation', [KelasController::class, 'navigation'])->name('kelas.navigation');
Route::get('/prodi/navigation', [ProdiController::class, 'navigation'])->name('prodi.navigation');
Route::get('/dosen/navigation', [DosenController::class, 'navigation'])->name('dosen.navigation');
Route::get('/ruang/navigation', [RuangController::class, 'navigation'])->name('ruang.navigation');
Route::get('/jam/navigation', [JamController::class, 'navigation'])->name('jam.navigation');
Route::get('/pengampu/navigation', [PengampuController::class, 'navigation'])->name('pengampu.navigation');


Route::post('/login', [LoginController::class, 'login']);
// login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::post('/user/{id}/update-password', [UserController::class, 'updatePassword'])->name('user.updatePassword');

Route::post('/', [LoginController::class, 'login']);
// login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/', [LoginController::class, 'login'])->name('login');
