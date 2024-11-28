<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_dosen', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('pengampu_id'); // Foreign key untuk pengampu
            $table->unsignedBigInteger('ruang_id');    // Foreign key untuk ruang
            $table->unsignedBigInteger('hari_id');     // Foreign key untuk hari
            $table->unsignedBigInteger('jam_id');      // Foreign key untuk jam
            $table->unsignedBigInteger('kelas_id');    // Foreign key untuk kelas
            $table->string('tahun_akademik');          // Tahun akademik
            $table->timestamps();                     // Created at & Updated at

            // Opsional: tambahkan foreign key constraints
            $table->foreign('pengampu_id')->references('id')->on('pengampus')->onDelete('cascade');
            $table->foreign('ruang_id')->references('id')->on('ruangs')->onDelete('cascade');
            $table->foreign('hari_id')->references('id')->on('haris')->onDelete('cascade');
            $table->foreign('jam_id')->references('id')->on('jams')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal_dosen');
    }
}
