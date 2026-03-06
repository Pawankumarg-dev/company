<?php
    
    namespace App\Services\Payments\Receiver;

    interface IReceiver{
        public function getAttributeString();
        public function getMarchantParam3();
    }

?>