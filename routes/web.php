<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\OrderController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// -------------------------
// Auth Routes
// -------------------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// -------------------------
// Dashboard Routes (no middleware for now)
// -------------------------
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
Route::get('/dashboard/vendor', [DashboardController::class, 'vendor'])->name('dashboard.vendor');
Route::get('/dashboard/customer', [DashboardController::class, 'customer'])->name('dashboard.customer');

// -------------------------
// Product Listing (Customer)
// -------------------------
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// -------------------------
// Cart Routes
// -------------------------
Route::prefix('cart')->middleware('auth')->group(function () {

    // View Cart
    Route::get('/', [CartController::class, 'viewCart'])->name('cart.index');

    // Add Product to Cart
    Route::post('/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');

    // Remove Product from Cart
    Route::post('/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');

    // Update single product quantity
    Route::post('/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');

    // Update all quantities at once
    Route::post('/update', [CartController::class, 'updateAll'])->name('cart.updateAll');

    // checkout
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');

});

Route::prefix('admin')->group(function () {
    // View all orders
    Route::get('orders', [OrderController::class, 'index'])->name('admin.orders.index');

    // View single order details
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
});