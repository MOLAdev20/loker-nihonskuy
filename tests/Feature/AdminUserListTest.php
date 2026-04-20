<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminUserListTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_user_list_requires_admin_authentication(): void
    {
        $response = $this->get(route("admin.users"));

        $response->assertRedirect("/admin/login");
    }

    public function test_authenticated_admin_can_view_user_list_with_joined_status_and_ordering(): void
    {
        $admin = $this->createAdmin();
        $oldestUser = User::factory()->create([
            "name" => "Oldest User",
            "email" => "oldest@example.com",
        ]);
        $middleUser = User::factory()->create([
            "name" => "Middle User",
            "email" => "middle@example.com",
        ]);
        $latestUser = User::factory()->create([
            "name" => "Latest User",
            "email" => "latest@example.com",
        ]);

        $this->createUserProfile($middleUser->id, "Middle User Profile");
        $this->createUserProfile($latestUser->id, "Latest User Profile");

        $response = $this->actingAs($admin, "admin")->get(route("admin.users"));

        $response->assertOk();
        $response->assertSeeInOrder([
            "Latest User Profile",
            "latest@example.com",
            "Middle User Profile",
            "middle@example.com",
            "Oldest User",
            "oldest@example.com",
        ]);
        $response->assertSee("Completed");
        $response->assertSee("Incomplete");
    }

    public function test_user_list_can_search_full_name_with_fallback_to_users_name(): void
    {
        $admin = $this->createAdmin();
        $profileMatchedUser = User::factory()->create([
            "name" => "Profile Match Base",
            "email" => "profile-match@example.com",
        ]);
        $fallbackMatchedUser = User::factory()->create([
            "name" => "Fallback Match User",
            "email" => "fallback-match@example.com",
        ]);
        $unmatchedUser = User::factory()->create([
            "name" => "Hidden User",
            "email" => "hidden@example.com",
        ]);

        $this->createUserProfile($profileMatchedUser->id, "Profile Search Keyword");
        $this->createUserProfile($unmatchedUser->id, "Completely Different Name");

        $profileResponse = $this->actingAs($admin, "admin")
            ->get(route("admin.users", ["q" => "Search Keyword"]));

        $profileResponse->assertOk();
        $profileResponse->assertSee("Profile Search Keyword");
        $profileResponse->assertDontSee("Fallback Match User");
        $profileResponse->assertDontSee("Hidden User");

        $fallbackResponse = $this->actingAs($admin, "admin")
            ->get(route("admin.users", ["q" => "Fallback Match"]));

        $fallbackResponse->assertOk();
        $fallbackResponse->assertSee("Fallback Match User");
        $fallbackResponse->assertDontSee("Profile Search Keyword");
        $fallbackResponse->assertDontSee("Hidden User");
    }

    public function test_user_list_is_paginated_and_keeps_search_query_on_links(): void
    {
        $admin = $this->createAdmin();

        foreach (range(1, 11) as $index) {
            $label = str_pad((string) $index, 2, "0", STR_PAD_LEFT);
            $user = User::factory()->create([
                "name" => "Pagination User {$label}",
                "email" => "pagination-user-{$label}@example.com",
            ]);

            $this->createUserProfile($user->id, "Pagination Search {$label}");
        }

        $response = $this->actingAs($admin, "admin")
            ->get(route("admin.users", ["q" => "Pagination Search"]));

        $response->assertOk();
        $response->assertSee("Pagination Search 11");
        $response->assertDontSee("Pagination Search 01");
        $response->assertSee('value="Pagination Search"', false);

        $pageTwoResponse = $this->actingAs($admin, "admin")
            ->get(route("admin.users", ["q" => "Pagination Search", "page" => 2]));

        $pageTwoResponse->assertOk();
        $pageTwoResponse->assertSee('value="Pagination Search"', false);
        $pageTwoResponse->assertSee("Pagination Search 01");
        $pageTwoResponse->assertDontSee("Pagination Search 11");
    }

    public function test_user_list_shows_empty_state_when_search_has_no_result(): void
    {
        $admin = $this->createAdmin();
        $user = User::factory()->create([
            "name" => "Visible User",
            "email" => "visible@example.com",
        ]);

        $this->createUserProfile($user->id, "Visible User Profile");

        $response = $this->actingAs($admin, "admin")
            ->get(route("admin.users", ["q" => "No Match"]));

        $response->assertOk();
        $response->assertSee("Tidak ada user yang sesuai dengan pencarian saat ini.");
        $response->assertDontSee("Visible User Profile");
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
}
