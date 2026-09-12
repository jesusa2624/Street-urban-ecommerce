<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Vincula la venta a un cliente real (con cuenta) cuando corresponde. Se deja nullable
    // y no se toca customer_name: sigue sirviendo para clientes de paso sin cuenta, y como
    // respaldo si el cliente vinculado se llega a eliminar (nullOnDelete, no se pierde la venta).
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->after('customer_name')->constrained('customers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropConstrainedForeignId('customer_id');
        });
    }
};
