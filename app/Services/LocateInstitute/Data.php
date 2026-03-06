<?php
    namespace App\Services\LocateInstitute;

    use Illuminate\Http\Request;


    class Data extends Institutes{

        public function __construct(Request $r) {
            
            parent::__construct($r);
            $this->sp = "getInstituteData";
          
        }

        public function getParams(){
            return array(
                'state'=>['institute_id'],
                'course'=>['institute_id']
            );
        }

    }
?>