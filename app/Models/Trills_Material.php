<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trills_Material extends Model
{
     protected $fillable = [
        'trellis_code',
        'title',
        'description',
        'image',
        'price',
        'category',
        'grading',
        'discount_price',
        'quantity',
    ];


    public function getImageAttribute($value)
{
    if ($value) {
        // Return full URL instead of just the path
        return rtrim(config('app.url'), '/') . '/uploads/trills_materials/' . ltrim($value, '/');
    }

    return null;
}
    public function bookings()
{
    return $this->morphMany(Booking::class, 'bookable');
}

}
