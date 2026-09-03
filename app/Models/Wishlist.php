<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = ['owner_type', 'owner_id', 'product_color_id'];

    public function productColor()
    {
        return $this->belongsTo(ProductColor::class);
    }
}
