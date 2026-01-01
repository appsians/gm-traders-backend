<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    //  protected $fillable = ['user_id', 'image', 'description'];
         protected $fillable = ['user_id', 'before_image', 'after_image', 'description'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
