<?php

namespace App\Http\Controllers;

use App\Models\Jam;
use App\Models\Matakuliah; // Tambahkan import untuk model Matakuliah
use Illuminate\Http\Request;
use Carbon\Carbon;

class JamController extends Controller
{
    public function index()
    {
        $jamList = Jam::orderBy('jam_mulai')->get();
        return view('jam.index', compact('jamList'));
    }

    public function create()
    {
        $matakuliahList = Matakuliah::all(); // Ambil semua matakuliah untuk dropdown
        return view('jam.create', compact('matakuliahList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jam_mulai' => 'required',
            'matakuliah_id' => 'required|exists:matakuliah,id', // Validasi matakuliah_id
            'waktu_shalat' => 'boolean'
        ]);

        try {
            $jamMulai = $request->jam_mulai;
            $matakuliah = Matakuliah::findOrFail($request->matakuliah_id); // Ambil matakuliah berdasarkan ID
            $sks = $matakuliah->sks; // Ambil SKS dari matakuliah
            
            // Jika bukan waktu shalat, hitung jam selesai berdasarkan SKS
            if (!$request->waktu_shalat) {
                $durasiMenit = $sks * 50; // 1 SKS = 50 menit
                $jamSelesai = Carbon::parse($jamMulai)->addMinutes($durasiMenit)->format('H:i');
            } else {
                // Jika waktu shalat, gunakan jam selesai yang diinput
                $jamSelesai = $request->jam_selesai;
            }

            Jam::create([
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'matakuliah_id' => $request->matakuliah_id, // Simpan matakuliah_id
                'waktu_shalat' => $request->waktu_shalat
            ]);

            return redirect()->route('jam.index')
                             ->with('success', 'Data jam berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                             ->withInput();
        }
    }

    public function edit($id)
    {
        $jam = Jam::findOrFail($id);
        $matakuliahList = Matakuliah::all(); // Ambil semua matakuliah untuk dropdown
        return view('jam.edit', compact('jam', 'matakuliahList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jam_mulai' => 'required',
            'matakuliah_id' => 'required|exists:matakuliah,id', // Validasi matakuliah_id
            'waktu_shalat' => 'boolean'
        ]);

        try {
            $jam = Jam::findOrFail($id);
            $jamMulai = $request->jam_mulai;
            $matakuliah = Matakuliah::findOrFail($request->matakuliah_id); // Ambil matakuliah berdasarkan ID
            $sks = $matakuliah->sks; // Ambil SKS dari matakuliah
            
            // Jika bukan waktu shalat, hitung jam selesai berdasarkan SKS
            if (!$request->waktu_shalat) {
                $durasiMenit = $sks * 50; // 1 SKS = 50 menit
                $jamSelesai = Carbon::parse($jamMulai)->addMinutes($durasiMenit)->format('H:i');
            } else {
                $jamSelesai = $request->jam_selesai;
            }

            $jam->update([
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'matakuliah_id' => $request->matakuliah_id, // Simpan matakuliah_id
                'waktu_shalat' => $request->waktu_shalat
            ]);

            return redirect()->route('jam.index')
                             ->with('success', 'Data jam berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                             ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $jam = Jam::findOrFail($id);
            
            // Cek apakah jam sudah digunakan di jadwal
            if ($jam->jadwalKuliah()->exists()) {
                return redirect()->back()
                                 ->with('error', 'Jam ini tidak dapat dihapus karena sudah digunakan dalam jadwal');
            }

            $jam->delete();
            return redirect()->route('jam.index')
                             ->with('success', 'Data jam berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}