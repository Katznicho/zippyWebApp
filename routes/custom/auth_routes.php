<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('registerCommunity', [AuthController::class, 'registerCommunity']);
    Route::post('verifyEmail', [AuthController::class, 'verifyEmail']);
    Route::post('resendOTP', [AuthController::class, 'resendOTP']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('requestPasswordReset', [AuthController::class, 'requestPasswordReset']);
    Route::post('resetPassword', [AuthController::class, 'resetPassword']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('setUpUserWalletAccount', [AuthController::class, 'setUpUserWalletAccount']);
        Route::post('updateShowWalletBalance', [AuthController::class, 'updateShowWalletBalance']);
        Route::post('changeCustomerPin', [AuthController::class, 'changeCustomerPin']);
        Route::post('saveOrUpdateUserLocation', [AuthController::class, 'saveOrUpdateUserLocation']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('changePassword', [AuthController::class, 'changePassword']);
        Route::post('updateAvatar', [AuthController::class, 'updateAvatar']);
        Route::post('saveDeviceInfo', [AuthController::class, 'saveDeviceInfo']);
        Route::post('hasWalletAccount', [AuthController::class, 'hasWalletAccount']);
        Route::post('updateUserAvatarUrl', [AuthController::class, 'updateUserAvatarUrl']);

        Route::post('communityUploadVerificationDocument', [AuthController::class, 'communityUploadVerificationDocument']);
        Route::post('donorUpdateVerificationDocument', [AuthController::class, 'donorUpdateVerificationDocument']);
        Route::post('updateUserLocation', [AuthController::class, 'updateUserLocation']);
    });
});
