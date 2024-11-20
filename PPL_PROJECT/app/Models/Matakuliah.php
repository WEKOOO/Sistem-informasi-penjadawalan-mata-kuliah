<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliah';
    protected $fillable = [
        'kode',
        'nama',
        'sks',
        'dosen_id',
        'semester',
    ];

    // Relasi ke model Dosen
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    // Relasi ke model PengambilanMK (many-to-many ke mahasiswa)
    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class, 'pengambilan_mk', 'matakuliah_id', 'mahasiswa_id');
    }

    // Relasi ke model JadwalKuliah
    public function jadwalKuliah()
    {
        return $this->hasMany(JadwalKuliah::class, 'matakuliah_id');
    }
}
