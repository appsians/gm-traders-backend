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
use App\Models\Prompt;

use App\Mail\ContactMail;
use App\Models\plant_variety;
use App\Models\Replace;

use App\Models\plant_reservation;
use App\Models\Community;
use App\Models\PostComment;
use App\Models\PostLike;
use App\Models\Chat;
use App\Models\order_items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\File;
use ZipArchive;



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

    // public function gradingData(Request $request)
    // {
    //     $draw = $request->get('draw');
    //     $start = $request->get("start");
    //     $rowperpage = $request->get("length");

    //     $columnIndex_arr = $request->get('order');
    //     $columnName_arr = $request->get('columns');
    //     $order_arr = $request->get('order');
    //     $search_arr = $request->get('search');

    //     $columnIndex = isset($columnIndex_arr[0]['column']) ? $columnIndex_arr[0]['column'] : 0;
    //     $columnName = isset($columnName_arr[$columnIndex]['data']) ? $columnName_arr[$columnIndex]['data'] : 'id';
    //     $columnSortOrder = isset($order_arr[0]['dir']) ? $order_arr[0]['dir'] : 'desc';
    //     $searchValue = isset($search_arr['value']) ? $search_arr['value'] : '';

    //     $columnMap = ['id' => 'id'];
    //     $dbColumnName = $columnMap[$columnName] ?? 'id';

    //     $query = plant_reservation::with('variety');

    //     if ($searchValue != '') {
    //         $query->where(function($q) use ($searchValue) {
    //             $q->where('feather', 'like', '%' . $searchValue . '%')
    //               ->orWhereHas('variety', function($varietyQuery) use ($searchValue) {
    //                   $varietyQuery->where('name', 'like', '%' . $searchValue . '%');
    //               });
    //         });
    //     }

    //     $totalRecords = plant_reservation::count();
    //     $totalRecordswithFilter = $query->count();

    //     $query->orderBy($dbColumnName, $columnSortOrder);
    //     $reservations = $query->skip($start)->take($rowperpage)->get();

    //     $data_arr = [];
    //     foreach ($reservations as $reservation) {
    //         $data_arr[] = [
    //             'id' => $reservation->id,
    //              'type' =>  $reservation->variety->type,
    //              'image' => $reservation->variety->image,
    //             'variety' => $reservation->variety ? $reservation->variety->name : '-',
    //             'feather' => $reservation->feather ?? '-',
    //             'price' => $reservation->price ?? '-',
    //             'created_at' => $reservation->created_at ? \Carbon\Carbon::parse($reservation->created_at)->format('m/d/Y') : '-',
    //         ];
    //     }

    //     $response = [
    //         "draw" => intval($draw),
    //         "iTotalRecords" => $totalRecords,
    //         "iTotalDisplayRecords" => $totalRecordswithFilter,
    //         "aaData" => $data_arr
    //     ];

    //     return response()->json($response);
    // }
    
    
    
    
    public function gradingData(Request $request)
{
    $draw = intval($request->get('draw'));
    $start = intval($request->get("start"));
    $rowperpage = intval($request->get("length"));

    $columnIndex_arr = $request->get('order');
    $columnName_arr  = $request->get('columns');
    $order_arr       = $request->get('order');
    $search_arr      = $request->get('search');

    $columnIndex     = $columnIndex_arr[0]['column'] ?? 0;
    $columnName      = $columnName_arr[$columnIndex]['data'] ?? 'id';
    $columnSortOrder = $order_arr[0]['dir'] ?? 'desc';
    $searchValue     = $search_arr['value'] ?? '';

    // ✅ Map column names for sorting
    $columnMap = [
        'id' => 'id',
        'name' => 'name',
        'type' => 'type',
         'type' => 'type',
        'created_at' => 'created_at',
    ];

    $dbColumnName = $columnMap[$columnName] ?? 'id';

    // ✅ Base query with relations
    $query = plant_variety::with(['feathers', 'kanals']);

    // ✅ Search filter
    if (!empty($searchValue)) {
        $query->where(function ($q) use ($searchValue) {
            $q->where('name', 'like', "%$searchValue%")
              ->orWhere('type', 'like', "%$searchValue%")
              ->orWhereHas('feathers', function($q2) use ($searchValue) {
                  $q2->where('feather', 'like', "%$searchValue%")
                     ->orWhere('price', 'like', "%$searchValue%");
              })
              ->orWhereHas('kanals', function($q3) use ($searchValue) {
                  $q3->where('feather', 'like', "%$searchValue%")
                     ->orWhere('price', 'like', "%$searchValue%");
              });
        });
    }

    // ✅ Total records with filter
    $totalRecords =plant_variety::count();
    $totalRecordswithFilter = $query->count();

    // ✅ Sorting & Pagination
    $varieties = $query
        ->orderBy($dbColumnName, $columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();

    // ✅ Prepare data for DataTables
$data_arr = [];
foreach ($varieties as $variety) {
    // Loop through feathers
    foreach ($variety->feathers as $f) {
        $data_arr[] = [
            'id' => $f->id,
            'type' => $variety->type,
            'variety' => $variety->name,
             'variety_id' => $variety->id,
            'feather' => $f->feather,
            'price' => $f->price,
            'image' => $variety->image,
              'quantity' => $f->quantity,
            'created_at' => $variety->created_at
                ? Carbon::parse($variety->created_at)->format('m/d/Y')
                : '-',
        ];
    }

    // Optional: Loop through kanals if needed
    foreach ($variety->kanals as $k) {
        $data_arr[] = [
            'id' => $k->id,
            'type' => $variety->type,
            'variety' => $variety->name,
            'variety_id' => $variety->id,
             'image' => $variety->image,
            'feather' => $k->feather,
            'price' => $k->price,
              'quantity' => $k->quantity,
            'created_at' => $variety->created_at
                ? Carbon::parse($variety->created_at)->format('m/d/Y')
                : '-',
        ];
    }
}

    

    // ✅ Response for DataTables
    return response()->json([
        "draw" => $draw,
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
    ]);
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

    public function bulkDestroyBilling(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:billings,id',
        ]);

        $ids = $request->ids;
        $deletedCount = Billing::whereIn('id', $ids)->delete();

        return response()->json([
            'status' => true,
            'message' => $deletedCount . ' billing address(es) deleted successfully.',
            'deleted_count' => $deletedCount,
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
        Mail::to('bismillahgmtraders@gmail.com')->send(new ContactMail($request->all()));

        return response()->json([
            'status' => 'success',
            'message' => 'Your message has been sent!'
        ]);
    }


public function allUsers(Request $request)
{
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length");

    // FIX OFFSET ERROR (very important)
    if ($rowperpage == -1 || $rowperpage == null) {
        $rowperpage = User::count();
    }

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    $columnIndex = $columnIndex_arr[0]['column'] ?? 0;
    $columnName = $columnName_arr[$columnIndex]['data'] ?? 'id';
    $columnSortOrder = $order_arr[0]['dir'] ?? 'desc';
    $searchValue = $search_arr['value'] ?? '';

    $columnMap = [
        'id' => 'id',
        'first_name' => 'first_name',
        'last_name' => 'last_name',
        'phone' => 'phone',
        'email' => 'email',
        'role' => 'role',
        'created_at' => 'created_at',
    ];

    $dbColumnName = $columnMap[$columnName] ?? 'id';

    $query = User::query();

    if (!empty($searchValue)) {
        $query->where(function ($q) use ($searchValue) {
            $q->where('first_name', 'like', "%$searchValue%")
              ->orWhere('last_name', 'like', "%$searchValue%")
              ->orWhere('email', 'like', "%$searchValue%")
              ->orWhere('phone', 'like', "%$searchValue%");
        });
    }

    $totalRecords = User::count();
    $totalRecordswithFilter = $query->count();

    $query->orderBy($dbColumnName, $columnSortOrder);
    $users = $query->skip($start)->take($rowperpage)->get();

    $data_arr = [];
    foreach ($users as $user) {
        $data_arr[] = [
            'id' => $user->id,
            'first_name' => $user->first_name ?? '-',
            'last_name' => $user->last_name ?? '-',
            'phone' => $user->phone ?? '-',
            'email' => $user->email ?? '-',
            'created_at' => $user->created_at ? $user->created_at->format('Y-m-d') : '-',
            'role' => $user->role ?? 'user',
        ];
    }

    return response()->json([
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
    ]);
}

public function User()
{
    return view('Admin.User.datatable');
}

public function exportUsers(Request $request)
{
    // Get search value if any (same as in allUsers method)
    $searchValue = $request->get('search', '');
    
    $query = User::query();
    
    if (!empty($searchValue)) {
        $query->where(function ($q) use ($searchValue) {
            $q->where('first_name', 'like', "%$searchValue%")
              ->orWhere('last_name', 'like', "%$searchValue%")
              ->orWhere('email', 'like', "%$searchValue%")
              ->orWhere('phone', 'like', "%$searchValue%");
        });
    }
    
    $users = $query->orderBy('id', 'desc')->get();
    
    $filename = 'users_export_' . date('Y-m-d_His') . '.csv';
    
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        'Pragma' => 'no-cache',
        'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
        'Expires' => '0'
    ];
    
    $callback = function() use ($users) {
        $file = fopen('php://output', 'w');
        
        // Add BOM for UTF-8 to support special characters in Excel
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // CSV Headers
        fputcsv($file, [
            'ID',
            'First Name',
            'Last Name',
            'Phone',
            'Email',
            'Farm Name',
            'Role',
            'Referral Code',
            'Created At',
            'Updated At'
        ]);
        
        // CSV Data
        foreach ($users as $user) {
            fputcsv($file, [
                $user->id ?? '-',
                $user->first_name ?? '-',
                $user->last_name ?? '-',
                $user->phone ?? '-',
                $user->email ?? '-',
                $user->farm_name ?? '-',
                $user->role ?? 'user',
                $user->referral_code ?? '-',
                $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : '-',
                $user->updated_at ? $user->updated_at->format('Y-m-d H:i:s') : '-',
            ]);
        }
        
        fclose($file);
    };
    
    return response()->stream($callback, 200, $headers);
}

public function exportSingleUser(Request $request, $id)
{
    $user = User::find($id);
    
    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User not found.'
        ], 404);
    }
    
    // Get selected export types from request
    $exportTypes = $request->input('export_types', ['general']);
    
    if (!is_array($exportTypes)) {
        $exportTypes = explode(',', $exportTypes);
    }
    
    // Create temporary directory for CSV files
    $baseTempDir = storage_path('app/temp_exports');
    if (!file_exists($baseTempDir)) {
        mkdir($baseTempDir, 0755, true);
    }
    $tempDir = $baseTempDir . '/' . uniqid('user_' . $id . '_', true);
    if (!file_exists($tempDir)) {
        mkdir($tempDir, 0755, true);
    }
    
    $csvFiles = [];
    
    // Generate General Information CSV
    if (in_array('general', $exportTypes)) {
        $csvFiles[] = $this->generateGeneralInfoCSV($user, $tempDir);
    }
    
    // Generate Community Posts CSV
    if (in_array('posts', $exportTypes)) {
        $csvFiles[] = $this->generateCommunityPostsCSV($user, $tempDir);
    }
    
    // Generate Orders CSV (may return multiple files: orders.csv and order_items.csv)
    if (in_array('orders', $exportTypes)) {
        $orderFiles = $this->generateOrdersCSV($user, $tempDir);
        $csvFiles = array_merge($csvFiles, $orderFiles);
    }
    
    // Generate Chats CSV
    if (in_array('chats', $exportTypes)) {
        $csvFiles[] = $this->generateChatsCSV($user, $tempDir);
    }
    
    // Create ZIP file
    $zipFilename = 'user_' . $user->id . '_' . str_replace(' ', '_', ($user->first_name ?? 'User')) . '_' . date('Y-m-d_His') . '.zip';
    $zipFilename = preg_replace('/[^a-zA-Z0-9_.-]/', '', $zipFilename);
    $zipPath = $tempDir . '/' . $zipFilename;
    
    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
        foreach ($csvFiles as $csvFile) {
            if (file_exists($csvFile)) {
                $zip->addFile($csvFile, basename($csvFile));
            }
        }
        $zip->close();
    }
    
    // Clean up individual CSV files
    foreach ($csvFiles as $csvFile) {
        if (file_exists($csvFile)) {
            unlink($csvFile);
        }
    }
    
    // Return ZIP file
    if (file_exists($zipPath)) {
        // Clean up temp directory files (not the zip yet)
        if (file_exists($tempDir)) {
            $files = glob($tempDir . '/*');
            foreach ($files as $file) {
                if (is_file($file) && $file != $zipPath) {
                    @unlink($file);
                }
            }
        }
        
        $headers = [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => 'attachment; filename="' . $zipFilename . '"',
            'Content-Length' => filesize($zipPath),
        ];
        
        // Clean up temp directory after response is sent
        // Use deleteFileAfterSend for the zip file, and manually clean directory
        $response = response()->download($zipPath, $zipFilename, $headers);
        
        // Clean up directory after file is sent
        $response->deleteFileAfterSend(true);
        
        // Schedule directory cleanup
        register_shutdown_function(function() use ($tempDir) {
            if (is_dir($tempDir)) {
                // Delete all files in directory first
                $files = array_diff(scandir($tempDir), array('.', '..'));
                foreach ($files as $file) {
                    @unlink($tempDir . '/' . $file);
                }
                // Remove directory
                @rmdir($tempDir);
            }
        });
        
        return $response;
    }
    
    return response()->json([
        'status' => false,
        'message' => 'Failed to create export files.'
    ], 500);
}

