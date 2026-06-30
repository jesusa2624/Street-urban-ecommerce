<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Shop\ProductController; // <-- 1. Agregamos esta línea arriba
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Rutas de la tienda
Route::get('/', [ProductController::class, 'index'])->name('shop.home');
Route::get('/tienda', [ProductController::class, 'shop'])->name('shop.tienda');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
