<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DetailSalesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return view('views.main');
// });

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('authProcess');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('/products')->name('products.')->group(function () {
        Route::get('/', [ProductsController::class, 'index'])->name('index');
        Route::get('/create', [ProductsController::class, 'create'])->name('create');
        Route::post('/', [ProductsController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ProductsController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductsController::class, 'update'])->name('update');
        Route::put('/update-stock/{id}', [ProductsController::class, 'updateStock'])->name('updateStock');
        Route::delete('/{id}', [ProductsController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('/sales')->name('sales.')->group(function () {
        Route::get('/', [SalesController::class, 'index'])->name('index');
        Route::get('/create', [SalesController::class, 'create'])->name('create');
        Route::post('/', [SalesController::class, 'store'])->name('store');
        Route::post('/payment', [SalesController::class, 'paymentProccess'])->name('paymentProccess');
        Route::get('/payment/{id}', [SalesController::class, 'showMember'])->name('showMember');
        Route::post('/payment/{id}', [SalesController::class, 'updateSale'])->name('updateSale');
        Route::get('/payment/print/{id}', [SalesController::class, 'printSale'])->name('printSale');
        Route::get('/export-pdf/{id}', [SalesController::class, 'exportPDF'])->name('exportPDF');
        Route::get('/show/{id}', [SalesController::class, 'show'])->name('show');
        Route::get('/sale-today', [SalesController::class, 'getTotalSalesToday'])->name('getTotalSalesToday');
    });

    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::get('/sales/export/pdf/{id}', [SalesController::class, 'exportPDF'])->name('exportPDF');
    Route::get('/sales/export/excel', [SalesController::class, 'exportExcel'])->name('exportExcel');
});
