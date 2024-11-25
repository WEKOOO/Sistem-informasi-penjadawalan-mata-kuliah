<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    // Menampilkan daftar program studi
    public function index()
    {
        $prodi = Prodi::all(); // Mengambil semua data prodi
        return view('prodi.index', compact('prodi'));
    }

    // Form untuk tambah data prodi
    public function create()
    {
        return view('prodi.create');
    }

    // Simpan data program studi
    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi' => 'required|unique:prodi,nama_prodi|max:255',
        ]);

        Prodi::create($request->all());
        return redirect()->route('prodi.index')->with('success', 'Data program studi berhasil ditambahkan.');
    }

    // Form untuk edit data prodi
    public function edit(Prodi $prodi)
    {
        return view('prodi.edit', compact('prodi'));
    }

    // Update data program studi
    public function update(Request $request, Prodi $prodi)
    {
        $request->validate([
            'nama_prodi' => 'required|unique:prodi,nama_prodi,' . $prodi->id . '|max:255',
        ]);

        $prodi->update($request->all());
        return redirect()->route('prodi.index')->with('success', 'Data program studi berhasil diperbarui.');
    }

    // Hapus data program studi
    public function destroy(Prodi $prodi)
    {
        $prodi->delete();
        return redirect()->route('prodi.index')->with('success', 'Data program studi berhasil dihapus.');
    }
}

