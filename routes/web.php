<?php

use App\Http\Controllers\Admin\AdminpostController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

#Admin Controllers
    // Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function(){
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
        //User
        Route::get('/users', [UsersController::class, 'index'])->name('users');
        Route::delete('/users/{id}/deactivate', [UsersController::class, 'deactivate'])->name('users.deactivate');
        Route::patch('/users/{id}/activate', [UsersController::class, 'activate'])->name('users.activate');
        Route::get('/users/search', [UsersController::class, 'search'])->name('users.search');
        //Post
        Route::get('/posts', [AdminpostController::class, 'index'])->name('posts');
        Route::delete('posts/{id}/deactivate', [AdminpostController::class, 'deactivate'])->name('posts.deactivate');
        Route::patch('posts/{id}/activate', [AdminpostController::class, 'activate'])->name('posts.activate');
        Route::get('/posts/search', [AdminpostController::class, 'search'])->name('posts.search');
        //Categories
        Route::get('/categories',[CategoriesController::class, 'index'])->name('categories');
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

Route::get('/favorites', [FavoriteController::class, 'show'])->name('favorite');
Route::post('/favorite/{post_id}/store', [FavoriteController::class, 'store'])->name('favorite.store');
Route::delete('/favorite/{post_id}/destroy', [FavoriteController::class, 'destroy'])->name('favorite.destroy');

Route::get('/followers', function () {
    return view('followers_followings');
});

Route::get('/show2', function () {
    return view('users.profile.show2');
});

Route::get('profile/trip-map', function () {
    return view('users.profile.trip-map');
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
    });

});
