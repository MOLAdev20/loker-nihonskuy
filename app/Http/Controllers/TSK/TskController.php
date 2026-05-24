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
        $rawPath = $profile?->profile_picture ? trim($profile->profile_picture) : null;
        if (!$rawPath) {
            return null;
        }

        if ($rawPath === "default.jpg") {
            return asset("apple-touch-icon.png");
        }

        if (filter_var($rawPath, FILTER_VALIDATE_URL)) {
            return $rawPath;
        }

        $normalizedPath = ltrim($rawPath, "/");
        $normalizedPath = preg_replace("#^public/#", "", $normalizedPath);
        $normalizedPath = preg_replace("#^storage/#", "", $normalizedPath);

        $publicCandidates = [
            ltrim($rawPath, "/"),
            $normalizedPath,
            "storage/" . $normalizedPath,
        ];

        foreach ($publicCandidates as $publicPath) {
            if ($publicPath && file_exists(public_path($publicPath))) {
                return asset($publicPath);
            }
        }

        if ($normalizedPath && file_exists(storage_path("app/public/" . $normalizedPath))) {
            return asset("storage/" . $normalizedPath);
        }

        return null;
    }
}
