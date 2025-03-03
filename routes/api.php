<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TwilioController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('clients', ClientController::class);
    Route::group(['prefix' =>'dashboard'], function () {
        Route::get('/data', [DashboardController::class, 'getDashboardData']);
    });
    Route::group(['prefix' => 'twilio'], function () {
        Route::post('/call', [TwilioController::class, 'makeCall']);
        Route::get('/voice-response', [TwilioController::class, 'voiceResponse'])->name('twilio.voice-response');
    });
});

