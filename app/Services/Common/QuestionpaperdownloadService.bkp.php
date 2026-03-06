<?php

namespace App\Services\Common;
use App\Http\Requests;

use Session;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Questionpaperdownloadhistory;
use App\Services\Common\HelperService;

class QuestionpaperdownloadServiceBKP
{
    private $examtimetable;
    private $language;
    private $helperService ;
    private $externalexamcenter_id;

    public function __construct(HelperService $helper){
        //$this->helperService = $helper;
        $this->helperService= new HelperService();
        $this->externalexamcenter_id = $this->helperService->getExternalexamcenterID();
    }
    
    public function downloadquestionpaper($usertype_id,$r){
        //$schedule_id = 43;
        
        $externalexamcenter_id = $this->helperService->getExternalexamcenterID();
        $examtimetable = \App\Examtimetable::find(2421);
        $this->examtimetable = $examtimetable;
        if($externalexamcenter_id != 2731){
            $history = \App\Questionpaperdownloadhistory::where('examtimetable_id',$examtimetable->id)
            ->where('externalexamcenter_id',$externalexamcenter_id)
            ->where('language_id',$r->language_id)
            ->first();
            // if(!is_null($history) ){
            //     Session::flash('error','Already downloaded');
            //     return false;
            // }
            $this->log($usertype_id,$r);
            return '/files/questionpapers/demo.pdf';
        }
        if($externalexamcenter_id != 2731){
            $this->language = $this->examtimetable->languages()->where('id',$r->language_id)->first();
            //$this->log($usertype_id,$r);
            return '/files/questionpapers/demo.pdf';
        }

        $schedule_id = \App\Examschedule::where('description','Mockdrill')->first()->id;

        
        $this->examtimetable = \App\Examtimetable::find($r->examtimetable_id);
        $enabled = 1;
        if(strpos($r->agent,'X11')!== false){
            $enabled = 0;
        }
        if(strpos($r->agent,'Android')!== false){
            $enabled = 0;
        }
        if($enabled==0){
            //$this->log($usertype_id,$r);
            Auth::logout();
            return redirect('/');
        }
        
        if($usertype_id == 6){

            $externalexamcenter_id = $this->helperService->getExternalexamcenterID();
            $examtimetable = \App\Examtimetable::find(2421);
            
            if($externalexamcenter_id != 2731){
                //$this->language = $examtimetable->languages()->where('id',$r->language_id)->first();
                //$this->log($usertype_id,$r);
                return '/files/questionpapers/demo.pdf';
            }
            $history = \App\Questionpaperdownloadhistory::where('examtimetable_id',$r->examtimetable_id)
                        ->where('externalexamcenter_id',$externalexamcenter_id)
                        ->where('language_id',$r->language_id)
                        ->first();
            //if(Auth::user()->id != 134579){
                if(!is_null($history) ){
                    Session::flash('error','Already downloaded');
                    return false;
                }
            //}

            $exampapers  = \App\Allexampaper::where('examtimetable_id',$r->examtimetable_id)
                            ->where('externalexamcenter_id',$externalexamcenter_id)
                            ->get();
            $session_id = Session::getId();
            foreach($exampapers as $exampaer){
                $exampaer->downloaded_session = $session_id;
                $exampaer->save();
            }
        }
        // Mockdrill 
        if($externalexamcenter_id != 2731){
            $this->language = $this->examtimetable->languages()->where('id',$r->language_id)->first();
            $this->log($usertype_id,$r);
            return '/files/questionpapers/demo.pdf';
        }
        // Mockdrill ends
        $ttcount = $this->examtimetable->languages()->count();
        $omr_code = $this->examtimetable->subject->omr_code;
        $set = $this->examtimetable->examschedule->qpset;
        
        //DEMO Download
                // if($ttcount == 0){
                    
                //     $sql = "SELECT tt.id from examtimetables  tt inner join subjects s on tt.subject_id = s.id  and  s.omr_code = "+ $omr_code +" inner join examtimetable_language ttl on ttl.examtimetable_id = tt.id WHERE tt.exam_id= 27 group by tt.id";
                //     $result = collect(DB::select($sql))->first();
                //     if(!is_null($result)){
                //         $examtimetable = \App\Examtimetable::find($result->id);
                //     }else{
                //         return null;
                //     }
                // }else{
                //     $examtimetable = $exampapers->examtimetable;
                // }
                return null;
                $returnfile = '/files/processedqp/27/dist/'.$this->examtimetable->examschedule_id.'/wm_e_'.$this->externalexamcenter_id.'_'.$set.'_'.$r->language_id.'_'.$omr_code.'.pdf';
                return $returnfile;
        // DEMO DOWNLOAD END
        
        
        if($set == 0){
            return null;
        }
        // if( Auth::user()->id == 134579){
        //     $set = 1;
        // }
        $field = 'question_paper_'.$set;
      
        // if( Auth::user()->usertype_id = 3){
        //     $this->language = $this->examtimetable->languages()->where('id',$r->language_id)->first();
        //     if($r->rand_string == $this->language->pivot->rand_string){
        //         $file = $this->language->pivot->$field;
        //         //return '/files/questionpapers/'.$this->language->pivot->$field;
        //         return '/files/questionpapers/demo.pdf';
        //     }
        // }
        
        if(
            (
                (
                    $this->examtimetable->examschedule_id == 54
                    
                )
                &&
                    $this->examtimetable->examschedule->qpset > 0
            )
            || Auth::user()->id == 134579
            
        ){
            $this->language = $this->examtimetable->languages()->where('id',$r->language_id)->first();
            $this->log($usertype_id,$r);
            if($r->rand_string == $this->language->pivot->rand_string){
                $file = $this->language->pivot->$field;
                // if(is_null($file)){
                //     \App\Configuration::create([
                //         'attribute'  => $this->externalexamcenter_id . ' , ' . $r->examtimetable_id ,
                //         'value' => 'Set 1'
                //     ]);
                //     $field = 'question_paper_1';
                //     $set = 1;
                // }
                 $returnfile = '/files/processedqp/dist/wm_e_'.$this->externalexamcenter_id.'_'.$set.'_'.$this->language->pivot->$field;
            //    $cmd = app_path().'/processpdf/process.sh';
             //   $password  = \App\Allexampaper::where('externalexamcenter_id',$this->externalexamcenter_id)->where('examtimetable_id',$this->examtimetable->id)->where('exam_id',26)->first()->password;
             //   $nipassword = $this->examtimetable->password;
               // $op = shell_exec('sh '. $cmd . ' ' . app_path(). ' ' . public_path(). ' '. $file. ' '. $this->externalexamcenter_id .  ' '.$password. ' ' . $nipassword);
                if($this->examtimetable->examschedule->description == 'Mock Drill'){
                    return '/files/questionpapers/'.$this->language->pivot->question_paper_1;
                }
                return $returnfile;
            }
        }
        return false;
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

