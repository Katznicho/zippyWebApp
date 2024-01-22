<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('getUserProducts', [ProductController::class, 'getUserProducts']);
    Route::get('getUserDelivries', [ProductController::class, 'getUserDelivries']);
    Route::post('createProduct', [ProductController::class, 'createProduct']);
    Route::post('confirmDelivery', [ProductController::class, 'confirmDelivery']);
});

Route::get('geCategoriesByPage', [ProductController::class, 'geCategoriesByPage']);
Route::get('getAvailableProductsByCategoryWithPage', [ProductController::class, 'getAvailableProductsByCategoryWithPage']);
Route::get('getAVailableProductsByPage', [ProductController::class, 'getAVailableProductsByPage']);
Route::get('getAllProductCategories', [ProductController::class, 'getAllProductCategories']);
