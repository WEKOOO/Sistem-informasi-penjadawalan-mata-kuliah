<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jam', function (Blueprint $table) {
            $table->id();
            $table->time('jam_mulai');         // Gunakan tipe time untuk presisi
            $table->time('jam_selesai');       // Gunakan tipe time untuk presisi
            $table->integer('durasi')->default(50); // Durasi dalam menit
            $table->boolean('waktu_shalat')->default(false); // Gunakan boolean
            $table->timestamps();
        });        
    }

    public function down(): void
    {
        Schema::dropIfExists('jam');
    }
};