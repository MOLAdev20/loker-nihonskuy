<?php

namespace Tests\Feature;

use App\Models\UrgentVacancy;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingUrgentVacancyTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_index_returns_only_active_urgent_vacancies_in_saved_order(): void
    {
        $secondJob = $this->createVacancy([
            'job_code' => 'URG002',
            'title' => 'Urgent Kedua',
            'tags' => 'urgent',
        ]);
        $firstJob = $this->createVacancy([
            'job_code' => 'URG001',
            'title' => 'Urgent Pertama',
            'tags' => null,
        ]);
        $inactiveJob = $this->createVacancy([
            'job_code' => 'URG003',
            'title' => 'Urgent Nonaktif',
            'status' => 0,
        ]);
        $tagOnlyJob = $this->createVacancy([
            'job_code' => 'TAG001',
            'title' => 'Tag Only Job',
            'tags' => 'urgent',
        ]);

        $this->markAsUrgent($secondJob, 2);
        $this->markAsUrgent($firstJob, 1);
        $this->markAsUrgent($inactiveJob, 3);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Dibutuhkan Segera');
        $response->assertViewHas('urgentJobs', function ($urgentJobs) use ($firstJob, $secondJob, $tagOnlyJob) {
            if ($urgentJobs->count() !== 2) {
                return false;
            }

            return $urgentJobs->pluck('job_code')->values()->all() === [
                $firstJob->job_code,
                $secondJob->job_code,
            ] && ! $urgentJobs->pluck('job_code')->contains($tagOnlyJob->job_code);
        });
    }

    public function test_landing_index_hides_urgent_section_when_no_active_urgent_vacancy_exists(): void
    {
        $inactiveJob = $this->createVacancy([
            'job_code' => 'NON100',
            'title' => 'Inactive Urgent Job',
            'status' => 0,
            'tags' => 'urgent',
        ]);

        $this->markAsUrgent($inactiveJob, 1);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewHas('urgentJobs', fn ($urgentJobs) => $urgentJobs->isEmpty());
        $response->assertDontSee('Dibutuhkan Segera');
    }

    public function test_landing_index_limits_urgent_vacancies_to_twelve_items(): void
    {
        foreach (range(1, 13) as $index) {
            $vacancy = $this->createVacancy([
                'job_code' => 'URG-LIMIT-' . str_pad((string) $index, 2, '0', STR_PAD_LEFT),
                'title' => 'Urgent Limit ' . $index,
            ]);

            $this->markAsUrgent($vacancy, $index);
        }

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewHas('urgentJobs', function ($urgentJobs) {
            return $urgentJobs->count() === 12
                && $urgentJobs->pluck('job_code')->last() === 'URG-LIMIT-12'
                && ! $urgentJobs->pluck('job_code')->contains('URG-LIMIT-13');
        });
    }

    private function markAsUrgent(Vacancy $vacancy, int $order): UrgentVacancy
    {
        return UrgentVacancy::create([
            'job_id' => $vacancy->id,
            'order' => $order,
        ]);
    }

    private function createVacancy(array $overrides = []): Vacancy
    {
        static $vacancyCounter = 1;

        $defaultPayload = [
            'job_code' => 'JOB' . str_pad((string) $vacancyCounter++, 6, '0', STR_PAD_LEFT),
            'title' => 'Default Job Title',
            'visa_type' => 'Specified Skilled Worker',
            'placement' => 'Tokyo',
            'placement_branch' => null,
            'job_type' => 'Restoran',
            'source' => 'https://example.com/source',
            'salary' => '200000-250000',
            'whatsapp_number' => '6281200000000',
            'gender_requirement' => 'a',
            'domicile_requirement' => 'kokugai',
            'jlpt_requirement' => 'all',
            'kaiwa_requirement' => null,
            'qty' => 2,
            'benefit' => null,
            'tags' => null,
            'additional_information' => '{"ops":[{"insert":"Informasi tambahan"}]}',
            'expired_at' => now()->addDays(14),
            'status' => 1,
        ];

        return Vacancy::create(array_merge($defaultPayload, $overrides));
    }
}
