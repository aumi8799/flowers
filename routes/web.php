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

        if (Auth::user()->role === 'admin') {
            return redirect('/admin');  
        }
        if (Auth::user()->role === 'courier') {
            return redirect('/courier');  
        }

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

// Rezervacijos atšaukimas
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

// Rezervacijos redagavimas
Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');

Route::post('/order/process', [OrderController::class, 'processOrder'])->name('order.process');

// Užsakymų rodymas
Route::get('/orders', [OrderController::class, 'myOrders'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

Route::get('/addresses', function () {
    return view('addresses'); 
});
use App\Http\Controllers\SearchController;
Route::get('/search', [SearchController::class, 'index'])->name('search');

use App\Http\Controllers\ProductController;

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');


use App\Http\Controllers\CheckoutController;

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
//Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
//Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('paypal.cancel');


use App\Http\Controllers\PayPalController;

Route::get('/paypal/success', [PayPalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');


Route::post('/paypal/set-delivery-city', [PayPalController::class, 'setDeliveryCity'])->name('paypal.setDeliveryCity');
use App\Http\Controllers\ReviewController;

Route::middleware(['auth'])->group(function () {
    Route::get('/orders/{order}/review', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/orders/{order}/review', [ReviewController::class, 'store'])->name('reviews.store');
});

Route::get('/reviews', [ReviewController::class, 'showAll'])->name('reviews.show');

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourierController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:courier'])->group(function () {
    Route::get('/courier', [CourierController::class, 'index'])->name('courier.dashboard');
});
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/courier', [CourierController::class, 'index'])->name('courier.dashboard');

Route::middleware(['auth', 'role:courier'])->group(function () {
    Route::get('/courier/tasks', [OrderController::class, 'courierTasks'])->name('courier.tasks');
    Route::get('/courier/tasks/{id}', [OrderController::class, 'courierShow'])->name('courier.show');
    Route::put('/courier/tasks/{order}/delivered', [OrderController::class, 'markAsDelivered'])->name('order.delivered');
});
Route::get('/courier/tasks', [OrderController::class, 'courierTasks'])->name('courier.tasks');
Route::get('/courier/tasks/{id}', [OrderController::class, 'courierShow'])->name('courier.show');
Route::put('/courier/tasks/{order}/delivered', [OrderController::class, 'markAsDelivered'])->name('order.delivered');
