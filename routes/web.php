<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopCategoryController;
use App\Http\Controllers\ShopProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\WishlistController;

// ── Home ──────────────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ── Contact ──────────────────────────────────────────────────────────────────
Route::get('/page/{slug}', [\App\Http\Controllers\Shop\PageController::class, 'show'])->name('page.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// ── Shop ──────────────────────────────────────────────────────────────────────
Route::get('/shop', [ShopProductController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopCategoryController::class, 'show'])->name('shop.category');
Route::get('/product/{slug}', [ShopProductController::class, 'show'])->name('shop.product');

// ── Cart ──────────────────────────────────────────────────────────────────────
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// ── Checkout ─────────────────────────────────────────────────────────────────
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'place'])->name('checkout.place');
Route::get('/order/confirmation/{orderNumber}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');

// ── Order Tracking (public) ───────────────────────────────────────────────────
Route::get('/track-order', [OrderTrackingController::class, 'index'])->name('order.track');
Route::post('/track-order', [OrderTrackingController::class, 'track'])->name('order.track.post');

// ── Customer Auth (Email/Password) ────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.post');
    Route::get('/register', [CustomerAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.post');
});
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Customer Auth (Socialite – Google & GitHub) ───────────────────────────────
Route::get('/auth/{provider}/redirect', [CustomerAuthController::class, 'redirectToProvider'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [CustomerAuthController::class, 'handleProviderCallback'])->name('socialite.callback');

// ── Account Dashboard (logged-in customers only) ──────────────────────────────
Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/', [AccountController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
    Route::get('/orders/{orderNumber}', [AccountController::class, 'orderShow'])->name('order.show');
    Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
    Route::post('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [AccountController::class, 'changePassword'])->name('password.change');
});

// Admin redirect helper
Route::redirect('/admin', '/admin/login');
