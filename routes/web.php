<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Client\FrontEndController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

    Route::middleware('auth')->group(function () {
        Route::get('/account', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/account/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/avatar', [ProfileController::class, 'avatar'])->name('profile.avatar');
    });
});


Route::group([
    'as' => 'admin.',
    'middleware' => ['auth', 'isAdmin']
], function () {
    Route::view('admin/login', 'admin.login');
    Route::get('/dashboard', [AdminController::class, 'home'])->name('home');
});








require __DIR__ . '/auth.php';
