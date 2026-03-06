<?php 

    namespace App\Services\Institutes;


    use App\Services\DBService;

    use App\Services\Common\HelperService;

    class ListOfInstitutes{

        private $type = 'current';

        private $course_id = -1;

        private $nber_id ;

        private $helperService;

        public function __construct($course_id,$nber_id,$type = null) {
            $this->helperService = new HelperService();
            if(!is_null($type)){
                $this->type = $type;
            }
            $this->course_id = $course_id;
            $this->nber_id = $nber_id;

        }

        public function getInstitutes(){
            if($this->type=='current'){
                $sp = "getInstitutesOfNber(". $this->helperService->getAcademicYearID().",".$this->nber_id.",".$this->course_id.")";
            }
            return (new DBService)->callSP($sp,true);
        }
    }

?>
