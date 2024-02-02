<?php

use App\Http\Controllers\AgentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::post("registerPropertyOwner", [AgentController::class, "registerPropertyOwner"]);
    Route::post("verifyPropertyOwnerPhoneNumber", [AgentController::class, "verifyPropertyOwnerPhoneNumber"]);
    Route::get("getRegisterPropertyOwnersByPage", [AgentController::class, "getRegisterPropertyOwnersByPage"]);
    Route::get("getRegisterPropertyByPage", [AgentController::class, "getRegisterPropertyByPage"]);
    Route::post("registerPropertyByAgent", [AgentController::class, "registerPropertyByAgent"]);
    Route::post("getAgentTotals", [AgentController::class, "getAgentTotals"]);
    //Route::post("")
    Route::get("getAllRegisteredPropertyOwners", [AgentController::class, "getAllRegisteredPropertyOwners"]);
});
