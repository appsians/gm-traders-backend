<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fruit_scanner extends Model
{
       protected $fillable = [
        'fruit_qr_code',
        'fruit_name',
        'qr_code_image',
        'origin',
        'farmer_name',
        'orchard_size'
    ];
}
