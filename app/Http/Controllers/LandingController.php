<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function jpCompany()
    {
        $companies = $this->jpCompanies();

        return view('landing.jp-company', [
            'companies' => $companies,
        ]);
    }

    public function jpCompanyDetail(string $slug)
    {
        $company = collect($this->jpCompanies())->firstWhere('slug', $slug);

        abort_if(! $company, 404);

        return view('landing.jp-company-detail', [
            'company' => $company,
        ]);
    }

    public function index()
    {
        $jobs = $this->publicVacanciesQuery()
            ->latest()
            ->take(6)
            ->get();

        $urgentJobs = $this->publicVacanciesQuery()
            ->select('vacancies.*')
            ->join('urgent_vacancies', 'urgent_vacancies.job_id', '=', 'vacancies.id')
            ->orderBy('urgent_vacancies.order')
            ->orderBy('urgent_vacancies.id')
            ->take(12)
            ->get();

        return view('landing.main', [
            'jobs' => $jobs,
            'urgentJobs' => $urgentJobs,
            'advancedFilterOptions' => $this->advancedFilterOptions(),
            'advancedFilterState' => $this->normalizeAdvancedFilters(),
        ]);
    }

    public function explore(Request $request)
    {
        $query = $this->publicVacanciesQuery();

        if ($request->filled('q')) {
            $keyword = $request->string('q')->toString();
            $query->where(function ($builder) use ($keyword) {
                $builder->where('title', 'like', "%{$keyword}%")
                    ->orWhere('job_code', 'like', "%{$keyword}%")
                    ->orWhere('visa_type', 'like', "%{$keyword}%")
                    ->orWhere('job_type', 'like', "%{$keyword}%")
                    ->orWhere('placement', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('location')) {
            $location = $request->string('location')->toString();
            $query->where('placement', 'like', "%{$location}%");
        }

        $this->applyAdvancedFilters($query, $this->normalizeAdvancedFilters());

        $jobs = $query->latest()->paginate(12)->withQueryString();

        return view('landing.explore', [
            'jobs' => $jobs,
            'totalJobs' => $this->publicVacanciesQuery()->count(),
            'advancedFilterOptions' => $this->advancedFilterOptions(),
            'advancedFilterState' => $this->normalizeAdvancedFilters(),
        ]);
    }

    public function detail($id)
    {
        $job = Vacancy::where('job_code', $id)->firstOrFail();

        return view('landing.detail', [
            'job' => $job,
        ]);
    }

    private function publicVacanciesQuery(): Builder
    {
        return Vacancy::query()->where('status', 1);
    }

    private function jpCompanies(): array
    {
        return [
            [
                'slug' => 'sakura-precision-manufacturing',
                'name' => 'Sakura Precision Manufacturing',
                'location' => 'Osaka, Jepang',
                'initials' => 'SP',
                'logo' => 'company-logos/sakura-precision-manufacturing.svg',
                'from' => '#f43f5e',
                'to' => '#fb923c',
                'industry' => 'Manufacturing',
                'established' => '1998',
                'employees' => '850+',
                'website' => 'sakura-precision.co.jp',
                'overview' => 'Perusahaan manufaktur presisi yang berfokus pada komponen industri dan dukungan produksi untuk sektor otomotif dan elektronik.',
                'specialties' => ['Precision Parts', 'CNC Machining', 'Quality Control', 'Assembly'],
                'benefits' => ['Asrama', 'Lembur', 'Bonus Kinerja', 'Dukungan Transport'],
            ],
            [
                'slug' => 'nihon-green-foods',
                'name' => 'Nihon Green Foods',
                'location' => 'Aichi, Jepang',
                'initials' => 'NG',
                'logo' => 'company-logos/nihon-green-foods.svg',
                'from' => '#10b981',
                'to' => '#2dd4bf',
                'industry' => 'Food Processing',
                'established' => '2006',
                'employees' => '420+',
                'website' => 'nihongreenfoods.jp',
                'overview' => 'Pabrik pengolahan makanan dengan fokus pada kualitas bahan baku, kebersihan produksi, dan distribusi produk ke retail nasional.',
                'specialties' => ['Food Packing', 'Cold Storage', 'Hygiene Standards', 'Distribution'],
                'benefits' => ['Makan Gratis', 'Shift Malam', 'Asuransi', 'Training'],
            ],
            [
                'slug' => 'tokyo-logistics-center',
                'name' => 'Tokyo Logistics Center',
                'location' => 'Tokyo, Jepang',
                'initials' => 'TL',
                'logo' => 'company-logos/tokyo-logistics-center.svg',
                'from' => '#0f172a',
                'to' => '#334155',
                'industry' => 'Logistics',
                'established' => '2011',
                'employees' => '600+',
                'website' => 'tokyologistics.jp',
                'overview' => 'Pusat logistik dan pergudangan yang menangani distribusi barang untuk area metropolitan Tokyo dan sekitarnya.',
                'specialties' => ['Warehouse', 'Sorting', 'Shipping', 'Inventory'],
                'benefits' => ['Tunjangan Kehadiran', 'Asrama', 'Bonus Tahunan', 'Support TG2'],
            ],
            [
                'slug' => 'hokkaido-tech-works',
                'name' => 'Hokkaido Tech Works',
                'location' => 'Hokkaido, Jepang',
                'initials' => 'HT',
                'logo' => 'company-logos/hokkaido-tech-works.svg',
                'from' => '#0ea5e9',
                'to' => '#22d3ee',
                'industry' => 'Electronics',
                'established' => '2004',
                'employees' => '500+',
                'website' => 'hokkaidotech.jp',
                'overview' => 'Perusahaan teknologi yang memproduksi komponen elektronik dan mendukung proses perakitan perangkat konsumen.',
                'specialties' => ['Electronics Assembly', 'Testing', 'Inspection', 'Packaging'],
                'benefits' => ['Lembur', 'Tunjangan Shift', 'Makan Siang', 'Pelatihan'],
            ],
            [
                'slug' => 'fuji-care-support',
                'name' => 'Fuji Care Support',
                'location' => 'Shizuoka, Jepang',
                'initials' => 'FC',
                'logo' => 'company-logos/fuji-care-support.svg',
                'from' => '#8b5cf6',
                'to' => '#e879f9',
                'industry' => 'Care Worker',
                'established' => '2013',
                'employees' => '300+',
                'website' => 'fujicaresupport.jp',
                'overview' => 'Perusahaan layanan care worker yang berfokus pada pendampingan lansia, kebersihan, dan perawatan harian dengan standar tinggi.',
                'specialties' => ['Caregiving', 'Daily Support', 'Facility Cleaning', 'Patient Assistance'],
                'benefits' => ['Tunjangan Hijab', 'Toleransi Ibadah', 'Asrama', 'Support Kaigo'],
            ],
            [
                'slug' => 'kansai-automotive-parts',
                'name' => 'Kansai Automotive Parts',
                'location' => 'Kyoto, Jepang',
                'initials' => 'KA',
                'logo' => 'company-logos/kansai-automotive-parts.svg',
                'from' => '#f59e0b',
                'to' => '#facc15',
                'industry' => 'Automotive',
                'established' => '1995',
                'employees' => '1.200+',
                'website' => 'kansaiauto.jp',
                'overview' => 'Pemasok komponen otomotif untuk berbagai pabrikan kendaraan dengan proses produksi modern dan kontrol kualitas ketat.',
                'specialties' => ['Auto Parts', 'Stamping', 'Inspection', 'Assembly'],
                'benefits' => ['Bonus', 'Lembur', 'Tunjangan Kendaraan', 'Jaminan Kerja'],
            ],
        ];
    }

    private function advancedFilterOptions(): array
    {
        return [
            'visaTypes' => [
                'Tokutei Ginou 1' => 'Tokutei Ginou 1',
                'Tokutei Ginou 2' => 'Tokutei Ginou 2',
                'Kaigo Visa' => 'Kaigo Visa',
                'GIjinkoku' => 'GIjinkoku',
            ],
            'jlptLevels' => [
                'n5' => 'N5',
                'n4' => 'N4',
                'n3' => 'N3',
                'n2' => 'N2',
                'n1' => 'N1',
                'all' => 'Bebas',
            ],
            'kaiwaLevels' => [
                'n5' => 'N5',
                'n4' => 'N4',
                'n3' => 'N3',
                'n2' => 'N2',
                'n1' => 'N1',
                'all' => 'Bebas',
            ],
            'experienceRequirements' => [
                'Min. 6 Bulan Pengalaman' => 'Min. 6 Bulan Pengalaman',
                'Min. 1 Tahun Pengalaman' => 'Min. 1 Tahun Pengalaman',
            ],
            'domicileRequirements' => [
                'kokunai' => 'Domisili Jepang',
                'kokugai' => 'Domisili Indonesia',
                'kokunai-to-kokugai' => 'Domisili Jepang & Indonesia',
            ],
            'genderRequirements' => [
                'l' => 'Laki-laki',
                'p' => 'Perempuan',
                'a' => 'Laki-laki & Perempuan',
            ],
            'qtyRanges' => [
                'lt_10' => '< 10',
                'lt_30' => '< 30',
                'lt_50' => '< 50',
                'gt_100' => '> 100',
            ],
            'benefits' => [
                'Kenaikan Gaji',
                'Bonus',
                'Lembur',
                'Shift Malam',
                'Asrama',
                'Tunjangan Asrama',
                'Tunjangan Kendaraan',
                'Tunjangan Sertifikat',
                'Toleransi Babi',
                'Toleransi Ibadah',
                'Toleransi Hijab',
                'Makan Gratis',
                'Support TG2',
                'Support Kaigo',
                'Tunjangan Lainnya',
            ],
        ];
    }

    private function normalizeAdvancedFilters(): array
    {
        $options = $this->advancedFilterOptions();

        $state = [
            'placement' => trim((string) request()->query('placement', '')),
            'salary' => trim((string) request()->query('salary', '')),
            'visa_type' => (string) request()->query('visa_type', ''),
            'jlpt_requirement' => (string) request()->query('jlpt_requirement', ''),
            'kaiwa_requirement' => (string) request()->query('kaiwa_requirement', ''),
            'exp_requirement' => (string) request()->query('exp_requirement', ''),
            'domicile_requirement' => (string) request()->query('domicile_requirement', ''),
            'gender_requirement' => (string) request()->query('gender_requirement', ''),
            'qty' => (string) request()->query('qty', ''),
            'benefit' => request()->query('benefit', []),
        ];

        if (! array_key_exists($state['visa_type'], $options['visaTypes'])) {
            $state['visa_type'] = '';
        }

        if (! array_key_exists($state['jlpt_requirement'], $options['jlptLevels'])) {
            $state['jlpt_requirement'] = '';
        }

        if (! array_key_exists($state['kaiwa_requirement'], $options['kaiwaLevels'])) {
            $state['kaiwa_requirement'] = '';
        }

        if (! array_key_exists($state['exp_requirement'], $options['experienceRequirements'])) {
            $state['exp_requirement'] = '';
        }

        if (! array_key_exists($state['domicile_requirement'], $options['domicileRequirements'])) {
            $state['domicile_requirement'] = '';
        }

        if (! array_key_exists($state['gender_requirement'], $options['genderRequirements'])) {
            $state['gender_requirement'] = '';
        }

        if (! array_key_exists($state['qty'], $options['qtyRanges'])) {
            $state['qty'] = '';
        }

        $benefits = is_array($state['benefit']) ? $state['benefit'] : [];
        $state['benefit'] = array_values(array_intersect($options['benefits'], $benefits));

        return $state;
    }

    private function applyAdvancedFilters(Builder $query, array $filters): void
    {
        if ($filters['placement'] !== '') {
            $query->where('placement', 'like', '%' . $filters['placement'] . '%');
        }

        if ($filters['salary'] !== '') {
            $query->where('salary', 'like', '%' . $filters['salary'] . '%');
        }

        foreach ([
            'visa_type',
            'jlpt_requirement',
            'exp_requirement',
            'domicile_requirement',
            'gender_requirement',
        ] as $exactFilter) {
            if ($filters[$exactFilter] !== '') {
                $query->where($exactFilter, $filters[$exactFilter]);
            }
        }

        if ($filters['kaiwa_requirement'] !== '') {
            if ($filters['kaiwa_requirement'] === 'all') {
                $query->whereNull('kaiwa_requirement');
            } else {
                $query->where('kaiwa_requirement', $filters['kaiwa_requirement']);
            }
        }

        if ($filters['qty'] !== '') {
            [$operator, $value] = match ($filters['qty']) {
                'lt_10' => ['<', 10],
                'lt_30' => ['<', 30],
                'lt_50' => ['<', 50],
                'gt_100' => ['>', 100],
            };

            $query->where('qty', $operator, $value);
        }

        foreach ($filters['benefit'] as $benefit) {
            $this->applyDelimitedFilter($query, 'benefit', $benefit);
        }
    }

    private function applyDelimitedFilter(Builder $query, string $column, string $value): void
    {
        $query->where(function (Builder $builder) use ($column, $value) {
            $builder->where($column, $value)
                ->orWhere($column, 'like', $value . '|%')
                ->orWhere($column, 'like', '%|' . $value . '|%')
                ->orWhere($column, 'like', '%|' . $value);
        });
    }
}
