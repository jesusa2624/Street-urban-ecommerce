<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'whatsapp', 'address', 'ruc', 'low_stock_threshold'];

    // Configuración de una sola fila. No se fuerza id=1 porque un auto-increment no
    // reutiliza ids borrados — simplemente se usa la primera fila que exista, y si no
    // hay ninguna, se crea con los mismos valores que hoy están escritos directamente
    // en el código de la tienda.
    public static function current(): self
    {
        return static::first() ?? static::create([
            'name' => 'Street Urban',
            'email' => 'contacto@streeturban.com',
            'phone' => '+51 987 654 234',
            'whatsapp' => '51987654234',
            'address' => null,
            'ruc' => null,
            'low_stock_threshold' => 5,
        ]);
    }
}
