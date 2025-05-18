<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PostPDFController;
use App\Http\Controllers\Site\HomeController as SiteHomeController;
use App\Http\Controllers\Site\PostController as SitePostController;
use App\Http\Controllers\Site\CategoryController as SiteCategoryController;
use App\Http\Controllers\Site\SiteAuthController;
use App\Http\Controllers\Site\SiteCommentController;
use App\Http\Controllers\Site\SiteProfileController;
use App\Http\Controllers\Site\PasswordResetController;

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

Route::get('/',[HomeController::class,'index'])->name('home');

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    Route::get('/password/edit', [PasswordController::class, 'edit'])
        ->name('password.edit');

    Route::put('/password/update', [PasswordController::class, 'update'])
        ->name('password.p-update');

    Route::get('/users/archived', [UserController::class, 'archived'])
        ->name('users.archived');

    Route::put('/users/{id}/restore', [UserController::class, 'restore'])
    ->name('users.restore');

    Route::delete('/users/{id}/force-delete', [UserController::class, 'forceDelete'])
    ->name('users.forceDelete');

    Route::get('/users/{id}/password', [UserController::class, 'editPassword'])
    ->name('users.password.edit');

    Route::put('/users/{id}/password', [UserController::class, 'updatePassword'])
    ->name('users.password.update');
    Route::get('/roles/{role}/permissions', [RoleController::class, 'showPermissions'])
    ->name('roles.permissions');
    Route::get('/users/all-with-status', [UserController::class, 'allWithStatus'])
    ->name('users.all-with-status');

    Route::resource('users', UserController::class);
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::get('/logs/posts', [LogController::class, 'logsPosts'])->name('logs.posts');
    Route::get('/logs/users', [LogController::class, 'logsUsers'])->name('logs.users');
    Route::get('/logs/roles', [LogController::class, 'logsRoles'])->name('logs.roles');
    Route::get('/logs/posts/export/excel', [LogController::class, 'exportPostLogsExcel'])
    ->name('logs.posts.export.excel');
    Route::get('/export-pdf', [PostPDFController::class, 'exportPdf'])
    ->name('export.pdf');
});

Route::prefix('site')->name('site.')->group(function () {
    Route::get('/', [SiteHomeController::class, 'index'])->name('home');
    Route::get('/category/{slug}', [SiteCategoryController::class, 'show'])
    ->name('category.show');//عرض البوستات الخاصة بالفئة
    Route::get('/post/{slug}', [SitePostController::class, 'show'])
    ->name('post.show'); //عرض بوست معين من صفحة الفئة
    // Posts page route
    Route::get('/site/posts', [SitePostController::class, 'index'])
    ->name('posts.index');
    Route::post('/posts/{post}/comments', [SiteCommentController::class, 'store'])
    ->name('comment.store');

    Route::get('/login', [SiteAuthController::class, 'showLoginForm'])
    ->name('login');
    Route::post('/login', [SiteAuthController::class, 'login']);
    Route::get('/register', [SiteAuthController::class, 'showRegisterForm'])
    ->name('register');
    Route::post('/register', [SiteAuthController::class, 'register']);
    Route::post('/logout', [SiteAuthController::class, 'logout'])
    ->name('logout');
});

// Profile Routes
Route::middleware(['auth:site'])->group(function () {
    Route::get('/profile', [SiteProfileController::class, 'show'])
    ->name('profile.show');
    Route::post('/profile/update', [SiteProfileController::class, 'update'])
    ->name('profile.update');
    Route::get('/profile/password', [SiteProfileController::class, 'showPasswordForm'])
    ->name('profile.password.form');
    Route::post('/profile/password', [SiteProfileController::class, 'changePassword'])
    ->name('profile.password.change');

    
});

Route::middleware('guest:site')->group(function () {
    Route::get('/password/forgot', [PasswordResetController::class, 'showForgotForm'])
        ->name('site.password.forgot');
    Route::post('/password/forgot', [PasswordResetController::class, 'sendResetCode'])
        ->name('site.password.send-code');

    Route::get('/password/verify-code', [PasswordResetController::class, 'showVerifyCodeForm'])
    ->name('site.password.verify-code.form');
    Route::post('/password/verify-code', [PasswordResetController::class, 'verifyCode'])
    ->name('site.password.verify-code');

    Route::get('/password/reset', [PasswordResetController::class, 'showResetPasswordForm'])
    ->name('site.password.reset.form');
    Route::post('/password/reset', [PasswordResetController::class, 'resetPassword'])
    ->name('site.password.reset');
});



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
