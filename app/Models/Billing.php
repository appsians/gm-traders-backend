<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
      protected $fillable = ['full_name', 'phone', 'address','city','state','order_id'];



 public function order()
{
    return $this->belongsTo(Order::class, 'order_id', 'order_id');
}

}
