<?php

namespace App\Http\Controllers;

use App\Exports\ResumeExport;
use App\Models\User;
use App\Models\User\UserEducationHistory;
use App\Models\User\UserProfile;
use App\Models\User\WorkExperience;
use App\Services\GoogleTranslatorService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $queryFilter = trim((string) $request->query("q", ""));

        return view("admin.user.users", [
            "users" => User::getAdminUserList($queryFilter !== "" ? $queryFilter : null),
            "queryFilter" => $queryFilter,
        ]);
    }

    public function showAccountDetail(int $id)
    {
        $user = User::query()
            ->with([
                "userProfile",
                "educationHistories" => fn($query) => $query->orderByDesc("date_of_entry")->orderByDesc("id"),
                "workExperiences" => fn($query) => $query->orderByDesc("date_of_join")->orderByDesc("id"),
            ])
            ->findOrFail($id);

        return view("admin.user.detail", [
            "user" => $user,
        ]);
    }

    public function printResume(int $id, GoogleTranslatorService $translator)
    {
        User::query()->findOrFail($id);

        $profile = UserProfile::where('user_id', $id)->first();

        $educationHistories = UserEducationHistory::where('user_id', $id)
            ->orderBy('date_of_entry')
            ->orderBy('id')
            ->get();

        $workExperiences = WorkExperience::where('user_id', $id)
            ->orderBy('date_of_join')
            ->orderBy('id')
            ->get();

        $profile = $translator->translateModel($profile, [
            'gender',
            'religion',
            'marital_status',
            'nationality',
            'current_visa_type',
            'is_wearing_hijab',
            'prayer_requirement',
            'pork_tolerance',
            'alcohol_tolerance',
            'has_driver_license',
            'technical_experience',
        ]);

        $educationHistories = $translator->translateCollection($educationHistories, [
            'education',
            'status'
        ]);

        $workExperiences = $translator->translateCollection($workExperiences, [
            'field_of_work',
            'position',
            'employment_status',
        ]);

        $fileName = 'resume-user-' . $id . '-' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(
            new ResumeExport($profile, $educationHistories, $workExperiences),
            $fileName
        );
    }
}
