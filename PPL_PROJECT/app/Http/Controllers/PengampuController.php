<?php

namespace App\Http\Controllers;

use App\Models\Pengampu;
use App\Models\Dosen;
use App\Models\Matakuliah;
use App\Models\Kelas;
use Illuminate\Http\Request;

class PengampuController extends Controller
{
    public function index()
    {
        $pengampus = Pengampu::with(['dosen', 'matakuliah'])->get();
        return view('pengampu.index', compact('pengampus'));
    }

    public function create()
    {
        $dosens = Dosen::all();
        $matakuliahs = Matakuliah::all();
        return view('pengampu.create', compact('dosens', 'matakuliahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required',
            'matakuliah_id' => 'required',
            'tahun_akademik' => 'required' 
        ]);

        Pengampu::create($request->all());
        return redirect()->route('pengampu.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(Pengampu $pengampu)
    {
        $dosens = Dosen::all();
        $matakuliahs = Matakuliah::all();
        $kelas = Kelas::all();
        return view('pengampu.edit', compact('pengampu', 'dosens', 'matakuliahs'));
    }

    public function update(Request $request, Pengampu $pengampu)
    {
        $request->validate([
            'dosen_id' => 'required',
            'matakuliah_id' => 'required',
            'tahun_akademik' => 'required'
        ]);

        $pengampu->update($request->all());
        return redirect()->route('pengampu.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Pengampu $pengampu)
    {
        $pengampu->delete();
        return redirect()->route('pengampu.index')->with('success', 'Data berhasil dihapus');
    }
}