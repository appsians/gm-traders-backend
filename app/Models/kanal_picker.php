<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kanal_picker extends Model
{

      protected $fillable = ['plant_variety_id', 'feather', 'price' , 'quantity'];
      public function variety()
    {
        return $this->belongsTo(plant_variety::class, 'plant_variety_id');
    }
}
