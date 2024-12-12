<?php

namespace App\Http\Controllers;

use App\Models\JadwalKuliah;
use App\Models\Pengampu;
use App\Models\Ruang;
use App\Models\Hari;
use App\Models\Jam;
use App\Models\Kelas;
use Illuminate\Http\Request;

class JadwalKuliahController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalKuliah::with(['pengampu.matakuliah', 'pengampu.dosen', 'ruang', 'hari', 'jam', 'kelas']);

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->whereHas('pengampu.matakuliah', function($q) use ($searchTerm) {
                $q->where('nama', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('pengampu.dosen', function($q) use ($searchTerm) {
                $q->where('nama', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('ruang', function($q) use ($searchTerm) {
                $q->where('nama_ruang', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('hari', function($q) use ($searchTerm) {
                $q->where('nama_hari', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('jam', function($q) use ($searchTerm) {
                $q->where('jam_mulai', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('kelas', function($q) use ($searchTerm) {
                $q->where('nama_kelas', 'like', '%' . $searchTerm . '%');
            });
        }

        $jadwal = $query->paginate(10);
        $jadwal->appends($request->all()); // Preserve query parameters in pagination

        return view('jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        $pengampu = Pengampu::with(['matakuliah', 'dosen'])->get();
        $ruang = Ruang::all();
        $hari = Hari::all();
        $jam = Jam::all();
        $kelas = Kelas::all();

        return view('jadwal.create', compact('pengampu', 'ruang', 'hari', 'jam', 'kelas'));
    }

    public function edit($id)
    {
        $jadwal = JadwalKuliah::with(['pengampu.matakuliah', 'pengampu.dosen', 'ruang', 'hari', 'jam', 'kelas'])
            ->findOrFail($id);

        $pengampu = Pengampu::with(['matakuliah', 'dosen'])->get();
        $ruang = Ruang::all();
        $hari = Hari::all();
        $jam = Jam::all();
        $kelas = Kelas::all();

        return view('jadwal.edit', compact('jadwal', 'pengampu', 'ruang', 'hari', 'jam', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pengampu_id' => 'required',
            'ruang_id' => 'required',
            'hari_id' => 'required',
            'jam_id' => 'required',
            'kelas_id' => 'required',
            'tahun_akademik' => 'required',
        ]);

        $jadwal = JadwalKuliah::findOrFail($id);
        $jadwal->update($request->only([
            'pengampu_id',
            'ruang_id',
            'hari_id',
            'jam_id',
            'kelas_id',
            'tahun_akademik'
        ]));

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jadwal = JadwalKuliah::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }

   // Fungsi untuk menghasilkan jadwal kuliah berdasarkan permintaan
   public function generateJadwal(Request $request)
{
    // Hapus jadwal yang sudah ada untuk tahun akademik yang diberikan
    JadwalKuliah::where('tahun_akademik', $request->tahun_akademik)->delete();

    // Ambil data pengampu mata kuliah beserta relasi dengan matakuliah dan dosen
    $pengampuList = Pengampu::with(['matakuliah', 'dosen'])
        ->where('tahun_akademik', $request->tahun_akademik)
        ->get();

    // Ambil daftar semua ruangan
    $ruangList = Ruang::all();

    // Ambil daftar semua hari
    $hariList = Hari::all();

    // Ambil daftar semua kelas
    $kelasList = Kelas::all();

    // Variabel untuk melacak hari yang sudah digunakan untuk setiap mata kuliah
    $courseScheduledDays = [];

    // Variabel untuk melacak pengampu yang gagal dijadwalkan
    $jadwalGagal = [];

    // Loop untuk setiap pengampu mata kuliah
    foreach ($pengampuList as $pengampu) {
        $jadwalTersedia = false; // Indikator apakah jadwal telah ditemukan

        // Ambil daftar jam berdasarkan jumlah SKS mata kuliah
        $jamList = Jam::getJamBySKS($pengampu->matakuliah->sks);

        // Acak daftar hari untuk memberikan variasi jadwal
        $shuffledHariList = $hariList->shuffle();

        // Loop melalui daftar hari yang telah diacak
        foreach ($shuffledHariList as $hari) {
            // Lewati jika mata kuliah ini sudah dijadwalkan pada hari tersebut
            if (isset($courseScheduledDays[$pengampu->matakuliah->id]) &&
                in_array($hari->id, $courseScheduledDays[$pengampu->matakuliah->id])) {
                continue;
            }

            if ($jadwalTersedia) break; // Keluar jika jadwal sudah ditemukan

            // Loop melalui daftar jam
            foreach ($jamList as $jam) {
                $sks = $pengampu->matakuliah->sks; // Ambil jumlah SKS mata kuliah
                $durasi = $sks * 50; // Hitung durasi dalam menit (1 SKS = 50 menit)
                $jamMulai = $jam->id; // Jam mulai
                $jamSelesai = $jamMulai + ceil($durasi / 60); // Hitung jam selesai

                // Loop melalui daftar ruangan
                foreach ($ruangList as $ruang) {
                    // Cek apakah kapasitas ruangan memenuhi syarat
                    if ($ruang->kapasitas < $pengampu->matakuliah->kapasitas_minimum) {
                        continue; // Lewati jika kapasitas tidak mencukupi
                    }

                    // Loop melalui daftar kelas
                    foreach ($kelasList as $kelas) {
                        // Pastikan kelas berasal dari program studi yang sesuai
                        if ($kelas->prodi_id == $pengampu->matakuliah->prodi_id) {
                            // Cek apakah ada bentrokan jadwal pada ruangan atau pengampu
                            $bentrok = JadwalKuliah::where('hari_id', $hari->id)
                                ->where('jam_id', $jamMulai)
                                ->where(function($query) use ($ruang, $pengampu, $jamSelesai) {
                                    $query->where('ruang_id', $ruang->id) // Bentrokan dengan ruangan
                                        ->orWhere(function($q) use ($pengampu, $jamSelesai) {
                                            $q->where('pengampu_id', $pengampu->id) // Bentrokan dengan pengampu
                                                ->where('jam_id', '<=', $jamSelesai); // Bentrokan waktu selesai
                                        });
                                })
                                ->exists();

                            // Cek konflik pada kelas
                            $bentrokKelas = JadwalKuliah::where('hari_id', $hari->id)
                                ->where('jam_id', $jamMulai)
                                ->where('kelas_id', $kelas->id)
                                ->exists();

                            if (!$bentrok && !$bentrokKelas) {
                                // Buat entri jadwal baru
                                JadwalKuliah::create([
                                    'pengampu_id' => $pengampu->id,
                                    'ruang_id' => $ruang->id,
                                    'hari_id' => $hari->id,
                                    'jam_id' => $jamMulai,
                                    'kelas_id' => $kelas->id,
                                    'tahun_akademik' => $request->tahun_akademik
                                ]);

                                // Tandai hari untuk mata kuliah ini
                                $courseScheduledDays[$pengampu->matakuliah->id][] = $hari->id;

                                $jadwalTersedia = true; // Jadwal telah ditemukan
                                break;
                            }
                        }
                    }

                    if ($jadwalTersedia) break; // Keluar jika jadwal ditemukan
                }
                if ($jadwalTersedia) break; // Keluar jika jadwal ditemukan
            }
        }

        // Jika tidak ada jadwal tersedia, tambahkan ke daftar gagal
        if (!$jadwalTersedia) {
            $jadwalGagal[] = $pengampu;
        }
    }

    // Jika ada pengampu yang gagal dijadwalkan, tambahkan notifikasi
    if (!empty($jadwalGagal)) {
        return redirect()->route('jadwal.index')
            ->with('warning', 'Beberapa mata kuliah gagal dijadwalkan. Silakan cek log.');
    }

    // Redirect ke halaman jadwal dengan pesan sukses
    return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil digenerate!');
}




}
