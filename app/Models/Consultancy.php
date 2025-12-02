<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultancy extends Model
{

      protected $fillable = [
        'user_id',
        'category',
        'subcategory',
    ];




     public function user()
    {
        return $this->belongsTo(User::class);
    }
}



