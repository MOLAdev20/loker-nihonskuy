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
        Schema::create('user_interview_answers', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel kandidat/user
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Pertanyaan 1 - 3: Pengalaman & Komunikasi
            $table->text('work_history')->comment('Q1: Past work experience in Japan');
            $table->text('technical_skills')->comment('Q2: Skills mastered during previous work');
            $table->text('comm_challenges')->comment('Q3: Communication difficulties faced');

            // Pertanyaan 4 - 6: Alasan Pindah & Persiapan
            $table->text('leave_reason')->comment('Q4: Reason for leaving previous job');
            $table->text('apply_reason')->comment('Q5: Reason for choosing this new field');
            $table->text('career_prep')->comment('Q6: Preparation made for this career change');

            // Pertanyaan 7 - 9: Karakter & Resiliensi
            $table->text('personality_review')->comment('Q7: How bosses/peers describe them');
            $table->text('problem_solving')->comment('Q8: How they handle difficulties and pressure');
            $table->text('stay_motivation')->comment('Q9: What kept them motivated to finish contract');

            // Pertanyaan 10 - 12: Rencana Masa Depan
            $table->text('learning_goals')->comment('Q10: What they want to learn from this job');
            $table->text('japan_targets')->comment('Q11: Future targets while in Japan');
            $table->text('long_term_dream')->comment('Q12: Long term goals after returning to Indonesia');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_interview_answers');
    }
};
