<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ProductController extends Controller
{
    private function getProducts()
    {
        return [
            [
                'id' => 1,
                'name' => 'Zapatillas Running Pro',
                'description' => 'Amortiguación máxima para asfalto.',
                'price' => 120,
                'category' => 'Calzados',
                'brand' => 'Nike',
                'stock' => true,
                'rating' => 4.8,
                'sold' => 245,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 2,
                'name' => 'Polera Hoodie Oversize',
                'description' => 'Algodón pesado 100% peruano.',
                'price' => 45,
                'category' => 'Ropa',
                'brand' => 'Carhartt WIP',
                'stock' => true,
                'rating' => 4.6,
                'sold' => 189,
                'image' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 3,
                'name' => 'Gorra Trucker Urbana',
                'description' => 'Ajustable con malla transpirable.',
                'price' => 25,
                'category' => 'Sombrería',
                'brand' => 'Nike',
                'stock' => true,
                'rating' => 4.5,
                'sold' => 312,
                'image' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 4,
                'name' => 'Mochila Tech Impermeable',
                'description' => 'Compartimiento acolchado para laptop.',
                'price' => 85,
                'category' => 'Accesorios',
                'brand' => 'The North Face',
                'stock' => false,
                'rating' => 4.9,
                'sold' => 156,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 5,
                'name' => 'Pantalón Cargo Street',
                'description' => 'Bolsillos múltiples y ajuste relajado.',
                'price' => 60,
                'category' => 'Ropa',
                'brand' => 'Carhartt WIP',
                'stock' => true,
                'rating' => 4.7,
                'sold' => 223,
                'image' => 'https://images.pexels.com/photos/1055691/pexels-photo-1055691.jpeg?auto=compress&cs=tinysrgb&w=800'
            ],
            [
                'id' => 6,
                'name' => 'Camiseta Graphic Tee',
                'description' => 'Diseño exclusivo Street Urban.',
                'price' => 30,
                'category' => 'Ropa',
                'brand' => 'Stüssy',
                'stock' => true,
                'rating' => 4.4,
                'sold' => 178,
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 7,
                'name' => 'Chaqueta Bomber Black',
                'description' => 'Estilo clásico, ajuste moderno.',
                'price' => 110,
                'category' => 'Ropa',
                'brand' => 'The North Face',
                'stock' => true,
                'rating' => 4.9,
                'sold' => 134,
                'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 8,
                'name' => 'Sneakers White Luxe',
                'description' => 'Cuero premium, suela minimalista.',
                'price' => 140,
                'category' => 'Calzados',
                'brand' => 'Adidas',
                'stock' => true,
                'rating' => 4.7,
                'sold' => 267,
                'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 9,
                'name' => 'Joggers Urban Fit',
                'description' => 'Comodidad total para el día a día.',
                'price' => 50,
                'category' => 'Ropa',
                'brand' => 'Adidas',
                'stock' => true,
                'rating' => 4.6,
                'sold' => 198,
                'image' => 'https://images.pexels.com/photos/1055691/pexels-photo-1055691.jpeg?auto=compress&cs=tinysrgb&w=800'
            ],
            [
                'id' => 10,
                'name' => 'Accesorio Cadena Plata',
                'description' => 'Acero inoxidable 316L.',
                'price' => 35,
                'category' => 'Accesorios',
                'brand' => 'Supreme',
                'stock' => true,
                'rating' => 4.8,
                'sold' => 145,
                'image' => 'https://images.pexels.com/photos/437037/pexels-photo-437037.jpeg?auto=compress&cs=tinysrgb&w=800'
            ],
            [
                'id' => 11,
                'name' => 'Windbreaker Neon',
                'description' => 'Corta vientos reflectante.',
                'price' => 90,
                'category' => 'Ropa',
                'brand' => 'Puma',
                'stock' => true,
                'rating' => 4.5,
                'sold' => 167,
                'image' => 'https://images.unsplash.com/photo-1544022613-e87ca75a784a?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'id' => 12,
                'name' => 'Beanie Wool Black',
                'description' => 'Lana tejida, ajuste perfecto.',
                'price' => 20,
                'category' => 'Sombrería',
                'brand' => 'Carhartt WIP',
                'stock' => true,
                'rating' => 4.7,
                'sold' => 289,
                'image' => 'https://images.pexels.com/photos/3973661/pexels-photo-3973661.jpeg?auto=compress&cs=tinysrgb&w=800'
            ],
        ];
    }

    public function index()
    {
        return Inertia::render('Shop/Home', [
            'products' => $this->getProducts()
        ]);
    }

    public function shop()
    {
        return Inertia::render('Shop/Tienda', [
            'products' => $this->getProducts()
        ]);
    }
}
