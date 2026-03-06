<?php

    namespace App\Services\Payments\Tests;

    use Exception;

    class Error{

        public static function throwConfigurationError(){
            throw new Exception("PaymentGateway Configuration is missing");
        }

        public static function throwIncompleteError(){
            throw new Exception("Not sufficient data to proceed the payment.");
        }
        
    }
?>