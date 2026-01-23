<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Landing;
use App\Http\Controllers\Job;

Route::get("/", [Landing::class, "index"]);

Route::prefix("admin")->group(function () {
    Route::prefix("jobs")->group(function () {
        Route::get("/", [Job::class, "index"]);
        Route::post("insert", [Job::class, "store"]);
    });
});
