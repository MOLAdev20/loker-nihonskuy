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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('job_code')->unique();
            $table->string('title');
            $table->string('visa_type');
            $table->string('placement');
            $table->string('job_type');
            $table->string('source');
            $table->string('salary');
            $table->string('whatsapp_number');
            $table->char('gender_requirement', 1);
            $table->string('domicile_requirement');
            $table->integer('qty');
            $table->text('benefit')->nullable();
            $table->longText('additional_information');
            $table->string("thumbnail_path")->nullable();
            $table->timestamp('expired_at');
            $table->timestamps();
            $table->boolean("status")->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
