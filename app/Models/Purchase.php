<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['user_id', 'purchase_date', 'supplier', 'supplier_id', 'invoice_number', 'notes', 'total', 'cancelled_at', 'cancelled_by'];

    protected $casts = [
        'purchase_date' => 'date',
        'total' => 'decimal:2',
        'cancelled_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    // Se llama "provider" (no "supplier") para no chocar con la columna de texto
    // `supplier` que ya existe en esta tabla.
    public function provider()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
