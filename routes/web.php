<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\DataRegisterController;
use App\Http\Controllers\Shop\CheckoutValidateController;
use App\Http\Controllers\Shop\ContactController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\CustomerAdminController;

// Rutas de administración
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');

    Route::resource('products', ProductAdminController::class, ['as' => 'admin']);
    Route::resource('customers', CustomerAdminController::class, ['as' => 'admin']);
});

// Rutas de la tienda
Route::get('/', [ProductController::class, 'index'])->name('shop.home');
Route::get('/tienda', [ProductController::class, 'shop'])->name('shop.tienda');
Route::get('/carrito', [CartController::class, 'cart'])->name('shop.carrito');
Route::get('/registro-datos', [DataRegisterController::class, 'index'])->name('shop.registrodatos');
Route::get('/confirmar-pedido', [CheckoutValidateController::class, 'index'])->name('shop.confirmarpedido');
Route::get('/contacto', [ContactController::class, 'index'])->name('shop.contacto');
// Route::post('/contacto', [ContactController::class, 'store'])->name('shop.store');
Route::post('/validar-registro', [DataRegisterController::class, 'validateRegisterForm'])->name('shop.validateRegisterForm');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
