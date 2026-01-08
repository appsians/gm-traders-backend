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
use App\Services\OtpService;



use Illuminate\Support\Facades\Log;
use App\Services\TwilioService;


class RegisterController extends Controller
{

      protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
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
    // Log registration attempt
    Log::info('User registration attempt', [
        'phone' => $request->phone,
        'email' => $request->email,
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'timestamp' => now()->toDateTimeString()
    ]);

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

        Log::warning('Registration validation failed', [
            'phone' => $request->phone,
            'email' => $request->email,
            'errors' => $errors->toArray(),
            'ip_address' => $request->ip(),
            'timestamp' => now()->toDateTimeString()
        ]);



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
            Log::warning('Registration failed - Invalid referral code', [
                'phone' => $request->phone,
                'referral_code' => $request->referral_code,
                'ip_address' => $request->ip(),
                'timestamp' => now()->toDateTimeString()
            ]);
            
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

    Log::info('User created during registration', [
        'user_id' => $user->id,
        'phone' => $request->phone,
        'email' => $request->email,
        'referral_code' => $user->referral_code,
        'timestamp' => now()->toDateTimeString()
    ]);

    // STEP 2: Create referral if exists
    if ($referrer) {
        Referral::create([
            'referrer_id'      => $referrer->id,
            'referred_user_id' => $user->id,
            'referral_code'    => $request->referral_code,
            'coins_rewarded'   => 10,
        ]);
        
        Log::info('Referral record created during registration', [
            'user_id' => $user->id,
            'referrer_id' => $referrer->id,
            'referral_code' => $request->referral_code,
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    // STEP 3: Send OTP
    Log::info('Sending OTP for registration', [
        'user_id' => $user->id,
        'phone' => $request->phone,
        'timestamp' => now()->toDateTimeString()
    ]);
    
    $otpResponse = $this->otpService->sendOtp($request->phone);
    
    Log::info('OTP sent successfully for registration', [
        'user_id' => $user->id,
        'phone' => $request->phone,
        'otp_service_response' => $otpResponse,
        'timestamp' => now()->toDateTimeString()
    ]);

    // STEP 4: Return success
    return response()->json([
        'status'  => true,
        'message' => 'User registered successfully, OTP sent.',
        'phone'   => $request->phone,
    ], 200);

} catch (\Exception $e) {
    Log::error('Registration failed - Exception occurred', [
        'phone' => $request->phone ?? null,
        'email' => $request->email ?? null,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
        'ip_address' => $request->ip(),
        'timestamp' => now()->toDateTimeString()
    ]);

    // If OTP fails → delete user so registration does NOT happen
    if (isset($user)) {
        Log::warning('Deleting user due to OTP send failure', [
            'user_id' => $user->id,
            'phone' => $user->phone,
            'timestamp' => now()->toDateTimeString()
        ]);
        
        $user->delete();
    }

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

        $mobile = $request->phone;
        $otp = $request->otp;

        // Log OTP verification attempt during registration
        Log::info('OTP verification attempt during registration', [
            'phone' => $mobile,
            'otp_length' => strlen($otp),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString()
        ]);

        $verification = $this->otpService->verifyOtp($mobile, $otp);

        // Check if verification is successful (MSG91 returns array with 'type' field)
        $isVerified = false;
        if (is_array($verification) && isset($verification['type']) && $verification['type'] === 'success') {
            $isVerified = true;
        } elseif (is_object($verification) && isset($verification->status) && $verification->status === 'approved') {
            $isVerified = true;
        }

        if ($isVerified) {
            $user = User::where('phone', $mobile)->first();
            if ($user) {
                $user->update(['is_verified' => true]);

                $token = $user->createToken('auth_token')->plainTextToken;

                Log::info('OTP verified successfully during registration - User verified', [
                    'user_id' => $user->id,
                    'phone' => $mobile,
                    'verification_response' => $verification,
                    'token_generated' => true,
                    'is_verified' => true,
                    'timestamp' => now()->toDateTimeString()
                ]);

                return response()->json([
                    'status'  => 'success',
                    'message' => 'OTP verified successfully',
                    'token'   => $token,
                    'user'    => $user,
                    'referral_code' => $user->referral_code,
                 'coins' => $user->coins ?? 0,
                ]);
            } else {
                Log::warning('OTP verification successful but user not found', [
                    'phone' => $mobile,
                    'verification_response' => $verification,
                    'timestamp' => now()->toDateTimeString()
                ]);
            }
        }

        Log::warning('OTP verification failed during registration - Invalid or expired OTP', [
            'phone' => $mobile,
            'verification_response' => $verification,
            'error_message' => is_array($verification) ? ($verification['message'] ?? 'Invalid or expired OTP') : 'Invalid or expired OTP',
            'timestamp' => now()->toDateTimeString()
        ]);

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

        $mobile = $request->phone;

        // Log resend OTP request during registration
        Log::info('Resend OTP request during registration', [
            'phone' => $mobile,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString()
        ]);

        // find user by phone
        $user = User::where('phone', $mobile)->first();

        if (!$user) {
            Log::warning('Resend OTP failed during registration - User not found', [
                'phone' => $mobile,
                'ip_address' => $request->ip(),
                'timestamp' => now()->toDateTimeString()
            ]);
            
            return response()->json([
                'status'  => false,
                'message' => 'User not found'
            ], 404);
        }

        try {
            Log::info('Resending OTP via MSG91 service during registration', [
                'user_id' => $user->id,
                'phone' => $mobile,
                'timestamp' => now()->toDateTimeString()
            ]);

            $verification = $this->otpService->resendOtp($mobile);

            if (isset($verification['type']) && $verification['type'] === 'success') {
                Log::info('OTP resent successfully during registration', [
                    'user_id' => $user->id,
                    'phone' => $mobile,
                    'verification_response' => $verification,
                    'timestamp' => now()->toDateTimeString()
                ]);

                return response()->json([
                    'status'  => true,
                    'message' => 'OTP resent successfully',
                    'phone'   => $mobile,
                ], 200);
            }

            Log::warning('Failed to resend OTP during registration', [
                'user_id' => $user->id,
                'phone' => $mobile,
                'verification_response' => $verification,
                'timestamp' => now()->toDateTimeString()
            ]);

            return response()->json([
                'status'  => false,
                'message' => 'Failed to resend OTP. Please try again later.'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Exception while resending OTP during registration', [
                'user_id' => $user->id,
                'phone' => $mobile,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'timestamp' => now()->toDateTimeString()
            ]);

            return response()->json([
                'status'  => false,
                'message' => 'Failed to resend OTP. Please try again later.'
            ], 500);
        }
    }



}
