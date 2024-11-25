<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hari extends Model
{
    use HasFactory;

    protected $table = 'hari';
    protected $fillable = ['nama_hari'];

    public function jadwalKuliah()
    {
        return $this->hasMany(JadwalKuliah::class, 'hari_id');
    }
}
