<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class AdminVacancyAdvancedFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_filter_and_sort_vacancies_with_spatie_query_builder(): void
    {
        $admin = $this->createAdmin();

        $matchingA = $this->createVacancy([
            'job_code' => 'VAC-101',
            'visa_type' => 'Tokutei Ginou 1',
            'placement' => 'Tokyo',
            'gender_requirement' => 'a',
            'domicile_requirement' => 'kokugai',
            'jlpt_requirement' => 'n3',
            'kaiwa_requirement' => 'n4',
            'status' => 1,
        ]);

        $matchingB = $this->createVacancy([
            'job_code' => 'VAC-102',
            'visa_type' => 'Tokutei Ginou 1',
            'placement' => 'Tokyo',
            'gender_requirement' => 'a',
            'domicile_requirement' => 'kokugai',
            'jlpt_requirement' => 'n3',
            'kaiwa_requirement' => 'n4',
            'status' => 1,
        ]);

        $this->createVacancy([
            'job_code' => 'VAC-999',
            'visa_type' => 'Kaigo Visa',
            'placement' => 'Osaka',
            'gender_requirement' => 'p',
            'domicile_requirement' => 'kokunai',
            'jlpt_requirement' => 'n2',
            'kaiwa_requirement' => 'n2',
            'status' => 0,
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.vacancies', [
            'filter' => [
                'visa_type' => 'Tokutei Ginou 1',
                'placement' => 'Tokyo',
                'gender_requirement' => 'a',
                'domicile_requirement' => 'kokugai',
                'jlpt_requirement' => 'n3',
                'kaiwa_requirement' => 'n4',
                'status' => 1,
            ],
            'sort' => '-job_code',
        ]));

        $response->assertOk();
        $response->assertViewHas('jobs', function ($jobs) use ($matchingA, $matchingB) {
            if (! $jobs instanceof LengthAwarePaginator) {
                return false;
            }

            if ($jobs->total() !== 2) {
                return false;
            }

            $jobCodes = $jobs->pluck('job_code')->values()->all();

            return $jobCodes === [$matchingB->job_code, $matchingA->job_code];
        });
    }

    public function test_filtered_vacancies_pagination_keeps_query_string(): void
    {
        $admin = $this->createAdmin();

        foreach (range(1, 13) as $index) {
            $this->createVacancy([
                'job_code' => 'TG1-' . str_pad((string) $index, 3, '0', STR_PAD_LEFT),
                'visa_type' => 'Tokutei Ginou 1',
                'status' => 1,
            ]);
        }

        $response = $this->actingAs($admin, 'admin')->get(route('admin.vacancies', [
            'filter' => [
                'visa_type' => 'Tokutei Ginou 1',
                'status' => 1,
            ],
            'sort' => 'job_code',
        ]));

        $response->assertOk();
        $response->assertViewHas('jobs', function ($jobs) {
            if (! $jobs instanceof LengthAwarePaginator || $jobs->total() !== 13) {
                return false;
            }

            $nextPageUrl = $jobs->nextPageUrl();

            if (! is_string($nextPageUrl)) {
                return false;
            }

            $decodedUrl = urldecode($nextPageUrl);

            return str_contains($decodedUrl, 'filter[visa_type]=Tokutei Ginou 1')
                && str_contains($decodedUrl, 'filter[status]=1')
                && str_contains($decodedUrl, 'sort=job_code')
                && str_contains($decodedUrl, 'page=2');
        });
    }

    public function test_invalid_filter_or_sort_query_does_not_trigger_fatal_error(): void
    {
        $admin = $this->createAdmin();
        $this->createVacancy([
            'job_code' => 'SAFE-001',
            'status' => 1,
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.vacancies', [
            'filter' => [
                'unknown_filter' => 'invalid',
            ],
            'sort' => '-created_at',
        ]));

        $response->assertOk();
        $response->assertSee('Parameter filter atau sorting tidak valid', false);
        $response->assertSee('SAFE-001');
    }

    private function createAdmin(): Admin
    {
        return Admin::create([
            'name' => 'Admin User',
            'email' => 'admin-vacancy@example.com',
            'password' => 'password',
        ]);
    }

    private function createVacancy(array $overrides = []): Vacancy
    {
        static $vacancyCounter = 1;

        $defaultPayload = [
            'job_code' => 'JOB-' . str_pad((string) $vacancyCounter++, 4, '0', STR_PAD_LEFT),
            'title' => 'Vacancy Default',
            'visa_type' => 'Tokutei Ginou 1',
            'placement' => 'Tokyo',
            'placement_branch' => null,
            'job_type' => 'Restoran',
            'source' => 'https://example.com/source',
            'salary' => '200000-250000',
            'whatsapp_number' => '6281200000000',
            'gender_requirement' => 'a',
            'domicile_requirement' => 'kokugai',
            'jlpt_requirement' => 'all',
            'kaiwa_requirement' => 'n5',
            'qty' => 2,
            'benefit' => null,
            'tags' => null,
            'additional_information' => '{"ops":[{"insert":"Informasi tambahan"}]}',
            'expired_at' => now()->addDays(20),
            'status' => 1,
        ];

        return Vacancy::create(array_merge($defaultPayload, $overrides));
    }
}
