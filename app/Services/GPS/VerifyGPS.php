<?php 

    namespace App\Services\GPS;

    use Illuminate\Http\Request;


    use App\Services\DBService;
    use App\Services\Common\FilterService;
    use App\Services\Common\Grammer;
    use App\Services\Common\HelperService;

    class VerifyGPS extends FilterService{

        private $nber_id;
        private $helperService;

        public function __construct($nber_id,$type) {
            $this->nber_id = $nber_id;
            parent::__construct($type);
            $this->setTitle("Verify institute location ");
            $this->helperService = new HelperService();
        }



        public function getInstitutes(){
            $sp = "getInstituteGPS(".$this->helperService->getAcademicYearID()."," .$this->nber_id.",'".$this->getType()."')";
            return Grammer::returnIfNotNull((new DBService)->callSP($sp,true),$this->getType());
        }

        public function getGPSDetailsOfInstitute($id){
            $sp = "getInstituteGPSOf(".$this->helperService->getAcademicYearID().",".$id.")";
            return (new DBService)->callSP($sp);
        }
       
    }

?>
