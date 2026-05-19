<?php

namespace App\Support;

class FormWizardBuilder
{
    public static function buildSteps(
        string $activeStep,
        bool $isProfileCompleted,
        bool $isEducationCompleted,
        bool $isWorkingExperienceCompleted
    ): array {
        return [
            [
                'number' => 1,
                'label' => 'Informasi Pribadi',
                'route' => route('user.profile.form'),
                'isActive' => $activeStep === 'profile',
                'isCompleted' => $isProfileCompleted,
                'isAccessible' => true,
            ],
            [
                'number' => 2,
                'label' => 'Riwayat Pendidikan',
                'route' => route('user.education-history'),
                'isActive' => $activeStep === 'education',
                'isCompleted' => $isEducationCompleted,
                'isAccessible' => $isProfileCompleted,
            ],
            [
                'number' => 3,
                'label' => 'Riwayat Pekerjaan',
                'route' => route('user.working-experience'),
                'isActive' => $activeStep === 'workExperience',
                'isCompleted' => $isWorkingExperienceCompleted,
                'isAccessible' => $isProfileCompleted && $isEducationCompleted,
            ],
            [
                'number' => 4,
                'label' => 'Konfirmasi',
                'route' => route('users.confirm'),
                'isActive' => $activeStep === 'workExperience',
                'isCompleted' => $isWorkingExperienceCompleted,
                'isAccessible' => $isProfileCompleted && $isEducationCompleted,
            ],
        ];
    }
}
