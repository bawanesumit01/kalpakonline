<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\ClientAuthController;

use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {

    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize');

    return "Optimization commands executed successfully ✅";
});



Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/product/{id}', [HomeController::class, 'productDetails'])->name('product.details');

Route::post('/cart/add',    [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart',         [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/items', [CartController::class, 'getCartItems'])->name('cart.items');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/order/success/{orderId}', [CheckoutController::class, 'success'])->name('order.success');
Route::get('/order/success/{orderId}', [CheckoutController::class, 'success'])->name('order.success');

// Client Auth Routes
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('login',          [ClientAuthController::class, 'showLogin'])->name('login');
    Route::post('send-otp',      [ClientAuthController::class, 'sendOtp'])->name('send.otp');
    Route::get('verify-otp',     [ClientAuthController::class, 'showVerifyOtp'])->name('verify.otp');
    Route::post('verify-otp',    [ClientAuthController::class, 'verifyOtp'])->name('verify.otp.submit');
    Route::post('logout',        [ClientAuthController::class, 'logout'])->name('logout');
});

// Protected client routes
Route::middleware(['client'])->group(function () {
    Route::get('/client/profile',       [ProfileController::class, 'index'])->name('client.profile');
    Route::get('/client/orders',        [OrderController::class, 'index'])->name('client.orders');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->middleware('permission:dashboard')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:superadmin|admin'])->prefix('account')->group(function () {
    
    Route::get('/vendor', [VendorController::class, 'index'])->middleware('permission:vendors')->name('vendor.index');
    Route::get('/vendor/create', [VendorController::class, 'create'])->name('vendor.create');
    Route::post('/vendor/store', [VendorController::class, 'store'])->name('vendor.store');
    Route::get('/vendor/{id}/edit', [VendorController::class, 'edit'])->name('vendor.edit');
    Route::put('/vendor/{id}', [VendorController::class, 'update'])->name('vendor.update');
    Route::delete('/vendor/{id}', [VendorController::class, 'destroy'])->name('vendor.destroy');

    Route::get('/category', [CategoryController::class, 'index'])->middleware('permission:category')->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    Route::get('/products', [ProductController::class, 'index'])->middleware('permission:products')->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

});

// Route::middleware(['auth', 'role:admin'])->prefix('account')->group(function () {
//     // Route::get('/dashboard', [AdminDashboardController::class, 'index']);
// });

Route::middleware(['auth', 'role:client'])->group(function () {
    // Route::get('/dashboard', [ClientDashboardController::class, 'index']);
});


require __DIR__ . '/auth.php';
