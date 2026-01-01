<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\plant_reservation;
use App\Models\kanal_picker;
use App\Models\plant_variety;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlantreservationController extends Controller
{
      public function getAllVarieties()
    {
         $varieties=plant_variety::where('type','reservation')->get();


    //     if($varieties->isEmpty()) {
    //     return response()->json([
    //         'status' => false,
    //         'message' => 'No variety found ',
    //         'data' => []
    //     ], 404);
    // }
         return response()->json([
        'status' => true,
        'message' => 'variety retrieved successfully',
        'data' => $varieties
    ], 200);
    }

    // ✅ Get feathers + prices by variety ID
    public function getFeathersByVariety(Request $request)
    {

        // $feathers=plant_reservation::where('plant_variety_id', $request->id)
        //     ->select('id', 'feather', 'price')
        //     ->get();

           $feathers = plant_reservation::whereHas('variety', function ($query) {
        $query->where('type', 'reservation');
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




public function store(Request $request)
{


    // 1️⃣ Validate request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|in:reservation,kanal', // ✅ added type check
        'feathers' => 'required|array',
        'feathers.*.feather' => 'required|string',
        'feathers.*.price' => 'required|numeric',
        'image' => 'required|image',
         'feathers.*.quantity' => 'required|integer|min:1',
    ]);
    
    
     $imagePath = null;
    if ($request->hasFile('image')) {
        $filename = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/varieties'), $filename);
       $imagePath = url('uploads/varieties/' . $filename);
    }

    // 2️⃣ Create Plant Variety based on type
    $plantVariety = Plant_Variety::firstOrCreate([
        'name' => $validated['name'],
        'type' => $validated['type'],
          ], [
        'image' => $imagePath,
    ]);
    
    

    // 3️⃣ Store feathers based on selected type
    foreach ($validated['feathers'] as $f) {
        if ($validated['type'] === 'reservation') {
            // 👇 store in plant reservation table
            $plantVariety->feathers()->create([
                'feather' => $f['feather'],
                'price' => $f['price'],
                'quantity' => $f['quantity'],

            ]);
        } elseif ($validated['type'] === 'kanal') {
            // 👇 store in kanal table
            $plantVariety->kanals()->create([
                'feather' => $f['feather'],
                'price' => $f['price'],
                 'quantity' => $f['quantity'],

            ]);
        }
    }

    // 4️⃣ Return JSON response
    return response()->json([
        'status' => true,
        'message' => 'Data stored successfully for type: ' . $validated['type'],
        'data' => $plantVariety->load(['feathers', 'kanals'])
    ], 201);
}

public function create()
{
    
     $varieties = plant_variety::all();
return view('Admin.grading.add', compact('varieties'));
  
}



public function getAllFeathers()
{ $varieties = plant_variety::with(['feathers', 'kanals'])->get();


    return view('Admin.grading.datatable', compact('varieties'));
}
   // return view('Admin.grading.datatable');


// public function getAthers()
// {
//     $feathers = plant_reservation::with('variety:id,name')->get();

//     return response()->json([
//         'status' => true,
//         'message' => 'All feathers with variety fetched successfully',
//         'data' => $feathers

//   ]);
// }

// public function destroy($id, Request $request)
// {
//     $request->validate([
//         'type' => 'required|in:reservation,kanal',
//     ]);

//     if ($request->type === 'reservation') {
//         $feather = Plant_reservation::find($id);
//     } else {
//         $feather = kanal_picker::find($id);
//     }

//     if (!$feather) {
//         return response()->json([
//             'status' => 'error',
//             'message' => ucfirst($request->type) . ' feather not found.'
//         ], 404);
//     }

//     $feather->delete();

//     return response()->json([
//         'status' => 'success',
//         'message' => ucfirst($request->type) . ' feather deleted successfully.'
//     ]);
// }


public function destroy($id, Request $request)
{
    $request->validate([
        'type' => 'required|in:reservation,kanal',
    ]);

    return DB::transaction(function () use ($id, $request) {

        // Select correct feather type
        if ($request->type === 'reservation') {
            $feather = Plant_reservation::find($id);
        } else {
            $feather = kanal_picker::find($id);
        }

        if (!$feather) {
            return response()->json([
                'status' => 'error',
                'message' => ucfirst($request->type) . ' feather not found.'
            ], 404);
        }

        // Get variety id before delete
        $varietyId = $feather->plant_variety_id;

        // Delete feather
        $feather->delete();

        // Check if this variety still has feathers in BOTH tables
        $reservationExists = Plant_reservation::where('plant_variety_id', $varietyId)->exists();
        $kanalExists = kanal_picker::where('plant_variety_id', $varietyId)->exists();

        // If no feathers exist in ANY table → delete variety
        if (!$reservationExists && !$kanalExists) {
            $variety = plant_variety::find($varietyId);
            if ($variety) {
                $variety->delete();
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => ucfirst($request->type) . ' feather deleted successfully.',
        ]);
    });
}

public function edit($id, Request $request)
{
    $request->validate([
        'type' => 'required|in:reservation,kanal',
    ]);

    if ($request->type === 'reservation') {
        $feather = plant_reservation::find($id);
    } else {
        $feather = kanal_picker::find($id);
    }

    if (!$feather) {
        return response()->json([
            'status' => false,
            'message' => ucfirst($request->type) . ' feather not found.'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'message' => 'Feather retrieved successfully',
        'data' => $feather
    ]);
}

public function update(Request $request, $id)
{
    $request->validate([
        'type' => 'required|in:reservation,kanal',
        'feather' => 'required|string',
        'price' => 'required|numeric',
        'quantity' => 'required|integer|min:1',
        'variety_name' => 'required|string|max:255',
        'variety_id' => 'required|integer|exists:plant_varieties,id',
    ]);

    if ($request->type === 'reservation') {
        $feather = plant_reservation::find($id);
    } else {
        $feather = kanal_picker::find($id);
    }

    if (!$feather) {
        return response()->json([
            'status' => false,
            'message' => ucfirst($request->type) . ' feather not found.'
        ], 404);
    }

    // Update variety name if changed
    $variety = plant_variety::find($request->variety_id);
    if ($variety && $variety->name !== $request->variety_name) {
        $variety->update(['name' => $request->variety_name]);
    }

    $feather->update([
        'feather' => $request->feather,
        'price' => $request->price,
        'quantity' => $request->quantity,
    ]);

    return response()->json([
        'status' => true,
        'message' => ucfirst($request->type) . ' feather updated successfully.',
        'data' => $feather->load('variety')
    ]);
}


}



