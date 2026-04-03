<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Landing;
use App\Http\Controllers\Job;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\ProfileController;

Route::get("/", [Landing::class, "index"]);
Route::get("/jobs", [Landing::class, "explore"]);
Route::get("/jobs/{id}", [Landing::class, "detail"]);

Route::prefix("admin")->group(function () {
    Route::middleware("admin.guest")->group(function () {
        Route::get("/", [AuthController::class, "showLoginForm"]);
        Route::get("/login", [AuthController::class, "showLoginForm"])->name("admin.login");
        Route::post("/login", [AuthController::class, "login"])->name("admin.login.post");
    });

    Route::middleware("admin.auth")->group(function () {
        Route::post("/logout", [AuthController::class, "logout"])->name("admin.logout");

        Route::prefix("jobs")->group(function () {
            Route::get("/", [Job::class, "index"]);
            Route::get("create", [Job::class, "create"]);
            Route::get("/detail/{id}", [Job::class, "detail"]);
            Route::get("/edit/{id}", [Job::class, "edit"]);
            Route::post("insert", [Job::class, "store"]);
            Route::put("/update/{id}", [Job::class, "update"]);
            Route::post("/{id}/thumbnail", [Job::class, "updateThumbnail"]);
            Route::delete("/delete/{id}", [Job::class, "destroy"]);
            Route::get("/change-status/{id}", [Job::class, "changeStatus"]);
        });
    });
});

Route::get("sign-in", [AccountController::class, "signIn"]);
Route::post("sign-in", [AccountController::class, "validateAccount"]);
Route::get("sign-up", [AccountController::class, "signUp"]);
Route::post("sign-up", [AccountController::class, "createAccount"]);

Route::prefix("my")->group(function () {
    Route::get("/", [ProfileController::class, "showProfile"]);
    Route::get("/fill-profile", [ProfileController::class, "showProfileForm"])->name("my.fill-profile");
    Route::post("store-profile", [ProfileController::class, "storeProfile"]);
});
