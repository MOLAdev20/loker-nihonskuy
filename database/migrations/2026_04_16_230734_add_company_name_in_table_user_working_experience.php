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
        Schema::table('user_working_experience', function (Blueprint $table) {
            $table->string("company_name")->after("field_of_work");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_working_experience', function (Blueprint $table) {
            $table->removeColumn("company_name;");
        });
    }
};
