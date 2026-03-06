<?php 

    namespace App\Services\Faculty;

    use Illuminate\Http\Request;


    use App\Services\DBService;
    use App\Services\Common\FilterService;
    use App\Services\Common\Grammer;
    use App\Services\Common\HelperService;

    class VerifyFaculty extends FilterService{

        private $nber_id;
        private $helperService;

        public function __construct($nber_id,$type) {
            $this->nber_id = $nber_id;
            parent::__construct($type);
            $this->setTitle("Verify the Faculty details ");
            $this->helperService = new HelperService();
        }



        public function getFaculties(){
            $sp = "getFacultyDetails(".$this->helperService->getAcademicYearID()."," .$this->nber_id.",'".$this->getType()."')";
            return Grammer::returnIfNotNull((new DBService)->callSP($sp,true),$this->getType());
        }

        public function getFacultyDetailsOfInstitute($id){
            $sp = "getInstituteCourses(".$this->helperService->getAcademicYearID().",-1,".$id.")";
            $courses = (new DBService)->callSP($sp);
            $faculties = array();
            foreach($courses as $course){
                if($course->nber_id == $this->nber_id){
                    $sp = "getFacultyDetailsOfInstituteCourse(".$this->helperService->getAcademicYearID().",".$id.",".$course->id.")";
                    $faculties[$course->id] = [
                        'course' => $course,
                        'faculties' =>  (new DBService)->callSP($sp)
                    ];
                }
            }
            return $faculties;
        }

        public function getallFaculties(){
            $sp = "getAllFacultyDetails(" .$this->nber_id.",'".$this->getType()."')";
            return Grammer::returnIfNotNull((new DBService)->callSP($sp,true),$this->getType());
        }
       
    }

?>
