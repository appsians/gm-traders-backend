<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\plant_reservation;
use App\Models\plant_variety;
use App\Models\kanal_picker;
use Illuminate\Http\Request;

class kanal_pickerController extends Controller
{
    public function store(Request $request)
{

    // 1️⃣ Validate the request

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'feathers' => 'required|array',
        'feathers.*.feather' => 'required|string',
        'feathers.*.price' => 'required|numeric',
    ]);

    // 2️⃣ Create Plant Variety
    $plantVariety = plant_variety::firstOrCreate([
        'name' => $validated['name'], // ✔ string, not array
        'type' => 'kanal',      // ✔ fixed type
    ]);

    // 3️⃣ Create Related Feathers
    foreach ($validated['feathers'] as $f) { // ✔ loop over 'feathers' key
        $plantVariety->kanals()->create([
            'feather' => $f['feather'],
            'price' => $f['price'],
        ]);
    }

    // 4️⃣ Return response
    return response()->json([
        'status' => true,
        'message' => 'Plant variety and feathers added successfully',
        'data' => $plantVariety->load('feathers')
    ], 201);




}


   public function getAllVarieties()
    {
         $varieties=plant_variety::where('type','kanal')->get();


    //     if($varieties->isEmpty()) {
    //     return response()->json([
    //         'status' => false,
    //         'message' => 'No variety found ',
    //         'data' => []
    //     ], 404);
    // }
         return response()->json([
        'status' => true,
        'message' => ' kanal variety retrieved successfully',
        'data' => $varieties
    ], 200);
    }

    // ✅ Get feathers + prices by variety ID
    public function getFeathersByVariety(Request $request)
    {

       $feathers = kanal_picker::whereHas('variety', function ($query) {
        $query->where('type', 'kanal');
    })
    ->where('plant_variety_id', $request->id)
    ->select('id', 'feather', 'price','quantity')
    ->get();


    if ($feathers->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'No feathers found for this variety',
            'data' => []
        ], 404);
    }

    return response()->json([
        'status' => true,
        'message' => 'Feathers retrieved successfully',
        'data' => $feathers
    ], 200);
    }
public function getvariety()
{
    
 $varieties = plant_variety::all();
return view('grading.add', compact(' varieties'));
    
}

}



