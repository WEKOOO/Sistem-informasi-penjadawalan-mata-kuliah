<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    // Tampilkan data dosen
    public function index()
    {
        $dosen = Dosen::with('prodi')->get(); // Ambil data dosen dengan relasi prodi
        return view('dosen.index', compact('dosen'));
    }

    // Form untuk tambah data dosen
    public function create()
    {
        $prodi = Prodi::all(); // Ambil semua data prodi
        return view('dosen.create', compact('prodi'));
    }

    // Simpan data dosen
    public function store(Request $request)
    {
        $request->validate([
            'nidn' => 'required|unique:dosen,nidn',
            'nama' => 'required',
            'email' => 'required|email|unique:dosen,email',
        ]);

        Dosen::create($request->all());
        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil ditambahkan.');
    }

    // Form untuk edit data dosen
    public function edit(Dosen $dosen)
    {
        $prodi = Prodi::all(); // Ambil semua data prodi
        return view('dosen.edit', compact('dosen', 'prodi'));
    }

    // Update data dosen
    public function update(Request $request, Dosen $dosen)
    {
        $request->validate([
            'nidn' => 'required|unique:dosen,nidn,' . $dosen->id,
            'nama' => 'required',
            'email' => 'required|email|unique:dosen,email,' . $dosen->id,
        ]);

        $dosen->update($request->all());
        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil diperbarui.');
    }

    // Hapus data dosen
    public function destroy(Dosen $dosen)
    {
        $dosen->delete();
        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil dihapus.');
    }
}

