<?php

namespace App\Http\Controllers\Api;
use App\Models\Order;
use App\Models\order_items;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderCompletedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\OrderReplacement;
use App\Models\Billing;


class OrderController extends Controller
{




   public function store(Request $request)
{

    // // ✅ Validate incoming data
    // $request->validate([
    //     'name' => 'required|string|max:255',
    //     'location' => 'nullable|string|max:255',
    //     'placed_date' => 'nullable|date',
    //     'deliver_date' => 'nullable|date',
    //     'amount_paid' => 'required|numeric',
    //     'amount_remaining' => 'nullable|numeric',
    //     'items' => 'required|integer|min:1',
    //     'status' => 'nullable|string|in:pending,complete',
    // ]);
   // return $request;

    // ✅ Generate unique order number
    $orderNumber = 'OR-' . rand(1000000, 9999999);

    // ✅ Store in database
    $order = Order::create([
        'order_id' => $orderNumber,
        'name' => $request->name,
        'location' => $request->location,
        'placed_date' => $request->placed_date ?? now(),
        'deliver_date' => $request->deliver_date,
          'delivered_date' => $request->delivered_date,
        'amount_paid' => $request->amount_paid,
        'amount_remaining' => $request->amount_remaining,
        'items' => $request->items,
        'status' => $request->status ?? 'pending', // default to pending
    ]);

    // ✅ Return success response
    return response()->json([
        'status' => true,
        'message' => 'Order created successfully',
        'data' => $order
    ]);
}


//     public function getOrders()
// {
//         $userId = auth()->id();
//           Log::info('Create Order Request Data:',  ['user_id' => $userId] );
//     // Fetch pending orders
//     $pendingOrders = Order::where('user_id', $userId)->where('status', 'pending')->orderBy('id', 'desc')->get();

//     // Fetch completed orders
//     $completedOrders = Order::where('user_id', $userId)->where('status', 'completed')->orderBy('id', 'desc')->get();


//     // Return both in one response
//     return response()->json([
//         'status' => true,https://github.com/ajaxorg/ace/wiki/Default-Keyboard-Shortcuts
//          'message' => 'all Order fetch  successfully',
//         'pending_orders' => $pendingOrders,
//         'completed_orders' => $completedOrders,
//     ]);
// }


//   public function getOrders()
// {
    
//         $userId = auth()->id();
//           Log::info('Create Order Request Data:',  ['user_id' => $userId] );
//   // Fetch pending orders
//     $pendingOrders = Order::with('billing')->where('user_id', $userId)->where('status', 'pending')->orderBy('id', 'desc')->get();

//     // Fetch completed orders
//     $completedOrders = Order::with(['orderItems', 'billing'])->where('user_id', $userId)->where('status', 'completed')->orderBy('id', 'desc')->get();
//     //   $replaceOrders = Order::with('orderReplacements')->where('status', 'completed')->orderBy('id', 'desc')->get();
//     $replaceOrders = Order::with(['orderItems', 'orderReplacements'])
//     ->where('status', 'completed')
//     ->orderBy('id', 'desc')
//     ->get();

//       Log::info('Create Order Request Data:',  ['vbn' =>$replaceOrders ] );


//     // Return both in one response
//     return response()->json([
//         'status' => true,
//          'message' => 'all Order fetch  successfully',
//         'pending_orders' => $pendingOrders,
//         'completed_orders' => $completedOrders,
//           'replacement_orders' =>  $replaceOrders,
        
//     ]);
//}


