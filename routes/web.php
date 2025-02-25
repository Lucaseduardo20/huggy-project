<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HuggyAuthController;

Route::get('/', function () {
    return view('app');
});

Route::get('/auth/redirect', [HuggyAuthController::class, 'redirectToHuggy']);
Route::get('/auth/callback', [HuggyAuthController::class, 'handleHuggyCallback']);
