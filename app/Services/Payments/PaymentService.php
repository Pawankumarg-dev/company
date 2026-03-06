<?php 
    
    namespace App\Services\Payments;

    use App\Paymentcategory;
    use App\Services\Payments\Tests\Testable;

    class PaymentService extends Testable{

        public $type;
        private $param1;
        private $param2;
        private $param3;
        private $record;
        private $request;
        private $receiver;
        private $id;
        private $instance_id;

        public function __construct($type,$id,$instatnce_id) {
            
            $this->type = Paymentcategory::where('category',$type)->first();
            
            $classname = "\App\Services\Payments\Types\\" .  $this->getClass();
            $recordclass =  "\App\Services\Payments\Records\\" .  $this->getClass();
            
            $this->id = $id;
            $this->instance_id = $instatnce_id;
            $this->record = (new $recordclass($id,$instatnce_id));

            

            
        }


        public function getRecord(){
            return $this->record->getRecord();
        }

        public function getUser(){
            return $this->type->user;
        }

        public function getReceiver(){
            return $this->type->receiver;
        }

        public function getClass(){
            return $this->type->class;
        }
        
        public function getMarchantParams(){
            return   $this->param1 . "," . $this->param2 . "," . $this->param3;
        }

        public function createRequest(){
            return $this->getRecord();
        }

        public function test(){
            if(is_null($this->type)){
                Testable::throwConfigurationError();
            }
        }

    }

?>