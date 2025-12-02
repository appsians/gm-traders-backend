<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;
use App\Models\Referral;
use Illuminate\Support\Facades\Validator;



use Illuminate\Support\Facades\Log;
use App\Services\TwilioService;


class RegisterController extends Controller
{

      protected $twilio;

         public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }




      public function sendOtp(Request $request)
    {
        // You can replace this with $request->phone later
        $to = '+923223721615'; // verified number only
        $otp = rand(1000, 9999); // generate random OTP

        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        $message = $twilio->messages->create(
            $to,
            [
                'from' => env('TWILIO_PHONE'),
                'body' => "Your OTP is $otp",
            ]
        );

        return response()->json([
            'message' => 'OTP sent successfully!',
            'otp' => $otp,
            'sid' => $message->sid
        ]);
    }







    //    public function register(RegisterRequest $request )
    // {



    // $otp = rand(1000, 9999);

    // $user = User::create(array_merge(
    //     $request->validated(),
    //     [
    //         'name'           => $request->first_name . ' ' . $request->last_name,
    //         'phn_no'         => $request->phone,
    //         'otp'            => $otp,
    //         'otp_expires_at' => now()->addMinutes(5),
    //         'is_verified'    => false,
    //     ]
    // ));

    // $message = "Your OTP code is {$otp}";

    // // try {
    // //     $this->twilio->sendSms($request->phone, $message);
    // // } catch (\Exception $e) {
    // //     Log::error('Twilio Error: ' . $e->getMessage());
    // //     return response()->json([
    // //         'status'  => 'error',
    // //         'message' => 'Failed to send OTP via Twilio'
    // //     ], 500);
    // // }

    // return response()->json([
    //     'status'  => 'success',
    //     'message' => 'User registered. OTP sent for verification',
    //     'phone'   => $request->phone,
    //     'otp' =>$otp,
    // ]);
    // }

// public function verifyOtp(Request $request, TwilioService $twilio)
// {
//     $request->validate([
//         'phone' => 'required',
//         'otp'   => 'required'
//     ]);

//     $verification = $twilio->verifyOtp($request->phone, $request->otp);

//     if ($verification->status === 'approved') {
//         $user = User::where('phone', $request->phone)->first();
//         if ($user) {
//             $user->update(['is_verified' => true]);

//             $token = $user->createToken('auth_token')->plainTextToken;

//             return response()->json([
//                 'status' => 'success',
//                 'message' => 'OTP verified successfully',
//                 'token' => $token,
//                 'user' => $user
//             ]);
//         }
//     }

//     return response()->json([
//         'status' => 'error',
//         'message' => 'Invalid or expired OTP'
//     ], 400);

// }


//   public function register(Request $request)
//     {

//         // Log::info('Registration request: ' , $request->all());

//         $validaition = Validator::make($request->all(), [
//             'first_name' => 'nullable|string',
//             'last_name'  => 'nullable|string',
//              'phone'      => 'required|string|unique:users,phone',
//             'email'      => 'required|string|unique:users,email',
//             'farm_name'=> 'nullable|string',

//            'referral_code' => 'nullable|string', // ✅ optional referral
//         ],[
//            'first_name.required' => 'First name is required.',
//            'last_name.required'  => 'Last name is required.',
//             'phone.required'      => 'Phone number is required.',
//             'phone.unique'        => 'This phone number is already taken.',
//             'email.required'      => 'Email is required.',
//             'email.unique'        => 'This email is already registered.',


//         ]);

//             if ( $validaition->fails()) {
//         return response()->json([
//             'status'  => false,
//             'message' => 'Validation errors',
//             'errors'  =>  $validaition->errors(),
//         ], 422);
//     }




//         $user = User::create([
//             'first_name'       => $request->input('first_name'),
//              'last_name'       => $request->input('last_name'),
//              'farm_name'      =>$request->input('farm_name'),
//             'phone'      => $request->input('phone'),
//             'email'      => $request->input('email'),
//             'profile_image'=> $request->profile_image ?? "icon/home_sliders_1_icon.svg",
//         ]);


//         $user->referral_code = strtoupper(substr($user->first_name, 0, 3)) . rand(1000, 9999);
//     $user->save();

//     // If referral code provided
//         if ($request->filled('referral_code')) {


//         $referrer = User::where('referral_code', $request->referral_code)->first();

