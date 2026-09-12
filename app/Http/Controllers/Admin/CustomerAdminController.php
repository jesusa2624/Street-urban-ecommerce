<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CustomerAdminController extends Controller
{
    public function index()
    {
        $customers = Customer::orderByDesc('created_at')
            ->get()
            ->map(fn ($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'email' => $c->email,
                'phone' => $c->phone,
                'activa' => $c->email_verified_at !== null,
                'registrado' => $c->created_at->format('d/m/Y'),
            ]);

        return Inertia::render('Admin/Customers/Index', [
            'customers' => $customers,
        ]);
    }

    // El alta ahora se hace desde un modal en el índice; esta ruta se deja por si algo
    // la visita directamente (la genera Route::resource), pero no tiene vista propia.
    public function create()
    {
        return redirect()->route('admin.customers.index');
    }

    // Un cliente registrado desde el admin (ej. durante una venta en tienda física) no
    // necesita ni tiene por qué tener acceso a la web — solo se guarda su nombre/contacto
    // para historial. Se crea con una contraseña aleatoria e inutilizable; si más adelante
    // quiere comprar online, activa su cuenta él mismo con su email (flujo de activate-account),
    // que ya sabe reconocer a un cliente existente sin contraseña real.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'nullable',
                'email',
                'unique:customers,email',
                Rule::notIn(User::pluck('email')->all()),
            ],
            'phone' => 'nullable|string|max:20',
        ], [
            'email.not_in' => 'Ese correo ya está en uso por una cuenta de staff.',
        ]);

        Customer::create([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make(Str::random(40)),
        ]);

        return redirect()->route('admin.customers.index')->with('success', 'Cliente registrado exitosamente.');
    }

    public function edit(Customer $customer)
    {
        return Inertia::render('Admin/Customers/Edit', [
            'customer' => $customer,
        ]);
    }

    // Historial de compras de un cliente, para el botón aparte en la tabla de Clientes
    // (no es parte del formulario de edición — son dos acciones distintas).
    public function historial(Customer $customer)
    {
        $ventas = $customer->sales()
            ->with('items.variant.product', 'items.variant.productColor')
            ->orderByDesc('sale_date')
            ->orderByDesc('id')
            ->get()
            ->map(function ($v) {
                $nombres = $v->items->pluck('variant.product.name')->unique()->values();
                $producto = $nombres->count() <= 1
                    ? ($nombres->first() ?? 'Sin prendas')
                    : "{$nombres->first()} + " . ($nombres->count() - 1) . ' más';

                // Una venta puede incluir varios colores del mismo modelo — se muestran
                // hasta 3 y se resume el resto, en vez de aparentar que solo hubo un color.
                $coloresUnicos = $v->items->map(fn ($i) => $i->variant->productColor)->filter()->unique('id')->values();

                return [
                    'id' => $v->id,
                    'numero' => 'V-' . str_pad($v->id, 5, '0', STR_PAD_LEFT),
                    'fecha' => $v->sale_date->format('d/m/Y'),
                    'producto' => $producto,
                    'colores' => $coloresUnicos->take(3)->pluck('hex')->values(),
                    'masColores' => max(0, $coloresUnicos->count() - 3),
                    'total' => (float) $v->total,
                    'cancelada' => $v->cancelled_at !== null,
                ];
            });

        $vigentes = $ventas->reject('cancelada');

        return response()->json([
            'ventas' => $ventas,
            'stats' => [
                'totalCompras' => $vigentes->count(),
                'totalGastado' => $vigentes->sum('total'),
            ],
        ]);
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $customer->update($validated);

        return redirect()->route('admin.customers.index')->with('success', 'Cliente actualizado exitosamente');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Cliente eliminado exitosamente');
    }
}
