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
    public function index()
    {
        $jadwal = JadwalKuliah::with(['pengampu.matakuliah', 'pengampu.dosen', 'ruang', 'hari', 'jam', 'kelas'])
            ->paginate(10);
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
        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui!');
    }
    public function destroy($id)
    {
        $jadwal = JadwalKuliah::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }

    public function generateJadwal(Request $request)
    {
        // Hapus jadwal yang ada untuk tahun akademik yang sama
        JadwalKuliah::where('tahun_akademik', $request->tahun_akademik)->delete();

        $pengampuList = Pengampu::with(['matakuliah', 'dosen'])
            ->where('tahun_akademik', $request->tahun_akademik)
            ->get();
        
        $ruangList = Ruang::all();
        $hariList = Hari::all();
        $jamList = Jam::all();
        $kelasList = Kelas::all();

        foreach ($pengampuList as $pengampu) {
            $jadwalTersedia = false;
            
            // Hitung durasi waktu berdasarkan SKS
            $sks = $pengampu->matakuliah->sks; // Misal, ambil SKS dari model matakuliah
            $durasi = $sks * 50; // Hitung durasi dalam menit
            $jamMulai = null;

            foreach ($hariList as $hari) {
                if ($jadwalTersedia) break;
                
                foreach ($jamList as $jam) {
                    // Skip jika waktu shalat
                    if ($jam->waktu_shalat) continue;

                    // Hitung waktu selesai
                    $jamMulai = $jam->id; // Asumsikan jam ini adalah jam mulai
                    $jamSelesai = $jam->id + ($durasi / 60); // Menghitung jam selesai (asumsi jam dalam format jam ke-1, jam ke-2, dst.)

                    foreach ($ruangList as $ruang) {
                        // Cek kapasitas ruangan
                        if ($ruang->kapasitas < $pengampu->matakuliah->kapasitas_minimum) {
                            continue;
                        }
                        
                        // Cek bentrokan jadwal
                        $bentrok = JadwalKuliah::where('hari_id', $hari->id)
                            ->where('jam_id', $jamMulai)
                            ->where(function($query) use ($ruang, $pengampu, $jamSelesai) {
                                $query->where('ruang_id', $ruang->id)
                                    ->orWhere(function($q) use ($pengampu, $jamSelesai) {
                                        $q->where('pengampu_id', $pengampu->id)
                                        ->where('jam_id', '<=', $jamSelesai);
                                    });
                            })
                            ->exists();
                            
                        if (!$bentrok) {
                            foreach ($kelasList as $kelas) {
                                if ($kelas->prodi_id == $pengampu->matakuliah->prodi_id) {
                                    JadwalKuliah::create([
                                        'pengampu_id' => $pengampu->id,
                                        'ruang_id' => $ruang->id,
                                        'hari_id' => $hari->id,
                                        'jam_id' => $jamMulai, // Menggunakan jam mulai
                                        'kelas_id' => $kelas->id,
                                        'tahun_akademik' => $request->tahun_akademik
                                    ]);
                                    
                                    $jadwalTersedia = true;
                                    break;
                                }
                            }
                        }
                        
                        if ($jadwalTersedia) break;
                    }
                    if ($jadwalTersedia) break;
                }
            }
        }
        

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil digenerate!');
}
}