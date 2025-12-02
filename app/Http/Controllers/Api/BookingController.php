<?php

namespace App\Http\Controllers\Api;
use App\Models\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
     public function index()
    {
        $bookings = Booking::with('bookable', 'user')->get();

        return response()->json([
            'status' => true,
            'message' => 'All bookings retrieved successfully.',
            'data' => $bookings,
        ], 200);
    }

    
}
