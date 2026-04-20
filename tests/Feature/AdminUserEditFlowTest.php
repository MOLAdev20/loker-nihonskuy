<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminUserEditFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_user_edit_routes_require_admin_authentication(): void
    {
        $user = User::factory()->create();

        $this->get(route("admin.users.profile.form", $user->id))
            ->assertRedirect("/admin/login");
        $this->get(route("admin.users.education.index", $user->id))
            ->assertRedirect("/admin/login");
        $this->get(route("admin.users.working-experience.index", $user->id))
            ->assertRedirect("/admin/login");
    }

    public function test_authenticated_admin_can_open_admin_user_edit_forms(): void
    {
        $admin = $this->createAdmin();
        $user = User::factory()->create([
            "name" => "Target User",
        ]);
        DB::table("user_profile")->insert([
            "user_id" => $user->id,
            "profile_picture" => "default.jpg",
            "full_name" => "Target User Full",
            "furigana_name" => "Target User Full",
            "birth_date" => "1998-01-01",
            "gender" => "male",
            "height" => 168,
            "weight" => 60,
            "marital_status" => "single",
            "nationality" => "Indonesia",
            "place_of_origin" => "Jakarta",
            "current_address" => "Jakarta",
            "religion" => "islam",
            "is_wearing_hijab" => "Tidak",
            "prayer_requirement" => "Normal",
            "pork_tolerance" => "Tidak",
            "alcohol_tolerance" => "Tidak",
            "entry_date" => null,
            "visa_expiry_date" => null,
            "current_visa_type" => "Tokutei Ginou",
            "jlpt_level" => "N3",
            "has_driver_license" => "Ya",
            "work_start_date" => "2026-06-01",
            "technical_experience" => "General",
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        $this->actingAs($admin, "admin")
            ->get(route("admin.users.profile.form", $user->id))
            ->assertOk()
            ->assertSee("Form Profil User")
            ->assertSee("Target User Full");

        $this->actingAs($admin, "admin")
            ->get(route("admin.users.education.index", $user->id))
            ->assertOk()
            ->assertSee("Riwayat Pendidikan User")
            ->assertSee("Tambah Riwayat Pendidikan");

        $this->actingAs($admin, "admin")
            ->get(route("admin.users.working-experience.index", $user->id))
            ->assertOk()
            ->assertSee("Riwayat Pekerjaan User")
            ->assertSee("Tambah Riwayat Pekerjaan");
    }

    public function test_admin_can_store_profile_data_for_target_user(): void
    {
        $admin = $this->createAdmin();
        $user = User::factory()->create();
        $profilePayload = $this->getProfilePayload();

        $response = $this->actingAs($admin, "admin")
            ->post(route("admin.users.profile.store", $user->id), $profilePayload);

        $response->assertRedirect(route("admin.users.education.index", $user->id));
        $this->assertDatabaseHas("user_profile", [
            "user_id" => $user->id,
            "full_name" => $profilePayload["fullName"],
            "furigana_name" => $profilePayload["furiganaName"],
            "jlpt_level" => $profilePayload["jlptLevel"],
        ]);
    }

    public function test_admin_can_crud_education_history_for_target_user(): void
    {
        $admin = $this->createAdmin();
        $user = User::factory()->create();
        $educationPayload = $this->getEducationPayload();

        $this->actingAs($admin, "admin")
            ->post(route("admin.users.education.store", $user->id), $educationPayload)
            ->assertRedirect(route("admin.users.education.index", $user->id));

        $educationHistory = DB::table("user_education_history")
            ->where("user_id", $user->id)
            ->first();
        $this->assertNotNull($educationHistory);

        $updatedEducationPayload = $educationPayload;
        $updatedEducationPayload["institution"] = "SMAN 5 Bandung";
        $updatedEducationPayload["status"] = "graduated";

        $this->actingAs($admin, "admin")
            ->put(route("admin.users.education.update", [
                "id" => $user->id,
                "educationHistoryId" => $educationHistory->id,
            ]), $updatedEducationPayload)
            ->assertRedirect(route("admin.users.education.index", $user->id));

        $this->assertDatabaseHas("user_education_history", [
            "id" => $educationHistory->id,
            "user_id" => $user->id,
            "institution" => "SMAN 5 Bandung",
        ]);

        $this->actingAs($admin, "admin")
            ->delete(route("admin.users.education.destroy", [
                "id" => $user->id,
                "educationHistoryId" => $educationHistory->id,
            ]))
            ->assertRedirect(route("admin.users.education.index", $user->id));

        $this->assertDatabaseMissing("user_education_history", [
            "id" => $educationHistory->id,
        ]);
    }

    public function test_admin_can_crud_work_experience_for_target_user(): void
    {
        $admin = $this->createAdmin();
        $user = User::factory()->create();
        $workExperiencePayload = $this->getWorkExperiencePayload();

        $this->actingAs($admin, "admin")
            ->post(route("admin.users.working-experience.store", $user->id), $workExperiencePayload)
            ->assertRedirect(route("admin.users.working-experience.index", $user->id));

        $workExperience = DB::table("user_working_experience")
            ->where("user_id", $user->id)
            ->first();
        $this->assertNotNull($workExperience);

        $updatedWorkExperiencePayload = $workExperiencePayload;
        $updatedWorkExperiencePayload["companyName"] = "PT Nihon Baru";

        $this->actingAs($admin, "admin")
            ->put(route("admin.users.working-experience.update", [
                "id" => $user->id,
                "workExperienceId" => $workExperience->id,
            ]), $updatedWorkExperiencePayload)
            ->assertRedirect(route("admin.users.working-experience.index", $user->id));

        $this->assertDatabaseHas("user_working_experience", [
            "id" => $workExperience->id,
            "user_id" => $user->id,
            "company_name" => "PT Nihon Baru",
        ]);

        $this->actingAs($admin, "admin")
            ->delete(route("admin.users.working-experience.destroy", [
                "id" => $user->id,
                "workExperienceId" => $workExperience->id,
            ]))
            ->assertRedirect(route("admin.users.working-experience.index", $user->id));

        $this->assertDatabaseMissing("user_working_experience", [
            "id" => $workExperience->id,
        ]);
    }

    public function test_admin_cannot_update_unowned_education_or_work_experience_record(): void
    {
        $admin = $this->createAdmin();
        $targetUser = User::factory()->create();
        $otherUser = User::factory()->create();

        $educationId = DB::table("user_education_history")->insertGetId([
            "user_id" => $otherUser->id,
            "education" => "SMA",
            "institution" => "SMAN 1 Jakarta",
            "location" => "Jakarta",
            "date_of_entry" => "2010-01-01",
            "date_of_graduation" => "2013-01-01",
            "date_of_dropped_out" => null,
            "status" => "graduated",
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        $workExperienceId = DB::table("user_working_experience")->insertGetId([
            "user_id" => $otherUser->id,
            "field_of_work" => "Retail",
            "company_name" => "PT Retail Maju",
            "location" => "Tokyo",
            "date_of_join" => "2020-01-01",
            "date_of_resign" => null,
            "employment_status" => "permanent",
            "visa_type" => "tokuteiGinou",
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        $this->actingAs($admin, "admin")
            ->put(route("admin.users.education.update", [
                "id" => $targetUser->id,
                "educationHistoryId" => $educationId,
            ]), $this->getEducationPayload())
            ->assertNotFound();

        $this->actingAs($admin, "admin")
            ->put(route("admin.users.working-experience.update", [
                "id" => $targetUser->id,
                "workExperienceId" => $workExperienceId,
            ]), $this->getWorkExperiencePayload())
            ->assertNotFound();
    }

    private function createAdmin(): Admin
    {
        return Admin::create([
            "name" => "Admin User",
            "email" => "admin@example.com",
            "password" => "password",
        ]);
    }

    private function getProfilePayload(): array
    {
        return [
            "fullName" => "Admin Target Full Name",
            "furiganaName" => "Admin Target Furigana",
            "birthDate" => "1998-01-01",
            "gender" => "male",
            "height" => 170,
            "weight" => 60,
            "maritalStatus" => "single",
            "nationality" => "Indonesia",
            "placeOfOrigin" => "Bandung",
            "currentAddress" => "Bandung Barat",
            "religion" => "islam",
            "isWearingHijab" => "Tidak",
            "prayerRequirement" => "Normal",
            "porkTolerance" => "Tidak",
            "alcoholTolerance" => "Tidak",
            "entryDate" => "2024-01-01",
            "visaExpiryDate" => "2027-01-01",
            "currentVisaType" => "Tokutei Ginou",
            "jlptLevel" => "N3",
            "hasDriverLicense" => "Memiliki SIM A",
            "workStartDate" => "2026-06-01",
            "technicalExperience" => "Operator Produksi",
        ];
    }

    private function getEducationPayload(): array
    {
        return [
            "education" => "SMA",
            "institution" => "SMAN 1 Bandung",
            "location" => "Bandung",
            "dateOfEntry" => "2010-07-01",
            "dateOfGraduation" => "2013-05-31",
            "dateOfDroppedOut" => null,
            "status" => "graduated",
        ];
    }

    private function getWorkExperiencePayload(): array
    {
        return [
            "fieldOfWork" => "Manufaktur",
            "companyName" => "PT Nihon Maju",
            "location" => "Tokyo",
            "dateOfJoin" => "2020-01-01",
            "dateOfResign" => null,
            "employmentStatus" => "permanent",
            "visaType" => "tokuteiGinou",
        ];
    }
}
