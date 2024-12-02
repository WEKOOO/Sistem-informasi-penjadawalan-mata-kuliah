<?php

namespace App\Http\Controllers;

use App\Models\Pengampu;
use App\Models\Dosen;
use App\Models\Matakuliah;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengampuController extends Controller
{
    public function index()
    {
        $pengampus = Pengampu::with('dosen', 'matakuliah')->get();
        return view('pengampu.index', compact('pengampus'));
    }

    public function create()
    {
        $dosens = Dosen::all();
        $matakuliahs = Matakuliah::all();
        $kelas = Kelas::all();
        return view('pengampu.create', compact('dosens', 'matakuliahs', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dosen1' => 'required',
            'matakuliah_id' => 'required',
            'kelas_id' => 'required',
            'tahun_akademik' => 'required'
        ]);

        DB::transaction(function () use ($request) {
            // Buat pengampu baru
            $pengampu = Pengampu::create([
                'matakuliah_id' => $request->matakuliah_id,
                'kelas_id' => $request->kelas_id,
                'tahun_akademik' => $request->tahun_akademik
            ]);

            // Kumpulkan dosen yang valid
            $dosenIds = array_filter([
                $request->dosen1,
                $request->dosen2 ?? null,
                $request->dosen3 ?? null
            ]);

            // Tambahkan dosen ke pengampu
            $pengampu->dosen()->sync($dosenIds);
        });

        return redirect()->route('pengampu.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(Pengampu $pengampu)
    {
        $dosens = Dosen::all();
        $matakuliahs = Matakuliah::all();
        $kelas = Kelas::all();
        return view('pengampu.edit', compact('pengampu', 'dosens', 'matakuliahs', 'kelas'));
    }

    public function update(Request $request, Pengampu $pengampu)
    {
        $request->validate([
            'dosen1' => 'required',
            'matakuliah_id' => 'required',
            'kelas_id' => 'required',
            'tahun_akademik' => 'required'
        ]);

        DB::transaction(function () use ($request, $pengampu) {
            // Update data pengampu
            $pengampu->update([
                'matakuliah_id' => $request->matakuliah_id,
                'kelas_id' => $request->kelas_id,
                'tahun_akademik' => $request->tahun_akademik
            ]);

            // Kumpulkan dosen yang valid
            $dosenIds = array_filter([
                $request->dosen1,
                $request->dosen2 ?? null,
                $request->dosen3 ?? null
            ]);

            // Update dosen-dosen yang mengampu
            $pengampu->dosen()->sync($dosenIds);
        });

        return redirect()->route('pengampu.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Pengampu $pengampu)
    {
        $pengampu->delete();
        return redirect()->route('pengampu.index')->with('success', 'Data berhasil dihapus');
    }
}