<?php

namespace App\Models\User;

use App\Models\User as UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserInterviewAnswer extends Model
{
    use HasFactory;

    protected $table = 'user_interview_answers';

    protected $fillable = [
        'user_id',
        'work_history',
        'technical_skills',
        'comm_challenges',
        'leave_reason',
        'apply_reason',
        'career_prep',
        'personality_review',
        'problem_solving',
        'stay_motivation',
        'learning_goals',
        'japan_targets',
        'long_term_dream',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}
