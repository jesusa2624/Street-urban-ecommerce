<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        $products = [
            ['name' => 'Camiseta Urban Básica', 'category' => 1, 'price' => 29.99, 'stock' => 50],
            ['name' => 'Camiseta Streetwear Premium', 'category' => 1, 'price' => 49.99, 'stock' => 30],
            ['name' => 'Camiseta Oversized', 'category' => 1, 'price' => 39.99, 'stock' => 40],
            ['name' => 'Pantalón Jogger', 'category' => 2, 'price' => 59.99, 'stock' => 25],
            ['name' => 'Pantalón Cargo', 'category' => 2, 'price' => 69.99, 'stock' => 20],
            ['name' => 'Gorro Urban', 'category' => 3, 'price' => 19.99, 'stock' => 100],
            ['name' => 'Cinturón Piel', 'category' => 3, 'price' => 24.99, 'stock' => 80],
            ['name' => 'Zapatilla Alta', 'category' => 4, 'price' => 99.99, 'stock' => 15],
            ['name' => 'Zapatilla Baja', 'category' => 4, 'price' => 84.99, 'stock' => 35],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'description' => 'Producto de calidad superior con diseño urbano',
                'sku' => strtoupper(str_replace(' ', '-', $product['name'])),
                'price' => $product['price'],
                'cost' => $product['price'] * 0.4,
                'stock' => $product['stock'],
                'category_id' => $product['category'],
                'image_url' => 'https://via.placeholder.com/300',
                'active' => true,
            ]);
        }
    }
}
