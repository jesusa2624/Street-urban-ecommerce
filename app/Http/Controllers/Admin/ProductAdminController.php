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
        try {
            $response = Http::timeout(5)->get("{$this->apiUrl}/products?per_page=100");
            $products = $response->successful() ? $response->json()['data'] ?? [] : [];
        } catch (\Exception $e) {
            $products = [];
        }

        try {
            $categoriesResponse = Http::timeout(5)->get("{$this->apiUrl}/categories?per_page=100");
            $categories = $categoriesResponse->successful() ? $categoriesResponse->json()['data'] ?? [] : [];
        } catch (\Exception $e) {
            $categories = [];
        }

        return Inertia::render('Admin/Products/Index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        try {
            $response = Http::timeout(5)->get("{$this->apiUrl}/categories?per_page=100");
            $categories = $response->successful() ? $response->json()['data'] ?? [] : [];
        } catch (\Exception $e) {
            $categories = [];
        }

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
        try {
            $response = Http::timeout(5)->get("{$this->apiUrl}/products/{$id}");
            $product = $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            $product = null;
        }

        try {
            $categoriesResponse = Http::timeout(5)->get("{$this->apiUrl}/categories?per_page=100");
            $categories = $categoriesResponse->successful() ? $categoriesResponse->json()['data'] ?? [] : [];
        } catch (\Exception $e) {
            $categories = [];
        }

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
