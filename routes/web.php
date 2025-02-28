<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HuggyAuthController;

Route::group(['prefix' =>'auth'], function () {
    Route::get('/redirect', [HuggyAuthController::class, 'redirectToHuggy']);
    Route::get('/callback', [HuggyAuthController::class, 'handleHuggyCallback']);
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
