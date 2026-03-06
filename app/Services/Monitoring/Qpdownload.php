<?php 

    namespace App\Services\Monitoring;

    use Illuminate\Http\Request;


    use App\Services\Common\HelperService;
    use App\Services\DBService;
    use App\Services\Common\FilterService;
    use App\Services\Common\Grammer;

    class Qpdownload extends FilterService{

        private $helperService;
        private $exam_id;

        public function __construct($type) {
            $this->helperService = new HelperService();
            parent::__construct($type);
            $this->setTitle("QP Downloading");
            $this->exam_id = $this->helperService->getScheduledExamID();
            $this->exam_id = 27;
        }


        public function getQPDownloadStats(){
            $sp = "monitoringQPDownload(".$this->exam_id.",'".$this->getType()."')";
            return Grammer::returnIfNotNull((new DBService)->callSP($sp,true),$this->getType());
        }

        public function getSchedules(){
            return \App\Examschedule::where('exam_id',$this->exam_id)->orderBy('examdate')->orderBy('starttime')->orderBy('endtime')->get();
        }

       
    }

?>
