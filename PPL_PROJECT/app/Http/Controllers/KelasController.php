<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Prodi;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    // Menampilkan daftar kelas
    public function index()
    {
        $kelas = Kelas::with('prodi')->get();
        return view('kelas.index', compact('kelas'));
    }

    // Menampilkan form untuk menambahkan kelas baru
    public function create()
    {
        $prodi = Prodi::all(); // Ambil semua data prodi
        return view('kelas.create', compact('prodi'));
    }

    // Menyimpan kelas baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'prodi_id' => 'required|exists:prodi,id',
        ]);

        Kelas::create($request->all());
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    

    // Menampilkan form untuk mengedit kelas
    public function edit(Kelas $kelas)
    {
        $prodi = Prodi::all(); // Ambil semua data prodi
        return view('kelas.edit', compact('kelas', 'prodi'));
    }

    // Memperbarui data kelas
    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'prodi_id' => 'required|exists:prodi,id',
        ]);

        $kelas->update($request->all());
        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }


    // Menghapus kelas
    public function destroy(Kelas $kelas)
    {
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}