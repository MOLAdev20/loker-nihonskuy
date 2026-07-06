<?php

namespace App\Support;

class AdminUserFormWizardBuilder
{
    public static function buildSteps(
        string $activeStep,
        int $userId,
        bool $isProfileCompleted,
        bool $isEducationCompleted,
        bool $isWorkingExperienceCompleted,
        bool $isInterviewCompleted = true
    ): array {
        return [
            [
                "number" => 1,
                "label" => "Pertanyaan Interview",
                "route" => route("admin.users.interview-answer.index", $userId),
                "isActive" => $activeStep === "interview",
                "isCompleted" => $isInterviewCompleted,
                "isAccessible" => true,
            ],
            [
                "number" => 2,
                "label" => "Informasi Pribadi",
                "route" => route("admin.users.profile.form", $userId),
                "isActive" => $activeStep === "profile",
                "isCompleted" => $isProfileCompleted,
                "isAccessible" => true,
            ],
            [
                "number" => 3,
                "label" => "Riwayat Pendidikan",
                "route" => route("admin.users.education.index", $userId),
                "isActive" => $activeStep === "education",
                "isCompleted" => $isEducationCompleted,
                "isAccessible" => true,
            ],
            [
                "number" => 4,
                "label" => "Riwayat Pekerjaan",
                "route" => route("admin.users.working-experience.index", $userId),
                "isActive" => $activeStep === "workExperience",
                "isCompleted" => $isWorkingExperienceCompleted,
                "isAccessible" => true,
            ],
        ];
    }
}
