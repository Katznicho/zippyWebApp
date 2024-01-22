<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('getUserPayments', [PaymentController::class, 'getUserPayments']);

    Route::post('processOrder', [PaymentController::class, 'processOrder']);

    Route::post('testSendingMessages', [PaymentController::class, 'testSendingMessages']);

    // Route::post('checkTransactionStatus', [PaymentController::class, 'checkTransactionStatus']);
});

Route::post('registerIPN', [PaymentController::class, 'registerIPN']);
Route::get('listIPNS', [PaymentController::class, 'listIPNS']);
Route::get('completePayment', [PaymentController::class, 'completePayment']);
