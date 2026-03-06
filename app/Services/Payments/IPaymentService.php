<?php

    namespace App\Services\Payments;

    abstract class IPaymentService
    {
        public function __construct() {
            
        }
        abstract public function paymentRequest($request);
        abstract public function paymentResponse();
        abstract public function getStatus();
    }

?>
