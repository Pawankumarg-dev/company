<?php 

    namespace App\Services\LocateInstitute;

    use Illuminate\Http\Request;
    
    class Institutes extends Filter{

        public function __construct(Request $r) {
            $this->setter = "institute_id";
            $this->sp = "getInstitutes";
            parent::__construct($r);
        }

        public function getParams(){
            return array(
                'state'=>['state_id','course_id'],
                'course'=>['state_id','course_id']
            );
        }

    }

?>
