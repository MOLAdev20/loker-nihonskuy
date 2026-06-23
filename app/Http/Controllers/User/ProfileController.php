<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserProfileRequest;
use App\Models\User\UserEducationHistory;
use App\Models\User\UserInterviewAnswer;
use App\Models\User\UserProfile;
use App\Models\User\WorkExperience;
use App\Support\FormWizardBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/** @var \App\Models\User $user */

class ProfileController extends Controller
{
    public function showProfile()
    {
        $userId = auth()->id();
        $profile = UserProfile::where('user_id', $userId)->first();
        $educationHistories = UserEducationHistory::where('user_id', $userId)
            ->orderByDesc('date_of_entry')
            ->get();
        $workExperiences = WorkExperience::where('user_id', $userId)
            ->orderByDesc('date_of_join')
            ->get();

        return view("user.profile", [
            "profile" => $profile,
            "educationHistories" => $educationHistories,
            "workExperiences" => $workExperiences,
        ]);
    }

    public function showProfileForm()
    {
        $profile = UserProfile::where('user_id', auth()->id())->first();
        $educationHistoriesCount = UserEducationHistory::where('user_id', auth()->id())->count();
        $workExperiencesCount = WorkExperience::where('user_id', auth()->id())->count();
        $interviewAnswer = UserInterviewAnswer::where('user_id', auth()->id())->first();
        $wizardSteps = FormWizardBuilder::buildSteps(
            'profile',
            (bool) $profile,
            $educationHistoriesCount > 0,
            $workExperiencesCount > 0,
            (bool) $interviewAnswer
        );

        return view('user.profile-form', [
            'profile' => $profile,
            'wizardSteps' => $wizardSteps,
            'formOptions' => [
                'hijabOptions' => UserProfile::hijabOptions(),
                'porkToleranceOptions' => UserProfile::porkToleranceOptions(),
                'alcoholToleranceOptions' => UserProfile::alcoholToleranceOptions(),
                'prayOptions' => UserProfile::prayOptions(),
                'driverLicenseOptions' => UserProfile::driverLicenseOptions(),
                'japaneseCertificateOptions' => UserProfile::japaneseCertificateOptions(),
            ]
        ]);
    }

    public function showConfirmPage()
    {
        $profile = UserProfile::where('user_id', auth()->id())->first();
        if (! $profile) {
            return redirect()
                ->route('user.profile.form');
        }

        $educationHistories = UserEducationHistory::where('user_id', auth()->id())
            ->orderByDesc('id')
            ->get();
        if ($educationHistories->isEmpty()) {
            return redirect()
                ->route('user.education-history');
        }

        $workExperiences = WorkExperience::where('user_id', auth()->id())
            ->orderByDesc('id')
            ->get();
        if ($workExperiences->isEmpty()) {
            return redirect()
                ->route('user.working-experience');
        }

        $interviewAnswer = UserInterviewAnswer::where('user_id', auth()->id())->first();

        if (! $interviewAnswer) {
            return redirect()
                ->route('user.interview-answer');
        }

        $wizardSteps = FormWizardBuilder::buildSteps(
            'confirm',
            (bool) $profile,
            $educationHistories->isNotEmpty(),
            $workExperiences->isNotEmpty(),
            true
        );

        $publicProfileUrl = route('public.candidates.show', auth()->id());
        $waMessage = "Halo Kak, saya {$profile['full_name']}.\n\n"
            . "Mau konfirmasi nih, saya sudah selesai melengkapi data pribadi di platform *Nihonskuy*! sebagai calon kandidat.\n\n"
            . "Kira-kira untuk next step-nya bagaimana ya, Kak? Mohon arahannya,\n\n"
            . "_yoroshiku onegaishimasu_ 🙏\n\n"
            . "Berikut adalah tautan/link profile saya {$publicProfileUrl}";
        $waLink = 'https://api.whatsapp.com/send?phone=6289514161277&text=' . rawurlencode($waMessage);

        return view('user.confirm-team', [
            'waLink' => $waLink,
            'wizardSteps' => $wizardSteps,
        ]);
    }

    public function storeProfile(StoreUserProfileRequest $request)
    {
        $existingProfile = UserProfile::where('user_id', auth()->id())->first();
        $profilePayload = $this->mapProfilePayload($request->validated(), $existingProfile?->profile_picture);

        UserProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            $profilePayload
        );

        return redirect()
            ->route('user.education-history')
            ->with('status', 'Data profil berhasil disimpan.');
    }

    public function uploadProfilePicture(Request $request)
    {
        $validated = $request->validate([
            'profilePicture' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $profile = UserProfile::where('user_id', auth()->id())->first();
        if (!$profile) {
            return redirect()
                ->route('user.profile.form')
                ->with('error', 'Data profil belum tersedia. Isi profil terlebih dahulu.');
        }

        $currentProfilePicture = $profile->profile_picture;
        $isCurrentExternalUrl = $currentProfilePicture &&
            (str_starts_with($currentProfilePicture, 'http://') || str_starts_with($currentProfilePicture, 'https://'));

        if ($currentProfilePicture && !$isCurrentExternalUrl && $currentProfilePicture !== 'default.jpg') {
            $currentProfilePicturePath = ltrim($currentProfilePicture, '/');
            if (Storage::disk('public')->exists($currentProfilePicturePath)) {
                Storage::disk('public')->delete($currentProfilePicturePath);
            }
        }

        $uploadedPath = $validated['profilePicture']->store('user-profile-pictures', 'public');
        $profile->update([
            'profile_picture' => $uploadedPath,
        ]);

        return redirect()
            ->route('user.dashboard')
            ->with('status', 'Foto profile berhasil diperbarui.');
    }

    private function mapProfilePayload(array $validatedData, ?string $currentProfilePicture = null): array
    {
        $hasInterviewAnswer = UserInterviewAnswer::where('user_id', auth()->id())->exists();

        return [
            'profile_picture' => $currentProfilePicture ?: 'default.jpg',
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
            'summary' => $validatedData['summary'] ?? null,
            'technical_experience' => $validatedData['technicalExperience'],
            'reason_for_leaving' => $validatedData['reasonForLeaving'] ?? null,
            'additional_info' => $validatedData['additionalInfo'] ?? null,
            'jp_summary' => $hasInterviewAnswer
                ? UserProfile::where('user_id', auth()->id())->value('jp_summary')
                : toJapan($validatedData['summary']),
            'jp_reason_for_leaving' => toJapan($validatedData['reasonForLeaving']),
            'jp_additional_info' => toJapan($validatedData['additionalInfo']),
        ];
    }
}
