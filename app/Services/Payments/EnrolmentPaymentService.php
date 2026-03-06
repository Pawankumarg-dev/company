<?php 
    
    namespace App\Services\Payments;

    use App\Services\Common\HelperService;
    use App\Services\Payments\Configuration\NBERPaymentConfiguration;
    use App\Services\Payments\OrderService;
    use Session;

    class EnrolmentFeePaymentService implements PaymentService{

        private $data;
        private $nber_id;
        private $candidate;
        private $helperService;
        private $merchant_id;

        public function __construct(HelperService $helperService) {
            $this->helperService = $helperService;
            $this->candidate = $helperService->getCandidate();
        }

        public function paymentRequest($request)
        {
            $this->data = $request->except('_token');        
            $this->nber_id = $this->candidate->approvedprogramme->programme->nber_id;
            $this->merchant_id = (new NBERPaymentConfiguration($this->nber_id))->getMarchentID();
            $merchant_param1 =  '2024,' . $this->candidate->enrolmentno . ',' . $this->nber_id;
            $this->data += ['redirect_url' => url("/candidate/enrolmentpayments/ccavenuepaymentgatewayresponsehandler")];
            $this->data += ['cancel_url' => url("/candidate/enrolmentpayments/ccavenuepaymentgatewayresponsehandler")];
            $this->data += ['currency' => 'INR'];
            $this->data += ['merchant_id' => $this->merchant_id];
            $this->data += ['merchant_param1' => $merchant_param1];
            $this->data += ['merchant_param2' => 'Enrolment Fee'];
            $this->data['amount'] = Session::get('total');
            $order = (new OrderService)->store($this->data);
            $this->candidate->orders()->attach($order->id);
        }

        public function paymentResponse()
        {
            
        }
    }

?>