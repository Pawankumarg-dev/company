<?php 

    namespace App\Services\Exam;

    use Illuminate\Http\Request;


    use App\Services\DBService;
    use App\Services\Common\FilterService;
    use App\Services\Common\Grammer;
    use App\Services\Common\HelperService;
    use Session;

    class ApplicationService extends FilterService{

        private $nber_id;
        private $helperService;
        

        public function __construct($nber_id,$type) {
            $this->nber_id = $nber_id;
            parent::__construct($type);
            $this->setTitle("Exam Applications - ". Session::get('examname'));
            $this->helperService = new HelperService();
        }

        public function getProgrammes(){
            $sql = "SELECT 
                        p.id, p.abbreviation 
                    FROM combinedapplications ca
                    INNER JOIN candidates c on c.id = ca.candidate_id
                    INNER JOIN approvedprogrammes ap on ap.id = c.approvedprogramme_id
                    INNER JOIN programmes p ON p.id = ap.programme_id
                    WHERE ca.exam_id = ". Session::get('exam_id'). " AND ( ". $this->nber_id ." > 0 AND 
                        p.nber_id = " . $this->nber_id . ")
                        OR
                        " . $this->nber_id . "= 0 
                    GROUP BY p.id     
                    ";
            return (new DBService)->fetch($sql,true);
        }

        public function getList(){
            //$sp = "getApplications(".$this->helperService->getAcademicYearID()."," .$this->nber_id.",'".$this->getType()."')";
            //return Grammer::returnIfNotNull((new DBService)->callSP($sp,true),$this->getType());
            return "";
        }

        public function getGPSDetailsOfInstitute($id){
            $sp = "getInstituteGPSOf(".$this->helperService->getAcademicYearID().",".$id.")";
            return (new DBService)->callSP($sp);
        }
       
    }

?>
