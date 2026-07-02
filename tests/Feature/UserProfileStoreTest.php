<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\User\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_store_profile_with_additional_text_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('user.profile.store'), $this->getProfilePayload());

        $response->assertRedirect(route('user.education-history'));
        $this->assertDatabaseHas('user_profile', [
            'user_id' => $user->id,
            'summary' => 'Ringkasan diri kandidat.',
            'technical_experience' => 'Pernah magang di manufaktur.',
            'reason_for_leaving' => 'Ingin tantangan kerja yang lebih baik.',
            'additional_info' => 'Bersedia relokasi.',
        ]);
    }

    public function test_authenticated_user_can_store_jikoshoukai_youtube_link(): void
    {
        $user = User::factory()->create();

        UserProfile::query()->create([
            'user_id' => $user->id,
            'profile_picture' => 'default.jpg',
            'full_name' => 'User Kandidat',
            'furigana_name' => 'Yuza Kandidaato',
            'birth_date' => '1998-01-01',
            'gender' => 'male',
            'height' => 170,
            'weight' => 60,
            'marital_status' => 'single',
            'nationality' => 'Indonesia',
            'place_of_origin' => 'Bandung',
            'current_address' => 'Bandung Barat',
            'religion' => 'islam',
            'is_wearing_hijab' => 'Tidak',
            'prayer_requirement' => 'Normal',
            'pork_tolerance' => 'Tidak',
            'alcohol_tolerance' => 'Tidak',
            'entry_date' => '2024-01-01',
            'visa_expiry_date' => '2027-01-01',
            'current_visa_type' => 'Tokutei Ginou',
            'jlpt_level' => 'N3',
            'has_driver_license' => 'Memiliki SIM A',
            'work_start_date' => '2026-06-01',
            'technical_experience' => 'Pernah magang di manufaktur.',
        ]);

        $response = $this->actingAs($user)
            ->post(route('user.profile.jikoshoukai.store'), [
                'jikoshoukai' => 'https://www.youtube.com/watch?v=qAxpv3cCHO8',
            ]);

        $response->assertRedirect(route('user.dashboard'));

        $this->assertDatabaseHas('user_profile', [
            'user_id' => $user->id,
            'jikoshoukai' => 'https://www.youtube.com/watch?v=qAxpv3cCHO8',
        ]);
    }

    public function test_authenticated_user_cannot_store_non_youtube_jikoshoukai_link(): void
    {
        $user = User::factory()->create();

        UserProfile::query()->create([
            'user_id' => $user->id,
            'profile_picture' => 'default.jpg',
            'full_name' => 'User Kandidat',
            'furigana_name' => 'Yuza Kandidaato',
            'birth_date' => '1998-01-01',
            'gender' => 'male',
            'height' => 170,
            'weight' => 60,
            'marital_status' => 'single',
            'nationality' => 'Indonesia',
            'place_of_origin' => 'Bandung',
            'current_address' => 'Bandung Barat',
            'religion' => 'islam',
            'is_wearing_hijab' => 'Tidak',
            'prayer_requirement' => 'Normal',
            'pork_tolerance' => 'Tidak',
            'alcohol_tolerance' => 'Tidak',
            'entry_date' => '2024-01-01',
            'visa_expiry_date' => '2027-01-01',
            'current_visa_type' => 'Tokutei Ginou',
            'jlpt_level' => 'N3',
            'has_driver_license' => 'Memiliki SIM A',
            'work_start_date' => '2026-06-01',
            'technical_experience' => 'Pernah magang di manufaktur.',
        ]);

        $response = $this->from(route('user.dashboard'))
            ->actingAs($user)
            ->post(route('user.profile.jikoshoukai.store'), [
                'jikoshoukai' => 'https://vimeo.com/123456',
            ]);

        $response->assertRedirect(route('user.dashboard'));
        $response->assertSessionHasErrors('jikoshoukai');
    }

    private function getProfilePayload(): array
    {
        return [
            'fullName' => 'User Kandidat',
            'furiganaName' => 'Yuza Kandidaato',
            'birthDate' => '1998-01-01',
            'gender' => 'male',
            'height' => 170,
            'weight' => 60,
            'maritalStatus' => 'single',
            'nationality' => 'Indonesia',
            'placeOfOrigin' => 'Bandung',
            'currentAddress' => 'Bandung Barat',
            'religion' => 'islam',
            'isWearingHijab' => 'Tidak',
            'prayerRequirement' => 'Normal',
            'porkTolerance' => 'Tidak',
            'alcoholTolerance' => 'Tidak',
            'entryDate' => '2024-01-01',
            'visaExpiryDate' => '2027-01-01',
            'currentVisaType' => 'Tokutei Ginou',
            'jlptLevel' => 'N3',
            'hasDriverLicense' => 'Memiliki SIM A',
            'workStartDate' => '2026-06-01',
            'summary' => 'Ringkasan diri kandidat.',
            'technicalExperience' => 'Pernah magang di manufaktur.',
            'reasonForLeaving' => 'Ingin tantangan kerja yang lebih baik.',
            'additionalInfo' => 'Bersedia relokasi.',
        ];
    }
}
