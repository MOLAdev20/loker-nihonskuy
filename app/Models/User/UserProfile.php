<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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

    public static function hijabOptions()
    {
        return [
            "wajib-memakai" => [
                "id" => "Saya ingin/wajib memakai jilbab",
                "jp" => "絶対にしたい"
            ],
            "bisa-menyesuaikan" => [
                "id" => "Saya bisa menyesuaikan situasi",
                "jp" => "柔軟に対応可能"
            ],
            "tidak-memakai" => [
                "id" => "Saya tidak berencana memakainya",
                "jp" => "しなくていい"
            ]
        ];
    }

    public static function porkToleranceOptions()
    {
        return [
            "tidak-toleran-sama-sekali" => [
                "id" => "Tidak memasak, mencicipi dan mengonsumsi daging babi",
                "jp" => "調理NG|豚骨やラード入り料理など味見NG|豚食NG"
            ],
            "hanya-memasak" => [
                "id" => "Boleh memasak, tapi tidak mencicipi/mengonsumsi",
                "jp" => "調理OK|豚骨やラード入り料理など味見NG|豚食NG"
            ],
            "hanya-memasak-dan-mencicipi" => [
                "id" => "Boleh memasak & mencicipi, tapi tidak mengonsumsi",
                "jp" => "調理OK|豚骨やラード入り料理など味見OK|豚食NG"
            ],
            "tidak-ada-batasan" => [
                "id" => "Bebas. Tidak ada batasan terkait daging babi",
                "jp" => "調理OK|豚骨やラード入り料理など味見OK|豚食OK"
            ],
        ];
    }

    public static function alcoholToleranceOptions()
    {
        return [
            "tidak-toleran-sama-sekali" => [
                "id" => "Tidak mempersiapkan, mencicipi dan mengonsumsi minuman/makanan beralkohol",
                "jp" => "作酒NG|お酒入食事味見NG|飲酒NG"
            ],
            "hanya-memasak" => [
                "id" => "Boleh mempersiapkan, tapi tidak mencicipi/mengonsumsi",
                "jp" => "作酒OK|お酒入食事味見NG|飲酒NG"
            ],
            "hanya-memasak-dan-mencicipi" => [
                "id" => "Boleh mempersiapkan & mencicipi, tapi tidak mengonsumsi",
                "jp" => "作酒OK|お酒入食事味見OK|飲酒NG"
            ],
            "tidak-ada-batasan" => [
                "id" => "Bebas. Tidak ada batasan terkait minuman/makanan beralkohol",
                "jp" => "作酒OK|お酒入食事味見OK|飲酒OK"
            ],
        ];
    }

    public static function prayOptions()
    {
        return [
            "sangat-membutuhkan" => [
                "id" => "Saya sangat membutuhkan fasilitas ibadah",
                "jp" => "絶対にしたい"
            ],
            "bisa-menyesuaikan" => [
                "id" => "Bisa menyesuaikan kondisi",
                "jp" => "柔軟に対応可能"
            ],
            "tidak-begitu-dibutuhkan" => [
                "id" => "Saya tidak membutuhkannya",
                "jp" => "しなくていい"
            ]
        ];
    }

    // Assesor
    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_date)->age;
    }

    public static function driverLicenseOptions()
    {
        return [
            "tidak-ada" => [
                "id" => "Tidak ada",
                "jp" => "なし"
            ],
            "lokal-sim-motor" => [
                "id" => "Lokal | Memiliki SIM motor",
                "jp" => "現地 | バイク免許あり"
            ],
            "lokal-sim-mobil" => [
                "id" => "Lokal | Memiliki SIM mobil",
                "jp" => "現地 | 自動車免許あり"
            ],
            "jepang-sim-motor" => [
                "id" => "Jepang | Memiliki SIM motor",
                "jp" => "日本 | バイク免許あり"
            ],
            "jepang-sim-skuter" => [
                "id" => "Jepang | Memiliki SIM skuter",
                "jp" => "日本 | 原付免許あり"
            ],
            "jepang-sim-mobil-standar-at" => [
                "id" => "Jepang | Memiliki SIM mobil standar (hanya AT)",
                "jp" => "日本 | 自動車普通免許（ATのみ）あり"
            ],
            "jepang-sim-mobil-standar" => [
                "id" => "Jepang | Memiliki SIM mobil standar",
                "jp" => "日本 | 自動車普通免許あり"
            ],
            "jepang-sim-mobil-sedan" => [
                "id" => "Jepang | Memiliki SIM mobil ukuran sedan",
                "jp" => "日本 | 自動車準中型免許あり"
            ],
            "jepang-sim-mobil-besar" => [
                "id" => "Jepang | Memiliki SIM mobil besar",
                "jp" => "日本 | 自動車中型免許あり"
            ],
            "jepang-sim-mobil-sangat-besar" => [
                "id" => "Jepang | Memiliki SIM mobil sangat besar",
                "jp" => "日本 | 自動車大型免許あり"
            ],
        ];
    }

    public static function japaneseCertificateOptions()
    {
        return [
            "N1" => [
                "id" => "JLPT N1",
                "jp" => "JLPT N1"
            ],
            "N2" => [
                "id" => "JLPT N2",
                "jp" => "JLPT N2"
            ],
            "N3" => [
                "id" => "JLPT N3",
                "jp" => "JLPT N3"
            ],
            "N4" => [
                "id" => "JLPT N4",
                "jp" => "JLPT N4"
            ],
            "N5" => [
                "id" => "JLPT N5",
                "jp" => "JLPT N5"
            ],
            "none" => [
                "id" => "Tidak memiliki sertifikat",
                "jp" => "資格なし"
            ],
            "other" => [
                "id" => "Lainnya",
                "jp" => "その他"
            ],
        ];
    }
}
