<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPhotoController;
use App\Http\Controllers\UserController;


Route::get('/', [PhotoController::class, 'welcome'])->name('welcome');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::resource('photos', PhotoController::class);

    Route::post('/photos/{id}/like', [PhotoController::class, 'like'])->name('photos.like');
    Route::post('/photos/{photo}/comment', [PhotoController::class, 'addComment'])->name('photos.comment');

    Route::get('/search', [PhotoController::class, 'search'])->name('photos.search');

    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
});

Route::prefix('admin')->middleware(['auth', 'is_admin'])->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::get('/photos/{id}/edit', [AdminPhotoController::class, 'edit'])->name('photos.edit');
    Route::put('/photos/{id}', [AdminPhotoController::class, 'update'])->name('photos.update');
    Route::delete('/photos/{id}', [AdminPhotoController::class, 'destroy'])->name('photos.destroy');
    Route::get('/photos/{id}', [AdminPhotoController::class, 'show'])->name('photos.show');

    Route::get('/users', [AdminPhotoController::class, 'listUsers'])->name('users');
});

Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');
