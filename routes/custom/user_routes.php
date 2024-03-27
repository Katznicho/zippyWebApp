<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('getUserPoints', [UserController::class, 'getUserPoints']);

    Route::get('fetchUserPointsUsages', [UserController::class, 'fetchUserPointsUsages']);

    Route::get('loadMoreUserPointsUsages', [UserController::class, 'loadMoreUserPointsUsages']);

    Route::post('updateUserPoints', [UserController::class, 'updateUserPoints']);

    Route::post('createPropertyAlert', [UserController::class, 'createPropertyAlert']);
    Route::post("deActivateAlert", [UserController::class, "deActivateAlert"]);
    Route::post("ActivateAlert", [UserController::class, "ActivateAlert"]);
    Route::get("getUserAlerts", [UserController::class, "getUserAlerts"]);
    Route::get("getUserNotifications", [UserController::class, "getUserNotifications"]);

    Route::post("createUserBooking", [UserController::class, "createUserBooking"]);
    Route::get("getUserBookings", [UserController::class, "getUserBookings"]);
});
