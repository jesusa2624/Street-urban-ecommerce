<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

// Protegido por el middleware admin.only (ver routes/web.php) — solo un administrador
// puede cambiar estos datos, ya que afectan lo que ven los clientes en toda la tienda.
class BusinessSettingController extends Controller
{
    public function edit()
    {
        return Inertia::render('Admin/Settings/Edit', [
            'settings' => BusinessSetting::current(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'ruc' => 'nullable|string|max:20',
            'low_stock_threshold' => 'required|integer|min:1|max:1000',
        ]);

        BusinessSetting::current()->update($validated);

        return redirect()->route('admin.settings.edit')->with('success', 'Datos del negocio actualizados.');
    }
}
