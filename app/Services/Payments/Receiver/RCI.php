<?php
    
    namespace App\Services\Payments\Receiver;


    class RCI  implements IReceiver{

        public function getAttributeString(){
            return '';     
        }

        public function getMarchantParam3()
        {
            return 0;
        }


    }

?>