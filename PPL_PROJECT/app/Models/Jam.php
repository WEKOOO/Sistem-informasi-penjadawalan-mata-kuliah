<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Jam extends Model
{
    protected $table = 'jam';
    
    protected $fillable = [
        'jam_mulai', 
        'jam_selesai', 
        'durasi', 
        'waktu_shalat'
    ];

    // Hapus relasi dengan matakuliah
    // Gunakan durasi sebagai pengganti SKS dari mata kuliah

    public function getJamMulaiAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    public function getJamSelesaiAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    public function jadwalKuliah()
    {
        return $this->hasMany(JadwalKuliah::class);
    }

    // Tambahkan accessor untuk range waktu
    public function getRangeWaktuAttribute()
    {
        return $this->jam_mulai . ' - ' . $this->jam_selesai;
    }

    // Tambahkan mutator untuk jam_mulai
    public function setJamMulaiAttribute($value)
    {
        $this->attributes['jam_mulai'] = Carbon::parse($value)->format('H:i:s');
    }

    // Tambahkan mutator untuk jam_selesai
    public function setJamSelesaiAttribute($value)
    {
        $this->attributes['jam_selesai'] = Carbon::parse($value)->format('H:i:s');
    }
    public static function getJamBySKS($sks)
    {
        // Durasi per SKS adalah 50 menit
        $durasi_sks = $sks * 50;

        // Ambil slot jam yang sesuai dengan durasi SKS
        return self::where('durasi', '>=', $durasi_sks)
                   ->where('waktu_shalat', false)
                   ->get();
    }
}