<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OtpService
{
    protected $authKey;
    protected $templateId;

    public function __construct()
    {
        $this->authKey = env('MSG91_AUTH_KEY');
        $this->templateId = env('MSG91_DLT_TEMPLATE_ID'); 
        $this->senderId = env('MSG91_SENDER_ID');
    }

    /**
     * Send OTP to a mobile number
     *
     * @param string $mobile
     * @return array
     */
    public function sendOtp($mobile)
    {
        $response = Http::withHeaders([
            'authkey' => $this->authKey,
            'Content-Type' => 'application/json'
        ])->post('https://api.msg91.com/api/v5/otp', [
            'template_id' => $this->templateId,
            'mobile' => $mobile
        ]);

        $data = $response->json();

        Log::info('Msg91 OTP Request', [
            'mobile' => $mobile,
            'template_id' => $this->templateId,
            'response' => $data
        ]);

        return $data;
    }

    /**
     * Verify OTP entered by the user
     *
     * @param string $requestId
     * @param string $otp
     * @return array
     */
    public function verifyOtp($mobile, $otp)
    {
        $response = Http::withHeaders([
            'authkey' => $this->authKey,
            'Content-Type' => 'application/json'
        ])->post('https://api.msg91.com/api/v5/otp/verify', [
            'mobile' => $mobile,   // ✅ REQUIRED
        'otp'    => $otp
        ]);

        $data = $response->json();

        Log::info('Msg91 OTP Verify', [
          
            'otp' => $otp,
        'mobile' => $mobile, // numeric only
            'response' => $data
        ]);

        return $data;
    }
    
    
    
    public function resendOtp($mobile)
{
    $mobile = $mobile;

    $response = Http::withHeaders([
        'authkey' => $this->authKey,
        'Content-Type' => 'application/json'
    ])->post('https://api.msg91.com/api/v5/otp/retry', [
        'mobile' => $mobile,
        'retrytype' => 'text' // text | voice
    ]);

    $data = $response->json();

    Log::info('Msg91 OTP Resend', [
        'mobile' => $mobile,
        'response' => $data
    ]);

    return $data;
}
}
