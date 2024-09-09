<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post("login", [AuthController::class, "login"]);

Route::apiResource("blogs", BlogController::class)->only(["index", "show"]);
Route::apiResource("blogs.comments", CommentController::class)->only(["store", "index"]);

Route::apiResource('contacts', ContactController::class);
Route::apiResource("products", ProductController::class)->only(["index", "show"]);

Route::apiResource("projects", ProjectController::class)->only(["index", "show"]);

Route::apiResource("messages", MessageController::class);

// Authenticated routes
Route::middleware("auth:api")->group(function() {
    Route::apiResource("users", UserController::class);
    
    // Only add the store, update, and destroy methods for blogs here
    Route::apiResource("blogs", BlogController::class)->only(["store", "update", "destroy"]);

    // Add route for authenticated user's blogs
    Route::get("auth/blogs", [BlogController::class, "auth"]);

    /**
     * Create Product Resource
     */
    Route::apiResource("products", ProductController::class)->only(["store", "update", "destroy"]);

    Route::apiResource("projects", ProjectController::class)->only(["store", "update", "destroy"]);
    Route::get("/auth/projects", [ProjectController::class, "auth"]);

    /**
     * Get Authenticated Product
     */
    Route::get("/auth/products", [ProductController::class, "auth"]);
    
    // Authenticated user routes
    Route::get("auth/current", [AuthController::class, "current"]);
    Route::put("auth/update", [AuthController::class, "updateCurrentUserPassword"]);
    Route::post("auth/logout", [AuthController::class, "logout"]);  // Changed from GET to POST
});
