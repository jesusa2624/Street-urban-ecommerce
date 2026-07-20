<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class AboutController extends Controller
{
  public function index()
  {
    return Inertia::render('Shop/Nosotros', []);
  }
}
