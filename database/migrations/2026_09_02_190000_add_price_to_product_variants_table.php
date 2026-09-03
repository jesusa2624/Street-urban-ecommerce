<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable()->after('cost');
        });

        // Cada variante empieza con el precio de venta que tenía su producto hasta ahora;
        // de aquí en adelante cada compra actualiza el precio de SU propia variante.
        DB::table('product_variants')
            ->join('products', 'products.id', '=', 'product_variants.product_id')
            ->update(['product_variants.price' => DB::raw('products.price')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
