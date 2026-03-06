<?php 

    namespace App\Services\Exam;

    use Illuminate\Http\Request;


    use App\Services\DBService;
    use App\Services\Common\FilterService;
    use App\Services\Common\Grammer;
    use App\Services\Common\HelperService;
    use Session;

    class VerifyAttendanceNInternalsService extends FilterService{

        private $nber_id;
        private $helperService;
        

        public function __construct($nber_id,$type) {
            $this->nber_id = $nber_id;
            parent::__construct($type);
            $this->setTitle("Classroom attendance and Internal Mark entry verification - ". Session::get('examname'));
            $this->helperService = new HelperService();
        }


        public function getInstitutes(){
            $sp = "getInstituteListForExam(" .$this->nber_id.",'".$this->getType()."')";
            return (new DBService)->callSP($sp,true);
        }

        public function getAttendances($id){
            $sp = "getAttendances(" .$id.",27)";
            return (new DBService)->callSP($sp,false);
        }

        public function getInternalMarks($id,$stid,$term){
            $sp = "getInternalMarks(" .$id.",27,".$stid.",".$term.")";
            return (new DBService)->callSP($sp,false);
        }

        public function getSubjects($id,$stid,$term){
            $sp= "getInternalSubjects(" .$id.",".$stid.",".$term.")";
            return (new DBService)->callSP($sp,false);
        }
        
       
    }

?>
