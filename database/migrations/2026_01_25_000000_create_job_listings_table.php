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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('job_code')->unique();
            $table->string('title');
            $table->string('company_name');
            $table->string('placement');
            $table->string('job_type');
            $table->string('salary');
            $table->char('gender_requirement', 1);
            $table->string('domicile_requirement');
            $table->integer('qty');
            $table->longText('additional_information');
            $table->timestamps();
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
