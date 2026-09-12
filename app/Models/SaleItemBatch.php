<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItemBatch extends Model
{
    protected $fillable = ['sale_item_id', 'purchase_item_id', 'quantity'];

    public function saleItem()
    {
        return $this->belongsTo(SaleItem::class);
    }

    public function purchaseItem()
    {
        return $this->belongsTo(PurchaseItem::class);
    }
}
