<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post("login", [AuthController::class, "login"]);

Route::apiResource("blogs", BlogController::class)->only(["index", "show"]);
Route::apiResource("blogs.comments", CommentController::class)->only(["store", "index"]);

// Authenticated routes
Route::middleware("auth:api")->group(function() {
    Route::apiResource("users", UserController::class);
    
    // Only add the store, update, and destroy methods for blogs here
    Route::apiResource("blogs", BlogController::class)->only(["store", "update", "destroy"]);

    // Authenticated user routes
    Route::get("auth/current", [AuthController::class, "current"]);
    Route::put("auth/update", [AuthController::class, "updateCurrentUserPassword"]);
    Route::post("auth/logout", [AuthController::class, "logout"]);  // Changed from GET to POST
});
