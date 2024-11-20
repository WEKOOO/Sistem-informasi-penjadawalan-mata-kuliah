<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    use HasFactory;

    protected $table = 'jadwalkuliah';
    protected $fillable = [
        'matakuliah_id',
        'kelas_id',
        'ruang_id',
        'hari_id',
        'jam_id',
        'dosen_id'
    ];

    // Relasi ke model Matakuliah
    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id');
    }

    // Relasi ke model Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // Relasi ke model Ruang
    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'ruang_id');
    }

    // Relasi ke model Hari
    public function hari()
    {
        return $this->belongsTo(Hari::class, 'hari_id');
    }

    // Relasi ke model Jam
    public function jam()
    {
        return $this->belongsTo(Jam::class, 'jam_id');
    }
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }
}
  