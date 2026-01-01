<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderReplacement extends Model
{
    protected $fillable = [
        'order_id',
        'reason',
        'image',
        'description',
        'quantity_to_replace',
        'billing_id',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function billing()
    {
        return $this->belongsTo(Billing::class, 'billing_id');
    }
}
