<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    MenuController,
    CheckoutController,
    OrderController,
    SalesReportController,
    PaymentController,
    UserAuthController,
    PromoController,
    WhatsAppController,
    DeliveryController,
    SocialiteUserController,
    CartController,
    ChatController
};
use Laragear\WebAuthn\Http\Controllers\{
    WebAuthnLoginController,
    WebAuthnRegisterController,
    WebAuthnDeleteController
};
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\AdminChatController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\MenuCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SalesReportController as AdminSalesReportController;

// =====================
// 🟢 HALAMAN PUBLIK (TANPA LOGIN)
// =====================
Route::get('/', [HomeController::class, 'showHome'])->name('home');
Route::get('/about', [HomeController::class, 'showAbout'])->name('about');
Route::get('/menu', [HomeController::class, 'showMenu'])->name('menu');
Route::get('/gallery', [HomeController::class, 'showGallery'])->name('gallery');
Route::get('/contact', [HomeController::class, 'showContact'])->name('contact');

// =====================
// 🟢 ROUTE PENGGUNA (USER) DENGAN PREFIX 'user'
// =====================
Route::prefix('user')->group(function () {
    Route::get('/user/login', [UserAuthController::class, 'showLoginForm'])->name('user.login');
    Route::get('/login', fn () => redirect()->route('user.login'))->name('login');
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');

    // 🔐 Login via Google
    Route::get('/auth/google', [SocialiteUserController::class, 'redirectToGoogle'])->name('user.google.login');
    Route::get('/auth/google/callback', [SocialiteUserController::class, 'handleGoogleCallback']);

    // 📧 Verifikasi Email
    Route::get('/email/verify', [UserAuthController::class, 'showEmailVerificationNotice'])->middleware('auth')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [UserAuthController::class, 'verifyEmail'])->middleware(['auth', 'signed'])->name('verification.verify');
    Route::post('/email/verification-notification', [UserAuthController::class, 'resendVerificationEmail'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    // 👤 Profil User (Setelah login)
    Route::middleware('auth')->group(function () {
        Route::get('/profile', fn () => view('user.profile-settings'))->name('profile.settings');
        Route::get('/profile/settings', [UserAuthController::class, 'settings'])->name('user.profile-settings');
        Route::put('/profile/settings', [UserAuthController::class, 'updateSettings'])->name('profile.settings.update');

        // Pembayaran
        Route::get('/payment', [PaymentController::class, 'index'])->name('user.payment');
        Route::get('/payment/from-order/{order}', [PaymentController::class, 'fromOrder'])->name('user.payment.fromOrder');
        Route::post('/payment/store', [PaymentController::class, 'store'])->name('user.payment.store');
        Route::get('/payment/show', [PaymentController::class, 'showCheckout'])->name('user.payment.show');
        Route::post('/checkout/pay', [PaymentController::class, 'checkoutPay'])->name('checkout.pay');
        Route::post('/payment/upload', [PaymentController::class, 'uploadProof'])->name('user.payment.upload');
    });
});

// =====================
// 🟢 CHECKOUT ROUTES
// =====================
Route::middleware('auth')->prefix('user')->group(function () {
    Route::post('/checkout/proceed', [CheckoutController::class, 'proceed'])->name('checkout.proceed');
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('user.payment.show');
    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('user.checkout');
    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// =====================
// 🟢 AUTH ADMIN
// =====================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth:admin', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/reports/sales', [SalesReportController::class, 'index'])->name('reports.sales');

        Route::resource('/menus', AdminMenuController::class)->names('menus');
        Route::resource('/menu-categories', MenuCategoryController::class)->names('menu-categories');

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');

        Route::resource('/users', UserController::class)->only(['index', 'show', 'destroy'])->names('users');
        Route::resource('/transactions', AdminTransactionController::class)->only(['index', 'show'])->names('transactions');
        Route::put('/transactions/confirm/{id}', [AdminTransactionController::class, 'confirm'])->name('transactions.confirm');
    });
});

// =====================
// 🟢 WEB AUTHN BIOMETRIK USER
// =====================
Route::prefix('user')->group(function () {
    Route::get('/webauthn/login/options', [WebAuthnLoginController::class, 'options'])->name('user.webauthn.options');
    Route::post('/webauthn/login', [WebAuthnLoginController::class, 'login'])->name('user.webauthn.login');

    Route::middleware('auth')->group(function () {
        Route::get('/webauthn/register/options', [WebAuthnRegisterController::class, 'options'])->name('user.webauthn.register.options');
        Route::post('/webauthn/register', [WebAuthnRegisterController::class, 'register'])->name('user.webauthn.register');
        Route::delete('/webauthn-credential/{id}', [WebAuthnDeleteController::class, 'destroy'])->name('user.webauthn.destroy');
    });
});

// =====================
// 🟢 MENU, ORDER, PROMO
// =====================
Route::resource('menu', MenuController::class)->only(['index', 'show']);

Route::middleware('auth')->group(function () {
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/checkout/confirm', [CheckoutController::class, 'confirmOrder'])->name('checkout.confirm');
    Route::get('/user/cart', [OrderController::class, 'cart'])->name('user.cart');
});

// =====================
// 🟢 CART ROUTES
// =====================
Route::middleware('auth')->prefix('cart')->group(function () {
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/', [CartController::class, 'show'])->name('cart.show');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

// =====================
// 🟢 PROMO
// =====================
Route::get('/promo', [PromoController::class, 'show'])->name('promo.show');
Route::post('/promo/apply', [PromoController::class, 'apply'])->name('promo.apply');

// =====================
// 🟢 LIVE CHAT ROUTES
// =====================
Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
Route::get('/chat/fetch', [ChatController::class, 'fetch'])->name('chat.fetch');

// web.php
Route::prefix('admin')->middleware(['auth:admin'])->name('admin.')->group(function () {
    Route::get('/chat', [AdminChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/fetch', [AdminChatController::class, 'fetch'])->name('chat.fetch');
    Route::post('/chat/send', [AdminChatController::class, 'send'])->name('chat.send');
});
Route::post('/admin/chat/mark-as-read', [AdminChatController::class, 'markAsRead'])->name('admin.chat.markAsRead');