//         if (!$referrer) {
//             // Create referral record
//            return response()->json([
//         'status'  => false,
//         'message' => 'invalid referral_code',
//        // 'phone'   => $request->phone,
//     ],200);
//         }

//         else{
//              Referral::create([
//                 'referrer_id' => $referrer->id,
//                 'referred_user_id' => $user->id,
//                 'referral_code' => $request->referral_code,
//                 'coins_rewarded' => 10,
//             ]);

//         }
//     }


// // $token = $user->createToken('auth_token')->plainTextToken;


// try {
//     // Send OTP once
//     $otp = $this->twilio->sendOtp($request->phone);

//     if ($otp) {
//         // Store OTP in the user's record
//        // $user->update(['otp' => $otp]);
//     }
//     // Success response
//     return response()->json([
//         'status'  => true,
//         'message' => 'User registered, OTP sent to phone',
//         'phone'   => $request->phone,
//     ],200);
// } catch (\Exception $e) {
//     // Log the actual error for debugging
//     \Log::error('Twilio Error: ' . $e->getMessage());

//     // Return JSON error response
//     return response()->json([
//         'status'  => false,
//         'message' => 'Failed to send OTP. Please try again later.',

//     ], 200);
// }
//     }



//   public function Register(Request $request)
// {
//     $validation = Validator::make($request->all(), [
//         'first_name'     => 'nullable|string',
//         'last_name'      => 'nullable|string',
//         'phone'          => 'required|string|unique:users,phone',
//         'email'          => 'required|string|unique:users,email',
//         'farm_name'      => 'nullable|string',
//         'referral_code'  => 'nullable|string',
//     ], [
//         'phone.required' => 'Phone number is required.',
//         'phone.unique'   => 'This phone number is already taken.',
//         'email.required' => 'Email is required.',
//         'email.unique'   => 'This email is already registered.',
//          'referral_code'  => 'required',
//     ]);

//     if ($validation->fails()) {
//         return response()->json([
//             'status'  => false,
//             'message' => 'Validation errors',
//             'errors'  => $validation->errors(),
//         ], 422);
//     }

//     // ✅ STEP 1: Check referral code first (if provided)
//     $referrer = null;
//     if ($request->filled('referral_code')) {
//         $referrer = User::where('referral_code', $request->referral_code)->first();

//         if (!$referrer) {
//             return response()->json([
//                 'status'  => false,
//                 'message' => 'Invalid referral code',
//             ], 400);
//         }
//     }
        
    

//     // ✅ STEP 2: Create the user
//     $user = User::create([
//         'first_name'    => $request->input('first_name'),
//         'last_name'     => $request->input('last_name'),
//         'farm_name'     => $request->input('farm_name'),
//         'phone'         => $request->input('phone'),
//         'email'         => $request->input('email'),
//         // 'profile_image' => $request->profile_image ?? "icon/home_sliders_1_icon.svg",
//         'referral_code' => strtoupper(substr($request->input('first_name', 'USR'), 0, 3)) . rand(1000, 9999),
//     ]);

//     // ✅ STEP 3: Create referral record if referral code was valid
//     if ($referrer) {
//         Referral::create([
//             'referrer_id'      => $referrer->id,
//             'referred_user_id' => $user->id,
//             'referral_code'    => $request->referral_code,
//             'coins_rewarded'   => 10,
//         ]);
//     }

//     // ✅ STEP 4: Send OTP using Twilio
//     try {
//         $otp = $this->twilio->sendOtp($request->phone);

//         return response()->json([
//             'status'  => true,
//             'message' => 'User registered successfully, OTP sent to phone',
//             'phone'   => $request->phone,
//         ], 200);
//     } catch (\Exception $e) {
//         \Log::error('Twilio Error: ' . $e->getMessage());

//         return response()->json([
//             'status'  => false,
//             'message' => 'Failed to send OTP. Please try again later.',
//         ], 500);
//     }
// }

