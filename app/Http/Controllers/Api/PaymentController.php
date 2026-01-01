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
    Log::info('Create Order Request Data:', $data);

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
                $order->orderitems()->create([
                    'product_id'  => $item['product_id'] ?? null,
                    'variety'     => $item['variety'] ?? null,
                    'quality'     => $item['quality'] ?? null,
                    'price'       => $item['price'] ?? 0,
                    'quantity'    => $item['quantity'] ?? 0,
                    'total_price' => $item['total_price'] ?? 0,
                    'image'       => $item['image'] ?? null,
                    'cart_type'   => $item['cart_type'] ?? null,
                ]);
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

      $order->update([
        'is_verify' => 1,

    ]);

       $orderItems = $order->orderitems; // fetch related order items

        foreach ($orderItems as $item) {

            $itemModel = null;
            $itemTitle = '';

            switch ($item->cart_type) {

                case 'plant':
                    $itemModel = Product::where('id', $item->product_id)->first();

                    break;

                case 'trills_material':
                    $itemModel = Trills_Material::where('id', $item->product_id)->first();

                    break;

                case 'kanal_picker':
                    // For kanal_picker, product_id is plant_variety_id, so query by plant_variety_id and price
                    $itemModel = kanal_picker::where('plant_variety_id', $item->product_id)
                        ->where('price', (int)$item->price)
                        ->first();
                    $itemTitle = $itemModel ? 'Kanal Picker' : 'Kanal Picker';
                    break;
    case 'plants_reservation':
                    // For plant_reservation, product_id is plant_variety_id, so query by plant_variety_id and price
                    $itemModel = plant_reservation::where('id', $item->product_id)
                        ->where('price', (int)$item->price)
                        ->first();
                    $itemTitle = $itemModel ? 'Plant Reservation' : 'Plant Reservation';
                    break;


            }

             if ($itemModel) {
                Log::info("Processing feather quantity deduction for {$item->cart_type} - Feather: {$itemModel->feather} (ID: {$itemModel->id}) - Current feather quantity: {$itemModel->quantity}, Deducting order quantity: {$item->quantity}");

                $newQuantity = $itemModel->quantity - $item->quantity;

                if ($newQuantity < 0) {
                    Log::error("Insufficient feather stock for {$itemTitle} '{$itemModel->feather}' on order {$order->order_id} - Available: {$itemModel->quantity}, Required: {$item->quantity}");
                    continue;
                }

                $itemModel->update(['quantity' => $newQuantity]);
                Log::info("Successfully updated feather '{$itemModel->feather}' quantity from {$itemModel->quantity} to: {$newQuantity}");
            } else {
                Log::error("Could not find {$item->cart_type} item with plant_variety_id: {$item->product_id} and price: {$item->price} for order {$order->order_id}");

                // Debug: Show what we're looking for
                if ($item->cart_type === 'plants_reservation') {
                    $existingRecords = plant_reservation::where('plant_variety_id', $item->product_id)
                        ->where('price', $item->price)
                        ->get();
                    Log::info("Available plant_reservation records with plant_variety_id {$item->product_id} and price {$item->price}: " . $existingRecords->count());
                    if ($existingRecords->count() == 0) {
                        // Also check without price filter to see all variants
                        $allRecords = plant_reservation::where('plant_variety_id', $item->product_id)->get();
                        Log::info("Total plant_reservation records with plant_variety_id {$item->product_id} (all prices): " . $allRecords->count());
                        foreach ($allRecords as $record) {
                            Log::info("  - ID: {$record->id}, Price: {$record->price}, Quantity: {$record->quantity}, Feather: {$record->feather}");
                        }
                    }
                } elseif ($item->cart_type === 'kanal_picker') {
                    $existingRecords = kanal_picker::where('plant_variety_id', $item->product_id)
                        ->where('price', $item->price)
                        ->get();
                    Log::info("Available kanal_picker records with plant_variety_id {$item->product_id} and price {$item->price}: " . $existingRecords->count());
                    if ($existingRecords->count() == 0) {
                        // Also check without price filter to see all variants
                        $allRecords = kanal_picker::where('plant_variety_id', $item->product_id)->get();
                        Log::info("Total kanal_picker records with plant_variety_id {$item->product_id} (all prices): " . $allRecords->count());
                        foreach ($allRecords as $record) {
                            Log::info("  - ID: {$record->id}, Price: {$record->price}, Quantity: {$record->quantity}, Feather: {$record->feather}");
                        }
                    }
                }
            }
        }








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

