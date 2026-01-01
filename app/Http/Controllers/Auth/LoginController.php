<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\TwilioService;
use App\Models\User;
use Twilio\Rest\Client;
use App\Services\OtpService;

class LoginController extends Controller
{
          protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    //  public function login(Request $request)
    // {

    //     $request->validate([
    //         'phone' => 'required'
    //     ]);

    //     $user = User::where('phone', $request->phone)->first();

    //     if (!$user) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'User not found, please register first.'
    //         ], 404);
    //     }



    //     return response()->json([
    //         'status'  => 'pending',
    //         'otp' => $otp,
    //         'message' => 'OTP sent to your phone for login',
    //         'phone'   => $request->phone,

    //     ]);
    // }

    // Step 2: Verify OTP
    // public function verifyOtp(Request $request)
    // {
    //     $request->validate([
    //         'phone' => 'required',
    //         'otp'   => 'required'
    //     ]);

    //   //  $user = $this->twilioService->verifyOtp($request->phone, $request->otp);

    //     if (!$user) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Invalid or expired OTP'
    //         ], 401);
    //     }

    //        $otp = rand(100000, 999999);
    // $user->update([
    //     'otp' => $otp,
    //     'otp_expires_at' => now()->addMinutes(5),
    // ]);

    // // send OTP via SMS
    // // $this->twilioService->sendOtp($user->phone, $otp);

    // // issue token
    // $token = $user->createToken('auth_token')->plainTextToken;

    // return response()->json([
    //     'status'  => 'success',
    //     'message' => 'OTP sent for login',
    //     'token'   => $token,
    //     'data'    => $user
    // ]);


    public function loghhin(Request $request)
{
    return $request;
    $request->validate([
        'phone' => 'required'
    ]);

    $user = User::where('phone', $request->phone)->first();
    return $user;

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $otp = rand(1000, 9999);

    $user->update([
        'otp' => $otp,
        'otp_expires_at' => now()->addMinutes(5),
        'is_verified' => false
    ]);

    // try {
    //     $this->twilio->sendSms($request->phone, "Your OTP is {$otp}");
    // } catch (\Exception $e) {
    //     return response()->json(['message' => 'Failed to send OTP'], 500);
    // }

    return response()->json([
        'status' => 'success',
        'message' => 'OTP sent for login verification',
        'phone' => $request->phone
    ]);
}




     public function login(Request $request)
    {

        $request->validate([
            'phone' => 'required',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'User not found'
            ], 200);
        }

        // Send OTP via Twilio Verify
        try {
            $this->otpService->sendOtp($request->phone);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to send OTP'
            ], 200);
        }

        return response()->json([
            'status'  => true,
            'message' => 'OTP sent to your phone',
            'phone'   => $request->phone,
        ],200);
    }


//     public function verifyOtp(Request $request)
// {
//     $request->validate([
//         'phone' => 'required',
//         'otp'   => 'required'
//     ]);


//     try {
//         // ✅ Check if user exists
//         $user = User::where('phone', $request->phone)->first();
//         if (!$user) {
//             return response()->json([
//                 'status'  => 'error',
//                 'message' => 'This phone number is not registered.'
//             ], 404);



//         }

//         // ✅ Call Twilio Verify API
//         $verification = $this->twilio->verifyOtp($request->phone, $request->otp);

//         // ✅ Handle Twilio response safely
//         if ($verification && isset($verification->status) && $verification->status === 'approved') {

//             // Mark verified and generate token
//             $user->update(['phone_verified_at' => '1']);

//             $token = $user->createToken('auth_token')->plainTextToken;

//             return response()->json([
//                 'status'  => true,
//                 'message' => 'OTP verified successfully',
//                 'token'   => $token,
//                 'user'    => $user,
//                 // 'first_name'=>$user->first_name,
//                 // 'last_name'=> $user->last_name,
//                 // 'email'=>$user->email,
//                 // 'phone'=>$user->phone,
//                 // 'profile_image'=> $user->profile_image ? url($user->profile_image) : null,
//                 // 'farm_name'=>$user->farm_name,
//                 // 'referral_code'=>$user->referral_code,
//             ],200);
//         }

