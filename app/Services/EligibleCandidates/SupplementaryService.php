<?php 

    namespace App\Services\EligibleCandidates;

    use Illuminate\Http\Request;


    use App\Services\DBService;
    use App\Services\Common\FilterService;
    use App\Services\Common\Grammer;
    use App\Services\Common\HelperService;

    class SupplementaryService extends FilterService{

        private $nber_id;
        private $helperService;

        public function __construct($nber_id,$type) {
            $this->nber_id = $nber_id;
            parent::__construct($type);
            $this->setTitle("Eligible Candidates");
            $this->helperService = new HelperService();
        }



        public function getCandidates(){
            $sp = "getEligibleCandidatesSupplementary(" .$this->nber_id.",'".$this->getType()."')";
            return Grammer::returnIfNotNull((new DBService)->callSP($sp,true),$this->getType());
        }

        public function getCourses(){
            $sp = "getEligibleCandidatesSupplementaryCourseList(" .$this->nber_id.")";
            return Grammer::returnIfNotNull((new DBService)->callSP($sp,true),$this->getType());
        }
        
        public function getProgrammes($id){
            $sp = "getEligibleCandidatesSupplementaryProgrammeList(" .$this->nber_id.",".$id.")";
            return Grammer::returnIfNotNull((new DBService)->callSP($sp,true),$this->getType());
        }
    }

?>
