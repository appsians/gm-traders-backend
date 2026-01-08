<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homescreen_banner extends Model
{
    protected $fillable = [
        'topic',
        'sub_topic',
        'icon',
       
    ];

    public function getIconAttribute($value)
    {
        if ($value) {
            // Return full URL instead of just the path
            return rtrim(config('app.url'), '/') . '/' . ltrim($value, '/');
        }

        return null;
    }
}