public function Register(Request $request)
{
    $validation = Validator::make($request->all(), [
        'first_name'     => 'nullable|string',
        'last_name'      => 'nullable|string',
        'phone'          => 'required|string|unique:users,phone',
        'email'          => 'required|string|unique:users,email',
        'farm_name'      => 'nullable|string',
        'referral_code'  => 'nullable|string',
    ], [
        'phone.required' => 'Phone number is required.',
        'phone.unique'   => 'This phone number is already taken.',
        'email.required' => 'Email is required.',
        'email.unique'   => 'This email is already registered.',
    ]);
    
    

    if ($validation->fails()) {
        
        
        $errors = $validation->errors();



           if ($errors->has('phone') && $errors->has('email')) {
        return response()->json([
            'status'  => false,
            'message' => 'Your phone number and email are already registered.',
        ], 200);
    }

    // ✅ If only one of them fails, show that one
    if ($errors->has('phone')) {
        return response()->json([
            'status'  => false,
            'message' => 'This phone number is already taken.',
        ], 200);
    }

    if ($errors->has('email')) {
        return response()->json([
            'status'  => false,
            'message' => 'This email is already registered.',
        ], 200);
    }
        
        
        
        
        /////
        return response()->json([
            'status'  => false,
            'message' => 'Validation errors',
            'errors'  => $validation->errors(),
        ], 422);
    }

    // ✅ STEP 1: Check referral code first (if provided)
    $referrer = null;
    if ($request->filled('referral_code')) {
        $referrer = User::where('referral_code', $request->referral_code)->first();

        // ❌ Stop registration if referral code invalid
        if (!$referrer) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid referral code. Please enter a valid one.',
            ], 200);
        }
    }

      // STEP 4: Send OTP
   try {

    // STEP 1: Create user first
    $user = User::create([
        'first_name'    => $request->first_name,
        'last_name'     => $request->last_name,
        'farm_name'     => $request->farm_name,
        'phone'         => $request->phone,
        'email'         => $request->email,
        'referral_code' => strtoupper(substr($request->first_name ?? 'USR', 0, 3)) . rand(1000, 9999),
    ]);

    // STEP 2: Create referral if exists
    if ($referrer) {
        Referral::create([
            'referrer_id'      => $referrer->id,
            'referred_user_id' => $user->id,
            'referral_code'    => $request->referral_code,
            'coins_rewarded'   => 10,
        ]);
    }

    // STEP 3: Send OTP
    $this->twilio->sendOtp($request->phone);

    // STEP 4: Return success
    return response()->json([
        'status'  => true,
        'message' => 'User registered successfully, OTP sent.',
        'phone'   => $request->phone,
    ], 200);

} catch (\Exception $e) {

    // If OTP fails → delete user so registration does NOT happen
    if (isset($user)) {
        $user->delete();
    }

    \Log::error("OTP Error: " . $e->getMessage());

    return response()->json([
        'status' => false,
        'message' => 'Failed to send OTP. Please try again.'
    ], 200);
}
}





  //  Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp'   => 'required'
        ]);

        $verification = $this->twilio->verifyOtp($request->phone, $request->otp);

        if ($verification->status === 'approved') {
            $user = User::where('phone', $request->phone)->first();
            if ($user) {
                $user->update(['is_verified' => true]);

                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'status'  => 'success',
                    'message' => 'OTP verified successfully',
                    'token'   => $token,
                    'user'    => $user,
                    'referral_code' => $user->referral_code,
                 'coins' => $user->coins ?? 0,
                ]);
            }
        }

        return response()->json([
            'status'  => 'false',
            'message' => 'Invalid or expired OTP'
        ], 200);
    }


        public function verifmmyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp'   => 'required',
        ]);


        // find user by phone
        $user = User::where('phone', $request->phone)->first();
        return $user;

        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // match OTP
        if ($user->otp == $request->otp) {

            // optional: clear otp after verification
          //  $user->otp = null;
            $user->save();

            // login user
            Auth::login($user);

            // generate token (for API)
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'OTP verified successfully',
                'token'   => $token,
                'user'    => $user,
            ],200);
        }

        return response()->json(['message' => 'Invalid OTP'], 400);
    }

     public function resendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users,phone',
        ]);

        // find user by phone
        $user = User::where('phone', $request->phone)->first();

        // generate new 4-digit OTP
        $otp = rand(1000, 9999);

        // update user's OTP
        $user->otp = $otp;
        $user->save();

        // if using Twilio
        // $this->twilio->sendOtp($user->phone);

        // log otp temporarily for testing (remove in production)
        Log::info("Resent OTP for {$user->phone}: {$otp}");

        return response()->json([
            'status'  => true,
            'message' => 'OTP resent successfully',
            'phone'   => $user->phone,
            // only for testing, remove next line in production
            'otp'     => $otp
        ],200);
    }



}
