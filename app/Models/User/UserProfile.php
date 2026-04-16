<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profile';

    protected $fillable = [
        'user_id',
        'profile_picture',
        'full_name',
        'furigana_name',
        'birth_date',
        'gender',
        'height',
        'weight',
        'marital_status',
        'nationality',
        'place_of_origin',
        'current_address',
        'religion',
        'is_wearing_hijab',
        'prayer_requirement',
        'pork_tolerance',
        'alcohol_tolerance',
        'entry_date',
        'visa_expiry_date',
        'current_visa_type',
        'jlpt_level',
        'has_driver_license',
        'work_start_date',
        'technical_experience',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'entry_date' => 'date',
            'visa_expiry_date' => 'date',
            'work_start_date' => 'date',
        ];
    }
}
