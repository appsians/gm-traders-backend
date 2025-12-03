<?php

namespace App\Http\Controllers;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use App\Models\Fruit;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Trills_Material;
use App\Models\Billing;

use App\Mail\ContactMail;


use App\Models\plant_reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class AdminController extends Controller
{
    public function index()
    {
         // Get recent orders (last 10)
         $recentOrders = Order::latest()->take(10)->get();

    // Counts
        $user =  Trills_Material::count();
         $plants = Product::count();
          $fruit = Fruit::count();
    $totalOrders = Order::count();
    $pendingOrders = Order::where('status', 'pending')->count();
    $completedOrders = Order::where('status', 'completed')->count();

    return view('dashboard', compact('recentOrders', 'totalOrders', 'pendingOrders', 'completedOrders','user','plants','fruit'));

    }

    public function getOrdersChartData(Request $request)
    {
        $range = $request->get('range', '7'); // default to 7 days
        
        $endDate = Carbon::now()->endOfDay();
        $startDate = Carbon::now()->startOfDay();
        
        switch ($range) {
            case '7':
                $startDate = Carbon::now()->subDays(6)->startOfDay(); // Include today, so 7 days total
                break;
            case '30':
                $startDate = Carbon::now()->subDays(29)->startOfDay(); // Include today, so 30 days total
                break;
            case '90':
                $startDate = Carbon::now()->subDays(89)->startOfDay(); // Include today, so 90 days total
                break;
            case 'custom':
                try {
                    $startDate = Carbon::parse($request->get('start_date'))->startOfDay();
                    $endDate = Carbon::parse($request->get('end_date'))->endOfDay();
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Invalid date format'
                    ], 400);
                }
                break;
        }
        
        // Use DB facade to bypass model accessors and get raw database values
        $orders = DB::table('orders')
            ->whereNotNull('placed_date')
            ->whereBetween('placed_date', [$startDate->format('Y-m-d H:i:s'), $endDate->format('Y-m-d H:i:s')])
            ->selectRaw('DATE(placed_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        // Fill in missing dates with 0
        $dates = [];
        $counts = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $dateStr = $currentDate->format('Y-m-d');
            $order = $orders->firstWhere('date', $dateStr);
            $dates[] = $currentDate->format('M d');
            $counts[] = $order ? (int)$order->count : 0;
            $currentDate->addDay();
        }
        
        return response()->json([
            'status' => true,
            'data' => [
                'dates' => $dates,
                'counts' => $counts,
                'total' => array_sum($counts)
            ]
        ]);
    }

    // fruits

     public function fruits()
    {
        return view('Admin.fruit.add');
    }

     public function all()
    {
        return view('Admin.fruit.datatable');
    }

    public function fruitsData(Request $request)
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
            'fruit_id' => 'fruit_id',
            'title' => 'title',
            'origin' => 'origin',
            'harvested_date' => 'harvested_date',
        ];

        $dbColumnName = $columnMap[$columnName] ?? 'id';

        $query = Fruit::query();

        // Search functionality
        if ($searchValue != '') {
            $query->where(function($q) use ($searchValue) {
                $q->where('fruit_id', 'like', '%' . $searchValue . '%')
                  ->orWhere('title', 'like', '%' . $searchValue . '%')
                  ->orWhere('origin', 'like', '%' . $searchValue . '%')
                  ->orWhere('harvested_date', 'like', '%' . $searchValue . '%');
            });
        }

        $totalRecords = Fruit::count();
        $totalRecordswithFilter = $query->count();

        // Sorting
        $query->orderBy($dbColumnName, $columnSortOrder);

        // Pagination
        $fruits = $query->skip($start)->take($rowperpage)->get();

        $data_arr = [];
        foreach ($fruits as $index => $fruit) {
            $data_arr[] = [
                'id' => $fruit->id,
                'fruit_id' => $fruit->fruit_id ?? '-',
                'image' => $fruit->image,
                'title' => $fruit->title ?? '-',
                'origin' => $fruit->origin ?? '-',
                'harvested_date' => $fruit->harvested_date ? \Carbon\Carbon::parse($fruit->harvested_date)->format('m/d/Y') : '-',
                'qr_code' => $fruit->qr_code,
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
    
    //search 
    
    
    
    
 public function plant()
    {
        return view('Admin.plant.add');
    }


       public function getallreservation()
    {
        return view('Admin.grading.datatable');
    }

    public function gradingData(Request $request)
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

        $columnMap = ['id' => 'id'];
        $dbColumnName = $columnMap[$columnName] ?? 'id';

        $query = plant_reservation::with('variety');

        if ($searchValue != '') {
            $query->where(function($q) use ($searchValue) {
                $q->where('feather', 'like', '%' . $searchValue . '%')
                  ->orWhereHas('variety', function($varietyQuery) use ($searchValue) {
                      $varietyQuery->where('name', 'like', '%' . $searchValue . '%');
                  });
            });
        }

        $totalRecords = plant_reservation::count();
        $totalRecordswithFilter = $query->count();

        $query->orderBy($dbColumnName, $columnSortOrder);
        $reservations = $query->skip($start)->take($rowperpage)->get();

        $data_arr = [];
        foreach ($reservations as $reservation) {
            $data_arr[] = [
                'id' => $reservation->id,
                'variety' => $reservation->variety ? $reservation->variety->name : '-',
                'feather' => $reservation->feather ?? '-',
                'price' => $reservation->price ?? '-',
                'created_at' => $reservation->created_at ? \Carbon\Carbon::parse($reservation->created_at)->format('m/d/Y') : '-',
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

   public function trills()
    {
        return view('Admin.trills_materials.add');
    }


public function users()
{
    $user = User::count();

    return view('dashboard',compact('user'));
}

public function billing()
{
    return view('Admin.billing.datatable');
}

public function billingData(Request $request)
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
        'name' => 'full_name',
    ];

    $dbColumnName = $columnMap[$columnName] ?? 'id';

    $query = Billing::with('order');

        if ($searchValue != '') {
            $query->where(function($q) use ($searchValue) {
                $q->where('full_name', 'like', '%' . $searchValue . '%')
                  ->orWhere('email', 'like', '%' . $searchValue . '%')
                  ->orWhere('phone', 'like', '%' . $searchValue . '%')
                  ->orWhere('address', 'like', '%' . $searchValue . '%')
                  ->orWhere('city', 'like', '%' . $searchValue . '%')
                  ->orWhere('state', 'like', '%' . $searchValue . '%');
            });
        }

    $totalRecords = Billing::count();
    $totalRecordswithFilter = $query->count();

    $query->orderBy($dbColumnName, $columnSortOrder);
    $billings = $query->skip($start)->take($rowperpage)->get();

    $data_arr = [];
    foreach ($billings as $billing) {
        $data_arr[] = [
            'id' => $billing->id,
            'name' => $billing->full_name ?? '-',
            'email' => $billing->email ?? '-',
            'phone' => $billing->phone ?? '-',
            'address' => $billing->address ?? '-',
            'city' => $billing->city ?? '-',
            'state' => $billing->state ?? '-',
            'order_id' => $billing->order ? ($billing->order->order_id ?? '-') : '-',
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




  public function destroy($id)
    {
        $material = Billing::find($id);

        if (!$material) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found.',
            ], 404);
        }

        $material->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data deleted successfully.',
        ], 200);
    }




  public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'email'   => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // send email
        Mail::to('rabiarajpoot4040@gmail.com')->send(new ContactMail($request->all()));

        return response()->json([
            'status' => 'success',
            'message' => 'Your message has been sent!'
        ]);
    }





}


