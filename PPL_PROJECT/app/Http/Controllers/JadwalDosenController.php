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
        // Ambil kata kunci pencarian dari query string
        $search = $request->input('search');

        // Ambil data dari tabel jadwal_kuliah dengan relasi yang diperlukan
        $jadwalKuliah = JadwalKuliah::with([
            'hari',
            'jam',
            'pengampu.matakuliah',
            'pengampu.dosen',
            'ruang',
            'kelas',
        ])
        ->when($search, function ($query, $search) {
            // Filter data berdasarkan pencarian
            $query->whereHas('pengampu.dosen', function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->orWhereHas('pengampu.matakuliah', function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%");
            });
        })
        ->paginate(10); // Gunakan pagination dengan 10 item per halaman

        // Return data ke view
        return view('jadwaldosen.index', compact('jadwalKuliah', 'search'));
    }


    /**
     * Menyalin data dari tabel jadwal_kuliah ke tabel jadwal_dosen.
     */
}
