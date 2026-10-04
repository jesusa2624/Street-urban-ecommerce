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
        // Se actualiza fila por fila para mantener compatibilidad con MySQL y SQLite
        // (la suite de pruebas usa SQLite en memoria).
        DB::table('product_variants')
            ->select(['product_variants.id', 'products.price'])
            ->join('products', 'products.id', '=', 'product_variants.product_id')
            ->orderBy('product_variants.id')
            ->get()
            ->each(function (object $variant): void {
                DB::table('product_variants')
                    ->where('id', $variant->id)
                    ->update(['price' => $variant->price]);
            });
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
