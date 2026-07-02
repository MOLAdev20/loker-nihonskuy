<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicCandidateController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserEducationController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserWorkingExpController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UrgentVacancyController;
use App\Http\Controllers\MatchingJobLandingController;
use App\Http\Controllers\User\ResumeController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\CertificateController;
use App\Http\Controllers\User\EducationController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\DocumentController;
use App\Http\Controllers\User\InterviewAnswerController;
use App\Http\Controllers\User\WorkExperienceController;
use App\Http\Controllers\TSK\TskController;

Route::get("/", [LandingController::class, "index"])->name("home");
Route::get("/vacancies", [LandingController::class, "explore"])->name("vacancies");
Route::get("/jp-company", [CompanyController::class, "landingIndex"])->name("jp.company");
Route::get("/jp-company/{company}", [CompanyController::class, "landingShow"])->name("jp.company.detail");
Route::get('/company-logo/{company}', [CompanyController::class, 'logo'])->whereNumber('company')->name('company.logo');
Route::get("/vacancy/{id}", [LandingController::class, "detail"])->name("vacancy.detail");
Route::get("/matching-job", [MatchingJobLandingController::class, "index"])->name("matching.job");
Route::get("/matching-job/education-program", [MatchingJobLandingController::class, "onlyEducation"])->name("matching.job.education");
Route::get("/matching-job/basic-program", [MatchingJobLandingController::class, "onlyMatchingJob"])->name("matching.job.basic");
Route::get("/matching-job/full-program", [MatchingJobLandingController::class, "fullBundling"])->name("matching.job.full");
Route::get('/share/{id}', [PublicCandidateController::class, 'show'])->whereNumber('id')->name('public.candidates.show');

Route::prefix("admin")->group(function () {
    Route::middleware("admin.guest")->group(function () {
        Route::get("/login", [AuthController::class, "showLoginForm"])->name("admin.login");
        Route::post("/login", [AuthController::class, "login"])->name("admin.login.post");
    });

    Route::middleware("admin.auth")->group(function () {
        Route::post("/logout", [AuthController::class, "logout"])->name("admin.logout");

        Route::prefix("vacancy")->group(function () {
            Route::get("/", [VacancyController::class, "index"])->name("admin.vacancies");

            Route::prefix('urgent')->group(function () {
                Route::get("/", [UrgentVacancyController::class, "index"])->name("admin.vacancy.urgent.index");
                Route::post("/", [UrgentVacancyController::class, "store"])->name("admin.vacancy.urgent.store");
                Route::patch("/order", [UrgentVacancyController::class, "updateOrder"])->name("admin.vacancy.urgent.order");
                Route::delete("/{urgentVacancy}", [UrgentVacancyController::class, "destroy"])->name("admin.vacancy.urgent.destroy");
            });

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

        Route::prefix("users")->group(function () {
            Route::get("/", [UserController::class, "index"])->name("admin.users");
            Route::post("/", [UserController::class, "store"])->name("admin.users.store");

            Route::prefix("{id}")->whereNumber("id")->group(function () {
                Route::prefix("education")->group(function () {
                    Route::get("/", [UserEducationController::class, "index"])->name("admin.users.education.index");
                    Route::post("/", [UserEducationController::class, "store"])->name("admin.users.education.store");
                    Route::put("/{educationHistoryId}", [UserEducationController::class, "update"])->name("admin.users.education.update");
                    Route::delete("/{educationHistoryId}", [UserEducationController::class, "destroy"])->name("admin.users.education.destroy");
                });

                Route::prefix("profile")->group(function () {
                    Route::get("/", [UserProfileController::class, "showForm"])->name("admin.users.profile.form");
                    Route::post("/", [UserProfileController::class, "store"])->name("admin.users.profile.store");
                    Route::post("/upload-photo", [UserProfileController::class, "uploadProfilePicture"])->name("admin.users.profile.upload-photo");
                });

                Route::get("/print-resume", [UserController::class, "printResume"])->name("admin.users.resume.print");

                Route::prefix("working-experience")->group(function () {
                    Route::get("/", [UserWorkingExpController::class, "index"])->name("admin.users.working-experience.index");
                    Route::post("/", [UserWorkingExpController::class, "store"])->name("admin.users.working-experience.store");
                    Route::put("/{workExperienceId}", [UserWorkingExpController::class, "update"])->name("admin.users.working-experience.update");
                    Route::delete("/{workExperienceId}", [UserWorkingExpController::class, "destroy"])->name("admin.users.working-experience.destroy");
                });

                Route::get("/", [UserController::class, "showAccountDetail"])->name("admin.users.detail");
            });
        });

        Route::prefix('jp-company')->name('admin.company.')->group(function () {
            Route::get('/', [CompanyController::class, 'index'])->name('index');
            Route::get('/create', [CompanyController::class, 'create'])->name('create');
            Route::post('/', [CompanyController::class, 'store'])->name('store');
            Route::get('/{company}', [CompanyController::class, 'show'])->whereNumber('company')->name('show');
            Route::get('/{company}/edit', [CompanyController::class, 'edit'])->whereNumber('company')->name('edit');
            Route::put('/{company}', [CompanyController::class, 'update'])->whereNumber('company')->name('update');
            Route::delete('/{company}', [CompanyController::class, 'destroy'])->whereNumber('company')->name('destroy');
        });
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get("/dashboard", [ProfileController::class, "showProfile"])->name("user.dashboard");

    // Profile
    Route::get('/profile', [ProfileController::class, 'showProfileForm'])->name('user.profile.form');
    Route::post('/profile', [ProfileController::class, 'storeProfile'])->name('user.profile.store');
    Route::post('/profile/upload-photo', [ProfileController::class, 'uploadProfilePicture'])->name('user.profile.upload-photo');
    Route::post('/profile/jikoshoukai', [ProfileController::class, 'updateJikoshoukai'])->name('user.profile.jikoshoukai.store');

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

    // Interview Answers
    Route::get('/interview-answer', [InterviewAnswerController::class, 'index'])->name('user.interview-answer');
    Route::post('/interview-answer', [InterviewAnswerController::class, 'store'])->name('user.interview-answer.store');

    // Document
    Route::get('/document', [DocumentController::class, 'index'])->name('user.document');
    Route::post('/document', [DocumentController::class, 'store'])->name('user.document.store');
    Route::get('/document/{document}', [DocumentController::class, 'show'])->whereNumber('document')->name('user.document.show');
    Route::delete('/document/{document}', [DocumentController::class, 'destroy'])->whereNumber('document')->name('user.document.destroy');

    // Certificate
    Route::get('/certificate', [CertificateController::class, 'index'])->name('user.certificate');
    Route::post('/certificate', [CertificateController::class, 'store'])->name('user.certificate.store');
    Route::get('/certificate/{certificate}', [CertificateController::class, 'show'])->whereNumber('certificate')->name('user.certificate.show');
    Route::delete('/certificate/{certificate}', [CertificateController::class, 'destroy'])->whereNumber('certificate')->name('user.certificate.destroy');

    // Contact Team Page
    Route::get("/contact-team", [ProfileController::class, "showConfirmPage"])->name("users.confirm");
});

Route::prefix("tsk")->group(function () {
    Route::get("/", [TskController::class, "index"])->name("tsk.candidates.index");
    Route::get("/candidate/{id}", [TskController::class, "show"])->whereNumber("id")->name("tsk.candidates.show");
    Route::get("/candidate/{id}/download-cv", [UserController::class, "printResume"])->whereNumber("id")->name("tsk.candidates.resume.download");
});

require __DIR__ . '/auth.php';
