<?php

    namespace App\Services\Payments\Configuration;

    use Exception;

    class Error{

        public static function throwError(){
            throw new Exception("PaymentGateway Configuration is missing");
        }
        
    }
?>