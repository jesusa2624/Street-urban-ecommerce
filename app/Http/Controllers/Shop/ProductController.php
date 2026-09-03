<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    private function mapProduct(Product $p): array
    {
        $colores = $p->colors
            ->map(fn ($c) => [
                'id' => $c->id,
                'nombre' => $c->name,
                'hex' => $c->hex,
                'imagen' => $c->image_url ? Storage::disk('public')->url($c->image_url) : null,
                'tallas' => $c->variants
                    ->map(fn ($v) => [
                        'talla' => $v->size,
                        'stock' => $v->stock,
                        'precio' => (float) ($v->price ?? $p->price),
                    ])
                    ->values(),
            ])
            ->filter(fn ($c) => $c['tallas']->count() > 0)
            ->map(fn ($c) => $c + ['precio' => $c['tallas']->min('precio')])
            ->values();

        $colorConFoto = $p->colors->first(fn ($c) => $c->image_url);
        $precioBase = $colores->isNotEmpty() ? $colores->min('precio') : (float) $p->price;

        return [
            'id' => $p->id,
            'name' => $p->name,
            'description' => $p->description,
            'price' => (float) $precioBase,
            'category' => $p->category->name ?? 'Sin categoría',
            'brand' => $p->brand->name ?? 'Sin marca',
            'stock' => $p->stock > 0,
            'rating' => 4.5,
            'sold' => 0,
            'image' => $colorConFoto ? Storage::disk('public')->url($colorConFoto->image_url) : null,
            'colores' => $colores,
        ];
    }

    private function getProducts()
    {
        return Product::with(['brand', 'category', 'colors.variants'])
            ->where('active', true)
            ->orderByDesc('created_at')
            ->get()
            ->map(fn ($p) => $this->mapProduct($p));
    }

    // Deriva las categorías a mostrar en el Home directo de los productos activos,
    // usando la foto de uno de sus productos como imagen. Así, al agregar una
    // categoría nueva (ej. "Medias") aparece sola, sin tocar código.
    private function getCategories($products)
    {
        return $products
            ->groupBy('category')
            ->map(function ($group, $name) {
                $conFoto = $group->firstWhere('image', '!=', null) ?? $group->first();

                return [
                    'name' => $name,
                    'image' => $conFoto['image'] ?? null,
                    'count' => $group->count(),
                ];
            })
            ->values();
    }

    public function index()
    {
        $products = $this->getProducts();

        return Inertia::render('Shop/Home', [
            'products' => $products,
            'categories' => $this->getCategories($products),
        ]);
    }

    public function shop()
    {
        return Inertia::render('Shop/Tienda', [
            'products' => $this->getProducts()
        ]);
    }

    public function show(Product $producto)
    {
        $producto->load(['brand', 'category', 'colors.variants']);

        return Inertia::render('Shop/ProductDetail', [
            'producto' => $this->mapProduct($producto),
        ]);
    }
}
