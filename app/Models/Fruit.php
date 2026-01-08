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
        'qr_code',
     ];

    public function getImageAttribute($value)
    {
        if ($value) {
            // Return full URL instead of just the path
            return rtrim(config('app.url'), '/') . '/' . ltrim($value, '/');
        }

        return null;
    }
}
