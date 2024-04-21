<?php

use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\FollowerController;
use App\Http\Controllers\API\FriendshipController;
use App\Http\Controllers\API\GroupController;
use App\Http\Controllers\API\LoginRegisterController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\VideoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\StoryController;



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

    Route::controller(GroupController::class)->prefix('groups')->group(function() {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{group}', 'show');
        Route::put('/{group}', 'update');
        Route::delete('/{group}', 'destroy');
    });
    // Story routes
    Route::controller(StoryController::class)->prefix('stories')->group(function() {
        Route::post('/upload', 'upload'); // Accessible at /stories/upload
        Route::get('/active', 'viewActiveStories'); // Accessible at /stories/active
        Route::delete('/{id}', 'delete'); // Accessible at /stories/{id}
    });

    Route::prefix('comments')->group(function() {
        Route::get('/', 'CommentController@index');
        Route::post('/', 'CommentController@store');
        Route::get('/{comment}', 'CommentController@show');
        Route::put('/{comment}', 'CommentController@update');
        Route::delete('/{comment}', 'CommentController@destroy');
    });


});



// Followers routes
Route::prefix('followers')->group(function() {
    Route::get('/', [FollowerController::class, 'index'])->name('followers.index');
    Route::post('/follow', [FollowerController::class, 'follow'])->name('followers.follow');
    Route::delete('/unfollow', [FollowerController::class, 'unfollow'])->name('followers.unfollow');
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

Route::middleware('auth:sanctum')->controller(CommentController::class)->prefix('comments')->group(function () {
    Route::post('/', 'store')->name('comments.store');
    Route::put('/{comment}', 'update')->name('comments.update');
    Route::get('/{comment}', 'show')->name('comments.show');
    Route::delete('/{comment}', 'destroy')->name('comments.destroy');
});
// Video routes
Route::controller(VideoController::class)->prefix('videos')->group(function() {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{video}', 'show');
    Route::put('/{video}', 'update');
    Route::delete('/{video}', 'destroy');
});
// Message routes
Route::controller(MessageController::class)->prefix('messages')->group(function() {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{message}', 'show');
    Route::put('/{message}', 'update');
    Route::delete('/{message}', 'destroy');
});
