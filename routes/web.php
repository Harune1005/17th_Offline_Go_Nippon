<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
// Admin
Route::get('admin/users', function () {
    return view('admin.users.index');
});
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('admin/posts', function () {
    return view('admin.posts.index');
});
Route::get('admin/categories', function () {
    return view('admin.categories.index');
});

// Analytics
Route::get('/users/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

Route::get('/message', function () {
    return view('messages.message');
});

Route::get('/message/board', function () {
    return view('messages.chat');
});

Route::get('/favorites', [FavoriteController::class, 'show'])->name('favorite');
Route::post('/favorite/{post_id}/store', [FavoriteController::class, 'store'])->name('favorite.store');
Route::delete('/favorite/{post_id}/destroy', [FavoriteController::class, 'destroy'])->name('favorite.destroy');

Route::get('/followers', function () {
    return view('followers_followings');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Profile
Route::get('/profile', function () {
    return view('users.profile.show');
});
Route::get('/profile/{id}/trip-map', [MapController::class, 'show'])->name('map.show');
Route::get('/profile/{id}/pref/{pref_id}', [MapController::class, 'showPost'])->name('map.showPost');
Route::get('/profile/{id}/pref/{pref_id}', [MapController::class, 'showPost'])->name('map.showPost');

Route::get('/show2', function () {
    return view('users.profile.show3');
});

Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
Route::get('/post/{id}/show', [PostController::class, 'show'])->name('post.show');
Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
Route::patch('/post/{id}/update', [PostController::class, 'update'])->name('post.update');
Route::delete('/post/{id}/destroy', [PostController::class, 'destroy'])->name('post.destroy');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    // PROFILE
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile/{id}/show', 'show')->name('profile.show');
        Route::get('profile/edit', 'edit')->name('profile.edit');
        Route::patch('/profile/{id}/update', 'update')->name('profile.update');
        Route::get('/profile/{id}/followers', 'followers')->name('profile.followers');
        Route::get('/profile/{id}/following', 'following')->name('profile.following');
    });

    // follow
    Route::controller(FollowController::class)->group(function () {
        Route::post('/follow/{user_id}/store', 'store')->name('follow.store');
        Route::delete('/follow/{user_id}/destroy', 'destroy')->name('follow.destroy');
        Route::get('/follow/{user_id}/search', 'search')->name('follow.search');
    });

});
