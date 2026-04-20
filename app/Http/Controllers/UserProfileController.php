<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserProfileRequest;
use App\Models\User;
use App\Models\User\UserEducationHistory;
use App\Models\User\UserProfile;
use App\Models\User\WorkExperience;
use App\Support\AdminUserFormWizardBuilder;

class UserProfileController extends Controller
{
    public function showForm(int $id)
    {
        $user = User::query()
            ->with("userProfile")
            ->findOrFail($id);

        $educationHistoriesCount = UserEducationHistory::where("user_id", $user->id)->count();
        $workExperiencesCount = WorkExperience::where("user_id", $user->id)->count();
        $wizardSteps = AdminUserFormWizardBuilder::buildSteps(
            "profile",
            $user->id,
            (bool) $user->userProfile,
            $educationHistoriesCount > 0,
            $workExperiencesCount > 0,
        );

        return view("admin.user.profile-form", [
            "user" => $user,
            "profile" => $user->userProfile,
            "wizardSteps" => $wizardSteps,
        ]);
    }

    public function store(StoreUserProfileRequest $request, int $id)
    {
        $user = User::query()->findOrFail($id);
        $profilePayload = $this->mapProfilePayload($request->validated());

        UserProfile::updateOrCreate(
            ["user_id" => $user->id],
            $profilePayload,
        );

        return redirect()
            ->route("admin.users.education.index", $user->id)
            ->with("status", "Data profil user berhasil disimpan.");
    }

    private function mapProfilePayload(array $validatedData): array
    {
        return [
            "profile_picture" => "default.jpg",
            "full_name" => $validatedData["fullName"],
            "furigana_name" => $validatedData["furiganaName"],
            "birth_date" => $validatedData["birthDate"],
            "gender" => $validatedData["gender"],
            "height" => $validatedData["height"],
            "weight" => $validatedData["weight"],
            "marital_status" => $validatedData["maritalStatus"],
            "nationality" => $validatedData["nationality"],
            "place_of_origin" => $validatedData["placeOfOrigin"],
            "current_address" => $validatedData["currentAddress"],
            "religion" => $validatedData["religion"],
            "is_wearing_hijab" => $validatedData["isWearingHijab"],
            "prayer_requirement" => $validatedData["prayerRequirement"],
            "pork_tolerance" => $validatedData["porkTolerance"],
            "alcohol_tolerance" => $validatedData["alcoholTolerance"],
            "entry_date" => $validatedData["entryDate"] ?? null,
            "visa_expiry_date" => $validatedData["visaExpiryDate"] ?? null,
            "current_visa_type" => $validatedData["currentVisaType"],
            "jlpt_level" => $validatedData["jlptLevel"],
            "has_driver_license" => $validatedData["hasDriverLicense"],
            "work_start_date" => $validatedData["workStartDate"],
            "technical_experience" => $validatedData["technicalExperience"],
        ];
    }
}
