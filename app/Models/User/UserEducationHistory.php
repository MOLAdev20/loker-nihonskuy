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
            "SMK" => [
                "id" => "SMK",
                "jp" => "短期大学"
            ],
            "Sekolah Bahasa Jepang" => [
                "id" => "Sekolah Bahasa Jepang",
                "jp" => "日本語学校"
            ],
            "Sarjana" => [
                "id" => "Sarjana",
                "jp" => "大学"
            ],
            "Pascasarjana" => [
                "id" => "Pascasarjana",
                "jp" => "大学院"
            ]
        ];
    }

    public static function eduLocationOptions()
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

    public static function eduStatusOptions()
    {
        return [
            "studying" => [
                "id" => "Masih Aktif",
                "jp" => "在学中"
            ],
            "graduated" => [
                "id" => "Lulus",
                "jp" => "卒業"
            ],
            "droppedOut" => [
                "id" => "Mengundurkan Diri",
                "jp" => "退学"
            ]
        ];
    }
}
