<?php
namespace App\Http\Controllers\Api;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Fruit;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Writer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;






class ProductController extends Controller
{
     public function index()
    {
        return view('Admin.plant.datatable');
    }

    public function plantsData(Request $request)
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
            'age' => 'age',
        ];

        $dbColumnName = $columnMap[$columnName] ?? 'id';

        $query = Product::with('plantfeather')->where('category', 'plant');

        if ($searchValue != '') {
            $query->where(function($q) use ($searchValue) {
                $q->where('title', 'like', '%' . $searchValue . '%')
                  ->orWhere('plant_id', 'like', '%' . $searchValue . '%')
                  ->orWhere('price', 'like', '%' . $searchValue . '%')
                  ->orWhere('age', 'like', '%' . $searchValue . '%');
            });
        }

        $totalRecords = Product::where('category', 'plant')->count();
        $totalRecordswithFilter = $query->count();

        $query->orderBy($dbColumnName, $columnSortOrder);
        $products = $query->skip($start)->take($rowperpage)->get();

        $data_arr = [];
        foreach ($products as $product) {
            $data_arr[] = [
                'id' => $product->id,
                'plant_id' => $product->plant_id ?? '-',
                'image' => $product->image,
                'title' => $product->title ?? '-',
                'price' => $product->price ?? '-',
                'age' => $product->age ?? '-',
                 'grading' => $product->grading ?? '-',
                'discount_price' => $product->discount_price ?? '-',
                'feathers' => $product->plantfeather->toArray(),
                'qr_code' => $product->qr_code ?? null,
                  'quantity' =>$product->quantity,
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


        public function show($id)
    {
        $product = Product::with('plantfeather')->find($id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'plant not found'], 404);
        }

        $data = $product->toArray();
        $data['feathers'] = $product->plantfeather->map(function($feather) {
            return [
                'feather' => $feather->feather,
                'price' => $feather->price,
                'quantity' => $feather->quantity,
            ];
        })->toArray();

        return response()->json(['status' => 'success', 'data' => $data]);
    }

       public function store(Request $request)

{
   


    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
        'image' => 'required|image',
        'price' => 'required|integer',
        'age' => 'required',
      
    ]);
    

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

    $plantId = $this->generatePlantId();

    $data = $request->only([
        'title','description','price','age','discount_price','quantity','grading'
    ]);

    $data['plant_id'] = $plantId;
    $data['category'] = 'plant';

    if ($request->hasFile('image')) {
        $filename = time().'.'.$request->image->extension();
        $target = public_path('uploads');
        if (!file_exists($target)) {
            @mkdir($target, 0755, true);
        }
        $request->image->move($target, $filename);
        $data['image'] = 'uploads/' . $filename;
    }

    $product = Product::create($data);

  if ($request->has('feathers') && is_array($request->feathers)) {
    foreach ($request->feathers as $feather) {
        \App\Models\PlantFeather::create([
            'product_id' => $product->id,
            'feather' => $feather['feather'],
            'price' => $feather['price'],
            'quantity' => $feather['quantity'],
        ]);
    }
}

    return response()->json([
        'status' => true,
        'message' => 'Plant created successfully',
        'data' => [
            'product' => $product,
        ]
    ], 200);
}



       public function update(Request $request)
    {
         $product = Product::find($request->id);


        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'plant not found'], 404);
        }

      $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
      
        'image' => 'image|max:5120',
        'price' => 'required|numeric|min:0',
           'discount_price' => 'nullable|numeric|min:0|lte:price',
          'age' => 'required|string',
          'feathers' => 'sometimes|array',
          'feathers.*.feather' => 'required_with:feathers|string',
          'feathers.*.price' => 'required_with:feathers|numeric|min:0',
          'feathers.*.quantity' => 'required_with:feathers|numeric|min:0',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

        $data = $request->only(['title','description','price','age','grading','discount_price','type','quantity']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $target = public_path('uploads/products');
            if (!file_exists($target)) {
                @mkdir($target, 0755, true);
            }
            $file->move($target, $filename);
            $data['image'] = 'uploads/products/' . $filename;
        }

        $product->update($data);

        if ($request->has('feathers') && is_array($request->feathers)) {
            // Delete existing feathers
            $product->plantfeather()->delete();
            // Add new ones
            foreach ($request->feathers as $feather) {
                if (empty($feather['feather'])) continue;
                \App\Models\PlantFeather::create([
                    'product_id' => $product->id,
                    'feather' => $feather['feather'] ?? null,
                    'price' => $feather['price'] ?? 0,
                    'quantity' => $feather['quantity'] ?? 0,
                ]);
            }
        }

        return response()->json(['status' => true, 'message' => 'Plant Updated Successfully', 'data' => $product->fresh()],200);
    }



       public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Plant Not Found'], 404);
        }

        $product->plantfeather()->delete();
        $product->delete();

        return response()->json(['status' => true, 'message' => 'Plant Deleted']);
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:products,id',
        ]);

        $ids = $request->ids;
        $deletedCount = 0;

        foreach ($ids as $id) {
            $product = Product::find($id);
            if ($product) {
                $product->plantfeather()->delete();
                $product->delete();
                $deletedCount++;
            }
        }

        return response()->json([
            'status' => true,
            'message' => $deletedCount . ' plant(s) deleted successfully.',
            'deleted_count' => $deletedCount,
        ], 200);
    }

    // product qr_code

     public function scanProduct(Request $request, $plant_id = null)
{

    $plantId = $plant_id ?? $request->get('plant_id');

    Log::info('📦 Full Scan Request Raw:', [
        'url_param' => $plant_id,
        'all' => $request->all(),
        'query' => $request->query(),
        'final_plant_id' => $plantId,
    ]);

    // 🧩 If plant ID is still missing, stop here
    if (!$plantId) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid Plant_id',
        ], 200);
    }

    // 🪴 Find product by plant_id
    $product = Product::where('plant_id', $plantId)->first();

    Log::info('🔎 Scan Product Result:', [
        'plant_id' => $plantId,
        'found' => (bool) $product,
    ]);

    if (!$product) {
        return response()->json([
            'status' => false,
            'message' => 'Product not found',
        ], 200);
    }