private function generateGeneralInfoCSV($user, $tempDir)
{
    $filename = $tempDir . '/general_information.csv';
    $file = fopen($filename, 'w');
    
    // Add BOM for UTF-8
    fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Headers
    fputcsv($file, ['Field', 'Value']);
    
    // Data
    $data = [
        ['ID', $user->id ?? '-'],
        ['First Name', $user->first_name ?? '-'],
        ['Last Name', $user->last_name ?? '-'],
        ['Phone', $user->phone ?? '-'],
        ['Email', $user->email ?? '-'],
        ['Farm Name', $user->farm_name ?? '-'],
        ['Role', $user->role ?? 'user'],
        ['Referral Code', $user->referral_code ?? '-'],
        ['Profile Image URL', $user->profile_image ?? '-'],
        ['Phone Verified At', $user->phone_verified_at ? $user->phone_verified_at->format('Y-m-d H:i:s') : '-'],
        ['Created At', $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : '-'],
        ['Updated At', $user->updated_at ? $user->updated_at->format('Y-m-d H:i:s') : '-'],
    ];
    
    foreach ($data as $row) {
        fputcsv($file, $row);
    }
    
    fclose($file);
    return $filename;
}

private function generateCommunityPostsCSV($user, $tempDir)
{
    $filename = $tempDir . '/community_posts.csv';
    $file = fopen($filename, 'w');
    
    // Add BOM for UTF-8
    fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Headers
    fputcsv($file, [
        'Post ID',
        'Description',
        'Before Image',
        'After Image',
        'Likes Count',
        'Comments Count',
        'Created At',
        'Updated At'
    ]);
    
    $posts = Community::where('user_id', $user->id)
        ->withCount(['likes', 'comments'])
        ->orderBy('created_at', 'desc')
        ->get();
    
    foreach ($posts as $post) {
        $beforeImage = $post->before_image ? url('uploads/community/' . $post->before_image) : '-';
        $afterImage = $post->after_image ? url('uploads/community/' . $post->after_image) : '-';
        
        fputcsv($file, [
            $post->id,
            $post->description ?? '-',
            $beforeImage,
            $afterImage,
            $post->likes_count ?? 0,
            $post->comments_count ?? 0,
            $post->created_at ? $post->created_at->format('Y-m-d H:i:s') : '-',
            $post->updated_at ? $post->updated_at->format('Y-m-d H:i:s') : '-',
        ]);
    }
    
    fclose($file);
    return $filename;
}

