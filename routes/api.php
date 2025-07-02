<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GoogleLoginController;
use App\Http\Controllers\Api\MenuController as ApiMenuController;
use App\Http\Controllers\Api\OrderController as ApiOrderController;
use App\Http\Controllers\Api\TransactionController as ApiTransactionController;

// 🔐 Login & Register
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// 🔒 Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/menus', [ApiMenuController::class, 'index']);
    Route::post('/orders', [ApiOrderController::class, 'store']);
    Route::get('/orders', [ApiOrderController::class, 'index']);
    Route::get('/transactions', [ApiTransactionController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::post('/google-login', [GoogleLoginController::class, 'handle']);

// =====================
// 📦 API UNTUK FLUTTER / MOBILE
// =====================
Route::prefix('v1')->group(function () {
    // 🔓 AUTH
    Route::post('/login', [ApiAuthController::class, 'login']);
    Route::post('/register', [ApiAuthController::class, 'register']);

    // 📋 MENU
    Route::get('/menus', [ApiMenuController::class, 'index']);
    Route::get('/menus/{id}', [ApiMenuController::class, 'show']);

    // 🧾 ORDER - hanya untuk user login
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/orders', [ApiOrderController::class, 'index']);
        Route::post('/orders', [ApiOrderController::class, 'store']);
        Route::get('/orders/{id}', [ApiOrderController::class, 'show']);
        Route::get('/orders/{id}/status', [ApiOrderController::class, 'getStatus']);
    });
});
