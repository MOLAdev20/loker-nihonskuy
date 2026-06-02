<?php

namespace Tests\Feature;

use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingAdvancedFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_and_explore_show_advanced_filter_entry_point(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Cari Preferensi Kerjamu');

        $this->get(route('vacancies'))
            ->assertOk()
            ->assertSee('Cari Preferensi Kerjamu');
    }

    public function test_explore_filters_public_vacancies_with_advanced_filters(): void
    {
        $matchingVacancy = $this->createVacancy([
            'job_code' => 'ADV-MATCH-001',
            'title' => 'Matching Vacancy',
            'visa_type' => 'Tokutei Ginou 1',
            'placement' => 'Tokyo',
            'salary' => '200000-250000',
            'gender_requirement' => 'a',
            'domicile_requirement' => 'kokugai',
            'exp_requirement' => 'Min. 6 Bulan Pengalaman',
            'jlpt_requirement' => 'n3',
            'kaiwa_requirement' => null,
            'qty' => 8,
            'benefit' => 'Bonus|Asrama|Support TG2',
        ]);

        $this->createVacancy([
            'job_code' => 'ADV-MISS-001',
            'title' => 'Missing Benefit Vacancy',
            'visa_type' => 'Tokutei Ginou 1',
            'placement' => 'Tokyo',
            'salary' => '200000-250000',
            'gender_requirement' => 'a',
            'domicile_requirement' => 'kokugai',
            'exp_requirement' => 'Min. 6 Bulan Pengalaman',
            'jlpt_requirement' => 'n3',
            'kaiwa_requirement' => null,
            'qty' => 8,
            'benefit' => 'Bonus|Support TG2',
        ]);

        $this->createVacancy([
            'job_code' => 'ADV-INACTIVE-001',
            'title' => 'Inactive Matching Vacancy',
            'visa_type' => 'Tokutei Ginou 1',
            'placement' => 'Tokyo',
            'salary' => '200000-250000',
            'gender_requirement' => 'a',
            'domicile_requirement' => 'kokugai',
            'exp_requirement' => 'Min. 6 Bulan Pengalaman',
            'jlpt_requirement' => 'n3',
            'kaiwa_requirement' => null,
            'qty' => 8,
            'benefit' => 'Bonus|Asrama|Support TG2',
            'status' => 0,
        ]);

        $response = $this->get(route('vacancies', [
            'placement' => 'Tokyo',
            'visa_type' => 'Tokutei Ginou 1',
            'salary' => '200000',
            'jlpt_requirement' => 'n3',
            'kaiwa_requirement' => 'all',
            'exp_requirement' => 'Min. 6 Bulan Pengalaman',
            'domicile_requirement' => 'kokugai',
            'gender_requirement' => 'a',
            'qty' => 'lt_10',
            'benefit' => ['Bonus', 'Asrama'],
        ]));

        $response->assertOk();
        $response->assertSee($matchingVacancy->title);
        $response->assertDontSee('Missing Benefit Vacancy');
        $response->assertDontSee('Inactive Matching Vacancy');
        $response->assertViewHas('jobs', function ($jobs) use ($matchingVacancy) {
            return $jobs->total() === 1
                && $jobs->first()?->job_code === $matchingVacancy->job_code;
        });
    }

    public function test_explore_pagination_keeps_active_advanced_filter_results_on_next_page(): void
    {
        foreach (range(1, 13) as $index) {
            $this->createVacancy([
                'job_code' => 'ADV-PAGE-' . str_pad((string) $index, 2, '0', STR_PAD_LEFT),
                'title' => 'Pagination Vacancy ' . $index,
                'visa_type' => 'Tokutei Ginou 1',
            ]);
        }

        $this->createVacancy([
            'job_code' => 'ADV-PAGE-OTHER',
            'title' => 'Other Visa Vacancy',
            'visa_type' => 'Kaigo Visa',
        ]);

        $response = $this->get(route('vacancies', [
            'visa_type' => 'Tokutei Ginou 1',
            'page' => 2,
        ]));

        $response->assertOk();
        $response->assertSee('Pagination Vacancy 13');
        $response->assertDontSee('Other Visa Vacancy');
        $response->assertViewHas('jobs', function ($jobs) {
            return $jobs->currentPage() === 2
                && $jobs->total() === 13
                && $jobs->every(fn ($job) => $job->visa_type === 'Tokutei Ginou 1');
        });
    }

    private function createVacancy(array $overrides = []): Vacancy
    {
        static $vacancyCounter = 1;

        $defaultPayload = [
            'job_code' => 'JOB' . str_pad((string) $vacancyCounter++, 6, '0', STR_PAD_LEFT),
            'title' => 'Default Job Title',
            'visa_type' => 'Kaigo Visa',
            'placement' => 'Osaka',
            'placement_branch' => null,
            'job_type' => 'Restoran',
            'source' => 'https://example.com/source',
            'salary' => '180000-220000',
            'whatsapp_number' => '6281200000000',
            'gender_requirement' => 'a',
            'domicile_requirement' => 'kokugai',
            'exp_requirement' => null,
            'jlpt_requirement' => 'all',
            'kaiwa_requirement' => 'n4',
            'qty' => 12,
            'benefit' => null,
            'tags' => null,
            'additional_information' => '{"ops":[{"insert":"Informasi tambahan"}]}',
            'expired_at' => now()->addDays(14),
            'status' => 1,
        ];

        return Vacancy::create(array_merge($defaultPayload, $overrides));
    }
}
