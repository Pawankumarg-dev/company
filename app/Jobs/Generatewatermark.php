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

class Generatewatermark extends Job implements ShouldQueue
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
        $counter = 1;
        echo $epcount . PHP_EOL;
        foreach($exampapers as $ep){
            //if($ep->encrypted < 2){
                $omr = \App\Omrcode::where('omr_code',$ep->omr_code)->first();
                $language_ids = \App\Qplanguage::where('omr_code',$ep->omr_code)->where('externalexamcenter_id',$ep->externalexamcenter_id)->pluck('language_id')->toArray();
                foreach($omr->languages()->get() as $l){
                    if(in_array($l->id, $language_ids)){
                        for($set=1;$set<4;$set++){
                            $field = 'question_paper_'.$set;
                            $file = $l->pivot->$field;
                            echo $counter . ' of ' . $epcount;
                            $op = shell_exec('sh '. $watermark . ' ' . app_path(). ' ' . public_path(). ' '. $file. ' '. $set . ' ' . $ep->externalexamcenter_id . ' ' . $l->id . ' ' . $ep->examtimetable->subject->omr_code . ' ' . $ep->examtimetable->examschedule_id);
                        }
                    }
                }
            //}
            $counter++;
            $eps = Allexampaper::where('externalexamcenter_id',$ep->externalexamcenter_id)->where('examschedule_id',$this->schedule_id)->where('omr_code',$ep->subject->omr_code)->get();
            foreach($eps as $ep){
                $ep->encrypted = 2;
                $ep->save();
                echo "Saving status for ". $ep->externalexamcenter->code . ' - ' . $ep->externalexamcenter->name. PHP_EOL;
            }
        }

        $exampapers = Allexampaper::where('examschedule_id',$this->schedule_id)->groupBy('externalexamcenter_id')->groupBy('omr_code')->get();
        echo "Step 3" . PHP_EOL;
        $counter = 1;
        foreach($exampapers as $ep){
            //if($ep->encrypted == 2){
                $password = $this->generateRandomString(8);
                $eps = Allexampaper::where('externalexamcenter_id',$ep->externalexamcenter_id)->where('examschedule_id',$this->schedule_id)->where('omr_code',$ep->subject->omr_code)->get();
                foreach($eps as $pwds){
                    $pwds->password = $password;
                    $pwds->save();
                    echo "Saving pwd for ". $ep->externalexamcenter->code . ' - ' . $ep->externalexamcenter->name. PHP_EOL;
                }
                echo $ep->externalexamcenter->code . ' - ' . $ep->externalexamcenter->name. PHP_EOL;
                $omr = \App\Omrcode::where('omr_code',$ep->omr_code)->first();
                $language_ids = \App\Qplanguage::where('omr_code',$ep->omr_code)->where('externalexamcenter_id',$ep->externalexamcenter_id)->pluck('language_id')->toArray();
                foreach($omr->languages()->get() as $l){
                    if(in_array($l->id, $language_ids)){
                        for($set=1;$set<4;$set++){
                            $field = 'question_paper_'.$set;
                            $file = $l->pivot->$field;
                            echo $counter . ' of ' . $epcount;
                            $op = shell_exec('sh '. $encrypt . ' ' . app_path(). ' ' . public_path(). ' '. $file. ' '. $set . ' ' . $ep->externalexamcenter_id. ' '. $password . ' ' . $l->id . ' ' . $ep->examtimetable->subject->omr_code . ' ' . $ep->examtimetable->examschedule_id );                                
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
        // }
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
