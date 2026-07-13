<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Camisetas',
            'description' => 'Camisetas urbanas y deportivas',
            'slug' => 'camisetas',
            'active' => true,
        ]);

        Category::create([
            'name' => 'Pantalones',
            'description' => 'Pantalones de diversos estilos',
            'slug' => 'pantalones',
            'active' => true,
        ]);

        Category::create([
            'name' => 'Accesorios',
            'description' => 'Accesorios y complementos urbanos',
            'slug' => 'accesorios',
            'active' => true,
        ]);

        Category::create([
            'name' => 'Calzado',
            'description' => 'Zapatos y zapatillas',
            'slug' => 'calzado',
            'active' => true,
        ]);
    }
}
