<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $table = 'user_working_experience';

    protected $fillable = [
        'user_id',
        'field_of_work',
        'company_name',
        'location',
        'date_of_join',
        'date_of_resign',
        'employment_status',
        'visa_type',
    ];

    protected $casts = [
        'date_of_join' => 'date',
        'date_of_resign' => 'date',
    ];
}
