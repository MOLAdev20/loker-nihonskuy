<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    protected $fillable = [
        'job_code',
        'title',
        'visa_type',
        'placement',
        'job_type',
        'salary',
        'gender_requirement',
        'domicile_requirement',
        'qty',
        'source',
        'benefit',
        'additional_information',
        'thumbnail_path',
        'status',
        'whatsapp_number',
    ];
}
