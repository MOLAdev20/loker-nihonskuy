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
        Schema::create('user_education_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->comment('Relasi ke tabel users');
            $table->string("education");
            $table->string("institution");
            $table->string("location");
            $table->date("date_of_entry");
            $table->date("date_of_graduation")->nullable();
            $table->date("date_of_dropped_out")->nullable()->comment("Tahun dan bulan jika berhenti sekolah");
            $table->string("status")->comment("Status di jenjang tersebut");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_education_history');
    }
};
