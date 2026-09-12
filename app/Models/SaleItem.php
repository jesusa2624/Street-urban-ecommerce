<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = ['sale_id', 'product_variant_id', 'quantity', 'returned_quantity', 'unit_price', 'unit_cost', 'subtotal'];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'unit_cost' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function batches()
    {
        return $this->hasMany(SaleItemBatch::class);
    }

    public function returns()
    {
        return $this->hasMany(SaleItemReturn::class);
    }

    // Cuánto de esta línea sigue contando como venta real, después de restar lo devuelto.
    public function getNetQuantityAttribute(): int
    {
        return $this->quantity - $this->returned_quantity;
    }

    public function getNetSubtotalAttribute(): float
    {
        return $this->net_quantity * (float) $this->unit_price;
    }
}
