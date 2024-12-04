<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengampu extends Model
{
    protected $table = 'pengampu';
    protected $fillable = ['matakuliah_id', 'kelas_id', 'tahun_akademik'];

    public function dosen()
    {
        return $this->belongsToMany(Dosen::class, 'pengampu_dosen', 'pengampu_id', 'dosen_id');
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class);
    }
    public function jadwalKuliah()
    {
        return $this->hasMany(JadwalKuliah::class, 'pengampu_id');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function jadwalmahasiswa(){
        return $this->hasMany(JadwalMahasiswa::class, 'pengampu_id');
    }
}
