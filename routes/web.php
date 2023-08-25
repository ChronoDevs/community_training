<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

// Home Index
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Facebook Login
Route::get('login/facebook', [LoginController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [LoginController::class, 'handleFacebookCallback']);

// Google Login
Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth:admin'])->group(function () {
    // Routes only accessible to admins
    Route::get('/admin/home', [\App\Http\Controllers\AdminController::class, 'home'])->name('admin.home');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/posts', [AdminController::class, 'posts'])->name('admin.posts');
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/tags', [AdminController::class, 'tags'])->name('admin.tags');

    Route::post('/admin/categories/create', 'App\Http\Controllers\AdminController@createCategory')->name('admin.categories.create');});
    Route::get('/admin/edit-category/{id}', 'App\Http\Controllers\AdminController@editCategory')->name('admin.editCategory');
    Route::post('/admin/update-category/{id}', 'App\Http\Controllers\AdminController@updateCategory')->name('admin.updateCategory');
    Route::get('/admin/delete-category/{id}', 'App\Http\Controllers\AdminController@deleteCategory')->name('admin.deleteCategory');
    Route::get('/admin/search-categories', 'App\Http\Controllers\AdminController@searchCategories')->name('admin.searchCategories');
