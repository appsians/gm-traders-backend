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
        return view('Admin.trills_materials.datatable');
    }

    public function trillsData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = isset($columnIndex_arr[0]['column']) ? $columnIndex_arr[0]['column'] : 0;
        $columnName = isset($columnName_arr[$columnIndex]['data']) ? $columnName_arr[$columnIndex]['data'] : 'id';
        $columnSortOrder = isset($order_arr[0]['dir']) ? $order_arr[0]['dir'] : 'desc';
        $searchValue = isset($search_arr['value']) ? $search_arr['value'] : '';

        $columnMap = [
            'id' => 'id',
            'title' => 'title',
            'price' => 'price',
            'grading' => 'grading',
        ];

        $dbColumnName = $columnMap[$columnName] ?? 'id';

        $query = Trills_Material::query();

        if ($searchValue != '') {
            $query->where(function($q) use ($searchValue) {
                $q->where('title', 'like', '%' . $searchValue . '%')
                  ->orWhere('price', 'like', '%' . $searchValue . '%')
                  ->orWhere('grading', 'like', '%' . $searchValue . '%');
            });
        }

        $totalRecords = Trills_Material::count();
        $totalRecordswithFilter = $query->count();

        $query->orderBy($dbColumnName, $columnSortOrder);
        $materials = $query->skip($start)->take($rowperpage)->get();

        $data_arr = [];
        foreach ($materials as $material) {
            $data_arr[] = [
                'id' => $material->id,
                'title' => $material->title ?? '-',
                'image' => $material->image,
                'price' => $material->price ?? '-',
                'discount_price' => $material->discount_price ?? '-',
                'grading' => $material->grading ?? '-',
            ];
        }

        $response = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ];

        return response()->json($response);
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
