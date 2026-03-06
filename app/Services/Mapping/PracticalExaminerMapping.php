<?php 

    namespace App\Services\Mapping;

    use Illuminate\Http\Request;


    use App\Services\DBService;
    use App\Services\Common\FilterService;
    use App\Services\Common\Grammer;
    use App\Services\Common\HelperService;

    use Session;

    class PracticalExaminerMapping extends FilterService{

        private $nber_id;
        private $exam_id;
        private $helperService;

        public function __construct($type) {
            $this->exam_id = 27;
            parent::__construct($type);
            $this->setTitle("Practical Examiner Mapping");
            $this->helperService = new HelperService();
            $this->nber_id = $this->helperService->getNberID();
        }

        public function getPracticalExaminers(){
            $sp = "getPracticalExaminers(".$this->exam_id."," .$this->nber_id.",'".$this->getType()."')";
            return Grammer::returnIfNotNull((new DBService)->callSP($sp,true),$this->getType());
        }

        public function getFacultyList(){
            $sp = "getAllFacultyList(".$this->nber_id.",'PE')";
            return Grammer::returnIfNotNull((new DBService)->callSP($sp,true),$this->getType());
        }

        public function getListofFaculties(){
            $sp = "getListoffacultites(".$this->nber_id.")";
            return Grammer::returnIfNotNull((new DBService)->callSP($sp,false),$this->getType());
        }
       
    }
?>