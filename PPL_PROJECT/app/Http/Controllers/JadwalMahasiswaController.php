<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JadwalMahasiswaController extends Controller
{
    public function index()
    {
        // Ambil data dari tabel jadwal_kuliah dengan relasi yang diperlukan
        $jadwalKuliah = \App\Models\JadwalKuliah::with([
            'hari',
            'jam',
            'pengampu.matakuliah',
            'pengampu.dosen',
            'ruang',
            'kelas',
        ])->get();

        // Return data ke view
        return view('jadwalmahasiswa.index', compact('jadwalKuliah'));
    }
}
