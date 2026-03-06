<?php 

    namespace App\Services\Monitoring;

    use Illuminate\Http\Request;


    use App\Services\Common\HelperService;
    use App\Services\DBService;
    use App\Services\Common\FilterService;
    use App\Services\Common\Grammer;
    use \Session;

    class Attendance extends FilterService{

        private $helperService;
        private $exam_id;
        private $nber_id ;
        public function __construct($type) {
            $this->helperService = new HelperService();
            parent::__construct($type);
            $this->setTitle("Attendance");
            $this->exam_id = Session::get('exam_id');
            $this->nber_id = $this->helperService->getNberORRCIID();
        }


        public function getExamCenters(){
            $sp = "monitoringAttendance(".$this->exam_id.",'".$this->getType()."',".$this->nber_id.")";
            return Grammer::returnIfNotNull((new DBService)->callSP($sp,true),$this->getType());
        }

        public function getSchedules(){
            return \App\Examschedule::where('exam_id',$this->exam_id)->orderBy('examdate')->orderBy('starttime')->orderBy('endtime')->get();
        }

        public function getApprovedprogrammes($eecid,$schedule_id){
            $approvedprogrammes  = \App\Allexampaper::where('exam_id',$this->exam_id)->where('externalexamcenter_id',$eecid);
            if(!is_null($schedule_id)){
                $approvedprogrammes  = $approvedprogrammes->where('examschedule_id',$schedule_id);
            }else{
                $approvedprogrammes = $approvedprogrammes->whereHas('examschedule_id',function($q){
                    $q->where('trackattendance',1);
                });
            }
            if($this->nber_id> 0){
                if($this->nber_id==4 || $this->nber_id==1){
                    $approvedprogrammes = $approvedprogrammes->whereHas('programme', function($q) {
                    $q->whereIn('nber_id', [1, 4]);

                });

                }else{
                    $approvedprogrammes  = $approvedprogrammes->whereHas('programme',function($q){
                    $q->where('nber_id',$this->nber_id);
                });
                }
                
            }
            $approvedprogrammes = $approvedprogrammes->get();
            return $approvedprogrammes;
        }
        
        public function getSchedule($schedule_id){
            return \App\Examschedule::find($schedule_id);
        }

        public function getExamCenter($id){
            return \App\Externalexamcenter::find($id);
        }
       
    }

?>
