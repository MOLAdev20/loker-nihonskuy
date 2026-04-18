<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\User\ResumeController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\EducationController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\WorkExperienceController;

Route::get("/", [LandingController::class, "index"])->name("home");
Route::get("/vacancies", [LandingController::class, "explore"])->name("vacancies");
Route::get("/vacancy/{id}", [LandingController::class, "detail"])->name("vacancy.detail");

Route::prefix("admin")->group(function () {
    Route::middleware("admin.guest")->group(function () {
        Route::get("/login", [AuthController::class, "showLoginForm"])->name("admin.login");
        Route::post("/login", [AuthController::class, "login"])->name("admin.login.post");
    });

    Route::middleware("admin.auth")->group(function () {
        Route::post("/logout", [AuthController::class, "logout"])->name("admin.logout");

        Route::prefix("vacancy")->group(function () {
            Route::get("/", [VacancyController::class, "index"])->name("admin.vacancies");
            Route::get("create", [VacancyController::class, "create"]);
            Route::get("/detail/{id}", [VacancyController::class, "detail"])->name("admin.vacancy.detail");
            Route::get("/edit/{id}", [VacancyController::class, "edit"])->name("admin.vacancy.edit");
            Route::post("insert", [VacancyController::class, "store"]);
            Route::put("/update/{id}", [VacancyController::class, "update"])->name("admin.vacancy.update");
            Route::post("/upload-thumbnail/{id}", [VacancyController::class, "updateThumbnail"])->name("admin.vacancy.upload-thumbnail");
            Route::delete("/delete/{id}", [VacancyController::class, "destroy"])->name("admin.vacancy.delete");
            Route::post("/change-status/{id}", [VacancyController::class, "changeStatus"])->name("admin.vacancy.change-status");
            Route::patch("/update-job-code/{id}", [VacancyController::class, "updateJobCode"])->name("admin.vacancy.update-job-code");
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get("/dashboard", [ProfileController::class, "showProfile"])->name("user.dashboard");

    // Profile
    Route::get('/profile', [ProfileController::class, 'showProfileForm'])->name('user.profile.form');
    Route::post('/profile', [ProfileController::class, 'storeProfile'])->name('user.profile.store');

    Route::get('/print-resume', [ResumeController::class, 'download'])->name('user.resume.print');

    // Education
    Route::get('/education-history', [EducationController::class, 'index'])->name('user.education-history');
    Route::post('/education-history', [EducationController::class, 'store'])->name('user.education-history.store');
    Route::put('/education-history/{id}', [EducationController::class, 'update'])->name('user.education-history.update');
    Route::delete('/education-history/{id}', [EducationController::class, 'destroy'])->name('user.education-history.destroy');

    // Working Experiences
    Route::get('/working-experience', [WorkExperienceController::class, 'index'])->name('user.working-experience');
    Route::post('/working-experience', [WorkExperienceController::class, 'store'])->name('user.working-experience.store');
    Route::put('/working-experience/{id}', [WorkExperienceController::class, 'update'])->name('user.working-experience.update');
    Route::delete('/working-experience/{id}', [WorkExperienceController::class, 'destroy'])->name('user.working-experience.destroy');
});

require __DIR__ . '/auth.php';
