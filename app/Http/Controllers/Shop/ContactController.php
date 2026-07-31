<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use Inertia\Inertia;

class ContactController extends Controller
{
  public function index()
  {
    return Inertia::render('Shop/Contacto', []);
  }

  public function store(StoreContactRequest $request)
  {
    Contact::create($request->validated());

    return redirect()->back()->with('success', 'Gracias por contactarnos. Te responderemos pronto.');
  }
}
