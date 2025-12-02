<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    // Step 1: Send OTP via Twilio Verify
    public function sendOtp($to)
    {
        return $this->client->verify->v2
            ->services(config('services.twilio.verify_sid'))
            ->verifications
            ->create($to, "sms");

    }

    // Step 2: Verify OTP
    public function verifyOtp($to, $code)
    {
        return $this->client->verify->v2
            ->services(config('services.twilio.verify_sid'))
            ->verificationChecks
            ->create([
                'to'   => $to,
                'code' => $code,
            ]);
    }
}
