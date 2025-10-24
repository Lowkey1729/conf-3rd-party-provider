<?php

use App\Http\Controllers\VerifyBvnWithSelfieSpaghettiVersion1Controller;
use App\Http\Controllers\VerifyNinWithSelfieController;
use Illuminate\Support\Facades\Route;

Route::prefix('identity-verification')->group(function () {
    Route::post("nin", VerifyNinWithSelfieController::class)
    ->name('identity-verification.nin');

    Route::post("bvn", VerifyBvnWithSelfieSpaghettiVersion1Controller::class)
        ->name('identity-verification.bvn');
});
