<?php

namespace App\Support;

class AdminUserFormWizardBuilder
{
    public static function buildSteps(
        string $activeStep,
        int $userId,
        bool $isProfileCompleted,
        bool $isEducationCompleted,
        bool $isWorkingExperienceCompleted
    ): array {
        return [
            [
                "number" => 1,
                "label" => "Informasi Pribadi",
                "route" => route("admin.users.profile.form", $userId),
                "isActive" => $activeStep === "profile",
                "isCompleted" => $isProfileCompleted,
                "isAccessible" => true,
            ],
            [
                "number" => 2,
                "label" => "Riwayat Pendidikan",
                "route" => route("admin.users.education.index", $userId),
                "isActive" => $activeStep === "education",
                "isCompleted" => $isEducationCompleted,
                "isAccessible" => $isProfileCompleted,
            ],
            [
                "number" => 3,
                "label" => "Riwayat Pekerjaan",
                "route" => route("admin.users.working-experience.index", $userId),
                "isActive" => $activeStep === "workExperience",
                "isCompleted" => $isWorkingExperienceCompleted,
                "isAccessible" => $isProfileCompleted && $isEducationCompleted,
            ],
        ];
    }
}
