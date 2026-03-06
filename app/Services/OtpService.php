<?php
namespace App\Services;

use App\Models\OtpVerification;
use Illuminate\Support\Facades\Http;

class OtpService
{
    public function generateOtp($length = 6)
    {
        $otp = '';
        for ($i = 0; $i < $length; $i++) {
            $otp .= rand(0, 9);
        }
        return $otp;
    }

    public function sendOtpSms($mobile, $otp)
    {
        $username = 'depwd.sms';
        $pin = 'De@Pw#789';
        $message = 'Your one time password is ' . $otp . '. Rehabilitation Council of India';
        $signature = 'RCIGOV';
        $dlt_entity_id = '1401370180000040261';
        $dlt_template_id = '1407165908962485291';

        $url = "https://164.100.14.211/failsafe/MLink?username={$username}&pin={$pin}&message=" . urlencode($message) . "&mnumber=91{$mobile}&signature={$signature}&dlt_entity_id={$dlt_entity_id}&dlt_template_id={$dlt_template_id}";

        $response = Http::get($url);

        return $response->successful();
    }

    public function saveOtp($mobile, $otp)
    {
        OtpVerification::create([
            'mobile' => $mobile,
            'otp_code' => $otp,
        ]);
    }

    public function verifyOtp($mobile, $otp)
    {
        $otpVerification = OtpVerification::where('mobile', $mobile)
            ->where('otp_code', $otp)
            ->where('is_verified', false)
            ->first();

        if ($otpVerification) {
            $otpVerification->is_verified = true;
            $otpVerification->save();
            return true;
        } else {
            return false;
        }
    }
}

?>
