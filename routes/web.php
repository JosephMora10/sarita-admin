<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Dashboard;

Route::redirect('/', 'login');

Route::middleware('auth')->group(function () {
    //Dashboard
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

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

    //Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    
});