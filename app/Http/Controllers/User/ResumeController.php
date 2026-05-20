<?php

namespace App\Http\Controllers\User;

use App\Exports\ResumeExport;
use App\Http\Controllers\Controller;
use App\Models\User\UserEducationHistory;
use App\Models\User\UserProfile;
use App\Models\User\WorkExperience;
use App\Services\GeminiTranslatorService;
use Maatwebsite\Excel\Facades\Excel;

class ResumeController extends Controller
{
    public function download(GeminiTranslatorService $translator)
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

        if ($profile) {
            $profile = $translator->translateObjectFields($profile, [
                'nationality',
                'current_address',
                'is_wearing_hijab',
                'pork_tolerance',
                'place_of_origin',
                'religion',
                'prayer_requirement',
                'alcohol_tolerance',
                'current_visa_type',
                'has_driver_license',
                'technical_experience',
            ]);
        }

        $educationHistories = $translator->translateCollection($educationHistories, [
            'education',
            'institution',
            'location',
        ]);

        $workExperiences = $translator->translateCollection($workExperiences, [
            'company_name',
            'field_of_work',
            'location',
        ]);

        $fileName = 'resume-' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(
            new ResumeExport($profile, $educationHistories, $workExperiences),
            $fileName
        );
    }
}
