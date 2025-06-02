<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsStaff;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController; // Add this for public product routes
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Staff\StaffOrderController;
use App\Http\Controllers\Staff\StaffProductController;





// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public product routes
Route::controller(ProductController::class)->group(function () {
    Route::get('/products/search', action: [ProductController::class, 'search'])->name('products.search');
    Route::get('/products', 'index')->name('products.index');
    Route::get('/products/{product}', 'show')->name('products.show');
});

// Authentication routess
require __DIR__ . '/auth.php';

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated user routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart routes
    Route::get('/cart', [CartItemController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartItemController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/{cartItem}', [CartItemController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartItemController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/clear', [CartItemController::class, 'clearCart'])->name('cart.clear');

    //Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.apply-coupon');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/download-pdf/{order}', [CheckoutController::class, 'downloadPdf'])
        ->name('checkout.download-pdf');

    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/download-pdf/{order}', [OrderController::class, 'downloadPdf'])
        ->name('orders.download-pdf');
});

// Admin Routes
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', AdminProductController::class); // Note: Using AdminProductController
    Route::resource('users', UserController::class);

    // PDF Export routes for admin
    Route::get('products/export/pdf', [AdminProductController::class, 'exportPdf'])
        ->name('products.export-pdf');

    Route::get('orders/export/pdf', [AdminOrderController::class, 'exportPdf'])
        ->name('orders.export-pdf');

    Route::get('categories/export/pdf', [CategoryController::class, 'exportPdf'])
        ->name('categories.export-pdf');

    Route::get('users/export/pdf', [UserController::class, 'exportPdf'])
        ->name('users.export-pdf');

    // Orders routes with custom updateStatus
    Route::resource('orders', AdminOrderController::class);
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');
});

// Staff Routes
Route::middleware(['auth', IsStaff::class])->prefix('staff')->name('staff.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');

    // Orders Management
    Route::resource('orders', StaffOrderController::class);
    Route::get('/orders/{order}/print', [StaffOrderController::class, 'print'])->name('orders.print');

    // Limited Product Management (inventory only)
    Route::get('/products', [StaffProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [StaffProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [StaffProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [StaffProductController::class, 'update'])->name('products.update');
});