<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserConsult extends Model
{
      protected $fillable = [
        'user_id',
        'consultancy',
        'sub_consultancy',
    ];
    
       public function user()
    {
        return $this->belongsTo(User::class);
    }
}


