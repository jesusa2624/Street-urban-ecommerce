<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            // La wishlist la puede usar tanto un cliente (customers) como un
            // usuario staff/admin (users), así que el dueño se guarda de forma
            // genérica en vez de una FK fija a una sola tabla.
            $table->string('owner_type');
            $table->unsignedBigInteger('owner_id');
            // Se guarda por color/variante (no por producto): un mismo modelo
            // con dos colores son dos favoritos independientes.
            $table->foreignId('product_color_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['owner_type', 'owner_id', 'product_color_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
