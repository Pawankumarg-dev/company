<?php
    
    namespace App\Services\Payments\Request;

    class Request{

        private $record;

       
        protected $data;

        public function __construct($request,$record) {
            
            $this->data = $request->except('_token');     
            $this->record = $record;
        }

        public function createRequest(){
            
        //$institute = Institute::where('user_id',Auth::user()->id)->first();
        //$academicyear_id = \App\Academicyear::where('current',1)->first()->id;
        //$data = $request->except('_token');
    
    //    $affiliationfee  = Affiliationfee::where('institute_id',$institute->id)->where('academicyear_id',$academicyear_id)->first();
        
        $merchant_id = Configuration::where('attribute','ccavenue_merchant_id')->first()->value;

        $merchant_param1 = $request->affiliationfee_id.','.$request->institute_id.','.$request->affiliationfee_id.','.$request->academicyear_id;

        $data += ['redirect_url' => "https://rcinber.org.in/institute/incidentalpayments/ccavenuepaymentgatewayresponsehandler"];
        $data += ['cancel_url' => "https://rcinber.org.in/institute/incidentalpayments/ccavenuepaymentgatewayresponsehandler"];
      //  $data += ['cancel_url' => "https://beta.rcinber.org.in/institute/incidentalpayments/ccavenuepaymentgatewayfailpage/"];

        $data += ['currency' => 'INR'];
        $data += ['merchant_id' => $merchant_id];
        $data += ['merchant_param1' => $merchant_param1];
        $data += ['merchant_param2' => 'Affiliation Fee'];
        $data['amount'] = Session::get('total');

        $order = Order::where('order_number',Session::get('order_number'))->count();
        if($order > 0){
            Session::put('messages','Session Expired!, Please try again');
            return back();
        }
        $order = Order::create([
            "order_number" => $data["order_number"],
            "ccavenue_referencenumber" => $data['ref_num'],
            "bank_referencenumber" => null,
            "order_status" => "Initiated",
            "status_message" => null,
            "total_amount" => Session::get('total'),
            "actual_amount" => Session::get('total'),
            "transaction_fee" => 0.00,
            "service_fee" => 0.00,
            "payment_date" => date("Y-m-d"),
            "payment_remarks" => $data["merchant_param2"],
            "transaction_remarks" => $data["billing_notes"],
            "reference_parameters" => $data["merchant_param1"],
            "billing_name" => $data["billing_name"],
            "billing_designation" => $data["billing_designation"],
            "billing_tel" => $data["billing_tel"],
            "billing_email" => $data["billing_email"],
        ]);

        $affiliationfee->orders()->attach($order->id);
        Session::put('data',$data);
        Session::put('order_number',$data["order_number"]);

        }

        public function getData(){
            return $this->data;
        }

    }

?>