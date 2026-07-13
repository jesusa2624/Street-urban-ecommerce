<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CustomerAdminController extends Controller
{
    public function index()
    {
        $customers = User::paginate(10);
        return Inertia::render('Admin/Customers/Index', [
            'customers' => $customers,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Customers/Create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed',
            ]);

            $validated['password'] = bcrypt($validated['password']);

            \Log::info('Creando usuario:', $validated);

            $user = User::create($validated);

            \Log::info('Usuario creado:', ['id' => $user->id, 'email' => $user->email]);

            return redirect()->route('admin.customers.index')->with('success', 'Cliente creado exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error al crear usuario: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(User $customer)
    {
        return Inertia::render('Admin/Customers/Edit', [
            'customer' => $customer,
        ]);
    }

    public function update(Request $request, User $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
        ]);

        $customer->update($validated);

        return redirect()->route('admin.customers.index')->with('success', 'Cliente actualizado exitosamente');
    }

    public function destroy(User $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Cliente eliminado exitosamente');
    }
}
