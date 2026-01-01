<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plantbooking extends Model
{
      protected $fillable = [
        'plantation_area',
        'plant_varieties',
        'plant_grading',
    ];
}

