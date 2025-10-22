<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\HomeController;
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
});
Route::get('admin/posts', function () {
    return view('admin.posts.index');
});
Route::get('admin/categories', function () {
    return view('admin.categories.index');
});

// Analytics
Route::get('/users/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

route::get('/message', function () {
    return view('messages.message');
});

route::get('/message/board', function () {
    return view('messages.chat');
});

route::get('/favorites', function () {
    return view('favorite');
});

route::get('/followers', function () {
    return view('followers_followings');
});

Route::get('/show2', function () {
    return view('users.profile.show2');
});

Route::get('profile/trip-map', function () {
    return view('users.profile.trip-map');
});

// ★★★ 修正不要、このルート定義で 'post.store' が有効です ★★★
// ルート名は post. で統一されているため、Blade側を post.store に合わせましょう。
Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
Route::get('/post/{id}/show', [PostController::class, 'show'])->name('post.show');
Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
Route::patch('/post/{id}/update', [PostController::class, 'update'])->name('post.update');
Route::delete('/post/{id}/destroy', [PostController::class, 'destroy'])->name('post.destroy');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    // PROFILE
    Route::get('/profile/{id}/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{id}/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/{id}/followers', [ProfileController::class, 'followers'])->name('profile.followers');

});