private function generateOrdersCSV($user, $tempDir)
{
    $files = [];
    $filename = $tempDir . '/orders.csv';
    $file = fopen($filename, 'w');
    
    // Add BOM for UTF-8
    fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Headers
    fputcsv($file, [
        'Order ID',
        'Order Number',
        'Status',
        'Order Type',
        'Subtotal',
        'Delivery Fee',
        'Total Amount',
        'Amount Paid',
        'Amount Remaining',
        'Is Partial Payment',
        'Pay Now',
        'Pay Later',
        'Is Verified',
        'Location',
        'Deliver Date',
        'Delivered Date',
        'Placed Date',
        'Name',
        'Created At',
        'Updated At'
    ]);
    
    $orders = Order::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();
    
    foreach ($orders as $order) {
        // Get raw values without accessors
        $orderRaw = $order->getAttributes();
        
        fputcsv($file, [
            $order->id,
            $order->order_id ?? '-',
            $orderRaw['status'] ?? '-',
            $order->order_type ?? '-',
            $orderRaw['subtotal'] ?? '0',
            $orderRaw['delivery_fee'] ?? '0',
            $orderRaw['total_amount'] ?? '0',
            $orderRaw['amount_paid'] ?? '0',
            $orderRaw['amount_remaining'] ?? '0',
            isset($orderRaw['is_partial_payment']) && $orderRaw['is_partial_payment'] ? 'Yes' : 'No',
            $orderRaw['pay_now'] ?? '0',
            $orderRaw['pay_later'] ?? '0',
            isset($orderRaw['is_verify']) && $orderRaw['is_verify'] ? 'Yes' : 'No',
            $order->location ?? '-',
            isset($orderRaw['deliver_date']) && $orderRaw['deliver_date'] ? Carbon::parse($orderRaw['deliver_date'])->format('Y-m-d') : '-',
            isset($orderRaw['delivered_date']) && $orderRaw['delivered_date'] ? Carbon::parse($orderRaw['delivered_date'])->format('Y-m-d') : '-',
            isset($orderRaw['placed_date']) && $orderRaw['placed_date'] ? Carbon::parse($orderRaw['placed_date'])->format('Y-m-d') : '-',
            $order->name ?? '-',
            $order->created_at ? $order->created_at->format('Y-m-d H:i:s') : '-',
            $order->updated_at ? $order->updated_at->format('Y-m-d H:i:s') : '-',
        ]);
    }
    
    fclose($file);
    $files[] = $filename;
    
    // Create separate CSV for order items if orders exist
    if ($orders->count() > 0) {
        $itemsFilename = $tempDir . '/order_items.csv';
        $itemsFile = fopen($itemsFilename, 'w');
        fprintf($itemsFile, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($itemsFile, [
            'Order ID',
            'Order Number',
            'Product ID',
            'Variety',
            'Quality',
            'Price',
            'Quantity',
            'Total Price',
            'Image',
            'Cart Type'
        ]);
        
        foreach ($orders as $order) {
            $items = order_items::where('order_id', $order->id)->get();
            foreach ($items as $item) {
                fputcsv($itemsFile, [
                    $order->id,
                    $order->order_id ?? '-',
                    $item->product_id ?? '-',
                    $item->variety ?? '-',
                    $item->quality ?? '-',
                    $item->price ?? '0',
                    $item->quantity ?? '0',
                    $item->total_price ?? '0',
                    $item->image ?? '-',
                    $item->cart_type ?? '-',
                ]);
            }
        }
        
        fclose($itemsFile);
        $files[] = $itemsFilename;
    }
    
    return $files;
}

private function generateChatsCSV($user, $tempDir)
{
    $filename = $tempDir . '/chats.csv';
    $file = fopen($filename, 'w');
    
    // Add BOM for UTF-8
    fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Headers
    fputcsv($file, [
        'Message ID',
        'Sender ID',
        'Sender Name',
        'Receiver ID',
        'Receiver Name',
        'Message',
        'Created At',
        'Updated At'
    ]);
    
    // Get all chats where user is sender or receiver
    $chats = Chat::where(function($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
        })
        ->with(['sender', 'receiver'])
        ->orderBy('created_at', 'asc')
        ->get();
    
    foreach ($chats as $chat) {
        $senderName = $chat->sender ? ($chat->sender->first_name . ' ' . $chat->sender->last_name) : 'Unknown';
        $receiverName = $chat->receiver ? ($chat->receiver->first_name . ' ' . $chat->receiver->last_name) : 'Unknown';
        
        fputcsv($file, [
            $chat->id,
            $chat->sender_id,
            trim($senderName),
            $chat->receiver_id,
            trim($receiverName),
            $chat->message ?? '-',
            $chat->created_at ? $chat->created_at->format('Y-m-d H:i:s') : '-',
            $chat->updated_at ? $chat->updated_at->format('Y-m-d H:i:s') : '-',
        ]);
    }
    
    fclose($file);
    return $filename;
}

public function destroyuser($id)
    {
        $material = User::find($id);

        if (!$material) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found.',
            ], 404);
        }

        // Prevent deletion of admin users
        if ($material->role === 'admin') {
            return response()->json([
                'status' => false,
                'message' => 'Admin users cannot be deleted.',
            ], 403);
        }

        $material->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully.',
        ], 200);
    }

    public function bulkDestroyUser(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:users,id',
        ]);

        $ids = $request->ids;
        $deletedCount = 0;
        $skippedCount = 0;

        foreach ($ids as $id) {
            $user = User::find($id);
            if ($user) {
                // Skip admin users
                if ($user->role === 'admin') {
                    $skippedCount++;
                    continue;
                }
                $user->delete();
                $deletedCount++;
            }
        }

        $message = $deletedCount . ' user(s) deleted successfully.';
        if ($skippedCount > 0) {
            $message .= ' ' . $skippedCount . ' admin user(s) were skipped (cannot be deleted).';
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'deleted_count' => $deletedCount,
            'skipped_count' => $skippedCount,
        ], 200);
    }
    
        public function Addprompt()
    {
            $prompt = DB::table('prompts')->where('id', 1)->value('text');
        return view('Admin.prompt' , compact('prompt'));
    }

    public function updateprompt(Request $request)
{
    
   
    $request->validate([
        'prompt_text' => 'required|string'
    ]);

    Prompt::updateOrCreate(
        ['id' => 1],
        ['text' => $request->prompt_text]
    );

    return response()->json(['status' => true]);
}




   public function fetch()
    {
        $reasons = Replace::pluck('replace');


        return response()->json([
            'status' => true,
            'message' => 'Reasons fetched successfully',
            'data' => $reasons
        ], 200);
    }



