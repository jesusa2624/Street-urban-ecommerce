<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class CartController extends Controller
{
  public function cart()
  {
    return Inertia::render('Shop/Carrito', []);
  }
}
