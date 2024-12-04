<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalKuliah;

class JadwalDosenController extends Controller
{
    /**
     * Menampilkan semua data jadwal kuliah.
     */
    public function index(Request $request)
{
    $search = $request->input('search');
    
    $jadwalKuliah = JadwalKuliah::when($search, function($query) use ($search) {
        $query->whereHas('pengampu.matakuliah', function($q) use ($search) {
            $q->where('nama', 'like', '%'.$search.'%');
        })->orWhereHas('pengampu.dosen', function($q) use ($search) {
            $q->where('nama', 'like', '%'.$search.'%');
        })->orWhereHas('ruang', function($q) use ($search) {
            $q->where('nama_ruang', 'like', '%' . $search . '%');
        })->orWhereHas('hari', function($q) use ($search) {
            $q->where('nama_hari', 'like', '%' . $search. '%');    
        })->orWhereHas('kelas', function($q) use ($search) {
            $q->where('nama_kelas', 'like', '%' . $search . '%');
        });
    })->paginate(10);

    return view('jadwaldosen.index', compact('jadwalKuliah', 'search'));
}

    /**
     * Menyalin data dari tabel jadwal_kuliah ke tabel jadwal_dosen.
     */
}