//         // OTP invalid or expired
//         return response()->json([
//             'status'  => false,
//             'message' => 'Please Enter Your Valid Verify OTP.'
//         ], 200);

//     } catch (\Twilio\Exceptions\RestException $e) {
        
//          if ($e->getCode() == 20429) {
//         return response()->json([
//             'status'  => false,
//             'message' => 'Too many OTP requests. Please wait a few moments before trying again.',
//         ], 429);
//     }
        
//         // ✅ Handle Twilio exceptions (e.g., invalid phone number)
//         return response()->json([
//             'status'  => 'error',
//             'message' => 'Twilio error: ' . $e->getMessage(),
//         ], 400);

//     } catch (\Exception $e) {
//         // ✅ Handle any other unexpected errors
//         return response()->json([
//             'status'  => 'error',
//             'message' => 'Something went wrong. ' . $e->getMessage(),
//         ], 500);
//     }



//     }


// public function verifyOtp(Request $request)
// {

//     $request->validate([
//         'phone' => 'required|numeric',
//         'otp'   => 'required|numeric'
//     ]);
     

//     $verification = $this->otpService->verifyOtp(
//         $request->phone,
//         $request->otp
//     );

//     // ✅ MSG91 success check
//     if (
//         isset($verification['type']) &&
//         $verification['type'] === 'success'
//     ) {
//         $user = User::where('phone', $request->phone)->first();

//         if (!$user) {
//             return response()->json([
//                 'status' => false,
//                 'message' => 'User not found'
//             ], 404);
//         }

//         $user->update(['phone_verified_at' => true]);

//         $token = $user->createToken('auth_token')->plainTextToken;

//         return response()->json([
//             'status'  => true,
//             'message' => 'OTP verified successfully',
//             'token'   => $token,
//             'user'    => $user,
//             'referral_code' => $user->referral_code,
//             'coins' => $user->coins ?? 0,
//         ]);
//     }

//     // ❌ OTP invalid / expired
//     return response()->json([
//         'status'  => false,
//         'message' => $verification['message'] ?? 'Invalid or expired OTP'
//     ], 400);
// }



public function verifyOtp(Request $request)
{
    $request->validate([
        'phone' => 'required',
        'otp'   => 'required|numeric'
    ]);

    $mobile = $request->phone;

    $user = User::where('phone', $mobile)->first();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User not found'
        ], 404);
    }

  

    // ✅ VERIFY OTP FROM MSG91
    $verification = $this->otpService->verifyOtp($mobile, $request->otp);

    if (isset($verification['type']) && $verification['type'] === 'success') {

       // $user->save(['phone_verified_at' => 1]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'OTP verified successfully',
            'token' => $token,
            'user' => $user,
//             'coins' => $user->coins ?? 0,
        ]);
    }

    return response()->json([
        'status' => false,
        'message' => $verification['message'] ?? 'Invalid or expired OTP'
    ], 200);
}


    public function resendOtp(Request $request)
{
    
   
    $request->validate([
        'phone' => 'required',
    ]);
 $mobile = $request->phone;
   
    try {
        // ✅ 1. Check if the user exists
       // $mobile = $request->phone; // numeric only for MSG91
        $user = User::where('phone', $mobile)->first();

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'This phone number is not registered.'
            ], 404);
        }

      

       
     $verification = $this->otpService->resendOtp($mobile);

        // ✅ 4. Handle MSG91 response
        if (isset($verification['type']) && $verification['type'] === 'success') {
            return response()->json([
                'status'  => true,
                'message' => 'OTP resent successfully.',
                'phone'   => $mobile,
            ], 200);
        }

        // Twilio didn’t accept or failed silently
        return response()->json([
            'status'  => false,
            'message' => 'Failed to resend OTP. Please try again later.'
        ], 200);

    
    
    
} catch (\Exception $e) {
    return response()->json([
        'status'  => 'error',
        'message' => 'MSG91 error: ' . $e->getMessage(),
    ], 500);
}

  
}

}