public function savereplace(Request $request)
{
    $request->validate([
        'replace' => 'required|string|max:255'
    ]);

    Replace::create([
        'replace' => $request->replace
    ]);

    if ($request->ajax()) {
        return response()->json([
            'status' => true,
            'message' => 'Reason added successfully'
        ], 200);
    }

    return redirect()->back()->with('success', 'Replace reason added successfully');
}



public function replace()
{
   return view('Admin.Orders.reasons');

}

   public function fetchreason()
    {
        $reasons = Replace::select('id', 'replace')->get();


        return response()->json([
            'status' => true,
            'message' => 'Reasons fetched successfully',
            'data' => $reasons
        ], 200);
    }

    public function profile()
    {
        return view('Admin.profile');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

   public function updateReplace(Request $request, $id)
    {
        $request->validate([
            'replace' => 'required|string|max:255'
        ]);

        $reason = Replace::findOrFail($id);
        $reason->update([
            'replace' => $request->replace
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Reason updated successfully'
        ], 200);
    }

    public function deleteReplace($id)
    {
        $reason = Replace::findOrFail($id);
        $reason->delete();

        return response()->json([
            'status' => true,
            'message' => 'Reason deleted successfully'
        ], 200);
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

    $feather->update([
        'feather' => $request->feather,
        'price' => $request->price,
        'quantity' => $request->quantity,
    ]);

    return response()->json([
        'status' => true,
        'message' => ucfirst($request->type) . ' feather updated successfully.',
        'data' => $feather
    ]);
}

// Community Posts Management
public function communityPosts()
{
    return view('Admin.Community.datatable');
}

public function communityPostsData(Request $request)
{
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length");

    if ($rowperpage == -1 || $rowperpage == null) {
        $rowperpage = Community::count();
    }

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    $columnIndex = $columnIndex_arr[0]['column'] ?? 0;
    $columnName = $columnName_arr[$columnIndex]['data'] ?? 'id';
    $columnSortOrder = $order_arr[0]['dir'] ?? 'desc';
    $searchValue = $search_arr['value'] ?? '';

    $columnMap = [
        'id' => 'id',
        'user_name' => 'first_name',
        'description' => 'description',
        'created_at' => 'created_at',
    ];

    $dbColumnName = $columnMap[$columnName] ?? 'id';

    $query = Community::with('user:id,first_name,last_name,email,profile_image')
        ->withCount(['likes', 'comments']);

    if (!empty($searchValue)) {
        $query->where(function ($q) use ($searchValue) {
            $q->where('description', 'like', "%$searchValue%")
              ->orWhereHas('user', function($userQuery) use ($searchValue) {
                  $userQuery->where('first_name', 'like', "%$searchValue%")
                           ->orWhere('last_name', 'like', "%$searchValue%")
                           ->orWhere('email', 'like', "%$searchValue%");
              });
        });
    }

    $totalRecords = Community::count();
    $totalRecordswithFilter = $query->count();

    // Adjust sorting for user name
    if ($columnName === 'user_name') {
        $query->leftJoin('users', 'communities.user_id', '=', 'users.id')
              ->select('communities.*')
              ->orderBy('users.first_name', $columnSortOrder);
    } else {
        $query->orderBy('communities.' . $dbColumnName, $columnSortOrder);
    }

    $posts = $query->skip($start)->take($rowperpage)->get();

    $data_arr = [];
    foreach ($posts as $post) {
        $userName = $post->user 
            ? ($post->user->first_name . ' ' . $post->user->last_name)
            : 'Unknown User';
        
        $data_arr[] = [
            'id' => $post->id,
            'user_id' => $post->user_id,
            'user_name' => $userName,
            'user_email' => $post->user ? $post->user->email : '-',
            'description' => $post->description ? (strlen($post->description) > 50 ? substr($post->description, 0, 50) . '...' : $post->description) : '-',
            'before_image' => $post->before_image ? asset('uploads/community/' . $post->before_image) : null,
            'after_image' => $post->after_image ? asset('uploads/community/' . $post->after_image) : null,
            'likes_count' => $post->likes_count ?? 0,
            'comments_count' => $post->comments_count ?? 0,
            'created_at' => $post->created_at ? $post->created_at->format('Y-m-d H:i:s') : '-',
        ];
    }

    return response()->json([
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
    ]);
}

public function userCommunityPosts($userId)
{
    $user = User::find($userId);
    if (!$user) {
        abort(404, 'User not found');
    }
    
    return view('Admin.Community.user_posts', compact('userId', 'user'));
}

public function userCommunityPostsData(Request $request, $userId)
{
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length");

    if ($rowperpage == -1 || $rowperpage == null) {
        $rowperpage = Community::where('user_id', $userId)->count();
    }

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    $columnIndex = $columnIndex_arr[0]['column'] ?? 0;
    $columnName = $columnName_arr[$columnIndex]['data'] ?? 'id';
    $columnSortOrder = $order_arr[0]['dir'] ?? 'desc';
    $searchValue = $search_arr['value'] ?? '';

    $columnMap = [
        'id' => 'id',
        'description' => 'description',
        'created_at' => 'created_at',
    ];

    $dbColumnName = $columnMap[$columnName] ?? 'id';

    $query = Community::where('user_id', $userId)
        ->with('user:id,first_name,last_name,email,profile_image')
        ->withCount(['likes', 'comments']);

    if (!empty($searchValue)) {
        $query->where('description', 'like', "%$searchValue%");
    }

    $totalRecords = Community::where('user_id', $userId)->count();
    $totalRecordswithFilter = $query->count();

    $query->orderBy($dbColumnName, $columnSortOrder);
    $posts = $query->skip($start)->take($rowperpage)->get();

    $data_arr = [];
    foreach ($posts as $post) {
        $userName = $post->user 
            ? ($post->user->first_name . ' ' . $post->user->last_name)
            : 'Unknown User';
        
        $data_arr[] = [
            'id' => $post->id,
            'user_id' => $post->user_id,
            'user_name' => $userName,
            'user_email' => $post->user ? $post->user->email : '-',
            'description' => $post->description ? (strlen($post->description) > 50 ? substr($post->description, 0, 50) . '...' : $post->description) : '-',
            'before_image' => $post->before_image ? asset('uploads/community/' . $post->before_image) : null,
            'after_image' => $post->after_image ? asset('uploads/community/' . $post->after_image) : null,
            'likes_count' => $post->likes_count ?? 0,
            'comments_count' => $post->comments_count ?? 0,
            'created_at' => $post->created_at ? $post->created_at->format('Y-m-d H:i:s') : '-',
        ];
    }

    return response()->json([
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
    ]);
}

public function destroyCommunityPost($id)
{
    $post = Community::find($id);

    if (!$post) {
        return response()->json([
            'status' => false,
            'message' => 'Post not found.',
        ], 404);
    }

    // Delete associated images
    if ($post->before_image && File::exists(public_path('uploads/community/' . $post->before_image))) {
        File::delete(public_path('uploads/community/' . $post->before_image));
    }
    
    if ($post->after_image && File::exists(public_path('uploads/community/' . $post->after_image))) {
        File::delete(public_path('uploads/community/' . $post->after_image));
    }

    // Delete related likes and comments first
    $post->likes()->delete();
    $post->comments()->delete();
    
    $post->delete();

    return response()->json([
        'status' => true,
        'message' => 'Post deleted successfully.',
    ], 200);
}

public function bulkDestroyCommunityPosts(Request $request)
{
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'required|integer|exists:communities,id',
    ]);

    $ids = $request->ids;
    $deletedCount = 0;

    foreach ($ids as $id) {
        $post = Community::find($id);
        if ($post) {
            // Delete associated images
            if ($post->before_image && File::exists(public_path('uploads/community/' . $post->before_image))) {
                File::delete(public_path('uploads/community/' . $post->before_image));
            }
            
            if ($post->after_image && File::exists(public_path('uploads/community/' . $post->after_image))) {
                File::delete(public_path('uploads/community/' . $post->after_image));
            }

            // Delete related likes and comments
            $post->likes()->delete();
            $post->comments()->delete();
            
            $post->delete();
            $deletedCount++;
        }
    }

    return response()->json([
        'status' => true,
        'message' => $deletedCount . ' post(s) deleted successfully.',
        'deleted_count' => $deletedCount,
    ], 200);
}









