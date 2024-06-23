<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;


// Index
Route::get('/', fn() => redirect('/products'));

// Auth middleware redirects to route with name 'login' if not authenticated
Route::middleware(['auth'])->group(function () {
    // Create
    Route::get('/products/create', [ProductController::class, 'showCreationPage']);
    Route::post('/products', [ProductController::class, 'create']);

    // Retrieve
    Route::get('/products', [ProductController::class, 'showProductsPage']);
    Route::get('/products/{id}', [ProductController::class, 'retrieve']);

    // Update
    Route::get('/products/{id}/update', [ProductController::class, 'showUpdatePage']);
    Route::put('/products/{id}/update', [ProductController::class, 'update']);

    // Delete
    Route::delete('/products/{id}', [ProductController::class, 'delete']);
});

// Login
Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
