<?php

namespace App\Http\Controllers\Api;
use App\Models\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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


    public function getOrders()
{
        $userId = auth()->id();
          Log::info('Create Order Request Data:',  ['user_id' => $userId] );
    // Fetch pending orders
    $pendingOrders = Order::where('user_id', $userId)->where('status', 'pending')->orderBy('id', 'desc')->get();

    // Fetch completed orders
    $completedOrders = Order::where('user_id', $userId)->where('status', 'completed')->orderBy('id', 'desc')->get();


    // Return both in one response
    return response()->json([
        'status' => true,
         'message' => 'all Order fetch  successfully',
        'pending_orders' => $pendingOrders,
        'completed_orders' => $completedOrders,
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
        $pendingOrders = Order::where('status', 'pending')->orderBy('id', 'desc')   // or any column you want
                     ->get();

        // $completedOrders = Order::where('status', 'completed')
        //     ->whereNotNull('delivered_date')
        //     ->get();

        // return response()->json([
        //     'status' => true,
        //     'message' => 'All orders fetched successfully',
        //     'pending_orders' => $pendingOrders,
        //     'completed_orders' => $completedOrders,
        // ]);

        return view('Admin.Orders.pending_orders' ,  ['Orders' =>  $pendingOrders]);
    }



     public function completeorders()
    {
        $completeOrders = Order::where('status', 'completed')->orderBy('id', 'desc')   // or any column you want
                     ->get();



        return view('Admin.Orders.complete_orders' ,  ['Orders' => $completeOrders]);
    }

    public function allorders()
    {
        $allOrders = Order::orderBy('id', 'desc')   // or any column you want
                     ->get();



        return view('Admin.Orders.all_orders' ,  ['Orders' => $allOrders]);
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

        $material->delete();

        return response()->json([
            'status' => true,
            'message' => 'Order deleted successfully.',
        ], 200);
    }


    public function show($id)
{
          $order = Order::with(['orderitems', 'billing'])->findOrFail($id);
      
   //  dd($order->id, \App\Models\Billing::where('order_id', $order->order_id)->first());



     return view('Admin.Orders.order_detail', compact('order'));
}



}
