<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserWorkExperienceRequest;
use App\Models\User;
use App\Models\User\UserEducationHistory;
use App\Models\User\WorkExperience;
use App\Support\AdminUserFormWizardBuilder;

class UserWorkingExpController extends Controller
{
    public function index(int $id)
    {
        $user = User::query()
            ->with("userProfile")
            ->findOrFail($id);
        $educationHistories = UserEducationHistory::where("user_id", $user->id)
            ->orderByDesc("id")
            ->get();
        $workExperiences = WorkExperience::where("user_id", $user->id)
            ->orderByDesc("id")
            ->get();
        $wizardSteps = AdminUserFormWizardBuilder::buildSteps(
            "workExperience",
            $user->id,
            (bool) $user->userProfile,
            $educationHistories->isNotEmpty(),
            $workExperiences->isNotEmpty(),
        );

        return view("admin.user.working-experience-form", [
            "user" => $user,
            "profile" => $user->userProfile,
            "educationHistories" => $educationHistories,
            "workExperiences" => $workExperiences,
            "wizardSteps" => $wizardSteps,
        ]);
    }

    public function store(StoreUserWorkExperienceRequest $request, int $id)
    {
        $user = User::query()->findOrFail($id);
        $workExperiencePayload = $this->mapWorkExperiencePayload($request->validated());

        WorkExperience::create([
            "user_id" => $user->id,
            ...$workExperiencePayload,
        ]);

        return redirect()
            ->route("admin.users.working-experience.index", $user->id)
            ->with("status", "Data riwayat pekerjaan user berhasil ditambahkan.");
    }

    public function update(StoreUserWorkExperienceRequest $request, int $id, int $workExperienceId)
    {
        $user = User::query()->findOrFail($id);
        $workExperience = $this->getOwnedWorkExperienceById($user->id, $workExperienceId);
        $workExperiencePayload = $this->mapWorkExperiencePayload($request->validated());

        $workExperience->update($workExperiencePayload);

        return redirect()
            ->route("admin.users.working-experience.index", $user->id)
            ->with("status", "Data riwayat pekerjaan user berhasil diperbarui.");
    }

    public function destroy(int $id, int $workExperienceId)
    {
        $user = User::query()->findOrFail($id);
        $workExperience = $this->getOwnedWorkExperienceById($user->id, $workExperienceId);

        $workExperience->delete();

        return redirect()
            ->route("admin.users.working-experience.index", $user->id)
            ->with("status", "Data riwayat pekerjaan user berhasil dihapus.");
    }

    private function getOwnedWorkExperienceById(int $userId, int $workExperienceId): WorkExperience
    {
        return WorkExperience::where("user_id", $userId)
            ->where("id", $workExperienceId)
            ->firstOrFail();
    }

    private function mapWorkExperiencePayload(array $validatedData): array
    {
        return [
            "field_of_work" => $validatedData["fieldOfWork"],
            "company_name" => $validatedData["companyName"],
            "location" => $validatedData["location"],
            "date_of_join" => $validatedData["dateOfJoin"],
            "date_of_resign" => $validatedData["dateOfResign"] ?? null,
            "employment_status" => $validatedData["employmentStatus"],
            "visa_type" => $validatedData["visaType"] ?? null,
        ];
    }
}
