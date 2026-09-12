<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItemReturn extends Model
{
    protected $fillable = ['sale_item_id', 'quantity', 'reason', 'returned_by'];

    public function saleItem()
    {
        return $this->belongsTo(SaleItem::class);
    }

    public function returnedBy()
    {
        return $this->belongsTo(User::class, 'returned_by');
    }
}
