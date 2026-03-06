<?php
namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Easebuzz\PayWithEasebuzzLaravel\PayWithEasebuzzLib;
use Illuminate\Support\Facades\Http;

class EasebuzzController extends Controller
{
    //
    public function initiate_payment_show()
    {
        return view('easebuzz.initiate_payment', ['result' => '']);
    }



    public function initiate_payment_ebz(Request $request)
    {

    $param = array(

        "txnid" => $this->generateTxnId(),
        "amount" => $request->amount,
        "firstname" => $request->name,
        "email" => $request->email,
        "phone" => $request->phone,
        "productinfo" => "examfee",
        "surl" => url('/payment-response'),
        "furl" => url('/payment-response'),
        "udf1" => "1",
        "udf2" => "2",
        "udf3" => "3",
        "udf4" => "4",
        "udf5" => "5",
        "udf6" => "6",
        "udf7" => "7",
        "udf8" => "8",
        "udf9" => "9",
        "udf10" => "10",
        "address1" => "aaaa",
        "address2" => "aaaa",
        "city" => "aaaa",
        "state" => "aaaa",
        "country" => "India",
        "zipcode" => "123123",
                "sub_merchant_id"=>"S256265WFOQ",

    );
        // $hash_sequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10|sub_merchant_id";

        $key = "YRSZNC6NV";
        $salt = "0HUX7DV7O";
        $env = "test";
        // $sub_merchant_key="S256265WFOQ";

        $payebz = new PayWithEasebuzzLib($key, $salt, $env);
        $result = $payebz->initiatePaymentAPI($param, true);
        
        var_dump($result);
         die();

        // return view('easebuzz.initiate_payment', ['result' => $result]);
    }

private function generateTxnId()
{
    $prefix = 'TXN'; // optional prefix
    $timestamp = Carbon::now()->format('YmdHis');
    $random = mt_rand(1000, 9999); // 4 digit random

    return $prefix . $timestamp . $random;
}
    
    public function ebz_response(Request $request): View
    {
        $param = $request->post();
        // $param will contain the response provided to you by Easebuzz. You can handle your success and failed scenarios based on the response.
        var_dump($param);
        die();
        return view('initiate_payment', ['result' => '']);
    }
}
