<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    protected $fillable = [
        'job_code',
        'title',
        'company_name',
        'placement',
        'job_type',
        'salary',
        'gender_requirement',
        'domicile_requirement',
        'qty',
        'additional_information',
    ];
}