// Get comments for a post
public function getPostComments($postId)
{
    $post = Community::find($postId);

    if (!$post) {
        return response()->json([
            'status' => false,
            'message' => 'Post not found.',
        ], 404);
    }

    $comments = PostComment::with('user:id,first_name,last_name,email,profile_image')
        ->where('post_id', $postId)
        ->orderBy('created_at', 'desc')
        ->get();

    $data = $comments->map(function ($comment) {
        return [
            'id' => $comment->id,
            'post_id' => $comment->post_id,
            'user_id' => $comment->user_id,
            'user_name' => $comment->user ? ($comment->user->first_name . ' ' . $comment->user->last_name) : 'Unknown User',
            'user_email' => $comment->user ? $comment->user->email : '-',
            'profile_image' => $comment->user && $comment->user->profile_image 
                ? asset($comment->user->profile_image) 
                : null,
            'comment' => $comment->comment,
            'created_at' => $comment->created_at ? $comment->created_at->format('Y-m-d H:i:s') : '-',
        ];
    });

    return response()->json([
        'status' => true,
        'message' => 'Comments retrieved successfully',
        'data' => $data,
    ], 200);
}

// Delete a comment
public function destroyComment($id)
{
    $comment = PostComment::find($id);

    if (!$comment) {
        return response()->json([
            'status' => false,
            'message' => 'Comment not found.',
        ], 404);
    }

    $comment->delete();

    return response()->json([
        'status' => true,
        'message' => 'Comment deleted successfully.',
    ], 200);
}

