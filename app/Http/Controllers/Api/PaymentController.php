<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Order;
use App\Models\Referral;
use App\Models\Billing;
use App\Models\order_items;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Trills_Material;
use App\Models\kanal_picker;
use App\Models\plant_reservation;


class PaymentController extends Controller
{



    public function createOrder(Request $request)
{
    $data = $request->all();
    
    // ✅ Log full payload with pretty JSON formatting
    Log::info('=== CREATE ORDER REQUEST PAYLOAD ===');
    Log::info('Full Request Payload: ' . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    Log::info('User ID: ' . (auth()->id() ?? ($data['user_id'] ?? 'not provided')));
    Log::info('Total Amount: ' . ($data['total_amount'] ?? 'not provided'));
    Log::info('Items Count: ' . (isset($data['items']) && is_array($data['items']) ? count($data['items']) : 0));
    Log::info('=====================================');

       $userId = auth()->id() ?? ($data['user_id'] ?? null);

    // If still not found, return error
    if (!$userId) {
        return response()->json([
            'status' => false,
            'message' => 'User not authenticated or user_id missing.',
        ], 401);
    }

    // ✅ Backend validation
    $validator = Validator::make($data, [
        'subtotal'       => 'required|numeric|min:0',
        'total_amount'   => 'required|numeric|min:0',
        'is_partial_payment' => 'boolean',

        // 'pay_now' => [
        //     Rule::requiredIf($request->input('is_partial_payment') == true),
        //     'numeric',
        //     'min:0',
        // ],
        // 'pay_later' => [
        //     Rule::requiredIf($request->input('is_partial_payment') == true),
        //     'numeric',
        //     'min:0',
        // ],

        'items'                => 'required|array|min:1',
         'delivery_fee' => 'required|numeric|min:0',

        'items.*.variety'      => 'required|string',
         'items.*.quality'      => 'required|string',
        'items.*.price'        => 'required|numeric|min:0',
        'items.*.quantity'     => 'required|integer|min:1',
        'items.*.total_price'  => 'required|numeric|min:0',
        'items.*.image'        => 'nullable|url',
        'items.*.cart_type'    => 'nullable|string',
        // 'items.*.product_id'      => 'required|string',

        'billingAddress.full_name' => 'required|string|max:255',
        'billingAddress.phone' => 'required|string|max:20',
        'billingAddress.address' => 'required|string',
        'billingAddress.city' => 'required|string',
        'billingAddress.state' => 'required|string',
       //'redeem_coins' => 'required|boolean',
    ]);

    // ✅ Return validation errors if any
    if ($validator->fails()) {
        return response()->json([
            'status'  => false,
            'message' => 'Validation failed.',
            'errors'  => $validator->errors(),
        ], 422);
    }
    //   Log::info('Create Order Request Data:', $validator->errors()->toArray());


     $totalCoins = 0;


if ($request->redeem_coins === true || $request->redeem_coins == 1) {


    $totalCoins = Referral::where('referrer_id', $userId)
        ->sum('coins_rewarded');

    Log::info("Total referral coins for user $userId = $totalCoins");
}

    //billing addresss...





    // ✅ Payment logic
    if(!empty($data['is_partial_payment']) && $data['is_partial_payment'] == true) {
        $amountPaid = $data['pay_now'] ?? 0;
          $deliveryFee = $data['delivery_fee'];
        //  $deliveryFee = 5;
        $remaining = ($data['total_amount'] ?? 0) - $amountPaid;
          $razorpayAmount = ($amountPaid + $deliveryFee) - ($request->redeem_coins ? $totalCoins : 0);



    }else{
        $amountPaid = $data['total_amount'] ?? 0;
        $remaining = 0;
        $razorpayAmount = ($amountPaid)-($request->redeem_coins ? $totalCoins : 0);
    }

    // ✅ Initialize Razorpay API
    $keyId = config('services.razorpay.key');
    $keySecret = config('services.razorpay.secret');
    $api = new Api($keyId, $keySecret);

    $itemCount = !empty($data['items']) && is_array($data['items']) ? count($data['items']) : 0;

    DB::beginTransaction();

    try {
        // ✅ Create local order (before Razorpay)
        $order = Order::create([
            'deliver_date'       => $data['deliver_date'] ?? now(),
            'delivered_date'     => Carbon::now()->addDays(7),
            'amount_paid'        =>  $razorpayAmount ,
            'amount_remaining'   => $data['pay_later'] ?? null,
            'items'              => $itemCount,
            'location'           => auth()->user()->farm_name ?? null,
            'placed_date'        => $data['placed_date'] ?? now(),
            'name'               => auth()->user()->first_name ?? ($data['name'] ?? null),
            'user_id'            => auth()->id() ?? ($data['user_id'] ?? null),
            'subtotal'           => $data['subtotal'] ?? 0,
            'delivery_fee'       => $data['delivery_fee'] ?? 0,
            'total_amount'       => $data['total_amount'] ?? 0,
            'is_partial_payment' => $data['is_partial_payment'] ?? false,
            'pay_now'            => $data['pay_now'] ?? null,
            'pay_later'          => $data['pay_later'] ?? null,
             'is_verify'          => false,
        ]);

        // ✅ Save order items
        if (!empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $orderItem = $order->orderitems()->create([
                    'product_id'  => $item['product_id'] ?? null,
                    'variety'     => $item['variety'] ?? null,
                    'quality'     => $item['quality'] ?? null,
                    'price'       => $item['price'] ?? 0,
                    'quantity'    => $item['quantity'] ?? 0,
                    'total_price' => $item['total_price'] ?? 0,
                    'image'       => $item['image'] ?? null,
                    'cart_type'   => $item['cart_type'] ?? null,
                ]);

                // ✅ Update quantities immediately when order is created
                $itemModel = null;
                $itemTitle = '';

                // ✅ Log item payload for debugging
                Log::info("Processing item - Cart Type: " . ($item['cart_type'] ?? 'null') . ", Product ID: " . ($item['product_id'] ?? 'null') . ", Price: " . ($item['price'] ?? 'null') . ", Quantity: " . ($item['quantity'] ?? 'null'));
                Log::info("Full item payload: " . json_encode($item, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                switch ($item['cart_type'] ?? null) {
                    case 'plant':
                        $itemModel = Product::where('id', $item['product_id'] ?? null)->first();
                        break;

                    case 'trills_material':
                        $itemModel = Trills_Material::where('id', $item['product_id'] ?? null)->first();
                        break;

                    case 'kanal_picker':
                        // Try to find by ID first (product_id might be kanal_picker id)
                        $itemModel = kanal_picker::where('id', $item['product_id'] ?? null)->first();
                        
                        // If not found, try by plant_variety_id and price (price is stored as string)
                        if (!$itemModel) {
                            $itemModel = kanal_picker::where('plant_variety_id', $item['product_id'] ?? null)
                                ->where('price', (string)($item['price'] ?? 0))
                                ->first();
                        }
                        
                        // If still not found, try with numeric comparison for price
                        if (!$itemModel) {
                            $itemModel = kanal_picker::where('plant_variety_id', $item['product_id'] ?? null)
                                ->whereRaw('CAST(price AS UNSIGNED) = ?', [(int)($item['price'] ?? 0)])
                                ->first();
                        }
                        
                        $itemTitle = 'Kanal Picker';
                        break;

                    case 'plants_reservation':
                        // For plant_reservation, product_id is the reservation id
                        $itemModel = plant_reservation::where('id', $item['product_id'] ?? null)
                            ->where('price', (int)($item['price'] ?? 0))
                            ->first();
                        $itemTitle = 'Plant Reservation';
                        break;
                }

                // ✅ Deduct quantity if item found and has quantity field
                if ($itemModel && isset($itemModel->quantity)) {
                    $oldQuantity = $itemModel->quantity;
                    $deductQuantity = $item['quantity'] ?? 0;
                    $itemName = isset($itemModel->feather) ? $itemModel->feather : ($itemModel->name ?? 'Item');
                    
                    Log::info("Processing quantity deduction for {$item['cart_type']} - Name: {$itemName} (ID: {$itemModel->id}) - Current quantity: {$oldQuantity}, Deducting order quantity: {$deductQuantity}");

                    $newQuantity = $oldQuantity - $deductQuantity;

                    if ($newQuantity < 0) {
                        $itemDisplayName = !empty($itemTitle) ? $itemTitle : ucfirst($item['cart_type'] ?? 'Item');
                        Log::error("Insufficient stock for {$itemDisplayName} '{$itemName}' on order creation - Available: {$oldQuantity}, Required: {$deductQuantity}");
                        DB::rollBack();
                        return response()->json([
                            'status' => false,
                            'message' => "Insufficient stock for {$itemDisplayName}. Available: {$oldQuantity}, Required: {$deductQuantity}",
                        ], 400);
                    }

                    $itemModel->update(['quantity' => $newQuantity]);
                    Log::info("Successfully updated '{$itemName}' quantity from {$oldQuantity} to: {$newQuantity}");
                } else {
                    if ($itemModel && !isset($itemModel->quantity)) {
                        Log::warning("Item model found for {$item['cart_type']} but quantity field does not exist (ID: {$item['product_id']})");
                    } elseif (in_array($item['cart_type'] ?? null, ['kanal_picker', 'plants_reservation'])) {
                        // Add debug logging to help troubleshoot
                        $debugQuery = kanal_picker::where('plant_variety_id', $item['product_id'] ?? null)->get();
                        Log::warning("Could not find {$item['cart_type']} item with product_id: {$item['product_id']} and price: {$item['price']} for order creation. Available records with plant_variety_id {$item['product_id']}: " . $debugQuery->count());
                        foreach ($debugQuery as $debug) {
                            Log::info("  - Kanal Picker ID: {$debug->id}, Price: '{$debug->price}' (type: " . gettype($debug->price) . "), Feather: {$debug->feather}");
                        }
                        
                        // Also check by ID
                        $byId = kanal_picker::where('id', $item['product_id'] ?? null)->first();
                        if ($byId) {
                            Log::info("  - Found kanal_picker by ID {$item['product_id']}: Price '{$byId->price}', Feather: {$byId->feather}");
                        }
                    }
                }
            }
        }

          $billing = Billing::create([
        'user_id' =>  $userId,
        'full_name' => $data['billingAddress']['full_name'],
        'phone' => $data['billingAddress']['phone'],
        'address' => $data['billingAddress']['address'],
        'city' => $data['billingAddress']['city'],
        'state' => $data['billingAddress']['state'],
    ]);




        // ✅ Create Razorpay order
        $razorpayOrder = $api->order->create([
            'receipt'  => 'rcptid_' . time(),
            'amount'   => $razorpayAmount * 100, // Razorpay expects paise
            'currency' => 'INR',
        ]);


  Referral::where('referrer_id', $userId)
        ->update(['coins_rewarded' => 0]);
        // ✅ Update DB order with Razorpay order_id
        $order->update([
            'order_id' => $razorpayOrder['id'],
        ]);


           $billing->update([
            'order_id' => $razorpayOrder['id'],
        ]);







        DB::commit();

        // ✅ Success response
        return response()->json([
            'status'  => true,
            'message' => 'Order created successfully.',
            'data'    => [
                'razorpay_id' => $razorpayOrder['id'],
                'amount'      => $razorpayOrder['amount'] / 100, // back to rupees
                'key'         => $keyId,
                'order_id'    => $order->id,
            ],
        ], 200, [], JSON_UNESCAPED_UNICODE);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Order creation failed: ' . $e->getMessage());


        return response()->json([
            'status'  => false,
            'message' => 'Failed to create order.',
            'error'   => $e->getMessage(),
        ], 500);
    }
}




//     public function createOrder(Request $request)
// {
//     $data = $request->all();
//      Log::info('Create Order Request Data:', $request->all());


//     // ✅ Handle payment logic
//     if (!empty($data['is_partial_payment']) && $data['is_partial_payment'] == true) {
//         // Partial payment case
//         $amountPaid = $data['pay_now'] ?? 0;
//         $remaining = ($data['total_amount'] ?? 0) - $amountPaid;
//         $razorpayAmount = $amountPaid; // Razorpay gets only partial payment
//         // $payLater = $remaining;

//     } else {
//         // Full payment case
//         $amountPaid = $data['total_amount'] ?? 0;
//         $remaining = 0;
//         $razorpayAmount = $amountPaid; // Razorpay gets full amount
//     }

//     $payLater = $data['pay_later'] ?? 0;

//     // ✅ Initialize Razorpay API
//     $keyId = config('services.razorpay.key');
//     $keySecret = config('services.razorpay.secret');
//     $api = new Api($keyId, $keySecret);

//     try {
//         // ✅ Dynamic amount — multiplied by 100 because Razorpay uses paise
//         $razorpayOrder = $api->order->create([
//             'receipt'  => 'rcptid_' . time(),
//           'amount'   =>   $razorpayAmount *100, // ✅ Dynamic amount
//         //   'amount' => 50000,
//             'currency' => 'INR',
//         ]);
//     } catch (\Exception $e) {
//         return response()->json(['error' => $e->getMessage()], 500);
//     }

//     $itemCount = !empty($data['items']) && is_array($data['items']) ? count($data['items']) : 0;

//     // ✅ Store order in DB
//     $order = Order::create([
//         'order_id'           => $razorpayOrder['id'],
//         'deliver_date'       => $data['deliver_date'] ?? now(),
//         'delivered_date'     => null,
//         'amount_paid'        => $amountPaid,
//         'amount_remaining'   =>  $data['pay_later'] ?? null,
//         'items'              => json_encode($data['items'] ?? []),
//         'location'           => auth()->user()->farm_name,
//         'placed_date'        => $data['placed_date'] ?? now(),
//         'name'               => auth()->user()->first_name ?? ($data['name'] ?? null),
//         'user_id'            => auth()->id() ?? ($data['user_id'] ?? null),
//         'subtotal'           => $data['subtotal'] ?? 0,
//         'delivery_fee'       => $data['delivery_fee'] ?? 0,
//         'total_amount'       => $data['total_amount'] ?? 0,
//         'is_partial_payment' => $data['is_partial_payment'] ?? false,
//         'pay_now'            => $data['pay_now'] ?? null,
//         'pay_later'          => $data['pay_later'] ?? null,
//         'items'              =>   $itemCount ,
//     ]);

//  //  Log::info('Order Created:', $order->toArray());

//     //return $order;

//     // ✅ Store each order item in order_items table
//     if (!empty($data['items']) && is_array($data['items'])) {
//         foreach ($data['items'] as $item) {
//             $order->items()->create([
//                 'product_id' => $item['id'] ?? null,
//                 'variety'    => $item['variety'] ?? null,
//                 'quality'    => $item['quality'] ?? null,
//                 'price'      => $item['price'] ?? 0,
//                 'quantity'   => $item['quantity'] ?? 0,
//                 'total_price'=> $item['total_price'] ?? 0,
//                 'image'      => $item['image'] ?? null,
//                 'cart_type'  => $item['cart_type'] ?? null,
//             ]);
//         }
//     }

//     // ✅ Return success response
//     return response()->json([
//         'status'  => true,
//         'message' => 'Order created successfully.',
//         'data'    => [

//                 'razorpay_id'       => $razorpayOrder['id'],
//                 'amount'   => $razorpayOrder['amount'] / 100, // convert back to rupees
//                 'currency' => $razorpayOrder['currency'],
//                 'key' => $keyId,

//             'order_id' => $order->id,
//         ],
//     ], 200, [], JSON_UNESCAPED_UNICODE);
// }
//     public function createOrder(Request $request)
//     {
//             $data = $request->all();

//           Log::info('Create Order Request Data:', $request->all());


//         //      $validated = $request->validate([
//         //     'subtotal'           => 'required|numeric',
//         //     'delivery_fee'       => 'nullable|numeric',
//         //     'total_amount'       => 'required|numeric',
//         //     'is_partial_payment' => 'required|boolean',
//         //     'pay_now'            => 'nullable|numeric',
//         //     'pay_later'          => 'nullable|numeric',
//         //     'items'              => 'required|array|min:1',
//         //     'name'               => 'nullable|string',
//         //     'location'           => 'nullable|string',
//         //     'user_id'            => 'nullable|integer',
//         //     'deliver_date'       => 'nullable|date',
//         //     'placed_date'        => 'nullable|date',
//         // ]);


//       if (!empty($data['is_partial_payment']) && $data['is_partial_payment'] == true) {
//         // Partial payment case
//         $amountPaid = $data['pay_now'] ?? 0;
//         $remaining = ($data['total_amount'] ?? 0) - $amountPaid;
//         $razorpayAmount = $amountPaid;
//     } else {
//         // Full payment case
//         $amountPaid = $data['total_amount'] ?? 0;
//         $remaining = 0;
//         $razorpayAmount = $amountPaid;
//     }
//         // return $request;
//         $keyId = config('services.razorpay.key');
//         $keySecret = config('services.razorpay.secret');
//         $api = new Api($keyId, $keySecret);

//         try {
//             $razorpayOrder = $api->order->create([
//                 'receipt' => 'rcptid_' . time(),
//                 'amount' => 50000,
//                 'currency' => 'INR',
//             ]);
//         } catch (\Exception $e) {
//             return response()->json(['error' => $e->getMessage()], 500);
//         }



//              $order = Order::create([
//         'order_id'           => $razorpayOrder['id'],
//         'deliver_date'       => $data['deliver_date'] ?? now(),
//         'delivered_date'     => null,
//         'amount_paid'        => $amountPaid,
//         'amount_remaining'   => $remaining,
//         'items'              => json_encode($data['items'] ?? []),
//         'location'           => $data['location'] ?? null,
//         'placed_date'        => $data['placed_date'] ?? now(),
//         'name'               => auth()->user()->name,
//          'user_id'            => auth()->user()->id,
//         'subtotal'           => $data['subtotal'] ?? 0,
//         'delivery_fee'       => $data['delivery_fee'] ?? 0,
//         'total_amount'       => $data['total_amount'] ?? 0,
//         'is_partial_payment' => $data['is_partial_payment'] ?? false,
//         'pay_now'            => $data['pay_now'] ?? null,
//         'pay_later'          => $data['pay_later'] ?? null,
//     ]);


// if (!empty($data['items']) && is_array($data['items'])) {
//     foreach ($data['items'] as $item) {
//         $order->items()->create([
//             'product_id' => $item['id'] ?? null,
//             'variety'    => $item['variety'] ?? null,
//             'quality'    => $item['quality'] ?? null,
//             'price'      => $item['price'] ?? 0,
//             'quantity'   => $item['quantity'] ?? 0,
//             'total_price'=> $item['total_price'] ?? 0,
//             'image'      => $item['image'] ?? null,
//             'cart_type'  => $item['cart_type'] ?? null,
//         ]);
//     }
// }



//              return response()->json([
//                 'status'  => true,
//                 'message' => 'Order created successfully.',
//                 'data'    => [
//                     'razorpay_order' => [
//                         'id'       => $razorpayOrder['id'],
//                         'amount'   => $razorpayOrder['amount'],
//                         'currency' => $razorpayOrder['currency'],
//                     ],
//                     'order_id' => $order->id,
//                 ],
//             ], 200, [], JSON_UNESCAPED_UNICODE);





    //     $data = [
    //         'order_id' => $order['id'],
    //         'amount' => $order['amount'],
    //         'currency' => $order['currency'],
    //         'key' => $keyId,
    //     ];
    //      return response()->json([
    //     'status'  => true,
    //     'message' => 'Razorpay order created successfully.',
    //     'data'    => $data,
    // ], 200, [], JSON_UNESCAPED_UNICODE);

       // return view('payment', compact('data'));
   // }

    public function verifyPayment(Request $request)
    {


          Log::info('Create Order Request Data:', $request->all());
      $generatedSignature = hash_hmac(
    'sha256',
    $request->order_id . '|' . $request->payment_id,
    config('services.razorpay.secret')
);

if ($generatedSignature === $request->signature) {
     $order = Order::where('order_id', $request->order_id)->first();

     if (!$order) {
         return response()->json([
             'status' => false,
             'message' => 'Order not found.',
         ], 404);
     }

      $order->update([
        'is_verify' => 1,
    ]);

    // ✅ Quantity deduction is now handled in createOrder method
    // No need to deduct quantities here to avoid double deduction

    Log::info("Payment verified successfully for order: {$order->order_id}");

    // Removed quantity deduction logic - quantities are updated in createOrder








         return response()->json([
        'status'  => true,
        'message' => 'Payment verified successfully',

            'razorpay_order_id'   => $request->order_id,
            'razorpay_payment_id' => $request->payment_id,


    ], 200);
}






else {



    return response()->json([
        'status'  => false,
        'message' => 'Payment verification failed. Invalid signature.',
    ], 400);
    }
}
}

