<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductAdminController extends Controller
{
    private $apiUrl = 'http://localhost:8000/api';

    public function index()
    {
        $response = Http::get("{$this->apiUrl}/products?per_page=100");
        $products = $response->json()['data'] ?? [];

        $categoriesResponse = Http::get("{$this->apiUrl}/categories?per_page=100");
        $categories = $categoriesResponse->json()['data'] ?? [];

        return Inertia::render('Admin/Products/Index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $response = Http::get("{$this->apiUrl}/categories?per_page=100");
        $categories = $response->json()['data'] ?? [];

        return Inertia::render('Admin/Products/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'sku' => 'required|string',
            'price' => 'required|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|integer',
            'image_url' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $response = Http::post("{$this->apiUrl}/products", $validated);

        if ($response->successful()) {
            return redirect()->route('admin.products.index')->with('success', 'Producto creado exitosamente');
        }

        return back()->withErrors(['error' => 'Error al crear el producto']);
    }

    public function edit($id)
    {
        $response = Http::get("{$this->apiUrl}/products/{$id}");
        $product = $response->json();

        $categoriesResponse = Http::get("{$this->apiUrl}/categories?per_page=100");
        $categories = $categoriesResponse->json()['data'] ?? [];

        return Inertia::render('Admin/Products/Edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'string',
            'description' => 'nullable|string',
            'sku' => 'string',
            'price' => 'numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'stock' => 'integer|min:0',
            'category_id' => 'integer',
            'image_url' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $response = Http::patch("{$this->apiUrl}/products/{$id}", $validated);

        if ($response->successful()) {
            return redirect()->route('admin.products.index')->with('success', 'Producto actualizado exitosamente');
        }

        return back()->withErrors(['error' => 'Error al actualizar el producto']);
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->apiUrl}/products/{$id}");

        if ($response->successful()) {
            return redirect()->route('admin.products.index')->with('success', 'Producto eliminado exitosamente');
        }

        return back()->withErrors(['error' => 'Error al eliminar el producto']);
    }
}
