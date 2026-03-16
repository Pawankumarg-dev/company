<?php
// main_script.php

require 'dbconnect.php'; // Include the database connection
require 'otp_functions.php'; // Include the OTP functions

// Generate OTP
$mobile = '9711086329'; // Replace with the actual mobile number
$otp = generateOtp();
echo $otp; 
echo "<br>";
echo $mobile;
// Save OTP to database
//saveOtpToDatabase($mobile, $otp, $pdo);
//
// Send OTP using the provided curl command
function sendOtpSms($mobile, $otp) 
{
    echo "hiiii";
    echo "<br>";
    $username = 'depwd.sms';
    $pin = 'De%40Pw%23789';
    $message = 'Your%20one%20time%20password%20is%20'.$otp.'.%20Rehabilitation%20Council%20of%20India';
    $signature = 'RCIGOV';
    $dlt_entity_id = '1401370180000040261';
    $dlt_template_id = '1407165908962485291';
    
    // $command = "curl -k https://164.100.14.211/failsafe/MLink?username={$username}&pin={$pin}&message=" .{$message}. "&mnumber=91{$mobile}&signature={$signature}&dlt_entity_id={$dlt_entity_id}&dlt_template_id={$dlt_template_id}";
    $command = "curl -k https://164.100.14.211/failsafe/MLink?username={$username}&pin={$pin}&message=.sss{$message}.&mnumber={$mobile}&signature={$signature}&dlt_entity_id={$dlt_entity_id}&dlt_template_id={$dlt_template_id}";
    echo $command;
    $output = [];
    $return_var = 0;
    exec($command, $output, $return_var);
    //echo "hello";
    if ($return_var === 0) {
        return true;
    } else {
        return false;
    }
}
    
// Send OTP
if (sendOtpSms($mobile, $otp)) {
    echo 'OTP sent successfully.';
} else {
    echo 'Failed to send OTP.';
}

// Verification example (this would typically be a separate request)
$user_input_otp = '123456'; // Replace with the OTP input by the user

if (verifyOtp($mobile, $user_input_otp, $pdo)) {
    echo 'OTP verified successfully.';
} else {
    echo 'Invalid OTP.';
}
?>
