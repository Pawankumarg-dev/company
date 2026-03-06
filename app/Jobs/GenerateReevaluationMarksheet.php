<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Candidate;
use App\Currentapplication;
use App\Reevaluationapplication;
use App\Reevaluationapplicationsubject;
use App\Subject;
use App\Application;
use App\Slno;


use App\Currentapplicant;

use PDF;

use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

class GenerateReevaluationMarksheet extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        ini_set('memory_limit', '4048M');

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo nl2br('BEGIN : Scanning through completed reevaluation and marking result_id'.PHP_EOL);
        $reevaluationapplications = Reevaluationapplication::where('status_id',1)->where('exam_id',22)->where('orderstatus_id',1)->get();
        $count = 1;
        foreach($reevaluationapplications as $ra){
            $count+=1;
            $completed = 1;
            foreach($ra->reevaluationapplicationsubjects as $rs){
                echo $rs->id .' , '; 
                if($rs->active_status == 1){
                    $completed = 0;
                }else{
                    if($rs->no_change != 1){
                        if($rs->reevaluated_marks != null){
                            $subject = Subject::find($rs->subject_id);
                            $currentapplication = Currentapplication::where('subject_id',$rs->subject_id)->where('candidate_id',$rs->candidate_id)->first();
                            if($subject->emin_marks <= $rs->reevaluated_marks && $subject->imin_marks <= $currentapplication->internal_mark){
                                $rs->result_id = 1;
                            }else{
                                $rs->result_id =0;
                            }
                            //if($rs->reevaluated_marks < $currentapplication->external_mark){
                               // $completed = 0;
                                //echo "LESS REEVALUATED MARK". PHP_EOL;
                            //}
                            shell_exec(app_path().'/mscpermission.sh');

                            $rs->save();
                        }
                    }
                } 
           //     echo 'Active Status: '. $rs->active_status. ', Result: '. $rs->result_id.PHP_EOL ; 
            }
            //echo 'Status ID: ' . $ra->status_id . PHP_EOL;
            if($completed==1){
            //   echo  $this->generatemsc($ra->candidate_id, $ra->id);
                $ra->status_id = 10;
                $ra->save();
            }
            echo $count . ') ' . $ra->id  . ' - Status: '. $ra->status_id . ', Completed: '. $completed  .PHP_EOL;
        }
        echo ("Completed".PHP_EOL);
        
    }

    private function processgracemarks($cid){

    }
       
  

    public function failed()
    {
        echo 'Failed';

    }


  
}