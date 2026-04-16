<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserProfileRequest;
use App\Models\User\UserProfile;

/** @var \App\Models\User $user */

class ProfileController extends Controller
{
    public function showProfile()
    {
        $profile = UserProfile::where('user_id', auth()->id())->first();

        return view("user.profile", [
            "profile" => $profile
        ]);
    }

    public function showProfileForm()
    {
        $profile = UserProfile::where('user_id', auth()->id())->first();

        return view('user.profile-form', [
            'profile' => $profile,
        ]);
    }

    public function storeProfile(StoreUserProfileRequest $request)
    {
        $profilePayload = $this->mapProfilePayload($request->validated());

        UserProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            $profilePayload
        );

        return redirect()
            ->route('user.profile.form')
            ->with('status', 'Data profil berhasil disimpan.');
    }

    private function mapProfilePayload(array $validatedData): array
    {
        return [
            'profile_picture' => "default.jpg",
            'full_name' => $validatedData['fullName'],
            'furigana_name' => $validatedData['furiganaName'],
            'birth_date' => $validatedData['birthDate'],
            'gender' => $validatedData['gender'],
            'height' => $validatedData['height'],
            'weight' => $validatedData['weight'],
            'marital_status' => $validatedData['maritalStatus'],
            'nationality' => $validatedData['nationality'],
            'place_of_origin' => $validatedData['placeOfOrigin'],
            'current_address' => $validatedData['currentAddress'],
            'religion' => $validatedData['religion'],
            'is_wearing_hijab' => $validatedData['isWearingHijab'],
            'prayer_requirement' => $validatedData['prayerRequirement'],
            'pork_tolerance' => $validatedData['porkTolerance'],
            'alcohol_tolerance' => $validatedData['alcoholTolerance'],
            'entry_date' => $validatedData['entryDate'] ?? null,
            'visa_expiry_date' => $validatedData['visaExpiryDate'] ?? null,
            'current_visa_type' => $validatedData['currentVisaType'],
            'jlpt_level' => $validatedData['jlptLevel'],
            'has_driver_license' => $validatedData['hasDriverLicense'],
            'work_start_date' => $validatedData['workStartDate'],
            'technical_experience' => $validatedData['technicalExperience'],
        ];
    }

}
