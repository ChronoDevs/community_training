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

    // Favorites page route
    Route::get('/favorites', [App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/add/{listing}', [App\Http\Controllers\FavoriteController::class, 'add'])->name('favorites.add');
    Route::delete('/favorites/remove/{listing}', [App\Http\Controllers\FavoriteController::class, 'remove'])->name('favorites.remove');

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

    // Admin users list page route
    Route::get('admin/editUser/{user}', [\App\Http\Controllers\AdminController::class, 'editUser'])->name('admin.editUser');
    Route::put('admin/updateUser/{user}', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.updateUser');
    Route::get('/export-users', [\App\Http\Controllers\AdminController::class, 'exportUsers'])->name('export.users');
    Route::get('/admin/users/search', [\App\Http\Controllers\AdminController::class, 'search'])->name('admin.users.search');

    // Admin posts/listings list page route
    Route::get('admin/inspectListing/{listing}', [\App\Http\Controllers\AdminController::class, 'inspectListing'])->name('admin.inspectListing');
    Route::put('admin/updateListingStatus/{listing}', [\App\Http\Controllers\AdminController::class, 'updateListingStatus'])->name('admin.updateListingStatus');
    Route::get('admin/filterListings', [\App\Http\Controllers\AdminController::class, 'filterListings'])->name('admin.filterListings');

    // Admin users categories list page route
    Route::post('admin/createCategory', [\App\Http\Controllers\AdminController::class, 'createCategory'])->name('admin.createCategory');
    Route::get('admin/editCategory/{category}', [\App\Http\Controllers\AdminController::class, 'editCategory'])->name('admin.editCategory');
    Route::put('admin/updateCategory/{category}', [\App\Http\Controllers\AdminController::class, 'updateCategory'])->name('admin.updateCategory');
    Route::delete('admin/deleteCategory/{category}', [\App\Http\Controllers\AdminController::class, 'deleteCategory'])->name('admin.deleteCategory');

    // Admin tags list page route
    Route::post('admin/createTag', [\App\Http\Controllers\AdminController::class, 'createTag'])->name('admin.createTag');
    Route::get('admin/editTag/{tag}', [\App\Http\Controllers\AdminController::class, 'editTag'])->name('admin.editTag');
    Route::put('admin/updateTag/{tag}', [\App\Http\Controllers\AdminController::class, 'updateTag'])->name('admin.updateTag');
    Route::delete('admin/deleteTag/{tag}', [\App\Http\Controllers\AdminController::class, 'deleteTag'])->name('admin.deleteTag');
});
