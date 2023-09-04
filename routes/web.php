<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


    Auth::routes();
    // Facebook Login
    Route::get('login/facebook', [\App\Http\Controllers\Auth\LoginController::class, 'redirectToFacebook'])->name('login.facebook');
    Route::get('login/facebook/callback', [\App\Http\Controllers\Auth\LoginController::class, 'handleFacebookCallback']);
    // Google Login
    Route::get('login/google', [\App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('login/google/callback', [\App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);
    // Home Index
    Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home.index');



    Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth:admin'])->group(function () {
    // Routes only accessible to admins
    Route::get('/admin/home', [\App\Http\Controllers\AdminController::class, 'home'])->name('admin.home');
    Route::get('/admin/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/posts', [\App\Http\Controllers\AdminController::class, 'posts'])->name('admin.posts');
    Route::get('/admin/categories', [\App\Http\Controllers\AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/tags', [\App\Http\Controllers\AdminController::class, 'tags'])->name('admin.tags');

    Route::put('admin/updateUser/{id}', '\App\Http\Controllers\AdminController@updateUser')->name('admin.updateUser');
    Route::get('/export-users', '\App\Http\Controllers\AdminController@exportUsers')->name('export.users');
    Route::get('/admin/users/search', '\App\Http\Controllers\AdminController@search')->name('admin.users.search');
});
