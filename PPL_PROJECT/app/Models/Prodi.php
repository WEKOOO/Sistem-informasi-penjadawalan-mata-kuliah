<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $table = 'prodi';
    protected $fillable = ['nama_prodi'];

    public function Matakuliah()
    {
        return $this->hasMany(MataKuliah::class, 'prodi_id');
    }

    public function Dosen()
    {
        return $this->hasMany(Dosen::class, 'prodi_id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'prodi_id');
    }
}   
