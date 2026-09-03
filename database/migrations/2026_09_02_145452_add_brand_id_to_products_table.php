<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('brand_id')->nullable()->after('brand')->constrained('brands')->nullOnDelete();
        });

        // Migra cada marca de texto existente hacia la tabla brands, y enlaza el producto.
        $products = DB::table('products')->whereNotNull('brand')->where('brand', '!=', '')->get(['id', 'brand']);

        foreach ($products as $product) {
            $name = trim($product->brand);
            $slug = Str::slug($name);

            $brandId = DB::table('brands')->where('slug', $slug)->value('id');

            if (!$brandId) {
                $brandId = DB::table('brands')->insertGetId([
                    'name' => $name,
                    'slug' => $slug,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('products')->where('id', $product->id)->update(['brand_id' => $brandId]);
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('brand');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('brand')->nullable()->after('brand_id');
        });

        $products = DB::table('products')->whereNotNull('brand_id')->get(['id', 'brand_id']);

        foreach ($products as $product) {
            $brandName = DB::table('brands')->where('id', $product->brand_id)->value('name');
            DB::table('products')->where('id', $product->id)->update(['brand' => $brandName]);
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('brand_id');
        });
    }
};
