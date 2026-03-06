<?php

    namespace App\Services\LocateInstitute;
    use Illuminate\Http\Request;


    class LocateInstituteService{

        protected $type;
        protected $states;
        protected $courses;
        protected $institutes;
        protected $institutedata = null;
        protected $coursedata = null;
        protected $candidates = null;
        protected $faculties = null;
        

        public function __construct(Request $r) {
            $this->states = new States($r);
            $this->courses = new Courses($r);
            $this->institutes = new Institutes($r);
            $this->institutedata = new Data($r);
            $this->coursedata = new CourseData($r);
            $this->candidates = new Candidates($r);
            $this->faculties = new Faculties($r);
            $this->type = new Type($r);

        }

        public function getSelected(){
            return [
                "state_id" => $this->states->getSelected(),
                "course_id" => $this->courses->getSelected(),
                "institute_id" => $this->institutes->getSelected(),
                "type" => $this->type->getSelected()
            ];
        }

        public function getDropdownData(){
            return array(
                "states" => $this->states->getData($this->getSelected()),
                "courses" => $this->courses->getData($this->getSelected()),
                "institutes" => $this->institutes->getData($this->getSelected())
            );
        }

        public function getData(){
            if($this->institutes->getSelected() > 0){
                $courses = $this->coursedata->getData(['institute_id'=>$this->institutes->getSelected(),'type'=>$this->type->getSelected()]);
                $coursedetails = array();
                foreach($courses as $course){
                    $coursedetails[$course->id]= array(
                        'candidates' => $this->candidates->getData(['institute_id'=>$this->institutes->getSelected(),'course_id'=>$course->id,'type'=>$this->type->getSelected()]),
                        'faculties' => $this->faculties->getData(['institute_id'=>$this->institutes->getSelected(),'course_id'=>$course->id,'type'=>$this->type->getSelected()]),
                    );
                }
                return array(
                    'institute' => $this->institutedata->getData(['institute_id'=>$this->institutes->getSelected(),'type'=>$this->type->getSelected()]),
                    'courses' => $courses,
                    'coursedetails' => $coursedetails
                );
            }
            return null;
        }

    }

?>
