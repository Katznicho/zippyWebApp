<?php

use App\Http\Controllers\PropertyOwnerController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get("getRegisterPropertyOfOwnerByPage", [PropertyOwnerController::class, "getRegisterPropertyByPage"]);
    Route::post("getOwnerTotals", [PropertyOwnerController::class, "getOwnerTotals"]);
});
