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
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->integer('quantity_remaining')->default(0)->after('quantity');
        });

        // Los lotes ya existentes: asumimos que todavía no se ha vendido nada de ese stock.
        DB::statement('UPDATE purchase_items SET quantity_remaining = quantity');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->dropColumn('quantity_remaining');
        });
    }
};
