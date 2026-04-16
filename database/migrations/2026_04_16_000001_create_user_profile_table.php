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
        Schema::create('user_profile', function (Blueprint $table) {
            $table->id()->comment('ID data profile user');
            $table->foreignId('user_id')->constrained('users')->comment('Relasi ke tabel users');
            $table->string('profile_picture', 255)->nullable()->comment('Foto Profile atau Pas Foto (氏名)');
            $table->string('full_name', 255)->comment('Nama lengkap (氏名)');
            $table->string('furigana_name', 255)->comment('Nama lengkap dalam bahasa Jepang (フリガナ)');
            $table->date('birth_date')->comment('Tanggal lahir (生年月日)');
            $table->enum('gender', ['male', 'female'])->comment('Jenis kelamin (性別)');
            $table->integer('height')->unsigned()->comment('Tinggi badan');
            $table->integer('weight')->unsigned()->comment('berat badan');
            $table->enum('marital_status', ['single', 'married', 'divorce'])->comment('Status pernikahan (婚姻)');
            $table->string('nationality', 255)->comment('Kewarganegaraan (国籍)');
            $table->string('place_of_origin', 255)->comment('Tempat asal (出身地)');
            $table->text('current_address')->comment('Alamat sekarang (現住所)');
            $table->string('religion', 50)->comment('Agama (宗教)');
            $table->string('is_wearing_hijab', 255)->comment('Pakai hijab atau tidak (ヒジャブ)');
            $table->text('prayer_requirement')->comment('Kebutuhan waktu ibadah (お祈り)');
            $table->text('pork_tolerance')->comment('Skala toleransi babi');
            $table->text('alcohol_tolerance')->comment('Skala toleransi alkohol (飲酒への許容度)');
            $table->date('entry_date')->nullable()->comment('Tanggal masuk Jepang (入国日)');
            $table->date('visa_expiry_date')->nullable()->comment('Masa berlaku visa (在留カードの期限)');
            $table->string('current_visa_type', 255)->comment('Jenis visa saat ini (現在の在留資格)');
            $table->enum('jlpt_level', ['N1', 'N2', 'N3', 'N4', 'N5', 'none'])->comment('Level bahasa Jepang (日本語能力)');
            $table->string('has_driver_license', 255)->comment('Punya SIM atau tidak (運転免許有無)');
            $table->date('work_start_date')->comment('Kapan siap mulai kerja (就労開始可能日)');
            $table->text('technical_experience')->comment('Detail pengalaman magang/skill (技能実習経験)');
            $table->timestamp('created_at')->useCurrent()->comment('Record data dibuat');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('Record data diupdate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profile');
    }
};
