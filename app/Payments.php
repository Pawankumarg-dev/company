<?php 

namespace App;

interface Payments
{
    public function paymentRequest();
    public function paymentResponse();
}