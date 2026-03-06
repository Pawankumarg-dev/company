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

class Processqpdemo extends Job implements ShouldQueue
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
        if($this->schedule_id == 0){
            $schedules = \App\Examschedule::where('exam_id',$this->exam_id)->where('description','<>','Mockdrill')->get();
            foreach($schedules as $schedule){
                $this->process($schedule->id);
            }
        }else{
            $this->process($this->schedule_id);
        }
    }
    public function process($schedule_id)
    {
        $timetables  = Examtimetable::where('examschedule_id',$schedule_id)->get();
        $decrypt = app_path().'/processpdf/decrypt.sh';
        $watermark = app_path().'/processpdf/watermark.sh';
        $encrypt= app_path().'/processpdf/encrypt.sh';
        $ttcount = $timetables->count();
        $counter = 1;
      
        // echo "Step 2";
            $exampapers = Allexampaper::where('examschedule_id',$schedule_id)->where('externalexamcenter_id',2731)->groupBy('subject_id')->get();
         $epcount = $exampapers->count();
        $counter = 1;
        foreach($exampapers as $ep){
            if($ep->encrypted == 0){
                $ttcount = $ep->examtimetable->languages()->count();
                if($ttcount == 0){
                   // $omr_code = $ep->examtimetable->subject->omr_code;
                    $examtimetable = \App\Examtimetable::find($ep->examtimetable->omr_examtimetable_id);
                  //  $sql = "SELECT tt.id from examtimetables  tt inner join subjects s on tt.subject_id = s.id  and  s.omr_code = "+ $omr_code +" inner join examtimetable_language ttl on ttl.examtimetable_id = tt.id WHERE tt.exam_id= 27 group by tt.id";
                   // $result = collect(DB::select($sql))->first();
                    //if(!is_null($result)){
                        
                    //}else{
                    //    echo "QP Not found";
                    //}
                }else{
                    $examtimetable = $ep->examtimetable;
                }
                $ttcount = $examtimetable->languages()->count();
                if($ttcount > 0){
                    foreach($examtimetable->languages()->get() as $l){
                        echo $ep->externalexamcenter->code . ' - ' . $ep->externalexamcenter->name. PHP_EOL;
                        for($set=1;$set<4;$set++){
                            $field = 'question_paper_'.$set;
                            $file = $l->pivot->$field;
                            if(!is_null($file)){
                                echo "Watermarking ". $counter  . ' of ' . $epcount .  " Course: ". $ep->examtimetable->subject->programme->course_name.  " Subject: ". $ep->examtimetable->subject->scode . " Language: ". $l->language . " Set : ". $set .  " NBER: ". $ep->examtimetable->subject->programme->nber->short_name_code .$set .  PHP_EOL;
                    
                                $op = shell_exec('sh '. $watermark . ' ' . app_path(). ' ' . public_path(). ' '. $file. ' '. $set . ' ' . $ep->externalexamcenter_id . ' ' . $l->id . ' ' . $ep->examtimetable->subject->omr_code .' ' . $ep->examtimetable->examschedule_id) ;
                            }
                        }
                    }
                }
                $counter++;
            }
        }


        echo "Step 3" . PHP_EOL;
        $counter = 1;
        foreach($exampapers as $ep){
            if($ep->encrypted == 0){
                $password = $this->generateRandomString(8);
                $eps = Allexampaper::where('externalexamcenter_id',$ep->externalexamcenter_id)->where('examschedule_id',$schedule_id)->where('subject_id',$ep->subject_id)->get();
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
                    }
                }else{
                    $examtimetable = $ep->examtimetable;
                }
                $ttcount = $examtimetable->languages()->count();
                if($ttcount > 0){
                    foreach($examtimetable->languages()->get() as $l){
                        for($set=1;$set<4;$set++){
                            $field = 'question_paper_'.$set;
                            $file = $l->pivot->$field;
                            if(!is_null($file)){
                                echo "Encrypting ". $counter  . ' of ' . $epcount  . " Course: ". $ep->examtimetable->subject->programme->course_name.  " Subject: ". $ep->examtimetable->subject->scode . " Language: ". $l->language . " Set: " . $set.  " NBER: ". $ep->examtimetable->subject->programme->nber->short_name_code .  PHP_EOL;
                                $op = shell_exec('sh '. $encrypt . ' ' . app_path(). ' ' . public_path(). ' '. $file. ' '. $set . ' ' . $ep->externalexamcenter_id. ' '. $password . ' ' . $l->id . ' ' . $ep->examtimetable->subject->omr_code .' ' . $ep->examtimetable->examschedule_id) ;
                            }
                        }
                    }
                }
                foreach($eps as $ep){
                    $ep->encrypted = 1;
                    $ep->save();
                    echo "Saving status for ". $ep->externalexamcenter->code . ' - ' . $ep->externalexamcenter->name. PHP_EOL;
                }
                $counter++;
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

    public function generatePDF($id)
    {

        if(file_exists( public_path('files/processedqp/overlays/'.$id.'.pdf'))){
            return true;
        }
        $ec = \App\Externalexamcenter::find($id);
        $text = $ec->code.' '. $ec->lgdistrict->districtName . ' ' . $ec->lgstate->code;
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $pdf = new Dompdf($options);
        $htmlWithWatermark = '<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); font-size: 60px; color: rgba(91, 91, 91, 0.5);white-space:nowrap;">'.$text.'</div>';
        $pdf->loadHtml($htmlWithWatermark);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $file = public_path('files/processedqp/overlays/'.$id.'.pdf'); 
        file_put_contents($file, $pdf->output());
        return true;
    }
}
