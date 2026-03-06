<?php 

    namespace App\Services\LocateInstitute;

    use Illuminate\Http\Request;

    class Candidates extends Institutes{

        public function __construct(Request $r) {
            parent::__construct($r);
            $this->sp = "getCandidateDetails";
        }

        public function getParams(){
            return array(
                'state'=>['institute_id','course_id'],
                'course'=>['institute_id','course_id']
            );
        }
    }

?>