// Bulk delete comments
public function bulkDestroyComments(Request $request)
{
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'required|integer|exists:post_comments,id',
    ]);

    $ids = $request->ids;
    $deletedCount = PostComment::whereIn('id', $ids)->delete();

    return response()->json([
        'status' => true,
        'message' => $deletedCount . ' comment(s) deleted successfully.',
        'deleted_count' => $deletedCount,
    ], 200);
}

// Get likes for a post
public function getPostLikes($postId)
{
    $post = Community::find($postId);

    if (!$post) {
        return response()->json([
            'status' => false,
            'message' => 'Post not found.',
        ], 404);
    }

    $likes = PostLike::with('user:id,first_name,last_name,email,profile_image')
        ->where('post_id', $postId)
        ->orderBy('created_at', 'desc')
        ->get();

    $data = $likes->map(function ($like) {
        return [
            'id' => $like->id,
            'post_id' => $like->post_id,
            'user_id' => $like->user_id,
            'user_name' => $like->user ? ($like->user->first_name . ' ' . $like->user->last_name) : 'Unknown User',
            'user_email' => $like->user ? $like->user->email : '-',
            'profile_image' => $like->user && $like->user->profile_image 
                ? asset($like->user->profile_image) 
                : null,
            'created_at' => $like->created_at ? $like->created_at->format('Y-m-d H:i:s') : '-',
        ];
    });

    return response()->json([
        'status' => true,
        'message' => 'Likes retrieved successfully',
        'data' => $data,
    ], 200);
}

}