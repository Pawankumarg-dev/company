<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use File;
use App\Examcenter;
use App\Allexampaper;
use App\Examtimetable;
use Dompdf\Dompdf;
use Dompdf\Options;
use DB;

class Encrypting extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

	public $exam_id;
    public $schedule_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($exam_id,$schedule_id)
    {
        $this->exam_id = $exam_id;
        $this->schedule_id = $schedule_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $timetables  = Examtimetable::where('examschedule_id',$this->schedule_id)->get();
        $decrypt = app_path().'/processpdf/decrypt.sh';
        $watermark = app_path().'/processpdf/watermark.sh';
        $encrypt= app_path().'/processpdf/encrypt.sh';
        echo "Step 1";
        $ttcount = $timetables->count();
        $counter = 1;
       
        // echo "Step 2";
             $exampapers = Allexampaper::where('examschedule_id',$this->schedule_id)->groupBy('externalexamcenter_id')->groupBy('omr_code')->get();
          $epcount = $exampapers->count();
      
        $exampapers = Allexampaper::where('examschedule_id',$this->schedule_id)->groupBy('externalexamcenter_id')->groupBy('omr_code')->get();
        echo "Step 3" . PHP_EOL;
        $counter = 1;
        foreach($exampapers as $ep){
            if($ep->encrypted == 2){
                $password = $this->generateRandomString(8);
                $eps = Allexampaper::where('externalexamcenter_id',$ep->externalexamcenter_id)->where('examschedule_id',$this->schedule_id)->where('omr_code',$ep->subject->omr_code)->get();
                foreach($eps as $pwds){
                    $pwds->password = $password;
                    $pwds->save();
                    echo "Saving pwd for ". $ep->externalexamcenter->code . ' - ' . $ep->externalexamcenter->name. PHP_EOL;
                }
                echo $ep->externalexamcenter->code . ' - ' . $ep->externalexamcenter->name. PHP_EOL;
                $ttcount = $ep->examtimetable->languages()->count();
                if($ttcount == 0){
                    $examtimetable = \App\Examtimetable::find($ep->examtimetable->omr_examtimetable_id);
                    // $omr_code = $ep->examtimetable->subject->omr_code;
                    // $sql = "SELECT tt.id from examtimetables  tt inner join subjects s on tt.subject_id = s.id  and  s.omr_code = "+ $omr_code +" inner join examtimetable_language ttl on ttl.examtimetable_id = tt.id WHERE tt.exam_id= 27 group by tt.id";
                    // $result = collect(DB::select($sql))->first();
                    // if(!is_null($result)){
                    //     $examtimetable = \App\Examtimetable::find($result->id);
                    // }else{
                    //     echo "QP Not found";
                    // }
                }else{
                    $examtimetable = $ep->examtimetable;
                }
                $ttcount = $examtimetable->languages()->count();
                if($examtimetable->subject->qp_required == 1){
                    if($ttcount > 0){
                        foreach($examtimetable->languages()->get() as $l){
                            for($set=1;$set<4;$set++){
                                $field = 'question_paper_'.$set;
                                $file = $l->pivot->$field;
                                if(!is_null($file)){
                                    echo "Encrypting ". $counter  . ' of ' . $epcount  . " Course: ". $ep->examtimetable->subject->programme->course_name.  " Subject: ". $ep->examtimetable->subject->scode . " Language: ". $l->language . " Set: " . $set.  " NBER: ". $ep->examtimetable->subject->programme->nber->short_name_code .  PHP_EOL;
                                    $op = shell_exec('sh '. $encrypt . ' ' . app_path(). ' ' . public_path(). ' '. $file. ' '. $set . ' ' . $ep->externalexamcenter_id. ' '. $password . ' ' . $l->id . ' ' . $ep->examtimetable->subject->omr_code . ' ' . $ep->examtimetable->examschedule_id );                                
                                }
                            }
                        }
                    }
                }
                foreach($eps as $ep){
                    $ep->encrypted = 3;
                    $ep->save();
                    echo "Saving status for ". $ep->externalexamcenter->code . ' - ' . $ep->externalexamcenter->name. PHP_EOL;
                }
                $counter++;
            }
        }
    }

    public function generateRandomString($max) {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXY3456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $max; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
