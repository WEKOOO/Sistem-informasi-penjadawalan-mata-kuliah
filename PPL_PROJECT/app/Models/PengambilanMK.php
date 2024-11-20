<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PengambilanMK extends Pivot
{
    protected $table = 'pengambilan_mk'; // Nama pivot table
    protected $fillable = [
        'mahasiswa_id',
        'matakuliah_id',
        'semester',
    ];
}
