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
        // Ambil semua data dari tabel jadwal_kuliah
        $jadwalKuliah = JadwalKuliah::all();

        // Return data ke view atau sebagai JSON
        return view('jadwaldosen.index', compact('jadwalKuliah'));
    }

    /**
     * Menyalin data dari tabel jadwal_kuliah ke tabel jadwal_dosen.
     */
    public function copyToJadwalDosen()
    {
        try {
            // Ambil semua data dari jadwal_kuliah
            $jadwalKuliah = JadwalKuliah::all();

            // Proses memasukkan data ke tabel jadwal_dosen
            foreach ($jadwalKuliah as $jadwal) {
                // Asumsikan model JadwalDosen sudah ada
                \App\Models\JadwalDosen::create([
                    'pengampu_id'   => $jadwal->pengampu_id,
                    'ruang_id'      => $jadwal->ruang_id,
                    'hari_id'       => $jadwal->hari_id,
                    'jam_id'        => $jadwal->jam_id,
                    'kelas_id'      => $jadwal->kelas_id,
                    'tahun_akademik'=> $jadwal->tahun_akademik,
                ]);
            }

            return response()->json(['message' => 'Data berhasil disalin ke tabel jadwal_dosen.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
