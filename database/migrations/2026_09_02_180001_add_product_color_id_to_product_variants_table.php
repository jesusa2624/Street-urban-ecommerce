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
            $table->foreignId('product_color_id')->nullable()->after('product_id')->constrained('product_colors')->nullOnDelete();
        });

        // Cada combinación (product_id, color) usada en variantes existentes se convierte
        // en una fila de product_colors, reutilizando el hex ya guardado en la variante.
        $variants = DB::table('product_variants')->select('id', 'product_id', 'color', 'color_hex')->get();

        $colorIds = [];
        foreach ($variants as $variant) {
            $colorName = trim((string) $variant->color);
            if ($colorName === '') {
                continue;
            }

            $key = $variant->product_id . '|' . mb_strtolower($colorName);

            if (!isset($colorIds[$key])) {
                $colorIds[$key] = DB::table('product_colors')->insertGetId([
                    'product_id' => $variant->product_id,
                    'name' => $colorName,
                    'hex' => $variant->color_hex,
                    'image_url' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('product_variants')->where('id', $variant->id)->update([
                'product_color_id' => $colorIds[$key],
            ]);
        }

        // Todo en un solo ALTER: MySQL solo valida el estado final, así el índice del FK de
        // product_id nunca se queda sin respaldo entre medio (el unique viejo lo cubría por ser
        // la columna izquierda del compuesto, y el nuevo unique también lo cubre igual).
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropUnique('product_variants_product_id_size_color_unique');
            $table->dropColumn(['color', 'color_hex']);
            $table->unique(['product_id', 'size', 'product_color_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropUnique(['product_id', 'size', 'product_color_id']);
        });

        Schema::table('product_variants', function (Blueprint $table) {
            $table->string('color')->nullable()->after('product_id');
            $table->string('color_hex')->nullable()->after('color');
        });

        $variants = DB::table('product_variants')->select('id', 'product_color_id')->whereNotNull('product_color_id')->get();
        foreach ($variants as $variant) {
            $color = DB::table('product_colors')->find($variant->product_color_id);
            if ($color) {
                DB::table('product_variants')->where('id', $variant->id)->update([
                    'color' => $color->name,
                    'color_hex' => $color->hex,
                ]);
            }
        }

        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropConstrainedForeignId('product_color_id');
        });
    }
};
