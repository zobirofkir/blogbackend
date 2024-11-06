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


/**
 * Add Login Route
 */
Route::post("login", [AuthController::class, "login"]);

/**
 * Add Blog Route
 */
Route::apiResource("blogs", BlogController::class)->only(["index", "show"]);

/**
 * Add Comment Routes
 */
Route::apiResource("blogs.comments", CommentController::class)->only(["store", "index"]);

/**
 * Add Contact Routes
 */
Route::apiResource('contacts', ContactController::class);

/**
 * Add Product Routes
 */
Route::apiResource("products", ProductController::class)->only(["index", "show"]);

/**
 * Add Project Routes
 */
Route::apiResource("projects", ProjectController::class)->only(["index", "show"]);

Route::apiResource("messages", MessageController::class);

/**
 * Add User Routes
 */
Route::middleware("auth:api")->group(function() {
    Route::apiResource("users", UserController::class);

    /**
     * Create Blog Resource
     */
    Route::apiResource("blogs", BlogController::class)->only(["store", "update", "destroy"]);

    /**
     * Add route for authenticated user's blogs
     */
    Route::get("auth/blogs", [BlogController::class, "auth"]);

    /**
     * Create Product Resource
     */
    Route::apiResource("products", ProductController::class)->only(["store", "update", "destroy"]);

    /**
     * Create Project Resource
     */
    Route::apiResource("projects", ProjectController::class)->only(["store", "update", "destroy"]);
    
    /**
     * Get Authenticated Project
     */
    Route::get("/auth/projects", [ProjectController::class, "auth"]);

    /**
     * Get Authenticated Product
     */
    Route::get("/auth/products", [ProductController::class, "auth"]);
    
    /**
     * Get Current Authenticated User
     */
    Route::get("auth/current", [AuthController::class, "current"]);

    /**
     * Update Current User Password
     */
    Route::put("auth/update", [AuthController::class, "updateCurrentUserPassword"]);
    
    /**
     * Logout Authenticated User
     */
    Route::post("auth/logout", [AuthController::class, "logout"]);  // Changed from GET to POST
});