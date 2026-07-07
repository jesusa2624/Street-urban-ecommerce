<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\DataRegisterController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Rutas de la tienda
Route::get('/', [ProductController::class, 'index'])->name('shop.home');
Route::get('/tienda', [ProductController::class, 'shop'])->name('shop.tienda');
Route::get('/carrito', [CartController::class, 'cart'])->name('shop.carrito');
Route::get('/registro-datos', [DataRegisterController::class, 'register'])->name('shop.registrodatos');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