return response()->json([ 'status' => true, 'message' => 'plant data fetched successfully', // 'user' => $user->only(['id', 'name', 'email']),
'plant_id' => $product->plant_id,
'age' => $product->age,
'title' => $product->title,
'variety' => 'apple variety',
// 'price'=> $product->price,
],200);
}

    //fruits scaning




    //      public function scanfruit(Request $request)
    // {

    //   // Log::info('Registration request: ' , $request->all());



    //   $request->validate([
    //         // 'fruit_id' => 'required',
    //     ]);

    //     $fruit = Fruit::where('fruit_id', $request->fruit_id)->first();

    //     if (!$fruit) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'fruit not found',
    //         ], 200);
    //     }

    //     // return response()->json([
    //     //     'status' => true,
    //     //     'message' => 'fruit fetched successfully',
    //     //     'data' => $fruit,

    //     // ]);

    //      return response()->json([
    //     'status' => true,
    //     'message' => 'fruit data fetched successfully',

    //       // 'user' => $user->only(['id', 'name', 'email']),
    //         'fruit_id' => $fruit->fruit_id,
    //       // 'age' => $product->age,
    //         'title' => $fruit->title,
    //         'origin' => $fruit->origin,
    //         'harvested_date'=> $fruit->harvested_date,



    //      ]);
    // }




    public function scanfruit(Request $request, $fruit_id = null)
{
    // 🔍 Determine fruit_id from URL or query parameter
    $fruitId = $fruit_id ?? $request->query('fruit_id');

    Log::info('🍎 Scan Fruit Request Details:', [
        'url_param' => $fruit_id,
        'query_param' => $request->query(),
        'final_fruit_id' => $fruitId,
    ]);

    // 🛑 Stop if fruit_id not provided
    if (!$fruitId) {
        return response()->json([
            'status' => false,
            'message' => 'fruit_id not provided in request',
        ], 400);
    }

    // 🪴 Find fruit by fruit_id
    $fruit = Fruit::where('fruit_id', $fruitId)->first();

    Log::info('🔎 Scan Fruit Result:', [
        'fruit_id' => $fruitId,
        'found' => (bool) $fruit,
    ]);

    if (!$fruit) {
        // ❌ Fruit not found response
        return response()->json([
            'status' => false,
            'message' => 'Fruit not found',
        ], 200);
    }


         return response()->json([
        'status' => true,
        'message' => 'fruit data fetched successfully',

          // 'user' => $user->only(['id', 'name', 'email']),
            'fruit_id' => $fruit->fruit_id,
          // 'age' => $product->age,
            'title' => $fruit->title,
            'origin' => $fruit->origin,
            'harvested_date'=>  Carbon::parse($fruit->harvested_date)->format('M d, Y'),




         ]);
}


    // fruits cruds

       public function fruit()
    {
        $fruit = Fruit::all();

        return response()->json(['status' => 'success', 'data' => $fruit]);
    }



   // store


          public function fruitstore(Request $request)
    {


          $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'origin' => 'required|string',
        'image' => 'required|image',
        'harvested_date' => 'required',
      //  'fruit_id' => 'required|string|unique:fruits,fruit_id',
    ], [
       // 'fruit_id.unique' => 'fruit_id already exists, please enter a new one.',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

      $fruitId = $this->generateFruitId();

        $data = $request->only(['title','origin','harvested_date','fruit_id','image']);

         $data['fruit_id'] = $fruitId;

        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            $target = public_path('uploads');
            if (!file_exists($target)) {
                @mkdir($target, 0755, true);
            }
            $request->image->move($target, $filename);
            $data['image'] = 'uploads/' . $filename;
        }


        $fruit = Fruit::create($data);

        return response()->json(['status' => 'success', 'message' => 'Fruits created successfully', 'data' => $fruit]);
    }






    public function showfruits($id)
{

    $fruit = Fruit::find($id);

    if (!$fruit) {
        return response()->json(['status' => false, 'message' => 'Product not found'], 404);
    }

     return response()->json([
        'status' => true,
        'data' => $fruit,
    ]);
}

