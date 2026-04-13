<?php

namespace App\Services\Common;
use App\Http\Requests;

use Session;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Questionpaperdownloadhistory;
use App\Services\Common\HelperService;
use Dompdf\Dompdf;
use Dompdf\Options;
use DB;
class QuestionpaperdownloadService
{
    private $examtimetable;
    private $language;
    private $helperService ;
    private $externalexamcenter_id;
    private $exam_id;

    public function __construct(HelperService $helper){
        //$this->helperService = $helper;
        $this->helperService= new HelperService();
        $this->externalexamcenter_id = $this->helperService->getExternalexamcenterID();
                $this->exam_id = 28;

    }
    
    public function downloadquestionpaper($usertype_id,$r){



       //return "processing";
        //$schedule_id = 43;
        $examtimetable = \App\Examtimetable::find($r->examtimetable_id);
        $this->examtimetable = $examtimetable;

        $enabled = 1;
        if(strpos($r->agent,'X11')!== false){
            $enabled = 0;
        }
        if(strpos($r->agent,'Android')!== false){
            $enabled = 0;
        }
        if($enabled==0){
            $this->log($usertype_id,$r);
            Auth::logout();
            return redirect('/');
        }
        $externalexamcenter_id = $this->helperService->getExternalexamcenterID();
        
       


            if($usertype_id == 6)
            {
                
          
                //Change this to specific schedule
            
                $history = \App\Questionpaperdownloadhistory::where('examtimetable_id',$r->examtimetable_id)
                            ->where('externalexamcenter_id',$externalexamcenter_id)
                            ->where('language_id',$r->language_id)
                            ->first();
                            
                    // if(!is_null($history) ){
                    //     Session::flash('error','Already downloaded');
                    //     return false;
                    // }
                
        $this->log($usertype_id,$r);

                
                $examtimetable_id = $r->examtimetable_id;
              
                $exampapers  = \App\Allexampaper::where('examtimetable_id',$examtimetable_id)
                                ->where('externalexamcenter_id',$externalexamcenter_id)
                                ->get();
                $session_id = Session::getId();
                $password = null;
                foreach($exampapers as $exampaer){
                    $exampaer->downloaded_session = $session_id;
                    $exampaer->save();
                    $password = $exampaer->password;
                }
              

                $allexampaper_id=$r->allexampaper_id;
                $omr_code = $r->omr_code;
                $language_id = $r->language_id;
                $set = 0;
                $set = \App\Examschedule::find($examtimetable->examschedule_id)->qpset;

               
                if($set == 0){
                   //$set = 1;
                   return "processing";
                }

                // return $set;
            
                   // $force = $this->extract($omr_code,$r,$set);
                   
                    $returnfile=$this->qpprocessed($password,$externalexamcenter_id,$set,$omr_code,$allexampaper_id,$language_id);

                    return $returnfile;

              
        
            }
        // }
        return false;
    }


private function qpprocessed($password,$externalexamcenter_id,$set,$omr_code,$allexampaper_id,$language_id){


$ec = \App\Externalexamcenter::where('exam_id', $this->exam_id)
    ->where('id', $externalexamcenter_id)
    ->first();
         $watermark  = public_path('files/watermark/overlays/' . $ec->id . '.pdf');

        // foreach($examcenters as $ec){

        // if(file_exists( public_path($watermark))){
        // }else{

        // $text = $ec->code.' '. $ec->lgdistrict->districtName . ' ' . $ec->lgstate->code;
        // $options = new Options();
        // $options->set('isHtml5ParserEnabled', true);
        // $options->set('isPhpEnabled', true);
        // $pdf = new Dompdf($options);
        // $htmlWithWatermark = '<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); font-size: 60px; color: rgba(91, 91, 91, 0.5);white-space:nowrap;">'.$text.'</div>';
        // $pdf->loadHtml($htmlWithWatermark);
        // $pdf->setPaper('A4', 'portrait');
        // $pdf->render();
        // file_put_contents($watermark, $pdf->output());
        // }

        

$qp = DB::table('examtimetable_language')
    ->where('exam_id', $this->exam_id)
    ->where('omr_code', $omr_code)
    ->where('language_id', $language_id)
    ->first();



$field = 'question_paper_' . $set;


   $newqp = DB::table('allexampapers')
    ->where('id', $allexampaper_id)
    ->first();





        $inputFile  = public_path('files/questionpapers/'.$this->exam_id.'/' . $qp->$field);

        $inputnopass  = public_path('files/watermark/without-en/'.$qp->$field);


        // $inputnopass  = public_path('files/watermark/without-en/'.$set.'/'.$qp->$field);
$outputFile = storage_path('questionpapers/' . $this->exam_id . '/' .$externalexamcenter_id . '_' . $set . '_' . $language_id . '_' . $omr_code . '.pdf');

        $password    = $qp->password;
        $newpassword = $newqp->password;;
// return $outputFile;

$script = app_path('processpdf/decryptfile.sh');
chmod($script, 0755);

$command = "sh " . escapeshellarg($script)
    . " " . escapeshellarg($inputFile)
    . " " . escapeshellarg($inputnopass)
    . " " . escapeshellarg($outputFile)
    . " " . escapeshellarg($password)
    . " " . escapeshellarg($watermark)
    . " " . escapeshellarg($newpassword);
$output = shell_exec($command . " 2>&1");


// if ($output === null) {
//     return response()->json([
//         'status' => false,
//         'message' => 'Shell execution failed'
//     ]);
// }

// return response()->json([
//     'status' => true,
//     'message' => $output
// ]);


return $outputFile;

        


}
    private function log($usertype_id,$r){
        $ip = $_SERVER["REMOTE_ADDR"];
        $session_id = Session::getId();
        $user_id = Auth::user()->id;
        if($usertype_id==6){
              $externalexamcenter_id = $this->helperService->getExternalexamcenterID();
        }else{
            $externalexamcenter_id = \App\Nberstaff::where('user_id',$user_id)->first()->id;
        }
        \App\Questionpaperdownloadhistory::create([
            'examtimetable_id' => $this->examtimetable->id,
            'language_id' => $r->language_id,
            'user_id' => $user_id,
            'externalexamcenter_id' => $externalexamcenter_id,
            'ip_address' => $ip,
            'session_id' => $session_id,
            'agent' => $r->agent,
            'usertype_id' => $usertype_id
        ]);
    }


}

