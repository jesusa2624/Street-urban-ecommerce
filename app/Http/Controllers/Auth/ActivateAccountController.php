<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\VerificationToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ActivateAccountController extends Controller
{
    private function getProducts()
    {
        return [
            ['id' => 1, 'name' => 'Zapatillas Running Pro', 'description' => 'Amortiguación máxima para asfalto.', 'price' => 120, 'category' => 'Calzados', 'brand' => 'Nike', 'stock' => true, 'rating' => 4.8, 'sold' => 245, 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=800&auto=format&fit=crop'],
            ['id' => 2, 'name' => 'Polera Hoodie Oversize', 'description' => 'Algodón pesado 100% peruano.', 'price' => 45, 'category' => 'Ropa', 'brand' => 'Carhartt WIP', 'stock' => true, 'rating' => 4.6, 'sold' => 189, 'image' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?q=80&w=800&auto=format&fit=crop'],
            ['id' => 3, 'name' => 'Gorra Trucker Urbana', 'description' => 'Ajustable con malla transpirable.', 'price' => 25, 'category' => 'Sombrería', 'brand' => 'Nike', 'stock' => true, 'rating' => 4.5, 'sold' => 312, 'image' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?q=80&w=800&auto=format&fit=crop'],
            ['id' => 4, 'name' => 'Mochila Tech Impermeable', 'description' => 'Compartimiento acolchado para laptop.', 'price' => 85, 'category' => 'Accesorios', 'brand' => 'The North Face', 'stock' => false, 'rating' => 4.9, 'sold' => 156, 'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?q=80&w=800&auto=format&fit=crop'],
            ['id' => 5, 'name' => 'Pantalón Cargo Street', 'description' => 'Bolsillos múltiples y ajuste relajado.', 'price' => 60, 'category' => 'Ropa', 'brand' => 'Carhartt WIP', 'stock' => true, 'rating' => 4.7, 'sold' => 223, 'image' => 'https://images.pexels.com/photos/1055691/pexels-photo-1055691.jpeg?auto=compress&cs=tinysrgb&w=800'],
            ['id' => 6, 'name' => 'Camiseta Graphic Tee', 'description' => 'Diseño exclusivo Street Urban.', 'price' => 30, 'category' => 'Ropa', 'brand' => 'Stüssy', 'stock' => true, 'rating' => 4.4, 'sold' => 178, 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=800&auto=format&fit=crop'],
            ['id' => 7, 'name' => 'Chaqueta Bomber Black', 'description' => 'Estilo clásico, ajuste moderno.', 'price' => 110, 'category' => 'Ropa', 'brand' => 'The North Face', 'stock' => true, 'rating' => 4.9, 'sold' => 134, 'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=800&auto=format&fit=crop'],
            ['id' => 8, 'name' => 'Sneakers White Luxe', 'description' => 'Cuero premium, suela minimalista.', 'price' => 140, 'category' => 'Calzados', 'brand' => 'Adidas', 'stock' => true, 'rating' => 4.7, 'sold' => 267, 'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=800&auto=format&fit=crop'],
            ['id' => 9, 'name' => 'Joggers Urban Fit', 'description' => 'Comodidad total para el día a día.', 'price' => 50, 'category' => 'Ropa', 'brand' => 'Adidas', 'stock' => true, 'rating' => 4.6, 'sold' => 198, 'image' => 'https://images.pexels.com/photos/1055691/pexels-photo-1055691.jpeg?auto=compress&cs=tinysrgb&w=800'],
            ['id' => 10, 'name' => 'Accesorio Cadena Plata', 'description' => 'Acero inoxidable 316L.', 'price' => 35, 'category' => 'Accesorios', 'brand' => 'Supreme', 'stock' => true, 'rating' => 4.8, 'sold' => 145, 'image' => 'https://images.pexels.com/photos/437037/pexels-photo-437037.jpeg?auto=compress&cs=tinysrgb&w=800'],
            ['id' => 11, 'name' => 'Windbreaker Neon', 'description' => 'Corta vientos reflectante.', 'price' => 90, 'category' => 'Ropa', 'brand' => 'Puma', 'stock' => true, 'rating' => 4.5, 'sold' => 167, 'image' => 'https://images.unsplash.com/photo-1544022613-e87ca75a784a?q=80&w=800&auto=format&fit=crop'],
            ['id' => 12, 'name' => 'Beanie Wool Black', 'description' => 'Lana tejida, ajuste perfecto.', 'price' => 20, 'category' => 'Sombrería', 'brand' => 'Carhartt WIP', 'stock' => true, 'rating' => 4.7, 'sold' => 289, 'image' => 'https://images.pexels.com/photos/3973661/pexels-photo-3973661.jpeg?auto=compress&cs=tinysrgb&w=800'],
        ];
    }
    public function show(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');
        $skipVerification = $request->query('skip-verification');

        // Si viene con skip-verification, es un email que ya fue verificado
        if ($skipVerification && $email) {
            return Inertia::render('Auth/ActivateAccount', [
                'token' => null,
                'email' => $email,
                'isValid' => true,
                'skipVerification' => true,
            ]);
        }

        if (!$token || !$email) {
            return Inertia::render('Auth/ActivateAccount', [
                'error' => 'Token o email inválido',
                'isValid' => false,
            ]);
        }

        // Verificar que el token sea válido
        $isValid = VerificationToken::isValidToken($email, $token);

        if (!$isValid) {
            return Inertia::render('Auth/ActivateAccount', [
                'error' => 'Token expirado o inválido',
                'isValid' => false,
            ]);
        }

        return Inertia::render('Auth/ActivateAccount', [
            'token' => $token,
            'email' => $email,
            'isValid' => true,
            'skipVerification' => false,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'token' => 'nullable|string',
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'skipVerification' => 'nullable|boolean',
        ]);

        try {
            // Verificar token válido (solo si no es skip-verification)
            if (!$validated['skipVerification'] && !VerificationToken::isValidToken($validated['email'], $validated['token'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token inválido o expirado',
                ], 400);
            }

            // Verificar si el cliente ya existe
            $customer = Customer::where('email', $validated['email'])->first();

            if ($customer && !$validated['skipVerification']) {
                // Cliente existe con contraseña en registro normal
                return response()->json([
                    'success' => false,
                    'message' => 'El email ya está registrado',
                ], 400);
            }

            if ($customer && $validated['skipVerification']) {
                // Actualizar contraseña del cliente existente (sin contraseña)
                $customer->update([
                    'password' => Hash::make($validated['password']),
                ]);
            } else if (!$customer) {
                // Crear nuevo cliente solo si no existe
                $customer = Customer::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'password' => Hash::make($validated['password']),
                    'email_verified_at' => now(),
                ]);
            }

            // Marcar token como verificado (solo si no es skip-verification)
            if (!$validated['skipVerification']) {
                VerificationToken::markAsVerified($validated['email'], $validated['token']);
            }

            // Auto-login del cliente usando guard web directo
            Auth::login($customer);

            return response()->json([
                'success' => true,
                'message' => 'Cuenta activada correctamente',
                'redirect' => '/',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la cuenta: ' . $e->getMessage(),
            ], 500);
        }
    }
}
