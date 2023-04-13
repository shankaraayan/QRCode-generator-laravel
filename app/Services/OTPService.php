<?php

namespace App\Services;

use App\Models\Otp;
use Illuminate\Support\Str;
use App\Models\Blacklisted;
use App\Exceptions\ErrorException;
use App\Mail\RequestOtp;
use Illuminate\Support\Facades\Mail;

class OTPService
{
    // protected TwilioService $smsService;

    function __construct()
    {
        // $this->smsService = new TwilioService;
    }

    public function verify(string $detail, int $otp, bool $drop = false): string|bool
    {
        $record = Otp::where('to', $detail)->where('otp', $otp)->first();

        if ($record && $drop) {
            $record->delete();
            return true;
        } elseif ($record) {
            $record->otp = null;
            $record->token = Str::uuid();
            $record->save();
            return $record->token;
        }

        return false;
    }

    public function verifyToken(string $detail, string $token): bool
    {
        $record = Otp::where('to', $detail)->where('token', $token)->whereTime('updated_at', '>=', now()->subMinutes(15))->first();

        if ($record) {
            $record->delete();
            return true;
        }

        return false;
    }

    public function sendOTP(string $type, string|int $details)
    {
        $otpRecord = Otp::where('to', $details)->whereNotNull('otp')->where('created_at', '>=', now()->subMinutes(15))->first();

        if (!$otpRecord || $otpRecord->count <= 100) {

            $otp = (string) random_int(101000, 998999); //to  minimize bruteforce

            if ($otpRecord) {
                $otp = $otpRecord->otp;
                $otpRecord->increment('count');
                $otpRecord->save();
            } else {
                $otpRecord = Otp::create(['to' => $details, 'otp' => $otp]);
            }

            //OTP Service
            $body = "Your PLywood Reward Account requested OTP is $otp.";
            if ($type == "mobile") {
                // $sms = $this->smsService->send($details, $body);
            } else {
                $mailData = [
                    'email' => $details,
                    'body' => $body,
                ];
            }
            return $otp; //temp
        } else {
            $this->addToBlacklist($details);
            throw new ErrorException('Mobile/Email blacklisted for an hour', 400);
        }
    }

    private function addToBlacklist(string|int $detail)
    {
        Blacklisted::create(['detail' => $detail]);
    }
}
