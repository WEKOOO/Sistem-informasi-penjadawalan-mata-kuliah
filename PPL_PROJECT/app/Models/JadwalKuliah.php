<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    use HasFactory;


    protected $table = 'jadwal_kuliah';
    protected $fillable = ['pengampu_id', 'ruang_id', 'hari_id', 'jam_id', 'kelas_id', 'tahun_akademik'];

    public function pengampu()
    {
        return $this->belongsTo(Pengampu::class);
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class);
    }

    public function hari()
    {
        return $this->belongsTo(Hari::class);
    }

    public function jam()
    {
        return $this->belongsTo(Jam::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jadwalDosen()
    {
        return $this->hasMany(JadwalDosen::class);
    }
    public function jadwalMahasiswa()
    {
        return $this->hasMany(JadwalMahasiswa::class);
    }
}