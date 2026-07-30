<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
  /**
   * Retorna la vista de contacto.
   */
  public function index()
  {
    return Inertia::render('Shop/Contacto', []);
  }

  /**
   * Valida y guarda los datos de contacto en la base de datos
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'message' => 'required|string',
    ]);

    Contact::create($validated);

    return redirect()->back()->with('success', 'Gracias por contactarnos. Te responderemos pronto.');
  }
}
