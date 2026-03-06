<?php 

    namespace App\Services\LocateInstitute;

    use Illuminate\Http\Request;

    class Courses extends Filter{

        public function __construct(Request $r) {
            $this->setter = "course_id";
            $this->sp = "getAllCourses";
            parent::__construct($r);
        }

        public function getParams(){
            return array(
                'state'=>['state_id','none'],
                'course'=>['none','none']
            );
        }
      
    }

?>
