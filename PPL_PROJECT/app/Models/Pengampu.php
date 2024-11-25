<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengampu extends Model
{
    protected $table = 'pengampu';
    protected $fillable = ['dosen_id', 'matakuliah_id', 'kelas_id', 'tahun_akademik'];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class);
    }
    public function jadwalKuliah()
    {
        return $this->hasMany(JadwalKuliah::class, 'pengampu_id');
    }
    
}