<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profile', function (Blueprint $table) {
            $table->id();
            $table->string('furigana')->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('tempat_asal')->nullable();
            $table->string('alamat_sekarang')->nullable();
            $table->string('agama')->nullable();
            $table->string('hijab')->nullable();
            $table->string('salat')->nullable();
            $table->string('toleransi_babi')->nullable();
            $table->string('toleransi_alkohol')->nullable();
            $table->date('tanggal_masuk_jepang')->nullable();
            $table->string('status_izin_tinggal')->nullable();
            $table->date('masa_berlaku_kartu')->nullable();
            $table->date('tanggal_mulai_kerja')->nullable();
            $table->string('kemampuan_bahasa')->nullable();
            $table->string('ujian_keterampilan')->nullable();
            $table->string('kepemilikan_sim')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_profile');
    }
};
