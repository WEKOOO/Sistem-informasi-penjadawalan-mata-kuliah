<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;
use App\Models\Prodi;

class MatakuliahController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $mataKuliah = MataKuliah::where('nama', 'like', '%' . $search . '%')->paginate(10); // Mengambil 10 data per halaman
        return view('matakuliah.index', compact('mataKuliah'));
    }
    

    // Menampilkan form untuk menambah matakuliah
    public function create()
    {
        $prodi = Prodi::all();
        return view('matakuliah.create', compact('prodi'));
    }

    // Menyimpan matakuliah baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_mk' => 'required|unique:matakuliah,kode_mk',
            'nama' => 'required',
            'sks' => 'required|numeric|min:1',
            'semester' => 'required|numeric|min:1|max:8',
            'prodi_id' => 'required|exists:prodi,id',
        ], [
            'kode_mk.required' => 'Kode mata kuliah wajib diisi',
            'kode_mk.unique' => 'Kode mata kuliah sudah digunakan',
            'nama.required' => 'Nama mata kuliah wajib diisi',
            'sks.required' => 'SKS wajib diisi',
            'sks.numeric' => 'SKS harus berupa angka',
            'semester.required' => 'Semester wajib diisi',
            'semester.numeric' => 'Semester harus berupa angka',
            'semester.min' => 'Semester minimal 1',
            'semester.max' => 'Semester maksimal 8',
            'prodi_id.required' => 'Program studi wajib dipilih',
        ]);

        try {
            MataKuliah::create($request->all());
            return redirect()->route('matakuliah.index')
                           ->with('success', 'Data mata kuliah berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat menyimpan data')
                           ->withInput();
        }
    }

    // Menampilkan form untuk mengedit matakuliah
    public function edit($id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        $prodi = Prodi::all();
        return view('matakuliah.edit', compact('mataKuliah', 'prodi'));
    }



    public function update(Request $request, $id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        
        // Validasi input
        $request->validate([
            'kode_mk' => 'required|unique:matakuliah,kode_mk,'.$id,
            'nama' => 'required',
            'sks' => 'required|numeric|min:1',
            'semester' => 'required|numeric|min:1|max:8',
            'prodi_id' => 'required|exists:prodi,id',
        ], [
            'kode_mk.required' => 'Kode mata kuliah wajib diisi',
            'kode_mk.unique' => 'Kode mata kuliah sudah digunakan',
            'nama.required' => 'Nama mata kuliah wajib diisi',
            'sks.required' => 'SKS wajib diisi',
            'sks.numeric' => 'SKS harus berupa angka',
            'semester.required' => 'Semester wajib diisi',
            'semester.numeric' => 'Semester harus berupa angka',
            'semester.min' => 'Semester minimal 1',
            'semester.max' => 'Semester maksimal 8',
            'prodi_id.required' => 'Program studi wajib dipilih',
        ]);

        try {
            $mataKuliah->update($request->all());
            return redirect()->route('matakuliah.index')
                           ->with('success', 'Data mata kuliah berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat memperbarui data')
                           ->withInput();
        }
    }

    // Menghapus matakuliah
    public function destroy($id)
    {
        $matakuliah = Matakuliah::findOrFail($id);
        $matakuliah->delete();
        return redirect()->route('matakuliah.index')->with('success', 'Matakuliah berhasil dihapus.');
    }
}