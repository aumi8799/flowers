<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/subscriptions', function () {
    return view('subscriptions');
})->name('subscriptions');

Route::get('/decoration', function () {
    return view('decoration');
})->name('decoration');

Route::get('/special', function () {
    return view('special');
})->name('special');

Route::get('/giftcoupons', function () {
    return view('giftcoupons');
})->name('giftcoupons');

use App\Http\Controllers\CartController;

Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

use App\Http\Controllers\CatalogController;
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/skintos-geles', [CatalogController::class, 'skintosGeles'])->name('catalog.skintos-geles');
Route::get('/catalog/puokstes', [CatalogController::class, 'puokstes'])->name('catalog.puokstes');
Route::get('/catalog/geles-dezuteje', [CatalogController::class, 'gelesDezuteje'])->name('catalog.geles-dezuteje');
Route::get('/catalog/miegancios-rozes', [CatalogController::class, 'mieganciosRoze'])->name('catalog.miegancios-rozes');


use App\Http\Controllers\OrderController;
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'myOrders'])->name('orders.index');
});

// Rezervacijos užsakymas
Route::post('/order/reserve', [OrderController::class, 'reserve'])->name('order.reserve');

// Užsakymų rodymas
Route::get('/orders', [OrderController::class, 'myOrders'])->name('orders.index');

Route::get('/addresses', function () {
    return view('addresses'); 
});
use App\Http\Controllers\SearchController;
Route::get('/search', [SearchController::class, 'index'])->name('search');

use App\Http\Controllers\ProductController;

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');


