<?php
    namespace App\Services\Payments\Tests;


    abstract class Testable{

        public function __construct(){
            $this->test();
        }
        
        abstract function test();

        public static function throwConfigurationError(){
            Error::throwConfigurationError();
        }

        public static function throwIncompleteError(){
            Error::throwIncompleteError();
        }

    }
?>