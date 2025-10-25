<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\DailySaleController;
use App\Http\Controllers\DashboardController;

// Ruta raíz con middleware de redirección
Route::get('/', function () {
    return redirect('/login');
})->middleware('redirect.role');

// Rutas solo para administradores (role = 1)
Route::middleware(['auth', 'can:access-admin'])->group(function () {

    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Users
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    //Products
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    //Product Categories
    Route::get('/categories', [ProductCategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [ProductCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [ProductCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [ProductCategoryController::class, 'destroy'])->name('categories.destroy');
});

// Rutas para todos los usuarios autenticados
Route::middleware(['auth'])->group(function () {
    //Sales
    Route::get('/sales', [DailySaleController::class, 'index'])->name('sales');
    Route::post('/sales', [DailySaleController::class, 'store'])->name('sales.store');
    Route::get('/sales/create', [DailySaleController::class, 'create'])->name('sales.create');
    Route::put('/sales/{id}', [DailySaleController::class, 'update'])->name('sales.update');
    Route::delete('/sales/{id}', [DailySaleController::class, 'destroy'])->name('sales.destroy');
});