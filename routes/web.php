<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HuggyAuthController;

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');

Route::get('/auth/redirect', [HuggyAuthController::class, 'redirectToHuggy']);
Route::get('/auth/callback', [HuggyAuthController::class, 'handleHuggyCallback']);
