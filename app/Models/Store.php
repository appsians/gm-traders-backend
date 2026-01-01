<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Store extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'scientific_name',
        'size',
        'plant_type',
        'height',
        'humidity',
        'description',
        'price',
        'discount_price',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}