     public function getOrders()
{

        $userId = auth()->id();
          Log::info('Get Orders Request Data:',  ['user_id' => $userId] );
  // Fetch pending orders
    // $pendingOrders = Order::with(['billing', 'orderItems'])->where('user_id', $userId)->where('status', 'pending')->orderBy('id', 'desc')->get();

    // Fetch completed orders
   
  
       $pendingOrders = Order::with(['billing', 'orderItems'])->where('user_id', $userId)->where('status', 'pending')->orderBy('id', 'desc')->get();
     $completedOrders = Order::with(['billing', 'orderItems'])->where('user_id', $userId)->where('status', 'completed')->orderBy('id', 'desc')->get();
       $replaceOrders = Order::with(['orderItems', 'orderReplacements'])
    ->whereHas('orderReplacements')
    ->where('user_id', $userId)
    ->where('status', 'completed')
    ->orderBy('id', 'desc')
    ->get();


    //     $completedOrders = Order::where('user_id', $userId)
    // ->where('status', 'completed')
    //  ->orderBy('id', 'desc')
    
    // ->get();

    // $completedOrders = Order::with(['orderItems', 'billing'])->where('user_id', '$userId')->where('status', 'completed')->orderBy('id', 'desc')->get();
    //   $replaceOrders = Order::with('orderReplacements')->where('status', 'completed')->orderBy('id', 'desc')->get();
  

       Log::info('Replacement Orders Data:',  ['complete' =>  $replaceOrders ] );


    // Return both in one response
    return response()->json([
        'status' => true,
         'message' => 'all Order fetch  successfully',
       'pending_orders' => $pendingOrders,
        'completed_orders' => $completedOrders,
        'replacement_orders' =>  $replaceOrders,

    ]);
}

//order admin side

public function confirmorder($orderId)
    {
        $completeorder = Order::find($orderId);

        if (!$completeorder) {
            return response()->json(['status' => false, 'message' => 'Order not found'], 404);
        }

        // Update order status to completed
        $completeorder->status = 'completed';
     //   $completeorder->delivered_date = Carbon::now()->addDays(7);
        $completeorder->save();
       return response()->json([
        'status' => true,
        'message' => 'Order confirmed successfully',
        'order' => $completeorder
    ]);



}


public function setDeliveredDate(Request $request, $id)
{
    $request->validate([
        'delivered_date' => 'required|date',
    ]);

    $order = Order::find($id);

    if (!$order) {
        return response()->json(['status' => false, 'message' => 'Order not found']);
    }

    $order->delivered_date = $request->delivered_date;
    $order->save();

    return response()->json([
        'status' => true,
        'message' => 'Delivered date set successfully!',
        'data' => $order
    ]);
}




 public function pendingorders()
    {
        return view('Admin.Orders.pending_orders');
    }

    public function pendingOrdersData(Request $request)
    {
        return $this->ordersData($request, 'pending');
    }



     public function completeorders()
    {
        return view('Admin.Orders.complete_orders');
    }

    public function completeOrdersData(Request $request)
    {
        return $this->ordersData($request, 'completed');
    }

    public function allorders()
    {
        return view('Admin.Orders.all_orders');
    }

    public function allOrdersData(Request $request)
    {
        return $this->ordersData($request, null);
    }

    public function getOrderCounts()
    {
        $total = Order::count();
        $pending = Order::where('status', 'pending')->count();
        $completed = Order::where('status', 'completed')->count();
          $cancelled = Order::where('status', 'cancelled')->count();
        
        return response()->json([
            'status' => true,
            'data' => [
                'total' => $total,
                'pending' => $pending,
                'completed' => $completed,
                  'cancelled' => $cancelled
            ]
        ]);
    }

