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

    public static function workingLocationOptions()
    {
        return [
            "Indonesia" => [
                "id" => "Indonesia",
                "jp" => "インドネシア"
            ],
            "Jepang" => [
                "id" => "Jepang",
                "jp" => "日本"
            ]
        ];
    }

    public static function workingStatusOptions()
    {
        return [
            "karyawan-tetap" => [
                "id" => "Karyawan Tetap",
                "jp" => "正社員"
            ],
            "karyawan-kontrak" => [
                "id" => "Karyawan Kontrak",
                "jp" => "契約社員"
            ],
            "pekerja-outsourcing" => [
                "id" => "Pekerja Outsourcing",
                "jp" => "派遣社員"
            ],
            "pekerja-part-time" => [
                "id" => "Pekerja Paruh Waktu/Part Time",
                "jp" => "パート/アルバイト"
            ],
            "wirausaha" => [
                "id" => "Wirausaha",
                "jp" => "自営業"
            ],
            "internship" => [
                "id" => "Internship",
                "jp" => "インターンシップ"
            ],
            "training" => [
                "id" => "Training",
                "jp" => "実習"
            ]
        ];
    }
}
