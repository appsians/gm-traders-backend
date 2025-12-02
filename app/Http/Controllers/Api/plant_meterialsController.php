<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Trills_Material;

class plant_meterialsController extends Controller
{

    public function getAllPlantsAndMaterials()
{
    try {
        // Fetch all records
        $plants = Product::all();
        $materials = Trills_Material::all();
         $bannerplant = Product::inRandomOrder()->take(2)->get();

        // Fetch 2 random materials
        $bannermaterials = Trills_Material::inRandomOrder()->take(2)->get();

 $bannerData = $bannerplant->merge($bannermaterials);
        // Return JSON response
        return response()->json([
            'status' => true,
            'message' => 'Data fetched successfully',
            'plants' => $plants,
            'materials' => $materials,
            'bannerData'=>$bannerData,
          
        ], 200);

    } catch (\Exception $e) {
        // Handle error response
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong: ' . $e->getMessage(),
        ], 500);
    }
}



public function getRandomPlantsAndMaterials()
{
    try {
        // Fetch 2 random plants
        $plants = Product::inRandomOrder()->take(2)->get();

        // Fetch 2 random materials
        $materials = Trills_Material::inRandomOrder()->take(2)->get();

        // Return JSON response
        return response()->json([
            'status' => true,
            'message' => 'Random data fetched successfully',
            'plants' => $plants,
            'materials' => $materials,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong: ' . $e->getMessage(),
        ], 500);
    }
}


}
