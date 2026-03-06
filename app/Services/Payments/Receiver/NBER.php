<?php
    
    namespace App\Services\Payments\Receiver;

    use Session;

    class NBER  implements IReceiver{

        private $nber_id;

        public function __construct($nber_id) {
            $this->nber_id = $nber_id;
            Session::put('nber_id',$this->nber_id);
        }

        public function getAttributeString(){
            return '_nber_'.$this->nber_id;         
        }

        public function getMarchantParam3()
        {
            return $this->nber_id;
        }



    }

?>