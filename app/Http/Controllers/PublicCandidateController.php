<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User\UserProfile;
use Illuminate\View\View;

class PublicCandidateController extends Controller
{
    public function show(int $id): View
    {
        $candidate = User::query()
            ->with([
                'userProfile',
                'educationHistories' => fn ($query) => $query->orderByDesc('date_of_entry'),
                'workExperiences' => fn ($query) => $query->orderByDesc('date_of_join'),
            ])
            ->whereHas('userProfile')
            ->findOrFail($id);

        return view('share.candidate-profile', [
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

        if ($rawPath === 'default.jpg') {
            return asset('apple-touch-icon.png');
        }

        if (filter_var($rawPath, FILTER_VALIDATE_URL)) {
            return $rawPath;
        }

        $normalizedPath = ltrim($rawPath, '/');
        $normalizedPath = preg_replace('#^public/#', '', $normalizedPath);
        $normalizedPath = preg_replace('#^storage/#', '', $normalizedPath);

        $publicCandidates = [
            ltrim($rawPath, '/'),
            $normalizedPath,
            'storage/' . $normalizedPath,
        ];

        foreach ($publicCandidates as $publicPath) {
            if ($publicPath && file_exists(public_path($publicPath))) {
                return asset($publicPath);
            }
        }

        if ($normalizedPath && file_exists(storage_path('app/public/' . $normalizedPath))) {
            return asset('storage/' . $normalizedPath);
        }

        return null;
    }
}
