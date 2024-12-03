<?php
namespace App\Http\Controllers;

use App\Models\Jam;
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
        return view('jam.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'durasi' => 'nullable|integer|min:10|max:240',
            'waktu_shalat' => 'boolean'
        ]);

        try {
            $jamMulai = Carbon::parse($request->jam_mulai);
            $jamSelesai = Carbon::parse($request->jam_selesai);
            
            Jam::create([
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'durasi' => $jamMulai->diffInMinutes($jamSelesai),
                'waktu_shalat' => $request->boolean('waktu_shalat', false)
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
        return view('jam.edit', compact('jam'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'durasi' => 'nullable|integer|min:10|max:240',
            'waktu_shalat' => 'boolean'
        ]);

        try {
            $jam = Jam::findOrFail($id);
            
            $jamMulai = Carbon::parse($request->jam_mulai);
            $jamSelesai = Carbon::parse($request->jam_selesai);

            $jam->update([
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'durasi' => $jamMulai->diffInMinutes($jamSelesai),
                'waktu_shalat' => $request->boolean('waktu_shalat', false)
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