<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CatalogoController extends Controller
{
    public function index()
    {
        $productos = Product::with(['category', 'brand', 'variants'])
            ->withCount('variants')
            ->orderBy('name')
            ->get()
            ->map(function ($p) {
                // El precio de venta vive por variante (cada color/talla puede costar distinto,
                // ej. una edición limitada). Si aún no hay variantes se usa el precio base del modelo.
                $precioMin = $p->variants->min('price');
                $precioMax = $p->variants->max('price');

                return [
                    'id' => $p->id,
                    'nombre' => $p->name,
                    'marca' => $p->brand->name ?? '-',
                    'categoria' => $p->category->name ?? '-',
                    'descripcion' => $p->description,
                    'stock' => $p->stock,
                    'precioVenta' => (float) ($precioMin ?? $p->price),
                    'precioVentaMax' => ($precioMax !== null && (float) $precioMax !== (float) ($precioMin ?? $p->price)) ? (float) $precioMax : null,
                    'variantes' => $p->variants_count,
                ];
            });

        return Inertia::render('Admin/Catalogo/Index', [
            'productos' => $productos,
            'categorias' => Category::orderBy('name')->pluck('name'),
            'marcas' => Brand::orderBy('name')->pluck('name'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'marcaDescripcion' => 'nullable|string|max:1000',
            'categoria' => 'required|string|max:255',
            'categoriaDescripcion' => 'nullable|string|max:1000',
            'descripcion' => 'nullable|string|max:2000',
        ]);

        $brand = Brand::firstOrCreate(
            ['slug' => Str::slug($validated['marca'])],
            ['name' => trim($validated['marca']), 'description' => $validated['marcaDescripcion'] ?? null, 'active' => true]
        );

        $existe = Product::where('brand_id', $brand->id)
            ->whereRaw('LOWER(TRIM(name)) = ?', [mb_strtolower(trim($validated['nombre']))])
            ->exists();

        if ($existe) {
            return back()->withErrors(['nombre' => 'Ya existe un modelo con ese nombre y esa marca.']);
        }

        $category = Category::firstOrCreate(
            ['slug' => Str::slug($validated['categoria'])],
            ['name' => $validated['categoria'], 'description' => $validated['categoriaDescripcion'] ?? null, 'active' => true]
        );

        Product::create([
            'name' => trim($validated['nombre']),
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'description' => $validated['descripcion'] ?? '',
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
            'marcaDescripcion' => 'nullable|string|max:1000',
            'categoria' => 'required|string|max:255',
            'categoriaDescripcion' => 'nullable|string|max:1000',
            'descripcion' => 'nullable|string|max:2000',
        ]);

        $brand = Brand::firstOrCreate(
            ['slug' => Str::slug($validated['marca'])],
            ['name' => trim($validated['marca']), 'description' => $validated['marcaDescripcion'] ?? null, 'active' => true]
        );

        $existe = Product::where('brand_id', $brand->id)
            ->whereRaw('LOWER(TRIM(name)) = ?', [mb_strtolower(trim($validated['nombre']))])
            ->where('id', '!=', $producto->id)
            ->exists();

        if ($existe) {
            return back()->withErrors(['nombre' => 'Ya existe otro modelo con ese nombre y esa marca.']);
        }

        $category = Category::firstOrCreate(
            ['slug' => Str::slug($validated['categoria'])],
            ['name' => $validated['categoria'], 'description' => $validated['categoriaDescripcion'] ?? null, 'active' => true]
        );

        $producto->update([
            'name' => trim($validated['nombre']),
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'description' => $validated['descripcion'] ?? '',
        ]);

        return redirect()->route('admin.catalogo.index')->with('success', 'Modelo actualizado.');
    }

    public function variantes(Product $producto)
    {
        $variantes = $producto->variants()
            ->with('productColor')
            ->orderBy('size')
            ->get()
            ->sortBy(fn ($v) => $v->productColor->name ?? '')
            ->values()
            ->map(fn ($v) => [
                'id' => $v->id,
                'talla' => $v->size,
                'color' => $v->productColor->name ?? '-',
                'colorHex' => $v->productColor->hex ?? null,
                'stock' => $v->stock,
                'costo' => (float) $v->cost,
            ]);

        return response()->json($variantes);
    }

    public function colores(Product $producto)
    {
        $colores = $producto->colors()
            ->orderBy('name')
            ->get()
            ->map(fn ($c) => [
                'id' => $c->id,
                'nombre' => $c->name,
                'hex' => $c->hex,
                'imagenUrl' => $c->image_url ? Storage::disk('public')->url($c->image_url) : null,
            ]);

        return response()->json($colores);
    }

    public function storeColor(Request $request, Product $producto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'hex' => 'nullable|string|max:7',
            'imagen' => 'nullable|image|max:4096',
        ]);

        $existe = $producto->colors()
            ->whereRaw('LOWER(TRIM(name)) = ?', [mb_strtolower(trim($validated['nombre']))])
            ->exists();

        if ($existe) {
            return back()->withErrors(['nombre' => 'Este modelo ya tiene un color con ese nombre.']);
        }

        $imagePath = $request->hasFile('imagen')
            ? $request->file('imagen')->store('product-colors', 'public')
            : null;

        $producto->colors()->create([
            'name' => trim($validated['nombre']),
            'hex' => $validated['hex'] ?? null,
            'image_url' => $imagePath,
        ]);

        return back()->with('success', 'Color agregado.');
    }

    public function updateColor(Request $request, ProductColor $color)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'hex' => 'nullable|string|max:7',
            'imagen' => 'nullable|image|max:4096',
        ]);

        $existe = ProductColor::where('product_id', $color->product_id)
            ->whereRaw('LOWER(TRIM(name)) = ?', [mb_strtolower(trim($validated['nombre']))])
            ->where('id', '!=', $color->id)
            ->exists();

        if ($existe) {
            return back()->withErrors(['nombre' => 'Este modelo ya tiene otro color con ese nombre.']);
        }

        $imagePath = $color->image_url;
        if ($request->hasFile('imagen')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('imagen')->store('product-colors', 'public');
        }

        $color->update([
            'name' => trim($validated['nombre']),
            'hex' => $validated['hex'] ?? null,
            'image_url' => $imagePath,
        ]);

        return back()->with('success', 'Color actualizado.');
    }

    public function destroyColor(ProductColor $color)
    {
        if ($color->variants()->exists()) {
            return back()->withErrors(['error' => 'No se puede eliminar: hay compras registradas con este color.']);
        }

        if ($color->image_url) {
            Storage::disk('public')->delete($color->image_url);
        }

        $color->delete();

        return back()->with('success', 'Color eliminado.');
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
