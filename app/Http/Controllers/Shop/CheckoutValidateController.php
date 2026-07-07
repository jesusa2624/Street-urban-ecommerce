<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CheckoutValidateController extends Controller
{
  public function index()
  {
    return Inertia::render('Shop/ConfirmarPedido', []);
  }
}
