<?php

use App\Http\Controllers\DonorController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('getDonorDetails', [DonorController::class, 'getDonorDetails']);
    Route::post('getDonorTotals', [DonorController::class, 'getDonorTotals']);
});

Route::get('getDonorsByPage', [DonorController::class, 'getDonorsByPage']);
