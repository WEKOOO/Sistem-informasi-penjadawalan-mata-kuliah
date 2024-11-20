<?php

namespace App\Http\Controllers;

use App\Models\PengambilanMK;
use Illuminate\Http\Request;

class PengambilanMKController extends Controller
{
    // Menampilkan daftar pengambilan matakuliah
    public function index()
    {
        $pengambilanMKs = PengambilanMK::all();
        return view('pengambilan_mk.index', compact('pengambilanMKs'));
    }

    // Menampilkan form untuk membuat pengambilan matakuliah baru
    public function create()
    {
        return view('pengambilan_mk.create');
    }

    // Menyimpan pengambilan matakuliah baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|integer',
            'matakuliah_id' => 'required|integer',
            'semester' => 'required|string|max:10',
        ]);

        PengambilanMK::create($request->all());

        return redirect()->route('pengambilan_mk.index')->with('success', 'Pengambilan matakuliah berhasil ditambahkan.');
    }

    // Menampilkan detail pengambilan matakuliah
    public function show($id)
    {
        $pengambilanMK = PengambilanMK::findOrFail($id);
        return view('pengambilan_mk.show', compact('pengambilanMK'));
    }

    // Menampilkan form untuk mengedit pengambilan matakuliah
    public function edit($id)
    {
        $pengambilanMK = PengambilanMK::findOrFail($id);
        return view('pengambilan_mk.edit', compact('pengambilanMK'));
    }

    // Memperbarui pengambilan matakuliah di database
    public function update(Request $request, $id)
    {
        $request->validate([
            'mahasiswa_id' => 'required|integer',
            'matakuliah_id' => 'required|integer',
            'semester' => 'required|string|max:10',
        ]);

        $pengambilanMK = PengambilanMK::findOrFail($id);
        $pengambilanMK->update($request->all());

        return redirect()->route('pengambilan_mk.index')->with('success', 'Pengambilan matakuliah berhasil diperbarui.');
    }

    // Menghapus pengambilan matakuliah dari database
    public function destroy($id)
    {
        $pengambilanMK = PengambilanMK::findOrFail($id);
        $pengambilanMK->delete();

        return redirect()->route('pengambilan_mk.index')->with('success', 'Pengambilan matakuliah berhasil dihapus.');
    }
}