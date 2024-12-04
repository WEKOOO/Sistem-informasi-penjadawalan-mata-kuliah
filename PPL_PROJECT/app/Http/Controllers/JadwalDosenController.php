<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalKuliah;

class JadwalDosenController extends Controller
{
    /**
     * Menampilkan semua data jadwal kuliah.
     */
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
        return view('jadwaldosen.index', compact('jadwalKuliah'));
    }
    

    /**
     * Menyalin data dari tabel jadwal_kuliah ke tabel jadwal_dosen.
     */
}
