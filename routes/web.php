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
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\CatalogoController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ActivateAccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

// Rutas de administración
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');

    Route::resource('products', ProductAdminController::class, ['as' => 'admin']);
    Route::resource('customers', CustomerAdminController::class, ['as' => 'admin']);

    Route::get('/compras', [PurchaseController::class, 'index'])->name('admin.purchases.index');
    Route::post('/compras', [PurchaseController::class, 'store'])->name('admin.purchases.store');
    Route::get('/compras/buscar-productos', [PurchaseController::class, 'searchProducts'])->name('admin.purchases.search');
    Route::get('/compras/variantes/{variant}/lotes', [PurchaseController::class, 'lotes'])->name('admin.purchases.lotes');
    Route::get('/compras/historial', [PurchaseController::class, 'historial'])->name('admin.purchases.historial');
    Route::get('/compras/reportes', [PurchaseController::class, 'reportes'])->name('admin.purchases.reportes');

    Route::get('/catalogo', [CatalogoController::class, 'index'])->name('admin.catalogo.index');
    Route::post('/catalogo', [CatalogoController::class, 'store'])->name('admin.catalogo.store');
    Route::patch('/catalogo/{producto}', [CatalogoController::class, 'update'])->name('admin.catalogo.update');
    Route::delete('/catalogo/{producto}', [CatalogoController::class, 'destroy'])->name('admin.catalogo.destroy');
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de autenticación (públicas)
Route::get('/login', fn() => redirect('/') )->name('login');
Route::post('/api/auth/check-email', [VerificationController::class, 'checkEmail']);
Route::post('/api/auth/send-verification-email', [VerificationController::class, 'sendVerificationEmail']);
Route::post('/auth/login-action', [LoginController::class, 'loginAction'])->name('auth.login-action');
Route::post('/api/auth/login', [LoginController::class, 'login']);
Route::post('/auth/logout', [LogoutController::class, 'logout'])->name('auth.logout');

// Rutas de activación de cuenta (públicas)
Route::get('/activate-account', [ActivateAccountController::class, 'show'])->name('activate-account.show');
Route::post('/api/auth/activate-account', [ActivateAccountController::class, 'store'])->name('activate-account.store');

require __DIR__.'/auth.php';
