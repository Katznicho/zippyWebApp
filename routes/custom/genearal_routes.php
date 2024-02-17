<?php

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\GeneralController;
use Illuminate\Support\Facades\Route;


Route::get("getAllServices", [GeneralController::class, "getAllServices"]);
Route::get("getAllAmenities", [GeneralController::class, "getAllAmenities"]);
Route::get("getAllCategories", [GeneralController::class, "getAllCategories"]);

Route::middleware('auth:sanctum')->group(function () {
    Route::post("profileUpload", [FileUploadController::class, "profileUpload"]);
});

Route::post("uploadIdImages", [FileUploadController::class, "uploadIdImages"]);

Route::get("getAllPropertyStatuses", [GeneralController::class, "getAllPropertyStatuses"]);
Route::get("getAllCurrencies", [GeneralController::class, "getAllCurrencies"]);
Route::get("getAllPaymentPeriods", [GeneralController::class, "getAllPaymentPeriods"]);

Route::get("getAllPropertiesByPagination", [GeneralController::class, "getAllPropertiesByPagination"]);
