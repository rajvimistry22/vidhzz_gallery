<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\SpinWheelController as AdminSpinWheelController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SpinWheelController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'home'])->name('shop.home');
Route::get('/collections', [ShopController::class, 'categories'])->name('shop.categories');
Route::get('/collections/{category}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/products', [ShopController::class, 'products'])->name('shop.products');
Route::get('/products/{product}', [ShopController::class, 'product'])->name('shop.product');
Route::get('/search', [ShopController::class, 'search'])->name('shop.search');
Route::get('/about', [ShopController::class, 'about'])->name('shop.about');
Route::get('/contact', [ShopController::class, 'contact'])->name('shop.contact');
Route::post('/contact', [ShopController::class, 'contactStore'])->name('shop.contact.store');

// Spin & Win
Route::get('/spin/check', [SpinWheelController::class, 'check'])->name('spin.check');
Route::post('/spin', [SpinWheelController::class, 'spin'])->name('spin.spin');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/items/{item}', [CartController::class, 'update'])->name('cart.items.update');
Route::delete('/cart/items/{item}', [CartController::class, 'destroy'])->name('cart.items.destroy');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::delete('/cart/coupon', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [ShopController::class, 'wishlist'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    Route::get('/account', [AccountController::class, 'dashboard'])->name('account.dashboard');
    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/account/orders/{order}', [AccountController::class, 'showOrder'])->name('account.orders.show');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/failure/{order}', [CheckoutController::class, 'failure'])->name('checkout.failure');
    Route::get('/orders/{order}/invoice', [CheckoutController::class, 'invoice'])->name('orders.invoice');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('storage-link', function () {
        try {
            \Illuminate\Support\Facades\Artisan::call('storage:link');
            return redirect()->route('admin.dashboard')->with('success', 'Storage symbolic link created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Failed to create storage link: ' . $e->getMessage());
        }
    })->name('storage-link');
    Route::resource('categories', AdminCategoryController::class)->except('show');
    Route::post('categories/{category}/delete-image', [AdminCategoryController::class, 'deleteImage'])->name('categories.delete-image');
    Route::post('categories/{category}/delete-banner', [AdminCategoryController::class, 'deleteBanner'])->name('categories.delete-banner');
    Route::post('categories/gallery/{image}/delete', [AdminCategoryController::class, 'deleteGalleryImage'])->name('categories.delete-gallery-image');

    Route::resource('products', AdminProductController::class)->except('show');
    Route::post('products/{product}/delete-primary-image', [AdminProductController::class, 'deletePrimaryImage'])->name('products.delete-primary-image');
    Route::post('products/gallery/{image}/delete', [AdminProductController::class, 'deleteGalleryImage'])->name('products.delete-gallery-image');
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
    Route::get('customers', [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{customer}', [AdminCustomerController::class, 'show'])->name('customers.show');
    Route::resource('coupons', AdminCouponController::class)->except('show');
    Route::resource('banners', AdminBannerController::class)->except('show');
    Route::get('spin-wheel', [AdminSpinWheelController::class, 'index'])->name('spin-wheel.index');
});

// Fallback route to serve uploaded storage files when public/storage symlink is missing or broken (e.g. on live shared hosting)
Route::get('storage/{path}', function ($path) {
    if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
        abort(404);
    }
    return \Illuminate\Support\Facades\Storage::disk('public')->response($path);
})->where('path', '.*');

