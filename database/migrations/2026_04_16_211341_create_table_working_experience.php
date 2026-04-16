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
        Schema::create('user_working_experience', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->comment('Relasi ke tabel users');
            $table->string("field_of_work");
            $table->string("location");
            $table->date("date_of_join");
            $table->date("date_of_resign")->nullable();
            $table->string("employment_status");
            $table->string("visa_type")->nullable()->comment("Status izin tinggal/jenis visa");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_working_experience');
    }
};
