<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserEducationHistoryRequest;
use App\Models\User;
use App\Models\User\UserEducationHistory;
use App\Models\User\WorkExperience;
use App\Support\AdminUserFormWizardBuilder;

class UserEducationController extends Controller
{
    public function index(int $id)
    {
        $user = User::query()
            ->with("userProfile")
            ->findOrFail($id);
        $educationHistories = UserEducationHistory::where("user_id", $user->id)
            ->orderByDesc("id")
            ->get();
        $workExperiencesCount = WorkExperience::where("user_id", $user->id)->count();
        $wizardSteps = AdminUserFormWizardBuilder::buildSteps(
            "education",
            $user->id,
            (bool) $user->userProfile,
            $educationHistories->isNotEmpty(),
            $workExperiencesCount > 0,
        );

        return view("admin.user.education-history-form", [
            "user" => $user,
            "profile" => $user->userProfile,
            "educationHistories" => $educationHistories,
            "wizardSteps" => $wizardSteps,
        ]);
    }

    public function store(StoreUserEducationHistoryRequest $request, int $id)
    {
        $user = User::query()->findOrFail($id);
        $educationHistoryPayload = $this->mapEducationHistoryPayload($request->validated());

        UserEducationHistory::create([
            "user_id" => $user->id,
            ...$educationHistoryPayload,
        ]);

        return redirect()
            ->route("admin.users.education.index", $user->id)
            ->with("status", "Data riwayat pendidikan user berhasil ditambahkan.");
    }

    public function update(StoreUserEducationHistoryRequest $request, int $id, int $educationHistoryId)
    {
        $user = User::query()->findOrFail($id);
        $educationHistory = $this->getOwnedEducationHistoryById($user->id, $educationHistoryId);
        $educationHistoryPayload = $this->mapEducationHistoryPayload($request->validated());

        $educationHistory->update($educationHistoryPayload);

        return redirect()
            ->route("admin.users.education.index", $user->id)
            ->with("status", "Data riwayat pendidikan user berhasil diperbarui.");
    }

    public function destroy(int $id, int $educationHistoryId)
    {
        $user = User::query()->findOrFail($id);
        $educationHistory = $this->getOwnedEducationHistoryById($user->id, $educationHistoryId);

        $educationHistory->delete();

        return redirect()
            ->route("admin.users.education.index", $user->id)
            ->with("status", "Data riwayat pendidikan user berhasil dihapus.");
    }

    private function getOwnedEducationHistoryById(int $userId, int $educationHistoryId): UserEducationHistory
    {
        return UserEducationHistory::where("user_id", $userId)
            ->where("id", $educationHistoryId)
            ->firstOrFail();
    }

    private function mapEducationHistoryPayload(array $validatedData): array
    {
        return [
            "education" => $validatedData["education"],
            "institution" => $validatedData["institution"],
            "location" => $validatedData["location"],
            "date_of_entry" => $validatedData["dateOfEntry"],
            "date_of_graduation" => $validatedData["dateOfGraduation"] ?? null,
            "date_of_dropped_out" => $validatedData["dateOfDroppedOut"] ?? null,
            "status" => $validatedData["status"],
        ];
    }
}
