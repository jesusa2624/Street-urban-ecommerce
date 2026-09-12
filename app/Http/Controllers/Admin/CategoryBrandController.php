<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoryBrandController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Settings/Taxonomias', [
            'categorias' => Category::withCount('products')->orderBy('name')->get()
                ->map(fn ($c) => $this->mapItem($c)),
            'marcas' => Brand::withCount('products')->orderBy('name')->get()
                ->map(fn ($m) => $this->mapItem($m)),
        ]);
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
        ]);

        Category::create([
            'name' => trim($validated['name']),
            'description' => $validated['description'] ?? null,
            'slug' => $this->uniqueSlug(Category::class, $validated['name']),
            'active' => true,
        ]);

        return back()->with('success', 'Categoría creada correctamente.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $category->update([
            'name' => trim($validated['name']),
            'description' => $validated['description'] ?? null,
            'slug' => $this->uniqueSlug(Category::class, $validated['name'], $category->id),
        ]);

        return back()->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroyCategory(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->withErrors(['error' => "No puedes eliminar \"{$category->name}\": tiene productos asociados."]);
        }

        $category->delete();

        return back()->with('success', 'Categoría eliminada correctamente.');
    }

    public function storeBrand(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'description' => 'nullable|string|max:1000',
        ]);

        Brand::create([
            'name' => trim($validated['name']),
            'description' => $validated['description'] ?? null,
            'slug' => $this->uniqueSlug(Brand::class, $validated['name']),
            'active' => true,
        ]);

        return back()->with('success', 'Marca creada correctamente.');
    }

    public function updateBrand(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $brand->update([
            'name' => trim($validated['name']),
            'description' => $validated['description'] ?? null,
            'slug' => $this->uniqueSlug(Brand::class, $validated['name'], $brand->id),
        ]);

        return back()->with('success', 'Marca actualizada correctamente.');
    }

    public function destroyBrand(Brand $brand)
    {
        if ($brand->products()->exists()) {
            return back()->withErrors(['error' => "No puedes eliminar \"{$brand->name}\": tiene productos asociados."]);
        }

        $brand->delete();

        return back()->with('success', 'Marca eliminada correctamente.');
    }

    private function mapItem($item): array
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'description' => $item->description,
            'productos' => $item->products_count,
        ];
    }

    private function uniqueSlug(string $model, string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;

        while ($model::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
