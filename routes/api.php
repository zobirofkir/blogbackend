<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post("login", [AuthController::class, "login"]);

Route::middleware("auth:api")->group(function(){
    Route::apiResource("users", UserController::class);
    Route::get("auth/current", [AuthController::class, "current"]);
    Route::put("auth/update", [AuthController::class, "updateCurrentUserPassword"]);
    Route::get("auth/logout", [AuthController::class, "logout"]);
});