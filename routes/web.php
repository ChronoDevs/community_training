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

// routes/web.php

// Social Login Routes
    Route::get('login/facebook', [\App\Http\Controllers\Auth\LoginController::class, 'redirectToFacebook'])->name('login.facebook');
    Route::get('login/facebook/callback', [\App\Http\Controllers\Auth\LoginController::class, 'handleFacebookCallback']);

    Route::get('login/google', [\App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('login/google/callback', [\App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);

    Route::get('login/line', [\App\Http\Controllers\Auth\LoginController::class, 'redirectToLine'])->name('login.line');
    Route::get('login/line/callback', [\App\Http\Controllers\Auth\LoginController::class, 'handleLineCallback']);

    // Regular Authentication Routes
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    // Home Index
    Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home.index');

    // Admin Login Routes
    Route::get('/admin/login', [\App\Http\Controllers\Admin\AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [\App\Http\Controllers\Admin\AdminLoginController::class, 'login']);
    Route::post('/admin/logout', [\App\Http\Controllers\Admin\AdminLoginController::class, 'showLoginForm'])->name('admin.logout');
//});

//Route::middleware(['auth'])->group(function () {
    // Listings page route
    Route::get('/listings', [App\Http\Controllers\ListingController::class, 'index'])->name('listings.index');
    Route::get('/listings/create', [App\Http\Controllers\ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [App\Http\Controllers\ListingController::class, 'store'])->name('listings.store');
    Route::get('/listings/search', [App\Http\Controllers\ListingController::class, 'searchListings'])->name('listings.search');
    Route::resource('listings', App\Http\Controllers\ListingController::class);

    // Show a specific listing
    Route::get('/listings/{listing}', [App\Http\Controllers\ListingController::class, 'show'])->name('listings.show');
    Route::post('/listings/{listing}/favorites/add', [App\Http\Controllers\FavoriteController::class, 'addToFavorites'])->name('favorites.add');

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

    // Comment
    Route::post('/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{listingId}', [\App\Http\Controllers\CommentController::class, 'index'])->name('comments.index');
    Route::post('/comments/{comment}/like', [\App\Http\Controllers\CommentController::class, 'like'])->name('comments.like');
    Route::delete('/comments/{comment}/unlike', [\App\Http\Controllers\CommentController::class, 'unlike'])->name('comments.unlike');

    // Routes for Replies
    Route::post('comments/{comment}/replies', [\App\Http\Controllers\CommentController::class, 'storeReply'])->name('comments.storeReply');
    Route::get('comments/{comment}/replies', [\App\Http\Controllers\CommentController::class, 'showReplies'])->name('comments.showReplies');
    Route::post('/replies/{replyId}/like', [\App\Http\Controllers\CommentController::class, 'likeReply'])->name('reply.like');
    Route::delete('/replies/{replyId}/unlike', [\App\Http\Controllers\CommentController::class, 'unlikeReply'])->name('reply.unlike');

    Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
//});

Route::middleware(['auth:admin'])->group(function () {
    // Routes only accessible to admins
    Route::get('/admin/home', [\App\Http\Controllers\Admin\DashboardController::class, 'home'])->name('admin.dashboard.index');
    Route::get('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'users'])->name('admin.users.index');
    Route::get('/admin/posts', [\App\Http\Controllers\Admin\ListingController::class, 'posts'])->name('admin.posts.index');
    Route::get('/admin/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'categories'])->name('admin.category.index');
    Route::get('/admin/tags', [\App\Http\Controllers\Admin\TagController::class, 'tags'])->name('admin.tags.index');

    // Admin users list page route
    Route::get('admin/editUser/{user}', [\App\Http\Controllers\Admin\UserController::class, 'editUser'])->name('admin.editUser');
    Route::put('admin/updateUser/{user}', [\App\Http\Controllers\Admin\UserController::class, 'updateUser'])->name('admin.updateUser');
    Route::get('/export-users', [\App\Http\Controllers\Admin\UserController::class, 'exportUsers'])->name('export.users');
    Route::get('/admin/users/search', [\App\Http\Controllers\Admin\UserController::class, 'search'])->name('admin.users.search');

    // Admin posts/listings list page route
    Route::get('admin/inspectListing/{listing}', [\App\Http\Controllers\Admin\ListingController::class, 'inspectListing'])->name('admin.inspectListing');
    Route::put('admin/updateListingStatus/{listing}', [\App\Http\Controllers\Admin\ListingController::class, 'updateListingStatus'])->name('admin.updateListingStatus');
    Route::get('admin/filterListings', [\App\Http\Controllers\Admin\ListingController::class, 'filterListings'])->name('admin.filterListings');

    // Admin users categories list page route
    Route::post('admin/createCategory', [\App\Http\Controllers\Admin\CategoryController::class, 'createCategory'])->name('admin.createCategory');
    Route::get('admin/editCategory/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'editCategory'])->name('admin.editCategory');
    Route::put('admin/updateCategory/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'updateCategory'])->name('admin.updateCategory');
    Route::delete('admin/deleteCategory/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'deleteCategory'])->name('admin.deleteCategory');

    // Admin tags list page route
    Route::post('admin/createTag', [\App\Http\Controllers\Admin\TagController::class, 'createTag'])->name('admin.createTag');
    Route::get('admin/editTag/{tag}', [\App\Http\Controllers\Admin\TagController::class, 'editTag'])->name('admin.editTag');
    Route::put('admin/updateTag/{tag}', [\App\Http\Controllers\Admin\TagController::class, 'updateTag'])->name('admin.updateTag');
    Route::delete('admin/deleteTag/{tag}', [\App\Http\Controllers\Admin\TagController::class, 'deleteTag'])->name('admin.deleteTag');
});
