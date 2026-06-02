<?php

namespace Tests\Feature;

use App\Models\User;
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
