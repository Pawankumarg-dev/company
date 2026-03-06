<?php 

    namespace App\Services\Examcenter;

    use Illuminate\Http\Request;


    use App\Services\Common\HelperService;
    use App\Services\DBService;
    use App\Services\Common\FilterService;
    use App\Services\Common\Grammer;

    class ExamcenterConsentForm extends FilterService{

        private $nber_id;
        private $helperService;
        private $academicyear_id;

        public function __construct($nber_id,$type) {
            $this->nber_id = $nber_id;
            $this->helperService = new HelperService();
            $this->academicyear_id = 12;// $this->helperService->getAcademicYearID();
            parent::__construct($type);
            $this->setTitle("Consent Form from Institutes");
        }


        public function getInstitutes(){
            $sp = "getNoOfExamConcentForms(". $this->academicyear_id .",".$this->nber_id.",'".$this->getType()."')";
            return Grammer::returnIfNotNull((new DBService)->callSP($sp,true),$this->getType());
        }

       
    }

?>
