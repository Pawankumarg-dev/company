<?php

require 'dbconnect.php'; // Include the database connection

function generateOtp($length = 6) {
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= rand(0, 9);
    }
    return $otp;
}

function saveOtpToDatabase($mobile, $otp, $pdo) {
    $stmt = $pdo->prepare("INSERT INTO otp_verification (mobile, otp_code, otp_type) VALUES (?, ?, 'mobile')");
    $stmt->execute([$mobile, $otp]);
}

function verifyOtp($mobile, $otp, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM otp_verification WHERE mobile = ? AND otp_code = ? AND is_verified = 0");
    $stmt->execute([$mobile, $otp]);
    $otpData = $stmt->fetch();

    if ($otpData) {
        $stmt = $pdo->prepare("UPDATE otp_verification SET is_verified = 1 WHERE id = ?");
        $stmt->execute([$otpData['id']]);
        return true;
    } else {
        return false;
    }
}

// function sendOtpSms($mobile, $otp) {
//     $username = 'depwd.sms';
//     $pin = 'De@Pw#789';
//     $message = 'Your one time password is ' . $otp . '. Rehabilitation Council of India';
//     $signature = 'RCIGOV';
//     $dlt_entity_id = '1401370180000040261';
//     $dlt_template_id = '1407165908962485291';
    
//     $command = "curl -k https://164.100.14.211/failsafe/MLink?username={$username}&pin={$pin}&message=" . urlencode($message) . "&mnumber=91{$mobile}&signature={$signature}&dlt_entity_id={$dlt_entity_id}&dlt_template_id={$dlt_template_id}";
// //print $command;
// echo $command;
//     $output = [];
//     $return_var = 0;
//     exec($command, $output, $return_var);
    
//     if ($return_var === 0) {
//         return true;
//     } else {
//         return false;
//     }
// }
?>