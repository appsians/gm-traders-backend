<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class plant_variety extends Model
{

      protected $fillable = ['name','type','image'];


      public function feathers()
    {
        return $this->hasMany(plant_reservation::class);
    }
      public function kanals()
    {
        return $this->hasMany(kanal_picker::class);
    }
}
