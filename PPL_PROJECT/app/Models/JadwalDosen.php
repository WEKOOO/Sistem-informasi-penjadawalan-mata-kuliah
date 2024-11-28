<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalDosen extends Model
{
    use HasFactory;

    protected $table = 'jadwal_dosen';

    protected $fillable = [
        'pengampu_id',
        'ruang_id',
        'hari_id',
        'jam_id',
        'kelas_id',
        'tahun_akademik',
    ];
}
