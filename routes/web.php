<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Client\FrontEndController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([
    'as' => 'client.'
], function () {
    Route::get('/', [FrontEndController::class, 'index'])->name('home');
    Route::view('/about', 'client.about')->name('about');
    Route::view('/faqs', 'client.faqs')->name('faqs');
    Route::view('/terms', 'client.terms')->name('terms');
    Route::view('/privacy', 'client.privacy')->name('privacy');
    Route::view('/contact', 'client.contact')->name('contact');

    Route::middleware('auth', 'isClient')->group(function () {
        Route::get('/account', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/account/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/avatar', [ProfileController::class, 'avatar'])->name('profile.avatar');
    });
});


Route::view('admin/login', 'admin.login')
    ->middleware('guest')
    ->name('admin.login');
Route::group([
    'as' => 'admin.',
    'middleware' => ['auth', 'isAdmin'],
    'prefix' => 'dashboard'
], function () {
    Route::get('/home', [AdminController::class, 'home'])->name('home');
    Route::get('/account', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/account/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'avatar'])->name('profile.avatar');

    // Categories
    Route::get('/categories/filter', [CategoryController::class, 'filter'])->name('categories.filter');
    Route::get('categories/export', [CategoryController::class, 'export'])->name('categories.export');
    Route::post('categories/import', [CategoryController::class, 'import'])->name('categories.import');
    Route::resource('categories', CategoryController::class)->except('create', 'edit', 'show');
    // Authors
    Route::get('/authors/filter', [AuthorController::class, 'filter'])->name('authors.filter');
    Route::get('authors/export', [AuthorController::class, 'export'])->name('authors.export');
    Route::post('authors/import', [AuthorController::class, 'import'])->name('authors.import');
    Route::resource('authors', AuthorController::class)->except('create', 'edit', 'show');
});








require __DIR__ . '/auth.php';
