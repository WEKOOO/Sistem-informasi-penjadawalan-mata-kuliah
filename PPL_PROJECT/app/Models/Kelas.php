<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $fillable = [
        'nama_kelas',
        'prodi_id',
    ];

    // Relasi ke model Mahasiswa
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'kelas_id');
    }

    // Relasi ke model Prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function jadwalKuliah()
    {
        return $this->hasMany(JadwalKuliah::class, 'kelas_id');
    }
    public function pengampu()
    {
        return $this->hasMany(Pengampu::class, 'kelas_id');
    }
}
