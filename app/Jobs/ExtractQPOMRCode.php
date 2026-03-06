<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use File;
use App\Examcenter;
use App\Exampaper;
use App\Examtimetable;
use Dompdf\Dompdf;
use Dompdf\Options;

class ExtractQPOMRCode extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

	public $exam_id;
    public $omr_code;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($exam_id,$omr_code)
    {
        $this->exam_id = $exam_id;
        $this->omr_code = $omr_code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
  
    public function handle()
    {
        

        
        
        $omr_code = $this->omr_code;
        $timetables  = Examtimetable::where('exam_id',$this->exam_id)
                        ->whereHas('subject',function($q) use($omr_code){
                            $q->where('qp_required',1);
                            $q->where('omr_code',$omr_code);
                        })->get();

        $total = 1;
        foreach($timetables as $tt){
            echo $tt->id  . ','. $tt->subject_id;
            if(!is_null($tt->subject->omr_code)){
                $total++;
            }
        }
        $c = 1;
        echo "TOTAL". $total. PHP_EOL;
        $timetables  = Examtimetable::where('exam_id',$this->exam_id)
        ->whereHas('subject',function($q) use($omr_code){
            $q->where('qp_required',1);
            $q->where('omr_code',$omr_code);
        })->get();

        foreach($timetables as $tt){
            //if($tt->qp_process == 0){
                echo 'OMR : '. $tt->subject->omr_code . PHP_EOL;
                if(!is_null($tt->subject->omr_code)){
                    $decrypt = app_path().'/processpdf/decrypt.sh';
                    echo $c. " Out of ".$total. PHP_EOL;
                    echo 'NBER ID '. $tt->subject->qp_prepared_by_nber_id . " Course: ". $tt->subject->programme->course_name.  " Subject: ". $tt->subject->omr_code . PHP_EOL;
                    $c++;
                    $ttcount = $tt->languages()->count();
                    if($ttcount > 0){
                        foreach($tt->languages()->get() as $l){
                            for($set=1;$set<4;$set++){
                                $field = 'question_paper_'.$set;
                                $file = $l->pivot->$field;
                        
                                $nipassword = $tt->password;
                                if(!is_null($file)){
                                    echo " Language: ". $l->language . " Set: ".  $set. PHP_EOL;
                                    $op = shell_exec('sh '. $decrypt . ' ' . app_path(). ' ' . public_path(). ' '. $file. ' '. $l->id . ' ' . $nipassword. ' ' . $tt->subject->omr_code . ' ' . $set . ' '. $tt->examschedule_id);
                                }
                            }
                        }
                        $tt->qp_process = 2;
                        $tt->save();
                    }
                }
           // }
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

        if(file_exists( public_path('files/processedqp/27/overlays/'.$id.'.pdf'))){
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
        $file = public_path('files/processedqp/27/overlays/'.$id.'.pdf'); 
        file_put_contents($file, $pdf->output());
        return true;
    }
}

