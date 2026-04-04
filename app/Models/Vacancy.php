<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    protected $table = 'vacancies';

    protected $fillable = [
        'job_code',
        'title',
        'visa_type',
        'placement',
        'job_type',
        'source',
        'salary',
        'whatsapp_number',
        'gender_requirement',
        'domicile_requirement',
        'qty',
        'benefit',
        'additional_information',
        'thumbnail_path',
        'expired_at'
    ];
}
