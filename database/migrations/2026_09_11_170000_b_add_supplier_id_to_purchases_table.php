<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Vincula la compra a un proveedor real cuando corresponde. Se deja nullable y no se
    // toca la columna `supplier` (texto): sigue sirviendo como respaldo si el proveedor
    // vinculado se llega a eliminar (nullOnDelete, no se pierde la compra).
    public function up(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->foreignId('supplier_id')->nullable()->after('supplier')->constrained('suppliers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropConstrainedForeignId('supplier_id');
        });
    }
};
