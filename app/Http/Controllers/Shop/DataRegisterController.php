<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateRegisterRequest;
use Inertia\Inertia;

class DataRegisterController extends Controller
{
  public function index()
  {
    return Inertia::render('Shop/RegistroDatos', []);
  }

  public function validateRegisterForm(ValidateRegisterRequest $request)
  {
    return to_route('shop.confirmarpedido');
  }
}
