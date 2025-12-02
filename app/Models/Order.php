<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

     protected $fillable = [
         'order_id',
         'deliver_date',
         'delivered_date',
         'amount_paid',
         'amount_remaining',
         'items',
         'location',
         'placed_date',
         'name',
         'user_id',
         'subtotal',
         'delivery_fee',
         'total_amount',
         'is_partial_payment',
         'pay_now',
         'pay_later',
         'is_verify',
         'user_id',


    ];



       public function orderitems()
    {
        return $this->hasMany(order_items::class, 'order_id', 'id');
    }

        public function getPlacedDateAttribute($value)
    {
        return $value
            ? 'Placed on: ' . Carbon::parse($value)->format('M j Y')
            : null;
    }

    // ✅ Accessor for deliver_date
      public function getDeliverDateAttribute($value)
    {
        return $value
            ? 'Deliver on: ' . Carbon::parse($value)->format('M j Y')
            : null;
    }
  public function getDeliveredDateAttribute($value)
{
     return $value
        ? 'Delivered on: ' .Carbon::parse($value)->format('M j Y')
        : null;
}

      public function getAmountPaidAttribute($value)
    {
        return 'Amount Paid: ₹' . number_format($value, 0);
    }

     public function getAmountRemainingAttribute($value)
    {
        return 'Amount Remaining: ₹' . number_format($value, 0);
    }

    public function getItemsAttribute($value)
    {
        return 'Items: ' . (int) $value;
    }

  public function billing()
{
    return $this->hasOne(Billing::class, 'order_id', 'order_id');
}


}
