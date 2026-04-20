<?php

namespace Database\Seeders;

use App\Models\Vacancy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class VacancySeeder extends Seeder
{
    public function run(): void
    {
        $companyList = [
            'Sakura Foods Co., Ltd.',
            'Hikari Logistics KK',
            'Tanaka Manufacturing Co., Ltd.',
            'Nippon Care Service',
            'Fuji Clean Support',
            'Yamato Retail Japan',
            'Kokoro Hospitality Group',
            'Matsuri Farm Industry',
            'Shinwa Auto Service',
            'Kizuna Tech Factory',
        ];

        $jobTypeList = [
            'Restoran',
            'Perawat Lansia',
            'Pengolahan Makanan',
            'Perhotelan',
            'Pembersihan Gedung',
            'Manufaktur Produk Industri',
            'Konstruksi',
            'Perikanan',
            'Perawatan Otomotif',
            'Pertanian (Peternakan)',
        ];

        $prefectureList = [
            'Tokyo',
            'Osaka',
            'Kanagawa',
            'Saitama',
            'Chiba',
            'Aichi',
            'Fukuoka',
            'Kyoto',
            'Hokkaido',
            'Shizuoka',
        ];

        $branchList = ['Shinjuku', 'Shibuya', 'Umeda', 'Sakae', 'Hakata', 'Kawasaki', null];
        $visaTypeList = ['Tokutei Ginou', 'Engineer/Specialist in Humanities/International Services', 'Kaigo'];
        $genderRequirementList = ['l', 'p', 'a'];
        $domicileRequirementList = ['kokunai', 'kokugai', 'kokunai-to-kokugai'];
        $benefitList = [
            'Gaji',
            'Kenaikan Gaji',
            'Lembur',
            'Bonus',
            'Asrama',
            'Makan Gratis',
            'Support Kaigo',
            'Tunjangan Kendaraan',
        ];

        $baseTimestamp = now();
        $vacancyRows = [];

        foreach (range(1, 50) as $index) {
            $companyName = $companyList[array_rand($companyList)];
            $jobType = $jobTypeList[array_rand($jobTypeList)];
            $placement = $prefectureList[array_rand($prefectureList)];
            $placementBranch = $branchList[array_rand($branchList)];
            $visaType = $visaTypeList[array_rand($visaTypeList)];
            $genderRequirement = $genderRequirementList[array_rand($genderRequirementList)];
            $domicileRequirement = $domicileRequirementList[array_rand($domicileRequirementList)];
            $salaryFrom = random_int(170000, 230000);
            $salaryTo = $salaryFrom + random_int(20000, 80000);
            $quantity = random_int(1, 12);
            $benefitValueList = collect($benefitList)->shuffle()->take(random_int(2, 5))->values()->all();
            $isUrgent = $index % 4 === 0;
            $jobCode = 'JPVAC' . str_pad((string) $index, 4, '0', STR_PAD_LEFT);
            $jobTitle = $jobType . ' - ' . $companyName;
            $descriptionDelta = [
                'ops' => [
                    ['insert' => 'Lowongan resmi dari ' . $companyName . ".\n"],
                    ['insert' => 'Penempatan: ' . $placement . ($placementBranch ? ' - ' . $placementBranch : '') . ".\n"],
                    ['insert' => 'Kandidat diharapkan siap bekerja profesional, disiplin, dan komunikatif.'],
                ],
            ];

            $vacancyRows[] = [
                'job_code' => $jobCode,
                'title' => $jobTitle,
                'visa_type' => $visaType,
                'placement' => $placement,
                'placement_branch' => $placementBranch,
                'job_type' => $jobType,
                'source' => 'https://jobs.example.jp/' . strtolower($jobCode),
                'salary' => $salaryFrom . '-' . $salaryTo,
                'whatsapp_number' => '81' . random_int(7011111111, 9099999999),
                'gender_requirement' => $genderRequirement,
                'domicile_requirement' => $domicileRequirement,
                'qty' => $quantity,
                'benefit' => implode('|', $benefitValueList),
                'tags' => $isUrgent ? 'urgent' : null,
                'additional_information' => json_encode($descriptionDelta, JSON_UNESCAPED_UNICODE),
                'thumbnail_path' => null,
                'expired_at' => Carbon::now()->addDays(random_int(20, 120)),
                'status' => 1,
                'created_at' => $baseTimestamp,
                'updated_at' => $baseTimestamp,
            ];
        }

        Vacancy::upsert(
            $vacancyRows,
            ['job_code'],
            [
                'title',
                'visa_type',
                'placement',
                'placement_branch',
                'job_type',
                'source',
                'salary',
                'whatsapp_number',
                'gender_requirement',
                'domicile_requirement',
                'qty',
                'benefit',
                'tags',
                'additional_information',
                'thumbnail_path',
                'expired_at',
                'status',
                'updated_at',
            ]
        );
    }
}
