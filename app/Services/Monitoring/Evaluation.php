<?php 

    namespace App\Services\Monitoring;

    use Illuminate\Http\Request;


    use App\Services\Common\HelperService;
    use App\Services\DBService;
    use App\Services\Common\FilterService;
    use App\Services\Common\Grammer;

    class Evaluation extends FilterService{

        private $helperService;
        private $exam_id;
        private $nber_id ;

        public function __construct($type) {
            $this->helperService = new HelperService();
            parent::__construct($type);
            $this->setTitle("Evaluation");
            $this->exam_id = $this->helperService->getScheduledExamID();
            $this->nber_id = $this->helperService->getNberORRCIID();
        }


        public function getData(){
            $sp = "monitorevaluation(".$this->exam_id.",".$this->nber_id.")";
            return Grammer::returnIfNotNull((new DBService)->callSP($sp,true),$this->getType());
        }

        
    }

?>
