<?php

use App\Http\Controllers\GeneralController;
use Illuminate\Support\Facades\Route;


Route::get("getAllServices", [GeneralController::class, "getAllServices"]);
Route::get("getAllAmenities", [GeneralController::class, "getAllAmenities"]);
