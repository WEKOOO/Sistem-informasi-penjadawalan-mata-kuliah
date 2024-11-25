<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Illuminate\Http\Request;

class RuangController extends Controller
{
    // Menampilkan daftar ruang
    public function index()
    {
        $ruang = Ruang::all();
        return view('ruang.index', compact('ruang'));
    }

    // Menampilkan form untuk membuat ruang baru
    public function create()
    {
        return view('ruang.create');
    }

    // Menyimpan ruang baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_ruang' => 'required|string|max:255',
            'kapasitas' => 'required|integer',
        ]);

        Ruang::create($request->all());
        return redirect()->route('ruang.index')->with('success', 'Ruang berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit ruang
    public function edit(Ruang $ruang)
    {
        return view('ruang.edit', compact('ruang'));
    }

    // Memperbarui ruang di database
    public function update(Request $request, Ruang $ruang)
    {
        $request->validate([
            'nama_ruang' => 'required|string|max:255',
            'kapasitas' => 'required|integer',
        ]);

        $ruang->update($request->all());
        return redirect()->route('ruang.index')->with('success', 'Ruang berhasil diperbarui.');
    }

    // Menghapus ruang dari database
    public function destroy(Ruang $ruang)
    {
        $ruang->delete();
        return redirect()->route('ruang.index')->with('success', 'Ruang berhasil dihapus.');
    }
}