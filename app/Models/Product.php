<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     protected $fillable = [
        'title',
        'image',
        'price',
        'description',
        'age',
        'tree_id',
        'plant_id',
        'category',
          'grading',
        'discount_price',
         'quantity',
     ];

    public function getImageAttribute($value)
{
    if ($value) {
        // Return full URL instead of just the path
        return rtrim(config('app.url'), '/') . '/' . ltrim($value, '/');
    }

    return null;
}

    public function bookings()
{
    return $this->morphMany(Booking::class, 'bookable');
}

public function plantfeather()
{
    return $this->hasMany(PlantFeather::class);
}
}
