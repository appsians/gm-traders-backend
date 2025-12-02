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
    $banners = Homescreen_banner::all()->map(function ($banner) {
        $banner->icon = asset($banner->icon); // 👈 adds full URL to icon path
        return $banner;
    });

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

   // $banners= Homescreen_banner::all();
        $banners = Homescreen_banner::all();

    return view('Admin.Banners.datatable' ,compact('banners'));

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
            $request->icon->move(public_path(''), $filename);
            $data['icon'] = '' . $filename;
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
            if($fruit->image && file_exists(public_path($fruit->icon))) {
                @unlink(public_path($fruit->icon));
            }

            $filename = time() . '.' . $request->icon->extension();
            $request->icon->move(public_path(''), $filename);
            $fruit->icon = $filename;
        }

    $fruit->update();



    return response()->json(['status' => 'success', 'message' => 'Banner updated successfully!']);
}

}







