<?php

use App\Http\Controllers\VerifyBvnWithSelfieController;
use App\Http\Controllers\VerifyNinWithSelfieController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1/identity-verification')->group(function () {
    Route::post('nin', VerifyNinWithSelfieController::class)
        ->name('identity-verification.nin');

    Route::post('bvn', VerifyBvnWithSelfieController::class)
        ->name('identity-verification.bvn');
});
