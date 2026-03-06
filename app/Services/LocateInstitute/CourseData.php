<?php 

    namespace App\Services\LocateInstitute;
    use Illuminate\Http\Request;

    class CourseData extends Courses{

        public function __construct(Request $r) {
            parent::__construct($r);
            $this->sp = "getInstituteCourse_data";
        }

        public function getParams(){
            return array(
                'state'=>['none','institute_id'],
                'course'=>['none','institute_id']
            );
        }
    }

?>
