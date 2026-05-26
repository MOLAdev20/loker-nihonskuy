<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UrgentVacancy extends Model
{
    public $timestamps = false;

    protected $table = 'urgent_vacancies';

    protected $fillable = [
        'job_id',
        'order',
    ];

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class, 'job_id');
    }
}