public function updatefruit(Request $request)
{

       $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'origin' => 'required|string',
        'image' => 'image',
        'harvested_date' => 'required',
      //  'fruit_id' => 'required|string|unique:fruits,fruit_id',
    ], [
       // 'fruit_id.unique' => 'fruit_id already exists, please enter a new one.',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

   $fruit = Fruit::find($request->id);

    if (!$fruit) {
        return response()->json(['status' => 'error', 'message' => 'Fruit not found'], 404);
    }

      $fruit->title = $request->title;
        //  $fruit->description = $request->description;
        $fruit->origin = $request->origin;
        $fruit->harvested_date = $request->harvested_date;


    if($request->hasFile('image')) {
            if($fruit->image && file_exists(public_path($fruit->image))) {
                @unlink(public_path($fruit->image));
            }

            $filename = time() . '.' . $request->image->extension();
            $target = public_path('uploads');
            if (!file_exists($target)) {
                @mkdir($target, 0755, true);
            }
            $request->image->move($target, $filename);
            $fruit->image = 'uploads/' . $filename;
        }

    $fruit->update();

    return response()->json(['status' => 'success', 'message' => 'Fruit updated successfully!']);
}




   public function destroyfruit($id)
    {
        $product = Fruit::find($id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Fruits not found'], 404);
        }

        $product->delete();

        return response()->json(['status' => 'success', 'message' => 'Fruits deleted successfully']);
    }

    public function bulkDestroyFruit(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:fruits,id',
        ]);

        $ids = $request->ids;
        $deletedCount = Fruit::whereIn('id', $ids)->delete();

        return response()->json([
            'status' => true,
            'message' => $deletedCount . ' fruit(s) deleted successfully.',
            'deleted_count' => $deletedCount,
        ], 200);
    }


    //generate plant and fruit ids

    function generatePlantId()
{
      $numbers = '0123456789';
    $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    // Generate mostly numbers
    $id = '';
    for ($i = 0; $i < 10; $i++) {
        // 70% chance number, 30% chance letter
        $id .= rand(1, 10) > 3
            ? $numbers[rand(0, strlen($numbers) - 1)]
            : $letters[rand(0, strlen($letters) - 1)];
    }

    return 'plant-' . $id;

}

function generateFruitId()
{
    $numbers = '0123456789';
    $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $id = '';
    for ($i = 0; $i < 10; $i++) {
        // 70% chance number, 30% chance letter
        $id .= rand(1, 10) > 3
            ? $numbers[rand(0, strlen($numbers) - 1)]
            : $letters[rand(0, strlen($letters) - 1)];
    }

    return 'fruit-' . $id;
}

