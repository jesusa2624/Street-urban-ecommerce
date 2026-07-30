<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\DataRegisterController;
use App\Http\Controllers\Shop\CheckoutValidateController;
use App\Http\Controllers\Shop\ContactController;
use App\Http\Controllers\Shop\AboutController;
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
Route::name('shop.')->group(function () {
  // Páginas principales
  Route::get('/', [ProductController::class, 'index'])->name('home');
  Route::get('/tienda', [ProductController::class, 'shop'])->name('tienda');
  Route::get('/contacto', [ContactController::class, 'index'])->name('contacto');
  Route::get('/nosotros', [AboutController::class, 'index'])->name('nosotros');

  // Carrito y checkout
  Route::get('/carrito', [CartController::class, 'cart'])->name('carrito');
  Route::get('/registro-datos', [DataRegisterController::class, 'index'])->name('registrodatos');
  Route::post('/validar-registro', [DataRegisterController::class, 'validateRegisterForm'])->name('validateRegisterForm');
  Route::get('/confirmar-pedido', [CheckoutValidateController::class, 'index'])->name('confirmarpedido');

  // Páginas legales y atención
  Route::get('/terminos-y-condiciones', function () {
    return Inertia::render('Shop/Legal/Terminos');
  })->name('terminos');
  Route::get('/politica-de-privacidad', function () {
    return Inertia::render('Shop/Legal/Privacidad');
  })->name('privacidad');
  Route::get('/cambios-y-devoluciones', function () {
    return Inertia::render('Shop/Legal/CambiosDevoluciones');
  })->name('cambios');
  Route::get('/libro-de-reclamaciones', function () {
    return Inertia::render('Shop/Legal/Reclamaciones');
  })->name('reclamaciones');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
