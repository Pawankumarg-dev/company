<?php

namespace App\Services\Common;
use App\Http\Requests;

use Session;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Questionpaperdownloadhistory;
use App\Services\Common\HelperService;

class QuestionpaperdownloadService
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
        
        // if($externalexamcenter_id != 2731){
        //     $examtimetable = \App\Examtimetable::find(2421);
        //     $this->examtimetable = $examtimetable;
            // $history = \App\Questionpaperdownloadhistory::where('examtimetable_id',$examtimetable->id)
            // ->where('externalexamcenter_id',$externalexamcenter_id)
            // ->where('language_id',$r->language_id)
            // ->first();
            // if(!is_null($history) ){
            //     Session::flash('error','Already downloaded');
            //     return false;
            // }
        //     $this->log($usertype_id,$r);
        //     return '/files/questionpapers/demo.pdf';
        // }else{
            if(!is_null($examtimetable->omr_examtimetable_id)){
                $examtimetable = \App\Examtimetable::find($examtimetable->omr_examtimetable_id);
                $this->examtimetable = $examtimetable;
            }
            if($usertype_id == 6 
                 && ($examtimetable->examschedule_id == 89 )
            )
            {
                
          
                //Change this to specific schedule
             //   $schedule_id = \App\Examschedule::find($examtimetable->examschedule_id)->id;
                $history = \App\Questionpaperdownloadhistory::where('examtimetable_id',$r->examtimetable_id)
                            ->where('externalexamcenter_id',$externalexamcenter_id)
                            ->where('language_id',$r->language_id)
                            ->first();
                // if(Auth::user()->id != 230448 && Auth::user()->id  != 230337){    
                    // if(!is_null($history) ){
                    //     Session::flash('error','Already downloaded');
                    //     return false;
                    // }
                // }
                $examtimetable_id = $r->examtimetable_id;
                // if($r->examtimetable_id == 2688){
                //     $examtimetable_id = 2460;
                // }
         
             
                $exampapers  = \App\Allexampaper::where('examtimetable_id',$examtimetable_id)
                                ->where('externalexamcenter_id',$externalexamcenter_id)
                                ->get();
                $session_id = Session::getId();
                $password = null;
               // return $exampapers->count();
                foreach($exampapers as $exampaer){
                    $exampaer->downloaded_session = $session_id;
                    $exampaer->save();
                    $password = $exampaer->password;
                }
                //return $password;
                $ttcount = $this->examtimetable->languages()->count();
                $omr_code = $this->examtimetable->subject->omr_code;
                // if($omr_code == 36117){
                //     $omr_code = 36115; 
                // }
                $set = $this->examtimetable->examschedule->qpset;
                if($set == 0){
                   //$set = 1;
                   return "processing";
                }
                if($omr_code == 22212){
                    $r->language_id = 1;
                }
                   // $force = $this->extract($omr_code,$r,$set);
                    $examschedule_id = $this->examtimetable->examschedule_id;
                    $returnfile = '/questionpapers/27/dist/'. $examschedule_id .'/wm_e_'.$this->externalexamcenter_id.'_'.$set.'_'.$r->language_id.'_'.$omr_code.'.pdf';

                    $this->regenerate($returnfile,$omr_code,$r,$set,$externalexamcenter_id,$usertype_id,$password,0);
                    if(($omr_code == 26116 && $r->language_id == 1)){
                        return "processing";
                    }
                    return $returnfile;
                    
             
            }
        // }
        return false;
    }

    private function extract($omr_code,$r,$set){
        $decrypt = app_path().'/processpdf/decrypt.sh';
        $omr  = \App\Omrcode::where('omr_code',$omr_code)->first();
        if($omr->regenerate == 1){
            foreach ($omr->languages as $paper){
                if($paper->pivot->language_id == $r->language_id){
                    $field = 'question_paper_'.$set;
                    $file = $paper->pivot->$field;
                    $op = shell_exec('sh '. $decrypt . ' ' . app_path(). ' ' . storage_path(). ' '. $file. ' '. $r->language_id . ' ' . $omr->password. ' ' . $omr_code . ' ' . $set . ' '. $this->examtimetable->examschedule_id);
                }
            }
        }
        return $omr->regenerate;
    }
    private function regenerate($returnfile,$omr_code,$r,$set,$externalexamcenter_id,$usertype_id,$password, $force  = 0){
        if(!file_exists(storage_path().$returnfile) || $force == 1){
            $generate = app_path().'/processpdf/generate.sh';
            $omr  = \App\Omrcode::where('omr_code',$omr_code)->first();
            foreach ($omr->languages as $paper){
                if($paper->pivot->language_id == $r->language_id){
                    $field = 'question_paper_'.$set;
                    $file = $paper->pivot->$field;
                    if($omr_code == 36115){
                        $schedule_id = 82;
                    }else{
                        $schedule_id = $this->examtimetable->examschedule_id;
                    }    

                    $op = shell_exec('sh '. $generate . ' ' . app_path(). ' ' . storage_path(). ' '. $file. ' '. $set . ' ' . $externalexamcenter_id. ' ' . $r->language_id . ' ' . $this->examtimetable->subject->omr_code . ' ' . $schedule_id .  ' '. $password );                                
                    //return 'yes';
                }
            }
            
        }
        
        $this->log($usertype_id,$r);
        
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

