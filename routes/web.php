<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware(['auth', 'active.user'])->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('can:manage-inventory')->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('products', ProductController::class);
        Route::resource('purchases', PurchaseOrderController::class)->only(['index', 'create', 'store', 'show']);
        Route::get('stock', [StockMovementController::class, 'index'])->name('stock.index');
        Route::get('stock/adjust', [StockMovementController::class, 'create'])->name('stock.create');
        Route::post('stock/adjust', [StockMovementController::class, 'store'])->name('stock.store');
    });

    Route::middleware('can:manage-sales')->group(function () {
        Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);
    });

    Route::middleware('can:manage-users')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity.index');
});
