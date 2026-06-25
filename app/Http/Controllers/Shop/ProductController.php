<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        // Un array con datos ficticios para probar el e-commerce
        $products = [
            [
                'id' => 1,
                'name' => 'Zapatillas Running Pro',
                'description' => 'Amortiguación máxima para asfalto.',
                'price' => 120,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 2,
                'name' => 'Polera Hoodie Oversize',
                'description' => 'Algodón pesado 100% peruano.',
                'price' => 45,
                'image' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 3,
                'name' => 'Gorra Trucker Urbana',
                'description' => 'Ajustable con malla transpirable.',
                'price' => 25,
                'image' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 4,
                'name' => 'Mochila Tech Impermeable',
                'description' => 'Compartimiento acolchado para laptop.',
                'price' => 85,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 5,
                'name' => 'Pantalón Cargo Street',
                'description' => 'Bolsillos múltiples y ajuste relajado.',
                'price' => 60,
                'image' => 'https://images.unsplash.com/photo-1593032465170-1e3f8c6b9f4d?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 6,
                'name' => 'Camiseta Graphic Tee',
                'description' => 'Diseño exclusivo Street Urban.',
                'price' => 30,
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 7,
                'name' => 'Chaqueta Bomber Black',
                'description' => 'Estilo clásico, ajuste moderno.',
                'price' => 110,
                'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 8,
                'name' => 'Sneakers White Luxe',
                'description' => 'Cuero premium, suela minimalista.',
                'price' => 140,
                'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 9,
                'name' => 'Joggers Urban Fit',
                'description' => 'Comodidad total para el día a día.',
                'price' => 50,
                'image' => 'https://images.unsplash.com/photo-1580487232645-567963703447?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 10,
                'name' => 'Accesorio Cadena Plata',
                'description' => 'Acero inoxidable 316L.',
                'price' => 35,
                'image' => 'https://images.unsplash.com/photo-1590548784585-6455f79c0f7f?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 11,
                'name' => 'Windbreaker Neon',
                'description' => 'Corta vientos reflectante.',
                'price' => 90,
                'image' => 'https://images.unsplash.com/photo-1544022613-e87ca75a784a?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 12,
                'name' => 'Beanie Wool Black',
                'description' => 'Lana tejida, ajuste perfecto.',
                'price' => 20,
                'image' => 'https://images.unsplash.com/photo-1576871337632-b9aef467560d?q=80&w=800&auto=format&fit=crop'
            ],
        ];

        // Renderizamos la vista de Vue que crearemos en el siguiente paso
        // Pasándole el array de productos como un "prop"
        return Inertia::render('Shop/Home', [
            'products' => $products
        ]);
    }
}
