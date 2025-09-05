<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class plant_scanner extends Model
{
    protected $fillable = [
        'plant_name',
        'qr_code',
        'variety',
        'birthday',
        'care_instructions',
        'verified_by',
        'qr_code_image'
    ];
}
