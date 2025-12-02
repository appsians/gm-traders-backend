<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fruit extends Model
{
     protected $fillable = [
        'fruit_id',
        'origin',
        'title',
        'image',
        'harvested_date',

     ];
}
