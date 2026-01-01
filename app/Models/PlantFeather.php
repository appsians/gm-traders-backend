<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantFeather extends Model
{
     protected $fillable = [
        'product_id',
        'feather',
        'price',
        'quantity',
    ];

       public function plant()
    {
        return $this->belongsTo(Product::class);
    }
}
