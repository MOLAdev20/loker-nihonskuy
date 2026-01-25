<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Landing;
use App\Http\Controllers\Job;

Route::get("/", [Landing::class, "index"]);

Route::prefix("admin")->group(function () {
    Route::prefix("jobs")->group(function () {
        Route::get("/", [Job::class, "index"]);
        Route::get("create", [Job::class, "create"]);
        Route::get("/detail/{id}", [Job::class, "detail"]);
        Route::get("/edit/{id}", [Job::class, "edit"]);
        Route::post("insert", [Job::class, "store"]);
        Route::put("/update/{id}", [Job::class, "update"]);
        Route::delete("/delete/{id}", [Job::class, "destroy"]);
    });
});
