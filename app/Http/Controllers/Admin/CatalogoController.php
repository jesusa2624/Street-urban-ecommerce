<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CatalogoController extends Controller
{
    public function index()
    {
        $productos = Product::with('category')
            ->withCount('variants')
            ->orderBy('name')
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'nombre' => $p->name,
                'marca' => $p->brand,
                'categoria' => $p->category->name ?? '-',
                'stock' => $p->stock,
                'precioVenta' => (float) $p->price,
                'variantes' => $p->variants_count,
            ]);

        $marcasPorCategoria = Product::with('category')
            ->whereNotNull('brand')->where('brand', '!=', '')
            ->get()
            ->groupBy(fn ($p) => $p->category->name ?? 'Sin categoría')
            ->map(fn ($group) => $group->pluck('brand')->unique()->sort()->values());

        return Inertia::render('Admin/Catalogo/Index', [
            'productos' => $productos,
            'categorias' => Category::orderBy('name')->pluck('name'),
            'marcas' => Product::whereNotNull('brand')->where('brand', '!=', '')->distinct()->orderBy('brand')->pluck('brand'),
            'marcasPorCategoria' => $marcasPorCategoria,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
        ]);

        $existe = Product::whereRaw('LOWER(TRIM(name)) = ?', [mb_strtolower(trim($validated['nombre']))])
            ->whereRaw('LOWER(TRIM(brand)) = ?', [mb_strtolower(trim($validated['marca']))])
            ->exists();

        if ($existe) {
            return back()->withErrors(['nombre' => 'Ya existe un modelo con ese nombre y esa marca.']);
        }

        $category = Category::firstOrCreate(
            ['slug' => Str::slug($validated['categoria'])],
            ['name' => $validated['categoria'], 'active' => true]
        );

        Product::create([
            'name' => trim($validated['nombre']),
            'brand' => trim($validated['marca']),
            'category_id' => $category->id,
            'description' => '',
            'sku' => strtoupper(Str::slug($validated['nombre'] . '-' . $validated['marca'])) . '-' . Str::random(4),
            'price' => 0,
            'cost' => 0,
            'stock' => 0,
            'image_url' => null,
            'active' => true,
        ]);

        return redirect()->route('admin.catalogo.index')->with('success', 'Modelo registrado en el catálogo.');
    }

    public function update(Request $request, Product $producto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
        ]);

        $existe = Product::whereRaw('LOWER(TRIM(name)) = ?', [mb_strtolower(trim($validated['nombre']))])
            ->whereRaw('LOWER(TRIM(brand)) = ?', [mb_strtolower(trim($validated['marca']))])
            ->where('id', '!=', $producto->id)
            ->exists();

        if ($existe) {
            return back()->withErrors(['nombre' => 'Ya existe otro modelo con ese nombre y esa marca.']);
        }

        $category = Category::firstOrCreate(
            ['slug' => Str::slug($validated['categoria'])],
            ['name' => $validated['categoria'], 'active' => true]
        );

        $producto->update([
            'name' => trim($validated['nombre']),
            'brand' => trim($validated['marca']),
            'category_id' => $category->id,
        ]);

        return redirect()->route('admin.catalogo.index')->with('success', 'Modelo actualizado.');
    }

    public function destroy(Product $producto)
    {
        if ($producto->stock > 0 || $producto->variants()->exists()) {
            return back()->withErrors(['error' => 'No se puede eliminar: tiene stock o compras registradas asociadas.']);
        }

        $producto->delete();

        return redirect()->route('admin.catalogo.index')->with('success', 'Modelo eliminado del catálogo.');
    }
}
