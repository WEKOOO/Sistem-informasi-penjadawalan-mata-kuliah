<?php
// app/Models/Jam.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jam extends Model
{
    protected $table = 'jam';
    protected $fillable = ['jam_mulai', 'jam_selesai', 'matakuliah_id', 'waktu_shalat'];

    public function getJamMulaiAttribute($value)
    {
        return \Carbon\Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function getJamSelesaiAttribute($value)
    {
        return \Carbon\Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function jadwalKuliah()
    {
        return $this->hasMany(JadwalKuliah::class);
    }

    // Relasi ke Matakuliah
    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class);
    }

    public function getRangeWaktuAttribute()
    {
        return $this->jam_mulai . ' - ' . $this->jam_selesai;
    }

    // Accessor untuk mendapatkan SKS dari Matakuliah
    public function getSksAttribute()
    {
        return $this->matakuliah ? $this->matakuliah->sks : null;
    }
}