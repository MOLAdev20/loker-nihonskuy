<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Landing;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\Admin\AuthController;

Route::get("/", [Landing::class, "index"]);
Route::get("/vacancies", [Landing::class, "explore"]);
Route::get("/vacancy/{id}", [Landing::class, "detail"]);

Route::prefix("admin")->group(function () {
    Route::middleware("admin.guest")->group(function () {
        Route::get("/", [AuthController::class, "showLoginForm"]);
        Route::get("/login", [AuthController::class, "showLoginForm"])->name("admin.login");
        Route::post("/login", [AuthController::class, "login"])->name("admin.login.post");
    });

    Route::middleware("admin.auth")->group(function () {
        Route::get("/logout", [AuthController::class, "logout"])->name("admin.logout");

        Route::prefix("vacancy")->group(function () {
            Route::get("/", [VacancyController::class, "index"])->name("admin.vacancies");
            Route::get("create", [VacancyController::class, "create"]);
            Route::get("/detail/{id}", [VacancyController::class, "detail"])->name("admin.vacancy.detail");
            Route::get("/edit/{id}", [VacancyController::class, "edit"])->name("admin.vacancy.edit");
            Route::post("insert", [VacancyController::class, "store"]);
            Route::put("/update/{id}", [VacancyController::class, "update"])->name("admin.vacancy.update");
            Route::post("/{id}/thumbnail", [VacancyController::class, "updateThumbnail"]);
            Route::delete("/delete/{id}", [VacancyController::class, "destroy"]);
        });
    });
});
