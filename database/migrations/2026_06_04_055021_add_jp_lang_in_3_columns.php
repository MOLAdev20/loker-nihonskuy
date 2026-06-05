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
        Schema::table('user_profile', function (Blueprint $table) {
            $table->text('jp_summary')->nullable()->after('reason_for_leaving');
            $table->text('jp_reason_for_leaving')->nullable()->after('jp_summary');
            $table->text('jp_additional_info')->nullable()->after('jp_reason_for_leaving');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profile', function (Blueprint $table) {
            $table->dropColumn(['summary', 'reason_for_leaving', 'additional_info']);
        });
    }
};
