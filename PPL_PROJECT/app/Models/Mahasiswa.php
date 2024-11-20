<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa'; // Nama tabel
    protected $fillable = [
        'npm',
        'nama',
        'kelas_id',
        'prodi_id',
        'semester',
    ]; // Kolom yang dapat diisi

    // Relasi ke model Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // Relasi ke model PengambilanMK (many-to-many ke matakuliah)
    public function matakuliah()
    {
        return $this->belongsToMany(Matakuliah::class, 'pengambilan_mk', 'mahasiswa_id', 'matakuliah_id');
    }
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

}
