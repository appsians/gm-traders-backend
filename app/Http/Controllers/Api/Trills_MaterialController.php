<?php

namespace App\Http\Controllers\Api;
use App\Models\Trills_Material;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Trills_MaterialController extends Controller
{
        public function index()
    {
        $materials = Trills_Material::all();

        return view('Admin.trills_materials.datatable' ,compact('materials'));

    }


        public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
          //  'trellis_code' => 'required|string|unique:trills__materials,trellis_code',
            'title' => 'required|string|max:255',
            'description' => 'string',
            'image' => 'required|image',
            'price' => 'required|numeric|min:0',
          'discount_price' => 'required|numeric|min:0|lte:price',
             'grading' =>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->only(['grading', 'title','image', 'description','category','discount_price' ,'price']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/trills_materials'), $filename);
          $data['image'] = $filename; // ✅ store only filename
        }

        $data['category'] = 'trills_material';

        $material = Trills_Material::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Material created successfully.',
            'data' => $material,
        ], 201);
    }

        public function show($id)
    {
        $material = Trills_Material::find($id);


        if (!$material) {
            return response()->json([
                'status' => false,
                'message' => 'Material not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Material fetched successfully.',
            'data' => $material,
        ], 200);
    }


    public function update(Request $request)

    {
        
         $validator = Validator::make($request->all(), [
          //  'trellis_code' => 'required|string|unique:trills__materials,trellis_code',
            'title' => 'required|string|max:255',
            'description' => 'string',
            'image' => 'image',
            'price' => 'required|numeric|min:0',
             'discount_price' => 'required|numeric|min:0|lte:price',
             'grading' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

       


        $id=$request->id;
           
        $material =Trills_Material::find($id);





    if (!$material) {
        return response()->json(['status' => 'error', 'message' => 'materials not found'], 404);
    }

    $data=($request->only(['price', 'title', 'description', 'image', 'discount_price','grading']));
    
    
      if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/trills_materials'), $filename);
          $data['image'] = $filename; // ✅ store only filename
        }
         $material->update($data);

    return response()->json(['status' => 'success', 'message' => 'Materials updated successfully!']);
}




      public function destroy($id)
    {
        $material = Trills_Material::find($id);

        if (!$material) {
            return response()->json([
                'status' => false,
                'message' => 'Material not found.',
            ], 404);
        }

        $material->delete();

        return response()->json([
            'status' => true,
            'message' => 'Material deleted successfully.',
        ], 200);
    }
}