// generate qr code


public function generateQr(Request $request)
{
    $plant = Product::find($request->id);

    if (!$plant) {
        return response()->json([
            'status' => false,
            'message' => 'Plant not found'
        ]);
    }

    $plantId = $plant->plant_id; // only the plant ID, e.g. "plant-941454F56R"

    $fileName = $plantId . '.svg';
    $directory = public_path('qrcodes');

    if (!file_exists($directory)) {
        mkdir($directory, 0755, true);
    }

    $fullPath = $directory . '/' . $fileName;

    // ✅ Generate QR code that contains ONLY the plant ID (no URL)
    $renderer = new ImageRenderer(
        new RendererStyle(300), // size of QR code
        new SvgImageBackEnd()   // SVG output
    );

    $writer = new Writer($renderer);

    // ⚠️ Important: this line must use $plantId (not URL)
    $writer->writeFile($plantId, $fullPath);

    // Save the QR filename to database
    $plant->qr_code = $fileName;
    $plant->save();

    return response()->json([
        'status' => true,
        'message' => 'QR Code generated successfully',
        'qr_code_url' => asset('qrcodes/' . $fileName)
    ]);
}
public function generateFruitQr(Request $request)
{
    // 🔍 Find fruit by ID
    $fruit = Fruit::find($request->id);

    if (!$fruit) {
        return response()->json([
            'status' => false,
            'message' => 'Fruit not found'
        ], 404);
    }

    $fruitId = $fruit->fruit_id; // only the fruit ID, e.g. "fruit-123ABC"

    $fileName = $fruitId . '.jpg';
    $directory = public_path('qrcodes');

    // ✅ Create directory if not exists
    if (!file_exists($directory)) {
        mkdir($directory, 0755, true);
    }

    $fullPath = $directory . '/' . $fileName;

    // 🖼 Generate QR code containing ONLY the fruit ID
    $renderer = new ImageRenderer(
    new RendererStyle(300),
    new ImagickImageBackEnd() // PNG FIX for mobile print
);

    $writer = new Writer($renderer);

    // ⚠️ Important: QR contains only fruitId
    $writer->writeFile($fruitId, $fullPath);

    // Save QR filename to database
    $fruit->qr_code = $fileName;
    $fruit->save();

    return response()->json([
        'status' => true,
        'message' => 'QR Code generated successfully',
        'qr_code_url' => asset('qrcodes/' . $fileName)
    ]);
}


// public function generateFruitQr(Request $request)
// {
//     // 🔍 Find fruit by ID
//     $fruit = Fruit::find($request->id);

//     if (!$fruit) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Fruit not found'
//         ], 404);
//     }

//     $fruitId = $fruit->fruit_id; // only the fruit ID, e.g. "fruit-123ABC"

//     $fileName = $fruitId . '.svg';
//     $directory = public_path('qrcodes');

//     // ✅ Create directory if not exists
//     if (!file_exists($directory)) {
//         mkdir($directory, 0755, true);
//     }

//     $fullPath = $directory . '/' . $fileName;

//     // 🖼 Generate QR code containing ONLY the fruit ID
//     $renderer = new ImageRenderer(
//         new RendererStyle(300), // size of QR code
//         new SvgImageBackEnd()   // SVG format
//     );

//     $writer = new Writer($renderer);
//     $writer->writeFile($fruitId, $fullPath);

//     // 🔹 Now inject company title "BGM Trader" into SVG
//     $svgContent = file_get_contents($fullPath);

//     // Add <text> element at the bottom (adjust x, y, font-size as needed)
//     $textSvg = '<text x="50%" y="97%" text-anchor="middle" font-size="24" fill="black" font-family="Arial">BGM Trader</text>';

//     // Insert the text before closing </svg>
//     $svgContent = str_replace('</svg>', $textSvg . '</svg>', $svgContent);

//     // Save back to file
//     file_put_contents($fullPath, $svgContent);

//     // Save QR filename to database
//     $fruit->qr_code = $fileName;
//     $fruit->save();

//     return response()->json([
//         'status' => true,
//         'message' => 'QR Code generated successfully',
//         'qr_code_url' => asset('qrcodes/' . $fileName)
//     ]);
// }

}

