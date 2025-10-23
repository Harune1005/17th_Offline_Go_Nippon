<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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
Route::get('users/analytics', function () {
    return view('users.analytics.index');
});

route::get('/message', function () {
    return view('message');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profile', function () {
    return view('users.profile.show');
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
Route::get('/users/profile', function () {
    return view('users.profile.edit');
});
