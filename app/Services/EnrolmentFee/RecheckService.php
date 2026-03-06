<?php

namespace App\Services\EnrolmentFee;
use Session;
use App\Services\Common\HelperService;

class RecheckService
{

    private $helperService;

    public function __construct(HelperService $helper)
    {
        $this->helperService = $helper;
    }

    public function recheck($id,$fid){
        
        set_time_limit(0);

        require_once base_path().'/resources/views/paymentgateway/CryptoNew.blade.php';

        error_reporting(0);

        $o = \App\Order::find($id);
        $fee = \App\Enrolmentfeepayment::find($fid);
        $nber_id = $fee->nber_id;
        $working_key = \App\Configuration::where('attribute','ccavenue_working_key_nber_'.$nber_id)->first()->value;
        $access_code = \App\Configuration::where('attribute','ccavenue_access_code_nber_'.$nber_id)->first()->value;

        $merchant_json_data =
        array(
            'order_email'=> $o->billing_email,
            'from_date' => '03-03-2023',
            'order_bill_tel' => $o->billing_tel,
            'order_no' => $o->order_number
        );

        $merchant_data = json_encode($merchant_json_data);
        $encrypted_data = payment_encrypt($merchant_data, $working_key);
        $final_data = 'enc_request='.$encrypted_data.'&access_code='.$access_code.'&command=orderLookup&request_type=JSON&response_type=JSON';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.ccavenue.com/apis/servlet/DoWebTrans");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,'Content-Type: application/json') ;
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $final_data);
        // Get server response ...
        $result = curl_exec($ch);
        curl_close($ch);
        $status = '';
        $information = explode('&', $result);

        $dataSize = sizeof($information);
        for ($i = 0; $i < $dataSize; $i++) {
            $info_value = explode('=', $information[$i]);
            if ($info_value[0] == 'enc_response') {
                $status = payment_decrypt(trim($info_value[1]), $working_key);
                
            }
        }

        $obj = json_decode($status);
        $success = false;
        $count  = 0;
        if(!is_null($obj->Order_Lookup_Result->error_desc)){
            Session::flash('error',$obj->Order_Lookup_Result->error_desc);
            return back();
        }
        //$supplimentaryapplicant->orders()->detach();
        Session::flash('data',$status);
        if($obj->Order_Lookup_Result->total_records > 1){
            
            foreach($obj->Order_Lookup_Result->order_Status_List->order as $order){
                $order_amt = $order->order_amt;
                $order_date_time = \Carbon\Carbon::parse($order->order_date_time)->format('Y-m-d H:i:s');
                $order_status = $sorder->order_status;
                if($order->order_status == 'Shipped' ){
                    $order_status = "Success";
                    $success = true;
                    $fee->orderstatus_id = 1;
                    $fee->order_id =  $id;
                    $fee->save();
                    Session::flash('messages','Payment Success');
                }
                $o->ccavenue_referencenumber = $order->reference_no;
                $o->order_status = $order_status;
                $o->payment_date = $order_date_time;
                $o->actual_amount = $order_amt;
                $o->save();
            }
        }else{
        

            $order = $obj->Order_Lookup_Result->order_Status_List->order;
        //    return $order . ' ,' . $order->order_amt . ' , ' . $amount;
            $order_amt = $order->order_amt;
            $order_date_time = \Carbon\Carbon::parse($order->order_date_time)->format('Y-m-d H:i:s');
            $order_status = $sorder->order_status;
            if($order_status == ''){
                $order_status = $o->order_status;
            }
            if($order->order_status == 'Shipped' ){
                $order_status = "Success";
                $success = true;
                $fee->orderstatus_id = 1;
                $fee->order_id =  $id;
                $fee->save();
                Session::flash('messages','Payment Success');
            }
            $o->ccavenue_referencenumber = $order->reference_no;
            $o->order_status = $order_status;
            $o->payment_date = $order_date_time;
            $o->actual_amount = $order_amt;
            $o->save();
        }
        if(!$success){
            Session::flash('error','Payment not success');
        }
        return back();
    }

    public function checkwithrefno($refno){
        
        set_time_limit(0);

        require_once base_path().'/resources/views/paymentgateway/CryptoNew.blade.php';

        error_reporting(0);

        
        
        $nber_id = $this->helperService->getNberID();
        $working_key = \App\Configuration::where('attribute','ccavenue_working_key_nber_'.$nber_id)->first()->value;
        $access_code = \App\Configuration::where('attribute','ccavenue_access_code_nber_'.$nber_id)->first()->value;

        $merchant_json_data =
        array(
            'from_date' => '03-03-2023',
            'reference_no' => $refno
        );

        $merchant_data = json_encode($merchant_json_data);
        $encrypted_data = payment_encrypt($merchant_data, $working_key);
        $final_data = 'enc_request='.$encrypted_data.'&access_code='.$access_code.'&command=orderLookup&request_type=JSON&response_type=JSON';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.ccavenue.com/apis/servlet/DoWebTrans");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,'Content-Type: application/json') ;
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $final_data);
        // Get server response ...
        $result = curl_exec($ch);
        curl_close($ch);
        $status = '';
        $information = explode('&', $result);

        $dataSize = sizeof($information);
        for ($i = 0; $i < $dataSize; $i++) {
            $info_value = explode('=', $information[$i]);
            if ($info_value[0] == 'enc_response') {
                $status = payment_decrypt(trim($info_value[1]), $working_key);
                
            }
        }

        $obj = json_decode($status);
        return $status;
        $success = false;
        $count  = 0;
        if(!is_null($obj->Order_Lookup_Result->error_desc)){
            Session::flash('error',$obj->Order_Lookup_Result->error_desc);
            return back();
        }
        //$supplimentaryapplicant->orders()->detach();
        Session::flash('data',$status);
        if($obj->Order_Lookup_Result->total_records > 1){
            
            foreach($obj->Order_Lookup_Result->order_Status_List->order as $order){
                $order_amt = $order->order_amt;
                $order_date_time = \Carbon\Carbon::parse($order->order_date_time)->format('Y-m-d H:i:s');
                $order_status = $sorder->order_status;
                if($order->order_status == 'Shipped' ){
                    $order_status = "Success";
                    $success = true;
                    $fee->orderstatus_id = 1;
                    $fee->order_id =  $id;
                    $fee->save();
                    Session::flash('messages','Payment Success');
                }
                $o->ccavenue_referencenumber = $order->reference_no;
                $o->order_status = $order_status;
                $o->payment_date = $order_date_time;
                $o->actual_amount = $order_amt;
                $o->save();
            }
        }else{
        

            $order = $obj->Order_Lookup_Result->order_Status_List->order;
        //    return $order . ' ,' . $order->order_amt . ' , ' . $amount;
            $order_amt = $order->order_amt;
            $order_date_time = \Carbon\Carbon::parse($order->order_date_time)->format('Y-m-d H:i:s');
            $order_status = $sorder->order_status;
            if($order_status == ''){
                $order_status = $o->order_status;
            }
            if($order->order_status == 'Shipped' ){
                $order_status = "Success";
                $success = true;
                $fee->orderstatus_id = 1;
                $fee->order_id =  $id;
                $fee->save();
                Session::flash('messages','Payment Success');
            }
            $o->ccavenue_referencenumber = $order->reference_no;
            $o->order_status = $order_status;
            $o->payment_date = $order_date_time;
            $o->actual_amount = $order_amt;
            $o->save();
        }
        if(!$success){
            Session::flash('error','Payment not success');
        }
        return back();
    }
}