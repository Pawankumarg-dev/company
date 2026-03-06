<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Candidate;
use App\Supplimentaryapplicant;
use App\Order;
use App\Currentapplicant;

use PDF;

use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

class CheckPaymentstatus extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        ini_set('memory_limit', '4048M');

    }

    /**
     * Execute the job.
     *
     * @return void
     */

     private function recheckStatusAll($rid){
        set_time_limit(0);

        require_once base_path().'/resources/views/paymentgateway/CryptoNew.blade.php';

        error_reporting(0);
        $supplimentaryapplicant = Supplimentaryapplicant::find($rid);
        $nber_id = $supplimentaryapplicant->candidate->approvedprogramme->programme->nber_id;
        $amount = $supplimentaryapplicant->amount;
        
        $working_key = \App\Configuration::where('attribute','ccavenue_working_key_nber_'.$nber_id)->first()->value;
        $access_code = \App\Configuration::where('attribute','ccavenue_access_code_nber_'.$nber_id)->first()->value;
        //$order=Order::find($oid);
        $candidate = Candidate::where('id',$supplimentaryapplicant->candidate_id)->first();
        if(is_null($candidate->email)){
            return 1;
        }
        if($candidate->duplicate_mobile_no == 1){
            return 1;
        }
        $merchant_json_data =
        array(
            'order_email'=> $candidate->email,
            'from_date' => '03-03-2024',
            'order_bill_tel' => $candidate->contactnumber
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
        

        foreach($obj->Order_Lookup_Result->order_Status_List->order as $order){
            if(str_contains($order->order_bank_response, 'SUCCESS') && $order->order_amt == $amount){
                
                $success = true;
                $ordernumber = $order->order_no;
                $reference_no = $order->reference_no;
                $order_amt = $order->order_amt;
                $order_date_time = $order->order_date_time;
                $order_notes = $order->order_notes;
                $order = Order::where('order_number',$ordernumber)->first();
                if(!is_null($order)){
                    $order->order_status = "Success";
                    $order->save();
                }else{
                    $order = Order::firstOrCreate([
                        "order_number" => $ordernumber,
                        "ccavenue_referencenumber" => $reference_no,
                        "bank_referencenumber" => null,
                        "order_status" => "Success",
                        "status_message" => null,
                        "total_amount" => $amount,
                        "actual_amount" => $amount,
                        "transaction_fee" => 0.00,
                        "service_fee" => 0.00,
                        "payment_date" => date($order_date_time),
                        "payment_remarks" => 'Throught Email and phone lookup',
                        "transaction_remarks" => $order_notes,
                        "reference_parameters" => '',
                        "billing_name" => $candidate->name,
                        "billing_designation" => 'Student',
                        "billing_tel" => $candidate->contactnumber,
                        "billing_email" => $candidate->email,
                    ]);
                    $supplimentaryapplicant->orders()->attach($order->id);
                }
                
                $supplimentaryapplicant->payment_status = 1;
                $supplimentaryapplicant->order_id=$order->id;
                $supplimentaryapplicant->save();
            }
        }
        if($success == true){
            echo "Success". PHP_EOL;
        }else{
            echo "NOT Success". PHP_EOL;
        }
        
        return back();
    }

    public function handle()
    {
        echo 'BEGIN : '.PHP_EOL;
      
        $supplimentaryapplicants = Supplimentaryapplicant::where('payment_status',0)->get();
        foreach($supplimentaryapplicants as $sa){
            echo $sa->id . ')'. PHP_EOL;
            $this->recheckStatusAll($sa->id);
        }

        echo 'END : '.PHP_EOL;
    }

       

    public function failed()
    {
        echo 'Failed';

    }


  
}