    public function searchCustomers(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'status' => true,
                'data' => []
            ]);
        }

        $customers = Order::select('name', 'order_id')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('order_id', 'like', '%' . $query . '%');
            })
            ->groupBy('name', 'order_id')
            ->limit(10)
            ->get()
            ->map(function($order) {
                return [
                    'id' => $order->order_id,
                    'text' => $order->name . ' (' . $order->order_id . ')',
                    'name' => $order->name,
                    'order_id' => $order->order_id
                ];
            });

        return response()->json([
            'status' => true,
            'data' => $customers
        ]);
    }

    public function searchProducts(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'status' => true,
                'data' => []
            ]);
        }

        $products = order_items::select('product_id', 'variety')
            ->where(function($q) use ($query) {
                $q->where('product_id', 'like', '%' . $query . '%')
                  ->orWhere('variety', 'like', '%' . $query . '%');
            })
            ->groupBy('product_id', 'variety')
            ->limit(10)
            ->get()
            ->map(function($item) {
                $display = $item->product_id;
                if ($item->variety) {
                    $display .= ' - ' . $item->variety;
                }
                return [
                    'id' => $item->product_id,
                    'text' => $display,
                    'product_id' => $item->product_id,
                    'variety' => $item->variety
                ];
            });

        return response()->json([
            'status' => true,
            'data' => $products
        ]);
    }

    public function getOrderDetail($id)
    {
        $order = Order::with(['orderitems', 'billing'])->find($id);
        
        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $rawOrder = $order->getAttributes();
        
        return response()->json([
            'status' => true,
            'data' => [
                'id' => $order->id,
                'order_id' => $rawOrder['order_id'] ?? '-',
                'name' => $rawOrder['name'] ?? '-',
                'location' => $rawOrder['location'] ?? '-',
                'placed_date' => isset($rawOrder['placed_date']) && $rawOrder['placed_date'] ? Carbon::parse($rawOrder['placed_date'])->format('Y-m-d') : null,
                'deliver_date' => isset($rawOrder['deliver_date']) && $rawOrder['deliver_date'] ? Carbon::parse($rawOrder['deliver_date'])->format('Y-m-d') : null,
                'delivered_date' => isset($rawOrder['delivered_date']) && $rawOrder['delivered_date'] ? Carbon::parse($rawOrder['delivered_date'])->format('Y-m-d') : null,
                'placed_date_formatted' => isset($rawOrder['placed_date']) && $rawOrder['placed_date'] ? Carbon::parse($rawOrder['placed_date'])->format('M j, Y') : '-',
                'deliver_date_formatted' => isset($rawOrder['deliver_date']) && $rawOrder['deliver_date'] ? Carbon::parse($rawOrder['deliver_date'])->format('M j, Y') : '-',
                'delivered_date_formatted' => isset($rawOrder['delivered_date']) && $rawOrder['delivered_date'] ? Carbon::parse($rawOrder['delivered_date'])->format('M j, Y') : '-',
                'amount_paid' => $rawOrder['amount_paid'] ?? 0,
                'amount_remaining' => $rawOrder['amount_remaining'] ?? 0,
                'status' => $rawOrder['status'] ?? 'pending',
                'subtotal' => $rawOrder['subtotal'] ?? 0,
                'delivery_fee' => $rawOrder['delivery_fee'] ?? 0,
                'total_amount' => $rawOrder['total_amount'] ?? 0,
                'items' => $order->orderitems->map(function($item) {
                    return [
                        'id' => $item->id,
                        'product_id' => $item->product_id ?? 'N/A',
                        'variety' => $item->variety ?? 'N/A',
                        'quality' => $item->quality ?? 'N/A',
                        'price' => $item->price ?? 0,
                        'quantity' => $item->quantity ?? 0,
                        'total_price' => $item->total_price ?? 0,
                    ];
                }),
                'billing' => $order->billing ? [
                    'full_name' => $order->billing->full_name ?? '',
                    'phone' => $order->billing->phone ?? '',
                    'address' => $order->billing->address ?? '',
                    'city' => $order->billing->city ?? '',
                    'state' => $order->billing->state ?? '',
                ] : null
            ]
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found'
            ], 404);
        }
        
              $order = Order::with('user')->find($id); 



        // Explicitly set status as string to avoid SQL issues
        $order->status = (string) $request->status;
        $order->save();
        
        if ($request->status === 'completed') {
    if ($order->user && !empty($order->user->email)) {
        Mail::to('rabiarajpoot4040@gmail.com')
            ->send(new OrderCompletedMail($order));
    }
}

        return response()->json([
            'status' => true,
            'message' => 'Order status updated successfully',
            'data' => $order
        ]);
    }

    public function cancelOrder($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found'
            ], 404);
        }

        // Explicitly set status as string to avoid SQL issues
        $order->status = (string) 'cancelled';
        $order->save();

        return response()->json([
            'status' => true,
            'message' => 'Order cancelled successfully',
            'data' => $order
        ]);
    }

    public function updateDeliveryDate(Request $request, $id)
    {
        $request->validate([
            'deliver_date' => 'nullable|date',
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if ($request->has('deliver_date')) {
            $order->deliver_date = $request->deliver_date;
        }
        $order->save();

        return response()->json([
            'status' => true,
            'message' => 'Delivery date updated successfully',
            'data' => $order
        ]);
    }

    private function ordersData(Request $request, $status = null)
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
            'order_id' => 'order_id',
            'name' => 'name',
            'status' => 'status',
            'placed_date' => 'placed_date',
            'deliver_date' => 'deliver_date',
            'payment status' => 'is_verify',
            'partial pay' =>'pay_now',
            'partial remaining' => 'pay_later',
        ];

        $dbColumnName = $columnMap[$columnName] ?? 'id';

        $query = Order::query();
        
        // Status filter (from card click or existing filter)
        if ($status) {
            $query->where('status', $status);
        } else {
            // Check for status filter in request
            $statusFilter = $request->get('status_filter');
            if ($statusFilter && in_array($statusFilter, ['pending', 'completed', 'cancelled'])) {
                $query->where('status', $statusFilter);
            }
        }

        // Date range filter
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        if ($dateFrom) {
            $query->whereDate('placed_date', '>=', Carbon::parse($dateFrom)->format('Y-m-d'));
        }
        if ($dateTo) {
            $query->whereDate('placed_date', '<=', Carbon::parse($dateTo)->format('Y-m-d'));
        }

        // Customer search filter
        $customerSearch = $request->get('customer_search');
        if ($customerSearch) {
            $query->where(function($q) use ($customerSearch) {
                $q->where('name', 'like', '%' . $customerSearch . '%')
                  ->orWhere('order_id', 'like', '%' . $customerSearch . '%');
            });
        }

        // Product search filter
        $productSearch = $request->get('product_search');
        if ($productSearch) {
            $query->whereHas('orderitems', function($q) use ($productSearch) {
                $q->where('product_id', 'like', '%' . $productSearch . '%')
                  ->orWhere('variety', 'like', '%' . $productSearch . '%');
            });
        }

        // General search
        if ($searchValue != '') {
            $query->where(function($q) use ($searchValue) {
                $q->where('order_id', 'like', '%' . $searchValue . '%')
                  ->orWhere('name', 'like', '%' . $searchValue . '%')
                  ->orWhere('location', 'like', '%' . $searchValue . '%')
                  ->orWhere('status', 'like', '%' . $searchValue . '%');
            });
        }

        $totalRecords = $status ? Order::where('status', $status)->count() : Order::count();
        $totalRecordswithFilter = $query->count();

        $query->orderBy($dbColumnName, $columnSortOrder);
        $orders = $query->skip($start)->take($rowperpage)->get();

        $data_arr = [];
        foreach ($orders as $order) {
            $rawOrder = $order->getAttributes();
            $data_arr[] = [
                'id' => $order->id,
                'order_id' => $rawOrder['order_id'] ?? '-',
                'name' => $rawOrder['name'] ?? '-',
                'location' => $rawOrder['location'] ?? '-',
                'placed_date' => isset($rawOrder['placed_date']) && $rawOrder['placed_date'] ? Carbon::parse($rawOrder['placed_date'])->format('m/d/Y') : '-',
                'deliver_date' => isset($rawOrder['deliver_date']) && $rawOrder['deliver_date'] ? Carbon::parse($rawOrder['deliver_date'])->format('m/d/Y') : null,
                'delivered_date' => isset($rawOrder['delivered_date']) && $rawOrder['delivered_date'] ? Carbon::parse($rawOrder['delivered_date'])->format('m/d/Y') : null,
                'amount_paid' => $rawOrder['amount_paid'] ?? 0,
                'amount_remaining' => $rawOrder['amount_remaining'] ?? 0,
                'status' => $rawOrder['status'] ?? '-',
                'subtotal' => $rawOrder['subtotal'] ?? 0,
                'delivery_fee' => $rawOrder['delivery_fee'] ?? 0,
                'total_amount' => $rawOrder['total_amount'] ?? 0,
                'is_verify' => $rawOrder['is_verify'] ?? 0,
               'pay_now' => ($rawOrder['pay_now'] ?? 0) + 250,
                 'pay_later' => $rawOrder['pay_later'] ?? 0,
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
        $material = Order::find($id);

        if (!$material) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found.',
            ], 404);
        }
         $material->orderReplacements()->delete();

        $material->delete();

        return response()->json([
            'status' => true,
            'message' => 'Order deleted successfully.',
        ], 200);
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:orders,id',
        ]);

        $ids = $request->ids;
        $deletedCount = 0;

        foreach ($ids as $id) {
            $order = Order::find($id);
            if ($order) {
                $order->orderReplacements()->delete();
                $order->delete();
                $deletedCount++;
            }
        }

        return response()->json([
            'status' => true,
            'message' => $deletedCount . ' order(s) deleted successfully.',
            'deleted_count' => $deletedCount,
        ], 200);
    }


    public function show($id)
{
          $order = Order::with(['orderitems', 'billing'])->findOrFail($id);
      
   //  dd($order->id, \App\Models\Billing::where('order_id', $order->order_id)->first());



     return view('Admin.Orders.order_detail', compact('order'));
}

  public function replacementOrders()
    {
        $replacements = \App\Models\OrderReplacement::with(['order', 'billing'])->get();

        return view('Admin.Orders.replacement_order', compact('replacements'));
    }




 public function Replaceorder(Request $request)
{
    Log::info('Replace Order API hit');
    Log::info('Request Data:', $request->all());

    // Validate the request
    $request->validate([
        'orderId' => 'required|string',
        'reason' => 'required|string',
        'description' => 'nullable|string',
        'quantity' => 'required|integer|min:1',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Find the order
    $order = Order::where('order_id', $request->orderId)->first();
    if (!$order) {
        return response()->json([
            'status' => false,
            'message' => 'Order not found'
        ], 404);
    }
    
$order->update(['order_type' => 'pending']);


    // Find the billing
    $billing = Billing::where('order_id', $request->orderId)->first();

    // Handle image upload
    $imagePath = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/replacements'), $imageName);
        $imagePath = 'uploads/replacements/' . $imageName;
    }

    // Create the replacement
    $replacement = OrderReplacement::create([
        'order_id' => $request->orderId,
        'billing_id' => $billing ? $billing->id : null,
        'reason' => $request->reason,
        'description' => $request->description,
        'quantity_to_replace' => $request->quantity,
        'image' => $imagePath,
        
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Order replacement created successfully',
        'data' => $replacement
    ]);
}

 public function updateReplacementStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Toggle logic: if current order_type is 'Replaced', change to 'pending', otherwise change to 'Replaced'
        if ($request->action === 'toggle_replace') {
            $order->order_type = ($order->order_type === 'Replaced') ? 'pending' : 'Replaced';
        } else {
            // Fallback for direct status setting
            $request->validate([
                'status' => 'required|string'
            ]);
            $order->order_type = $request->status;
        }

        $order->save();

        return response()->json([
            'status' => true,
            'message' => 'Status updated successfully',
            'new_status' => $order->order_type
        ]);
    }
    
       public function deleteReplacement($id)
    {
        try {
            $replacement = \App\Models\OrderReplacement::findOrFail($id);
            $replacement->delete();

            return response()->json([
                'status' => true,
                'message' => 'Replacement order deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete replacement: ' . $e->getMessage()
            ], 500);
        }
    }

}
