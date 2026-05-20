<?php

namespace App\Http\Controllers\TSK;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\UserProfile;
use Illuminate\View\View;

class TskController extends Controller
{
    public function index(): View
    {
        $candidates = User::query()
            ->with('userProfile')
            ->orderByDesc('id')
            ->paginate(35)
            ->withQueryString();

        return view('tsk.candidates-index', [
            'candidates' => $candidates,
        ]);
    }

    public function show(int $id): View
    {
        $candidate = User::query()
            ->with([
                'userProfile',
                'educationHistories' => fn ($query) => $query->orderByDesc('date_of_entry'),
                'workExperiences' => fn ($query) => $query->orderByDesc('date_of_join'),
            ])
            ->findOrFail($id);

        return view('tsk.candidate-detail', [
            'candidate' => $candidate,
            'profile' => $candidate->userProfile,
            'educationHistories' => $candidate->educationHistories,
            'workExperiences' => $candidate->workExperiences,
            'profilePictureUrl' => $this->resolveProfilePictureUrl($candidate->userProfile),
        ]);
    }

    private function resolveProfilePictureUrl(?UserProfile $profile): ?string
    {
        $profilePicturePath = $profile?->profile_picture ? ltrim($profile->profile_picture, '/') : null;
        if (!$profilePicturePath) {
            return null;
        }

        if (filter_var($profilePicturePath, FILTER_VALIDATE_URL)) {
            return $profilePicturePath;
        }

        if (file_exists(public_path($profilePicturePath))) {
            return asset($profilePicturePath);
        }

        if (file_exists(storage_path('app/public/' . $profilePicturePath))) {
            return asset('storage/' . $profilePicturePath);
        }

        return null;
    }
}
