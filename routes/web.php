<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', [NewsController::class, 'index'])->name('news.index');

Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

Route::prefix('admin')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('news', \App\Http\Controllers\Admin\NewsController::class)->except(['show'])->names('admin.news');

        Route::middleware('can:admin')->group(function () {
            Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show'])->names('admin.users');
        });
    });
});

// Summernote Image Upload/Delete Routes
Route::post('summernote/picture/upload/article', [App\Http\Controllers\ArticleController::class, 'uploadImageSummernote'])->name('summernote.image.upload');
Route::post('summernote/picture/delete/article', [App\Http\Controllers\ArticleController::class, 'deleteImageSummernote'])->name('summernote.image.delete');
