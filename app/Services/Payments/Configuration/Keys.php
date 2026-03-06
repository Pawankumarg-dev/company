<?php

    namespace App\Services\Payments\Configuration;
    use App\Configuration;
    use App\Services\Payments\Receiver\IReceiver;
    use App\Services\Payments\Tests\Testable;

    class Keys extends Testable{
        
        protected $merchantIDRaw;
        protected $accessCodeRaw;
        protected $workingKeyRaw;

        public function __construct(IReceiver $receiver) {
            $string = $receiver->getAttributeString();
            $this->merchantIDRaw = Configuration::where('attribute','ccavenue_merchant_id'.$string)->first();
            $this->accessCodeRaw = Configuration::where('attribute','ccavenue_access_code'.$string)->first();
            $this->workingKeyRaw = Configuration::where('attribute','ccavenue_working_key'.$string)->first();
            parent::__construct();
        }

        public  function getMarchentID()
        {
            return $this->merchantIDRaw->value;
        }

        public function getAccessCode()
        {
            return $this->accessCodeRaw->value;
        }

        public function getWorkingKey()
        {
            return $this->workingKeyRaw->value;
        }

        public function test(){
            if( is_null($this->merchantIDRaw) || is_null($this->accessCodeRaw) || is_null($this->workingKeyRaw)  ){
                Testable::throwConfigurationError();
            }
        }
    }
    
?>