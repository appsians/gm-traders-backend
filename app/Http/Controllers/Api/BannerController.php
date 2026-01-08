<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Homescreen_banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BannerController extends Controller
{
    public function index()
{
    $banners = Homescreen_banner::all(); // Icon URL is handled by model accessor

    return response()->json([
        'status' => true,
        'data' => $banners
    ]);
}

//admin side

public function banner(Request $request)
{
    return view('Admin.Banners.add');

}

public function all_banner(Request $request)
{
    return view('Admin.Banners.datatable');
}

public function bannersData(Request $request)
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

    // Map DataTable column names to database column names
    $columnMap = [
        'id' => 'id',
        'topic' => 'topic',
        'sub_topic' => 'sub_topic',
    ];

    $dbColumnName = $columnMap[$columnName] ?? 'id';

    $query = Homescreen_banner::query();

    // Search functionality
    if ($searchValue != '') {
        $query->where(function($q) use ($searchValue) {
            $q->where('topic', 'like', '%' . $searchValue . '%')
              ->orWhere('sub_topic', 'like', '%' . $searchValue . '%');
        });
    }

    $totalRecords = Homescreen_banner::count();
    $totalRecordswithFilter = $query->count();

    // Sorting
    $query->orderBy($dbColumnName, $columnSortOrder);

    // Pagination
    $banners = $query->skip($start)->take($rowperpage)->get();

    $data_arr = [];
    foreach ($banners as $index => $banner) {
        $data_arr[] = [
            'id' => $banner->id,
            'topic' => $banner->topic ?? '-',
            'sub_topic' => $banner->sub_topic ?? '-',
            'icon' => $banner->icon,
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
        'topic' => 'required|string|max:255',
        'sub_topic' => 'required|string|max:255',
        'icon' => 'required|image',
]);


    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

        $data = $request->only(['topic','sub_topic','icon']);

        if ($request->hasFile('icon')) {
            $filename = time() . '.' . $request->icon->extension();
            $target = public_path('uploads');
            if (!file_exists($target)) {
                @mkdir($target, 0755, true);
            }
            $request->icon->move($target, $filename);
            $data['icon'] = 'uploads/' . $filename;
        }


        $fruit = Homescreen_banner::create($data);

        return response()->json(['status' => 'success', 'message' => 'Banner created successfully', 'data' => $fruit]);
    }

      public function edit($id)
{

    $banner = Homescreen_banner::find($id);

    if (!$banner) {
        return response()->json(['status' => false, 'message' => 'data not found'], 404);
    }

     return response()->json([
        'status' => true,
        'data' => $banner,
    ]);
}

 public function destroy($id)
    {
        $product = Homescreen_banner::find($id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Banners not found'], 404);
        }

        $product->delete();

        return response()->json(['status' => 'success', 'message' => 'Banners deleted']);
    }


    public function update(Request $request)
{

          $validator = Validator::make($request->all(), [
        'topic' => 'required|string|max:255',
        'sub_topic' => 'required|string|max:255',
        'icon' => '|image',
]);


    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 422);
    }


    $fruit = Homescreen_banner::find($request->id);


    if (!$fruit) {
        return response()->json(['status' => 'error', 'message' => 'banner not found'], 404);
    }

       $fruit->topic = $request->topic;
        $fruit->sub_topic = $request->sub_topic;



    if($request->hasFile('icon')) {
            if($fruit->icon && file_exists(public_path($fruit->icon))) {
                @unlink(public_path($fruit->icon));
            }

            $filename = time() . '.' . $request->icon->extension();
            $target = public_path('uploads');
            if (!file_exists($target)) {
                @mkdir($target, 0755, true);
            }
            $request->icon->move($target, $filename);
            $fruit->icon = 'uploads/' . $filename;
        }

    $fruit->update();



    return response()->json(['status' => 'success', 'message' => 'Banner updated successfully!']);
}

}







