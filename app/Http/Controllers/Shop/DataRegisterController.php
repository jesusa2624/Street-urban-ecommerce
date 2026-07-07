<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DataRegisterController extends Controller
{
  public function index()
  {
    return Inertia::render('Shop/RegistroDatos', []);
  }

  public function validateRegisterForm(Request $request)
  {
    // Validación en el servidor
    $validatedData = $request->validate([
      'docType' => 'required|in:DNI,RUC',
      'docNumber' => 'required|string|max:20',
      'name' => 'required|string|max:255',
      'email' => 'required|email',
      'phone' => 'required|regex:/^[0-9]{9}$/',
    ]);

    // Si la validación pasa, redirigir a la pantalla de verificación
    return to_route('shop.confirmarpedido');
  }
}
