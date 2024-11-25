<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $fillable = [
        'nama',
        'nidn',
        'email',
        'prodi_id',
    ];

    // Relasi ke model Matakuliah
    public function matakuliah()
    {
        return $this->hasMany(Matakuliah::class, 'dosen_id');
    }

    public function Prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function JadwalKuliah()
    {
        return $this->hasMany(JadwalKuliah::class, 'dosen_id');
    }
}
