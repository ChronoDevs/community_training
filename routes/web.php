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

//Route::middleware(['auth:guest'])->group(function () {
    Auth::routes();

    // Facebook Login
    Route::get('login/facebook', [\App\Http\Controllers\Auth\LoginController::class, 'redirectToFacebook'])->name('login.facebook');
    Route::get('login/facebook/callback', [\App\Http\Controllers\Auth\LoginController::class, 'handleFacebookCallback']);

    // Google Login
    Route::get('login/google', [\App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('login/google/callback', [\App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);

    // Home Index
    Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home.index');

    // Line Login
    Route::get('login/line', [\App\Http\Controllers\Auth\LoginController::class, 'redirectToLine'])->name('login.line');
    Route::get('login/line/callback', [\App\Http\Controllers\Auth\LoginController::class, 'handleLineCallback']);
//});

//Route::middleware(['auth'])->group(function () {
    // Listings page route
    Route::get('/listings', [App\Http\Controllers\ListingController::class, 'index'])->name('listings.index');
    Route::get('/listings/create', [App\Http\Controllers\ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [App\Http\Controllers\ListingController::class, 'store'])->name('listings.store');
    Route::resource('listings', App\Http\Controllers\ListingController::class);

    // Tags page route
    Route::get('/tags', [App\Http\Controllers\TagController::class, 'index'])->name('tags.index');

    // Faqs page route
    Route::get('/faqs', [App\Http\Controllers\FaqController::class, 'index'])->name('faqs.index');

    // Like and Unlike
    Route::post('/listings/{listing}/like', [App\Http\Controllers\ListingController::class, 'like'])->name('listings.like');
    Route::delete('/listings/{listing}/unlike', [App\Http\Controllers\ListingController::class, 'unlike'])->name('listings.unlike');

    Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
//});

Route::middleware(['auth:admin'])->group(function () {
    // Routes only accessible to admins
    Route::get('/admin/home', [\App\Http\Controllers\AdminController::class, 'home'])->name('admin.home');
    Route::get('/admin/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/posts', [\App\Http\Controllers\AdminController::class, 'posts'])->name('admin.posts');
    Route::get('/admin/categories', [\App\Http\Controllers\AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/tags', [\App\Http\Controllers\AdminController::class, 'tags'])->name('admin.tags');

    Route::get('admin/editUser/{user}', [\App\Http\Controllers\AdminController::class, 'editUser'])->name('admin.editUser');
    Route::put('admin/updateUser/{user}', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.updateUser');
    Route::get('/export-users', [\App\Http\Controllers\AdminController::class, 'exportUsers'])->name('export.users');
    Route::get('/admin/users/search', [\App\Http\Controllers\AdminController::class, 'search'])->name('admin.users.search');
});
