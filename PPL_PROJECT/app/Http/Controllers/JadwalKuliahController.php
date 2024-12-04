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

    public function generateJadwal(Request $request)
    {
        // Hapus jadwal yang ada untuk tahun akademik yang sama
        JadwalKuliah::where('tahun_akademik', $request->tahun_akademik)->delete();

        $pengampuList = Pengampu::with(['matakuliah', 'dosen'])
            ->where('tahun_akademik', $request->tahun_akademik)
            ->get();
        
        $ruangList = Ruang::all();
        $hariList = Hari::all();
        $kelasList = Kelas::all();

        // Track used days for each course to ensure variety
        $courseScheduledDays = [];

        foreach ($pengampuList as $pengampu) {
            $jadwalTersedia = false;
            
            // Ambil jam sesuai SKS mata kuliah
            $jamList = Jam::getJamBySKS($pengampu->matakuliah->sks);

            // Shuffle hari list to add randomness to scheduling
            $shuffledHariList = $hariList->shuffle();

            foreach ($shuffledHariList as $hari) {
                // Skip if this course has already been scheduled on this day
                if (isset($courseScheduledDays[$pengampu->matakuliah->id]) && 
                    in_array($hari->id, $courseScheduledDays[$pengampu->matakuliah->id])) {
                    continue;
                }

                if ($jadwalTersedia) break;
                
                foreach ($jamList as $jam) {
                    $sks = $pengampu->matakuliah->sks;
                    $durasi = $sks * 50; // Durasi dalam menit
                    $jamMulai = $jam->id;
                    $jamSelesai = $jamMulai + ceil($durasi / 60);

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
                                        'jam_id' => $jamMulai,
                                        'kelas_id' => $kelas->id,
                                        'tahun_akademik' => $request->tahun_akademik
                                    ]);
                                    
                                    // Track the day for this course
                                    $courseScheduledDays[$pengampu->matakuliah->id][] = $hari->id;
                                    
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