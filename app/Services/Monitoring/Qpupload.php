<?php 

    namespace App\Services\Monitoring;

    use Illuminate\Http\Request;


    use App\Services\Common\HelperService;
    use App\Services\DBService;
    use App\Services\Common\FilterService;
    use App\Services\Common\Grammer;

    class Qpupload extends FilterService{

        private $helperService;
        private $exam_id;

        public function __construct($type) {
            $this->helperService = new HelperService();
            parent::__construct($type);
            $this->setTitle("QP Upload");
            $this->exam_id = $this->helperService->getScheduledExamID();
        }


        public function getQPuploadStats(){
            $sp = "monitoringQPUpload(".$this->exam_id.",'".$this->getType()."')";
            return Grammer::returnIfNotNull((new DBService)->callSP($sp,true),$this->getType());
        }

        public function getSchedules(){
            return \App\Examschedule::where('exam_id',$this->exam_id)->where('examtype_id',1)->orderBy('examdate')->orderBy('starttime')->orderBy('endtime')->get();
        }

       
    }

?>
