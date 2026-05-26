<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\UrgentVacancy;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AdminUrgentVacancyManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_add_vacancy_to_urgent_list(): void
    {
        $admin = $this->createAdmin();
        $vacancy = $this->createVacancy([
            'job_code' => 'URG-ADD-001',
            'title' => 'Cook Helper',
        ]);

        $response = $this->actingAs($admin, 'admin')->post(route('admin.vacancy.urgent.store'), [
            'job_id' => $vacancy->id,
        ]);

        $response->assertRedirect(route('admin.vacancy.urgent.index'));
        $this->assertDatabaseHas('urgent_vacancies', [
            'job_id' => $vacancy->id,
            'order' => 1,
        ]);
        $this->assertDatabaseHas('vacancies', [
            'id' => $vacancy->id,
            'tags' => 'urgent',
        ]);
    }

    public function test_urgent_vacancies_table_has_unique_job_id_index(): void
    {
        $this->assertTrue(Schema::hasColumn('urgent_vacancies', 'job_id'));

        $vacancy = $this->createVacancy([
            'job_code' => 'URG-UNIQUE-001',
        ]);

        UrgentVacancy::create([
            'job_id' => $vacancy->id,
            'order' => 1,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        UrgentVacancy::create([
            'job_id' => $vacancy->id,
            'order' => 2,
        ]);
    }

    public function test_urgent_vacancies_table_has_unique_order_index(): void
    {
        $firstVacancy = $this->createVacancy([
            'job_code' => 'URG-ORDER-UNIQUE-1',
        ]);
        $secondVacancy = $this->createVacancy([
            'job_code' => 'URG-ORDER-UNIQUE-2',
        ]);

        UrgentVacancy::create([
            'job_id' => $firstVacancy->id,
            'order' => 1,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        UrgentVacancy::create([
            'job_id' => $secondVacancy->id,
            'order' => 1,
        ]);
    }

    public function test_admin_cannot_add_duplicate_urgent_vacancy(): void
    {
        $admin = $this->createAdmin();
        $vacancy = $this->createVacancy([
            'job_code' => 'URG-DUP-001',
        ]);

        UrgentVacancy::create([
            'job_id' => $vacancy->id,
            'order' => 1,
        ]);

        $response = $this->from(route('admin.vacancy.urgent.index'))
            ->actingAs($admin, 'admin')
            ->post(route('admin.vacancy.urgent.store'), [
                'job_id' => $vacancy->id,
            ]);

        $response->assertRedirect(route('admin.vacancy.urgent.index'));
        $response->assertSessionHasErrors('job_id');
        $this->assertDatabaseCount('urgent_vacancies', 1);
    }

    public function test_admin_can_reorder_urgent_vacancies(): void
    {
        $admin = $this->createAdmin();
        $first = $this->createUrgentVacancy('URG-ORDER-001', 1);
        $second = $this->createUrgentVacancy('URG-ORDER-002', 2);
        $third = $this->createUrgentVacancy('URG-ORDER-003', 3);

        $response = $this->actingAs($admin, 'admin')->patch(route('admin.vacancy.urgent.order'), [
            'urgent_vacancy_ids' => [
                $third->id,
                $first->id,
                $second->id,
            ],
        ]);

        $response->assertRedirect(route('admin.vacancy.urgent.index'));
        $this->assertDatabaseHas('urgent_vacancies', [
            'id' => $third->id,
            'order' => 1,
        ]);
        $this->assertDatabaseHas('urgent_vacancies', [
            'id' => $first->id,
            'order' => 2,
        ]);
        $this->assertDatabaseHas('urgent_vacancies', [
            'id' => $second->id,
            'order' => 3,
        ]);
    }

    public function test_admin_can_reorder_urgent_vacancies_from_browser_string_payload(): void
    {
        $admin = $this->createAdmin();
        $first = $this->createUrgentVacancy('URG-ORDER-101', 1);
        $second = $this->createUrgentVacancy('URG-ORDER-102', 2);
        $third = $this->createUrgentVacancy('URG-ORDER-103', 3);

        $response = $this->actingAs($admin, 'admin')->patch(route('admin.vacancy.urgent.order'), [
            'urgent_vacancy_ids' => [
                (string) $second->id,
                (string) $third->id,
                (string) $first->id,
            ],
        ]);

        $response->assertRedirect(route('admin.vacancy.urgent.index'));
        $this->assertDatabaseHas('urgent_vacancies', [
            'id' => $second->id,
            'order' => 1,
        ]);
        $this->assertDatabaseHas('urgent_vacancies', [
            'id' => $third->id,
            'order' => 2,
        ]);
        $this->assertDatabaseHas('urgent_vacancies', [
            'id' => $first->id,
            'order' => 3,
        ]);
    }

    public function test_admin_can_remove_urgent_vacancy_and_remaining_order_is_normalized(): void
    {
        $admin = $this->createAdmin();
        $first = $this->createUrgentVacancy('URG-DEL-001', 1);
        $second = $this->createUrgentVacancy('URG-DEL-002', 2);
        $third = $this->createUrgentVacancy('URG-DEL-003', 3);

        $response = $this->actingAs($admin, 'admin')->delete(route('admin.vacancy.urgent.destroy', $second));

        $response->assertRedirect(route('admin.vacancy.urgent.index'));
        $this->assertDatabaseMissing('urgent_vacancies', [
            'id' => $second->id,
        ]);
        $this->assertDatabaseHas('urgent_vacancies', [
            'id' => $first->id,
            'order' => 1,
        ]);
        $this->assertDatabaseHas('urgent_vacancies', [
            'id' => $third->id,
            'order' => 2,
        ]);
        $this->assertDatabaseHas('vacancies', [
            'id' => $second->vacancy->id,
            'tags' => null,
        ]);
    }

    public function test_deleting_vacancy_normalizes_remaining_urgent_order(): void
    {
        $admin = $this->createAdmin();
        $first = $this->createUrgentVacancy('URG-DELETE-VAC-001', 1);
        $target = $this->createUrgentVacancy('URG-DELETE-VAC-002', 2);
        $third = $this->createUrgentVacancy('URG-DELETE-VAC-003', 3);

        $response = $this->actingAs($admin, 'admin')->delete(route('admin.vacancy.delete', $target->vacancy->job_code));

        $response->assertRedirect(route('admin.vacancies'));
        $this->assertDatabaseMissing('urgent_vacancies', [
            'job_id' => $target->vacancy->id,
        ]);
        $this->assertDatabaseHas('urgent_vacancies', [
            'id' => $first->id,
            'order' => 1,
        ]);
        $this->assertDatabaseHas('urgent_vacancies', [
            'id' => $third->id,
            'order' => 2,
        ]);
    }

    public function test_editing_vacancy_with_urgent_checkbox_adds_job_to_urgent_list(): void
    {
        $admin = $this->createAdmin();
        $existingUrgent = $this->createUrgentVacancy('URG-EDIT-001', 1);
        $vacancy = $this->createVacancy([
            'job_code' => 'URG-EDIT-002',
            'title' => 'Editable Vacancy',
            'tags' => null,
        ]);

        $response = $this->actingAs($admin, 'admin')->put(
            route('admin.vacancy.update', $vacancy->job_code),
            $this->makeVacancyUpdatePayload($vacancy, [
                'special-tag' => ['urgent'],
            ])
        );

        $response->assertRedirect(route('admin.vacancy.detail', $vacancy->job_code));
        $this->assertDatabaseHas('urgent_vacancies', [
            'job_id' => $vacancy->id,
            'order' => $existingUrgent->order + 1,
        ]);
        $this->assertDatabaseHas('vacancies', [
            'id' => $vacancy->id,
            'tags' => 'urgent',
        ]);
    }

    public function test_editing_vacancy_without_urgent_checkbox_removes_job_from_urgent_list(): void
    {
        $admin = $this->createAdmin();
        $first = $this->createUrgentVacancy('URG-EDIT-101', 1);
        $target = $this->createUrgentVacancy('URG-EDIT-102', 2);
        $third = $this->createUrgentVacancy('URG-EDIT-103', 3);

        $response = $this->actingAs($admin, 'admin')->put(
            route('admin.vacancy.update', $target->vacancy->job_code),
            $this->makeVacancyUpdatePayload($target->vacancy, [
                'special-tag' => [],
            ])
        );

        $response->assertRedirect(route('admin.vacancy.detail', $target->vacancy->job_code));
        $this->assertDatabaseMissing('urgent_vacancies', [
            'id' => $target->id,
        ]);
        $this->assertDatabaseHas('urgent_vacancies', [
            'id' => $first->id,
            'order' => 1,
        ]);
        $this->assertDatabaseHas('urgent_vacancies', [
            'id' => $third->id,
            'order' => 2,
        ]);
        $this->assertDatabaseHas('vacancies', [
            'id' => $target->vacancy->id,
            'tags' => null,
        ]);
    }

    private function createAdmin(): Admin
    {
        return Admin::create([
            'name' => 'Admin User',
            'email' => 'admin-urgent@example.com',
            'password' => 'password',
        ]);
    }

    private function createUrgentVacancy(string $jobCode, int $order): UrgentVacancy
    {
        $vacancy = $this->createVacancy([
            'job_code' => $jobCode,
            'title' => 'Urgent Vacancy ' . $jobCode,
            'tags' => 'urgent',
        ]);

        return UrgentVacancy::create([
            'job_id' => $vacancy->id,
            'order' => $order,
        ]);
    }

    private function makeVacancyUpdatePayload(Vacancy $vacancy, array $overrides = []): array
    {
        $payload = [
            'job-title' => $vacancy->title,
            'visa-type' => $vacancy->visa_type,
            'job-placement' => $vacancy->placement,
            'placement-branch' => $vacancy->placement_branch,
            'job-type' => $vacancy->job_type,
            'company-web' => $vacancy->company_web,
            'salary-from' => explode('-', $vacancy->salary)[0],
            'salary-to' => explode('-', $vacancy->salary)[1] ?? null,
            'whatsapp-number' => $vacancy->whatsapp_number,
            'gender-requirement' => $vacancy->gender_requirement,
            'domicile-requirement' => $vacancy->domicile_requirement,
            'exp-requirement' => $vacancy->exp_requirement,
            'jlpt-requirement' => $vacancy->jlpt_requirement,
            'kaiwa-requirement' => $vacancy->kaiwa_requirement,
            'qty' => $vacancy->qty,
            'source' => $vacancy->source,
            'benefit' => $vacancy->benefit ? explode('|', $vacancy->benefit) : [],
            'special-tag' => $vacancy->tags ? explode('|', $vacancy->tags) : [],
            'expiration-date' => date('Y-m-d', strtotime((string) $vacancy->expired_at)),
            'additional-information' => $vacancy->additional_information,
        ];

        return array_merge($payload, $overrides);
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
