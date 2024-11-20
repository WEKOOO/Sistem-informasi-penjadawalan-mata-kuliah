<?php

namespace App\Http\Controllers;

use App\Models\JadwalKuliah;
use Illuminate\Http\Request;

class JadwalKuliahController extends Controller
{
    // Menampilkan daftar jadwal kuliah
    public function index()
    {
        $jadwalKuliah = JadwalKuliah::with(['matakuliah', 'kelas', 'ruang', 'hari', 'jam', 'dosen'])->get();
        return view('jadwalkuliah.index', compact('jadwalKuliah'));
    }

    // Menampilkan form untuk menambah jadwal kuliah
    public function create()
    {
        return view('jadwalkuliah.create');
    }

    // Menyimpan jadwal kuliah yang baru ditambahkan
    public function store(Request $request)
    {
        $request->validate([
            'matakuliah_id' => 'required|exists:matakuliah,id',
            'kelas_id' => 'required|exists:kelas,id',
            'ruang_id' => 'required|exists:ruang,id',
            'hari_id' => 'required|exists:hari,id',
            'jam_id' => 'required|exists:jam,id',
            'dosen_id' => 'required|exists:dosen,id',
        ]);

        JadwalKuliah::create($request->all());
        return redirect()->route('jadwalkuliah.index')->with('success', 'Jadwal kuliah berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit jadwal kuliah
    public function edit($id)
    {
        $jadwalKuliah = JadwalKuliah::findOrFail($id);
        return view('jadwalkuliah.edit', compact('jadwalKuliah'));
    }

    // Memperbarui jadwal kuliah yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'matakuliah_id' => 'required|exists:matakuliah,id',
            'kelas_id' => 'required|exists:kelas,id',
            'ruang_id' => 'required|exists:ruang,id',
            'hari_id' => 'required|exists:hari,id',
            'jam_id' => 'required|exists:jam,id',
            'dosen_id' => 'required|exists:dosen,id',
        ]);

        $jadwalKuliah = JadwalKuliah::findOrFail($id);
        $jadwalKuliah->update($request->all());
        return redirect()->route('jadwalkuliah.index')->with('success', 'Jadwal kuliah berhasil diperbarui.');
    }

    // Menghapus jadwal kuliah
    public function destroy($id)
    {
        $jadwalKuliah = JadwalKuliah::findOrFail($id);
        $jadwalKuliah->delete();
        return redirect()->route('jadwalkuliah.index')->with('success', 'Jadwal kuliah berhasil dihapus.');
    }
}