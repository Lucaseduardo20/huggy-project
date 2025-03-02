<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HuggyAuthController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('clients', ClientController::class);
    Route::group(['prefix' =>'dashboard'], function () {
        Route::get('/data', [DashboardController::class, 'getDashboardData']);
    });
});

