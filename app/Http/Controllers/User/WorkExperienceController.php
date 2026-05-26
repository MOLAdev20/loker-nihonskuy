<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserWorkExperienceRequest;
use App\Models\User\UserEducationHistory;
use App\Models\User\UserProfile;
use App\Models\User\WorkExperience;
use App\Support\FormWizardBuilder;

class WorkExperienceController extends Controller
{
    public function index()
    {
        $profile = UserProfile::where('user_id', auth()->id())->first();
        $workingLocationOptions = WorkExperience::workingLocationOptions();
        $workingStatusOptions = WorkExperience::workingStatusOptions();
        $educationHistories = UserEducationHistory::where('user_id', auth()->id())
            ->orderByDesc('id')
            ->get();
        $workExperiences = WorkExperience::where('user_id', auth()->id())
            ->orderByDesc('id')
            ->get();
        $wizardSteps = FormWizardBuilder::buildSteps(
            'workExperience',
            (bool) $profile,
            $educationHistories->isNotEmpty(),
            $workExperiences->isNotEmpty()
        );

        return view('user.working-experience-form', [
            'profile' => $profile,
            'workingLocationOptions' => $workingLocationOptions,
            'workingStatusOptions' => $workingStatusOptions,
            'educationHistories' => $educationHistories,
            'workExperiences' => $workExperiences,
            'wizardSteps' => $wizardSteps,
        ]);
    }

    public function store(StoreUserWorkExperienceRequest $request)
    {
        $workExperiencePayload = $this->mapWorkExperiencePayload($request->validated());

        WorkExperience::create([
            'user_id' => auth()->id(),
            ...$workExperiencePayload,
        ]);

        return redirect()
            ->route('user.working-experience')
            ->with('status', 'Data riwayat pekerjaan berhasil ditambahkan.');
    }

    public function update(StoreUserWorkExperienceRequest $request, int $id)
    {
        $workExperience = $this->getOwnedWorkExperienceById($id);
        $workExperiencePayload = $this->mapWorkExperiencePayload($request->validated());

        $workExperience->update($workExperiencePayload);

        return redirect()
            ->route('user.working-experience')
            ->with('status', 'Data riwayat pekerjaan berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $workExperience = $this->getOwnedWorkExperienceById($id);
        $workExperience->delete();

        return redirect()
            ->route('user.working-experience')
            ->with('status', 'Data riwayat pekerjaan berhasil dihapus.');
    }

    private function getOwnedWorkExperienceById(int $id): WorkExperience
    {
        return WorkExperience::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();
    }

    private function mapWorkExperiencePayload(array $validatedData): array
    {
        return [
            'field_of_work' => $validatedData['fieldOfWork'],
            'company_name' => $validatedData['companyName'],
            'location' => $validatedData['location'],
            'date_of_join' => $validatedData['dateOfJoin'],
            'date_of_resign' => $validatedData['dateOfResign'] ?? null,
            'employment_status' => $validatedData['employmentStatus'],
            'visa_type' => $validatedData['visaType'] ?? null,
        ];
    }
}
