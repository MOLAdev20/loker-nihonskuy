<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEducationHistory extends Model
{
    use HasFactory;

    protected $table = 'user_education_history';

    protected $fillable = [
        'user_id',
        'education',
        'institution',
        'location',
        'date_of_entry',
        'date_of_graduation',
        'date_of_dropped_out',
        'status',
    ];

    protected $casts = [
        'date_of_entry' => 'date',
        'date_of_graduation' => 'date',
        'date_of_dropped_out' => 'date',
    ];
}
