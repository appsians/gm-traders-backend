<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function createOrder()
    {
        $amount = 50000; // ₹500 in paise

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));



    try {
        $order = $api->order->create([
            'amount' => 50000,
            'currency' => 'INR',
            'receipt' => uniqid('rcpt_'),
            'payment_capture' => 1
        ]);

        return view('payment', [
            'order_id' => $order['id'],
            'amount' => $order['amount'],
            'currency' => $order['currency'],
            'key' => env('RAZORPAY_KEY')
        ]);
    } catch (\Exception $e) {
        Log::error('Razorpay Exception', [
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}
