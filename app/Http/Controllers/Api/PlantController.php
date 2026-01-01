<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plantbooking;

class PlantController extends Controller
{


public function getPlantBookings()
{

    $plants = Plantbooking::all();


    $plantation_area = $plants->pluck('plantation_area');
    $plant_varieties = $plants->pluck('plant_varieties');
    $plant_grading   = $plants->pluck('plant_grading');

    return response()->json([
        'status' => 'success',
        'message' => 'Plant data fetched successfully',

            'plantation_area' => $plantation_area,
            'plant_varieties' => $plant_varieties,
            'plant_grading'   => $plant_grading,
        
    ]);
}

}
