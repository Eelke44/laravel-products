<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;

// Index
Route::get('/', fn() => redirect('/products'));

// Products
// Auth middleware redirects to /login if not authenticated
Route::get('/products', [ProductsController::class, 'products'])->middleware('auth');

// Auth
Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
