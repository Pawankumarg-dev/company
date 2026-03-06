<?php 

    namespace App\Services\NSPRegNo;

    use Illuminate\Http\Request;


    use App\Services\Common\HelperService;
    use App\Services\DBService;
    use App\Services\Common\FilterService;
    use App\Services\Common\Grammer;

    class NSPRegNo extends FilterService{

        private $nber_id;
        private $helperService;

        public function __construct($nber_id,$type) {
            $this->nber_id = $nber_id;
            $this->helperService = new HelperService();
            parent::__construct($type);
            $this->setTitle("NSP Registration Number");
        }


        public function getInstitutes(){
            $sp = "getNSPInstitutes(".$this->helperService->getAcademicYearID().",".$this->nber_id.",'".$this->getType()."')";
            return Grammer::returnIfNotNull((new DBService)->callSP($sp,true),$this->getType());
        }

       
    }

?>
