<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Client\FrontEndController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Client\ReviewController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Client\NotificationController as ClientNotificationController;
use App\Http\Controllers\Client\ShopController;
use Maatwebsite\Excel\Row;

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
    Route::get('/shop/product/availability/{id}/{quantity}', [ShopController::class, 'isAvailableProduct'])->name('productAvailability');
    Route::get('/cart', [FrontEndController::class, 'cart'])->name('cart');
    Route::get('/shop/filter', [ShopController::class, 'filter'])->name('shop.filter');
    Route::get('/shop', [ShopController::class, 'shop'])->name('shop');
    Route::get('/book/{book}', [ShopController::class, 'book'])->name('shop.book');
    Route::view('/about', 'client.about')->name('about');
    Route::view('/faqs', 'client.faqs')->name('faqs');
    Route::view('/terms', 'client.terms')->name('terms');
    Route::view('/privacy', 'client.privacy')->name('privacy');
    Route::view('/contact', 'client.contact')->name('contact');
    Route::view('banned', 'errors.banned')->name('profile.banned');

    Route::middleware(['auth', 'isActive'])->group(function () {
        Route::get('notifications', [ClientNotificationController::class, 'index'])->name('notifications.index');
        Route::get('notifications/filter', [ClientNotificationController::class, 'filter'])->name('notifications.filter');
        Route::get('/checkout', [FrontEndController::class, 'checkout'])->name('checkout');
        Route::patch('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
        Route::resource('orders', OrderController::class)->only(['index', 'show', 'store']);
        Route::middleware('isClient')->group(function () {
            Route::post('reviews/store/{book}', [ReviewController::class, 'store'])->name('reviews.store');
            Route::get('/account', [ProfileController::class, 'index'])->name('profile.index');
            Route::get('/account/edit', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::post('/profile/avatar', [ProfileController::class, 'avatar'])->name('profile.avatar');
        });
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
    Route::get('/', [AdminController::class, 'home'])->name('home');
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
    // Publishers
    Route::get('/publishers/filter', [PublisherController::class, 'filter'])->name('publishers.filter');
    Route::get('publishers/export', [PublisherController::class, 'export'])->name('publishers.export');
    Route::post('publishers/import', [PublisherController::class, 'import'])->name('publishers.import');
    Route::resource('publishers', PublisherController::class)->except('create', 'edit', 'show');


    // Books

    Route::post('/books/import', [BookController::class, 'import'])->name('books.import');
    Route::get('/books/export', [BookController::class, 'export'])->name('books.export');
    Route::get('/books/filter', [BookController::class, 'filter'])->name('books.filter');
    Route::resource('books', BookController::class);

    // Orders
    Route::get('orders/filter', [AdminOrderController::class, 'filter'])->name('orders.filter');
    Route::patch('orders/cancel/{order}', [AdminOrderController::class, 'cancel'])->name('orders.cancel');
    Route::patch('orders/confirm/{order}', [AdminOrderController::class, 'confirm'])->name('orders.confirm');
    Route::patch('orders/ship/{order}', [AdminOrderController::class, 'ship'])->name('orders.ship');
    Route::patch('orders/deliver/{order}', [AdminOrderController::class, 'deliver'])->name('orders.deliver');
    Route::patch('orders/return/{order}', [AdminOrderController::class, 'return'])->name('orders.return');
    Route::resource('orders', AdminOrderController::class)->only('show', 'index');


    // Clients
    Route::patch('clients/ban/{client}', [ClientController::class, 'ban'])->name('clients.ban');
    Route::patch('clients/activate/{client}', [ClientController::class, 'activate'])->name('clients.activate');
    Route::get('clients/filter', [ClientController::class, 'filter'])->name('clients.filter');
    Route::resource('clients', ClientController::class)->only('show', 'index');


    // Inventory
    Route::patch('inventory/manage/{book}', [InventoryController::class, 'manage'])->name('inventory.manage');
    Route::get('inventory/filter', [InventoryController::class, 'filter'])->name('inventory.filter');
    Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');


    // Reviews
    Route::get('reviews.filter', [AdminReviewController::class, 'filter'])->name('reviews.filter');
    Route::resource('reviews', AdminReviewController::class)->only(['index', 'destroy']);

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/filter', [NotificationController::class, 'filter'])->name('notifications.filter');

    // Shipping cost
    Route::patch('/shippingCost', [SettingController::class, 'setShippingCost'])->name('updateShippingCost');
});








require __DIR__ . '/auth.php';
