<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order_items extends Model
{
       protected $fillable = [
        'order_id',
        'product_id',
        'variety',
        'quality',
        'price',
        'quantity',
        'total_price',
        'image',
        'cart_type',
    ];

      public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
