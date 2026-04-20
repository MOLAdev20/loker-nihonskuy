<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminUserDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_user_detail_requires_admin_authentication(): void
    {
        $user = User::factory()->create();

        $response = $this->get(route("admin.users.detail", $user->id));

        $response->assertRedirect("/admin/login");
    }

    public function test_admin_can_view_user_detail_with_all_relations(): void
    {
        $admin = $this->createAdmin();
        $user = User::factory()->create([
            "name" => "Base User Name",
            "email" => "detail-user@example.com",
        ]);

        $this->createUserProfile($user->id, "Detail Profile Name");
        $this->createEducationHistory($user->id, "SMA", "SMAN 1 Jakarta");
        $this->createWorkExperience($user->id, "Retail", "PT Retail Maju");

        $response = $this->actingAs($admin, "admin")
            ->get(route("admin.users.detail", $user->id));

        $response->assertOk();
        $response->assertSee("Detail Profile Name");
        $response->assertSee("detail-user@example.com");
        $response->assertSee("SMAN 1 Jakarta");
        $response->assertSee("PT Retail Maju");
        $response->assertSee("Completed");
        $response->assertSee("Ubah Data");
        $response->assertSee(route("admin.users.profile.form", $user->id), false);
        $response->assertSee(route("admin.users.education.index", $user->id), false);
        $response->assertSee(route("admin.users.working-experience.index", $user->id), false);
    }

    public function test_admin_user_detail_shows_placeholder_when_relation_data_empty(): void
    {
        $admin = $this->createAdmin();
        $user = User::factory()->create();

        $response = $this->actingAs($admin, "admin")
            ->get(route("admin.users.detail", $user->id));

        $response->assertOk();
        $response->assertSee("No data provided.");
        $response->assertSee("Incomplete");
    }

    public function test_admin_user_detail_returns_404_for_unknown_user(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin, "admin")
            ->get(route("admin.users.detail", 999999));

        $response->assertNotFound();
    }

    private function createAdmin(): Admin
    {
        return Admin::create([
            "name" => "Admin User",
            "email" => "admin@example.com",
            "password" => "password",
        ]);
    }

    private function createUserProfile(int $userId, string $fullName): void
    {
        DB::table("user_profile")->insert([
            "user_id" => $userId,
            "profile_picture" => "default.jpg",
            "full_name" => $fullName,
            "furigana_name" => "Furigana Name",
            "birth_date" => "1990-01-01",
            "gender" => "male",
            "height" => 170,
            "weight" => 60,
            "marital_status" => "single",
            "nationality" => "Indonesia",
            "place_of_origin" => "Jakarta",
            "current_address" => "Jakarta",
            "religion" => "Islam",
            "is_wearing_hijab" => "no",
            "prayer_requirement" => "standard",
            "pork_tolerance" => "none",
            "alcohol_tolerance" => "none",
            "entry_date" => null,
            "visa_expiry_date" => null,
            "current_visa_type" => "Tokutei Ginou",
            "jlpt_level" => "N3",
            "has_driver_license" => "yes",
            "work_start_date" => "2026-01-01",
            "technical_experience" => "General experience",
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }

    private function createEducationHistory(int $userId, string $education, string $institution): void
    {
        DB::table("user_education_history")->insert([
            "user_id" => $userId,
            "education" => $education,
            "institution" => $institution,
            "location" => "Jakarta",
            "date_of_entry" => "2010-01-01",
            "date_of_graduation" => "2013-01-01",
            "date_of_dropped_out" => null,
            "status" => "Lulus",
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }

    private function createWorkExperience(int $userId, string $fieldOfWork, string $companyName): void
    {
        DB::table("user_working_experience")->insert([
            "user_id" => $userId,
            "field_of_work" => $fieldOfWork,
            "company_name" => $companyName,
            "location" => "Tokyo",
            "date_of_join" => "2020-01-01",
            "date_of_resign" => null,
            "employment_status" => "Full Time",
            "visa_type" => "Tokutei Ginou",
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }
}
