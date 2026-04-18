<?php

namespace App\Http\Controllers\User;

use App\Exports\ResumeExport;
use App\Http\Controllers\Controller;
use App\Models\User\UserEducationHistory;
use App\Models\User\UserProfile;
use App\Models\User\WorkExperience;
use Maatwebsite\Excel\Facades\Excel;

class ResumeController extends Controller
{
    public function download()
    {
        $userId = auth()->id();

        $profile = UserProfile::where('user_id', $userId)->first();
        $educationHistories = UserEducationHistory::where('user_id', $userId)
            ->orderBy('date_of_entry')
            ->orderBy('id')
            ->get();
        $workExperiences = WorkExperience::where('user_id', $userId)
            ->orderBy('date_of_join')
            ->orderBy('id')
            ->get();

        $fileName = 'resume-' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(
            new ResumeExport($profile, $educationHistories, $workExperiences),
            $fileName
        );
    }
}
