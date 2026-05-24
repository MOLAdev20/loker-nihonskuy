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

    public static function educationLevelOptions()
    {
        return [
            "SMP" => [
                "id" => "SMP",
                "jp" => "中学校"
            ],
            "SMA" => [
                "id" => "SMA",
                "jp" => "高等学校"
            ],
            "Sekolah Kejuruan" => [
                "id" => "Sekolah Kejuruan",
                "jp" => "専門学校"
            ],
            "Sekolah Bahasa Jepang" => [
                "id" => "Sekolah Bahasa Jepang",
                "jp" => "日本語学校"
            ],
            "SMK" => [
                "id" => "Sekolah Menengah Kejuruan",
                "jp" => "短期大学"
            ],
            "Universitas" => [
                "id" => "Universitas",
                "jp" => "大学"
            ],
            "Sekolah Pascasarjana" => [
                "id" => "Sekolah Pascasarjana",
                "jp" => "大学院"
            ]
        ];
    }
}
