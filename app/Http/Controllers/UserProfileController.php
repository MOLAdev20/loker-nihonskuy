<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserProfileRequest;
use App\Models\User;
use App\Models\User\UserEducationHistory;
use App\Models\User\UserInterviewAnswer;
use App\Models\User\UserProfile;
use App\Models\User\WorkExperience;
use App\Support\AdminUserFormWizardBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function showForm(int $id)
    {
        $user = User::query()
            ->with("userProfile")
            ->findOrFail($id);

        $educationHistoriesCount = UserEducationHistory::where("user_id", $user->id)->count();
        $workExperiencesCount = WorkExperience::where("user_id", $user->id)->count();
        $interviewCompleted = UserInterviewAnswer::where("user_id", $user->id)->exists();
        $wizardSteps = AdminUserFormWizardBuilder::buildSteps(
            "profile",
            $user->id,
            (bool) $user->userProfile,
            $educationHistoriesCount > 0,
            $workExperiencesCount > 0,
            $interviewCompleted,
        );

        return view("admin.user.profile-form", [
            "user" => $user,
            "profile" => $user->userProfile,
            "wizardSteps" => $wizardSteps,
            "formOptions" => [
                "hijabOptions" => UserProfile::hijabOptions(),
                "porkToleranceOptions" => UserProfile::porkToleranceOptions(),
                "alcoholToleranceOptions" => UserProfile::alcoholToleranceOptions(),
                "prayOptions" => UserProfile::prayOptions(),
                "driverLicenseOptions" => UserProfile::driverLicenseOptions(),
                "japaneseCertificateOptions" => UserProfile::japaneseCertificateOptions(),
                "countryOptions" => UserProfile::countryOptions(),
            ],
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

    public function uploadProfilePicture(Request $request, int $id)
    {
        $validated = $request->validate([
            "profilePicture" => ["required", "image", "mimes:jpg,jpeg,png,webp", "max:2048"],
        ]);

        $user = User::query()
            ->with("userProfile")
            ->findOrFail($id);

        if (!$user->userProfile) {
            return redirect()
                ->route("admin.users.detail", $user->id)
                ->with("error", "Data profile user belum tersedia. Lengkapi profile terlebih dahulu.");
        }

        $profile = $user->userProfile;
        $currentProfilePicture = $profile->profile_picture;
        $isCurrentExternalUrl = $currentProfilePicture &&
            (str_starts_with($currentProfilePicture, "http://") || str_starts_with($currentProfilePicture, "https://"));

        if ($currentProfilePicture && !$isCurrentExternalUrl && $currentProfilePicture !== "default.jpg") {
            $currentProfilePicturePath = ltrim($currentProfilePicture, "/");

            if (Storage::disk("public")->exists($currentProfilePicturePath)) {
                Storage::disk("public")->delete($currentProfilePicturePath);
            }
        }

        $uploadedPath = $validated["profilePicture"]->store("user-profile-pictures", "public");
        $profile->update([
            "profile_picture" => $uploadedPath,
        ]);

        return redirect()
            ->route("admin.users.detail", $user->id)
            ->with("status", "Foto profile berhasil diperbarui.");
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
            "domicile" => $validatedData["domicile"],
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
            "summary" => $validatedData["summary"] ?? null,
            "technical_experience" => $validatedData["technicalExperience"],
            "reason_for_leaving" => $validatedData["reasonForLeaving"] ?? null,
            "additional_info" => $validatedData["additionalInfo"] ?? null,
        ];
    }
}
