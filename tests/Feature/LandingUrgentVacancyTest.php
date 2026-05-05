<?php

namespace Tests\Feature;

use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingUrgentVacancyTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_index_returns_only_urgent_tagged_jobs_for_urgent_section(): void
    {
        $directUrgentJob = $this->createVacancy([
            "job_code" => "URG001",
            "title" => "Urgent Direct Job",
            "tags" => "urgent",
        ]);
        $combinedUrgentJob = $this->createVacancy([
            "job_code" => "URG002",
            "title" => "Urgent Combined Job",
            "tags" => "priority|urgent",
        ]);
        $this->createVacancy([
            "job_code" => "NON001",
            "title" => "Not Urgent Job",
            "tags" => "priority",
        ]);
        $this->createVacancy([
            "job_code" => "NON002",
            "title" => "False Match Job",
            "tags" => "noturgent",
        ]);
        $this->createVacancy([
            "job_code" => "NON003",
            "title" => "Inactive Urgent Job",
            "tags" => "urgent",
            "status" => 0,
        ]);

        $response = $this->get(route("home"));

        $response->assertOk();
        $response->assertSee("Dibutuhkan Segera");
        $response->assertViewHas("urgentJobs", function ($urgentJobs) use ($directUrgentJob, $combinedUrgentJob) {
            if ($urgentJobs->count() !== 2) {
                return false;
            }

            $urgentJobCodeList = $urgentJobs->pluck("job_code")->all();

            return in_array($directUrgentJob->job_code, $urgentJobCodeList, true)
                && in_array($combinedUrgentJob->job_code, $urgentJobCodeList, true)
                && ! in_array("NON001", $urgentJobCodeList, true)
                && ! in_array("NON002", $urgentJobCodeList, true)
                && ! in_array("NON003", $urgentJobCodeList, true);
        });
    }

    public function test_landing_index_hides_urgent_section_when_no_urgent_job_exists(): void
    {
        $this->createVacancy([
            "job_code" => "NON100",
            "title" => "Regular Job",
            "tags" => "priority",
        ]);

        $response = $this->get(route("home"));

        $response->assertOk();
        $response->assertViewHas("urgentJobs", fn ($urgentJobs) => $urgentJobs->isEmpty());
        $response->assertDontSee("Dibutuhkan Segera");
    }

    private function createVacancy(array $overrides = []): Vacancy
    {
        static $vacancyCounter = 1;

        $defaultPayload = [
            "job_code" => "JOB" . str_pad((string) $vacancyCounter++, 6, "0", STR_PAD_LEFT),
            "title" => "Default Job Title",
            "visa_type" => "Specified Skilled Worker",
            "placement" => "Tokyo",
            "placement_branch" => null,
            "job_type" => "Restoran",
            "source" => "https://example.com/source",
            "salary" => "200000-250000",
            "whatsapp_number" => "6281200000000",
            "gender_requirement" => "a",
            "domicile_requirement" => "kokugai",
            "jlpt_requirement" => "all",
            "kaiwa_requirement" => null,
            "qty" => 2,
            "benefit" => null,
            "tags" => null,
            "additional_information" => '{"ops":[{"insert":"Informasi tambahan"}]}',
            "expired_at" => now()->addDays(14),
            "status" => 1,
        ];

        return Vacancy::create(array_merge($defaultPayload, $overrides));
    }
}
