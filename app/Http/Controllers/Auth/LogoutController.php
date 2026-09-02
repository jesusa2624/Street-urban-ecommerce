<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout()
    {
        Auth::guard('web')->logout();
        Auth::guard('customer')->logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }
}
