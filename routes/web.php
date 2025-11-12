<?php

use App\Http\Controllers\Admin\AdminpostController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

// Admin Controllers
// Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function(){
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // User
    Route::get('/users', [UsersController::class, 'index'])->name('users');
    Route::delete('/users/{id}/deactivate', [UsersController::class, 'deactivate'])->name('users.deactivate');
    Route::patch('/users/{id}/activate', [UsersController::class, 'activate'])->name('users.activate');
    Route::get('/users/search', [UsersController::class, 'search'])->name('users.search');
    // Post
    Route::get('/posts', [AdminpostController::class, 'index'])->name('posts');
    Route::delete('posts/{id}/deactivate', [AdminpostController::class, 'deactivate'])->name('posts.deactivate');
    Route::patch('posts/{id}/activate', [AdminpostController::class, 'activate'])->name('posts.activate');
    Route::get('/posts/search', [AdminpostController::class, 'search'])->name('posts.search');
    // Categories
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');
    Route::post('categories/store', [CategoriesController::class, 'store'])->name('categories.store');
    Route::patch('/categories/{id}/update', [CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}/delete', [CategoriesController::class, 'delete'])->name('categories.delete');
});

// Analytics
Route::get('/users/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

Route::get('/message', function () {
    return view('messages.message');
});

Route::get('/message/board', function () {
    return view('messages.chat');
});

Route::middleware('auth')->group(function () {

    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/rankingpost', 'rankingPost')->name('ranking.post');
    });

    // Post
    Route::controller(PostController::class)->group(function () {
        Route::get('/post/create', 'create')->name('post.create');
        Route::post('/post/store', 'store')->name('post.store');
        Route::get('/post/{id}/show', 'show')->name('post.show');
        Route::get('/post/{id}/edit', 'edit')->name('post.edit');
        Route::patch('/post/{id}/update', 'update')->name('post.update');
        Route::delete('/post/{id}/destroy', 'destroy')->name('post.destroy');
    });

    // PROFILE
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile/{id}/show', 'show')->name('profile.show');
        Route::get('profile/edit', 'edit')->name('profile.edit');
        Route::patch('/profile/{id}/update', 'update')->name('profile.update');
        Route::get('/profile/{id}/followers', 'followers')->name('profile.followers');
        Route::get('/profile/{id}/following', 'following')->name('profile.following');
    });

    // Map
    Route::controller(MapController::class)->group(function () {
        Route::get('/profile/{id}/trip-map', 'show')->name('map.show');
        Route::get('/profile/{id}/pref/{pref_id}', 'showPost')->name('map.showPost');
        Route::get('/prefectures/{id}/posts', 'getPost')->name('map.getPost');
    });

    // follow
    Route::controller(FollowController::class)->group(function () {
        Route::post('/follow/{user_id}/store', 'store')->name('follow.store');
        Route::delete('/follow/{user_id}/destroy', 'destroy')->name('follow.destroy');
        Route::get('/follow/{user_id}/search', 'search')->name('follow.search');
    });

    // Like
    Route::controller(LikeController::class)->group(function () {
        Route::post('/like/{post_id}/store', 'store')->name('like.store');
        Route::delete('/like/{post_id}/destroy', 'destroy')->name('like.destroy');
    });

    // Comment
    Route::controller(CommentController::class)->group(function () {
        Route::post('/comment/{post_id}/store', 'store')->name('comment.store');
        Route::delete('/comment/{id}/destroy', 'destroy')->name('comment.destroy');
    });

    // favorite
    Route::controller(FavoriteController::class)->group(function () {
        Route::get('/favorites', 'show')->name('favorite');
        Route::post('/favorite/{post_id}/store', 'store')->name('favorite.store');
        Route::delete('/favorite/{post_id}/destroy', 'destroy')->name('favorite.destroy');
    });

    Route::get('/notifications', [NotificationController::class, 'index']);

});

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/');
    })->name('verification.verify');

    Route::post('/email/verification-notification', function (HttpRequest $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification email has been sent.');
    })->name('verification.send');
});

Route::get('auth/{provider}', [SocialAuthController::class, 'redirect'])->name('social.redirect');
Route::get('auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');
// comment
Route::post('/comment/{post_id}/store', [CommentController::class, 'store'])->name('comment.store');
Route::delete('/comment/{id}/destroy', [CommentController::class, 'destroy'])->name('comment.destroy');
