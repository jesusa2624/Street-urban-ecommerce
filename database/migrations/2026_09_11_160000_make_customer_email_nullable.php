<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // Un cliente registrado desde el admin puede no tener correo (solo nombre/teléfono).
    // Se usa SQL directo porque el ->change() fluido de Laravel requiere doctrine/dbal,
    // que no está instalado en el proyecto.
    public function up(): void
    {
        DB::statement('ALTER TABLE customers MODIFY email VARCHAR(255) NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE customers MODIFY email VARCHAR(255) NOT NULL');
    }
};
