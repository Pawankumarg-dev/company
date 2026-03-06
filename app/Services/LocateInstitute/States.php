<?php 

    namespace App\Services\LocateInstitute;

    use Illuminate\Http\Request;
    use App\Lgstate;

    class States extends Filter{

        public function __construct(Request $r) {
            $this->setter = "state_id";
            $this->sp = "getStates";
            parent::__construct($r);
        }

        // public function getData($args){
        //     return Lgstate::all();
        // }
      
        public function getParams(){
            return array(
                'state'=> ['none','none'],
                'course'=> ['none','course_id']
            );
        }
    }

?>
