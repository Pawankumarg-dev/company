<?php 
    namespace App\Services\Payments;

    use App\Order;
    use Exception;

    class OrderService{

        public function store($data){
            $this->validate();
            $order = Order::firstOrCreate([
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
            Session::put('data',$data);
            Session::put('order_number',$data["order_number"]);
            return $order;
        }

        public function  validate(){
            $ordercount = Order::where('order_number', Session::get('order_number'))->count();
            if ($ordercount > 0) {
                throw new Exception("Session Expired!, Please try again");
            }
        }
    }
    
?>