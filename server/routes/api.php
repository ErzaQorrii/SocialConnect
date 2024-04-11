<?php

use App\Http\Controllers\API\FriendshipController;
use App\Http\Controllers\API\LoginRegisterController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PhotoController;

Route::prefix('auth')->group(function () {
    Route::controller(LoginRegisterController::class)->group(function() {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::delete('/logout', 'logout')->middleware('auth:sanctum');
    });
});


// Protected routes
Route::middleware('auth:sanctum')->group( function () {
    Route::controller(ProfileController::class)->prefix('user')->group(function() {
        Route::get('/profile', 'profile');
        Route::put('/profile', 'updateProfile');
        Route::get('/{id}', 'getUserProfile');
    });

    // Post routes
    Route::controller(PostController::class)->prefix('posts')->group(function() {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
        Route::put('/{id}/like', 'toggleLike');
    });

    // Friendship routes
    Route::controller(FriendshipController::class)->prefix('friends')->group(function() {
        Route::get('/pending','pending');
        Route::get('/', 'index');
        Route::post('/','store');
        Route::put('/{friendship}', 'update');
        Route::delete('/{friendship}', 'destroy');
    });


     // Photo routes
    // Route::prefix('photos')->group(function() {
      //  Route::get('/{id}', [PhotoController::class, 'show']);
        //Route::put('/{id}', [PhotoController::class, 'update']);
        //Route::delete('/{id}', [PhotoController::class, 'destroy']);
    //});
    Route::prefix('photos')->group(function () {
        Route::get('/', [PhotoController::class, 'index']);
        Route::get('/{id}', [PhotoController::class, 'show']);
        Route::post('/', [PhotoController::class, 'store']);
        Route::put('/{id}', [PhotoController::class, 'update']);
        Route::delete('/{id}', [PhotoController::class, 'destroy']);
    });


});