<?php

namespace App\Http\Controllers\Examcenter\Exam;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Hash;

use App\Services\Exam\ExamService;
use App\Services\Common\HelperService;

use PDF;

class QuestionpaperotpController extends Controller
{
    private $examService;
    private $helperService;
    private $exam_id;
    private $externalexamcenter_id;
    private $examschedule_id;
    public function __construct(ExamService $exam,HelperService $helper)
    {
        $this->middleware(['role:examcenter']);
        $this->examService = $exam;
        $this->helperService = $helper;
        //$this->exam_id =  $this->helperService->getScheduledExamID();
        $this->exam_id = 27;
        $this->externalexamcenter_id= \App\Externalexamcenter::where('user_id',Auth::user()->id)->first()->id;
        $this->examschedule_id = app()->request->has('examschedule_id') ? app()->request->examschedule_id : null;

    }
    public function update($id,Request $r){
        $qpotp = \App\Questionpaperotp::find($id);
        if($qpotp->otp == $r->otp){
            $qpotp->verified =1 ;
            $qpotp->save();
            Session::put('messages','Verified');
        }else{
            Session::put('error','OTP not valid');
        }
        return redirect(url('examcenter/questionpaper').'?examschedule_id='.$qpotp->examschedule_id);
    }
    public function store(Request $r){
        $examcenter = \App\Externalexamcenter::find($this->externalexamcenter_id);
        $mobile = $examcenter->principal_mobile;
        $qpotp = \App\Questionpaperotp::where('externalexamcenter_id',$this->externalexamcenter_id)
        ->where('examschedule_id',$r->examschedule_id)
        ->where('exam_id',$this->exam_id)
        ->first();
        $otp = rand(100000, 999999);
        if(is_null($qpotp)){
            $qpotp = \App\Questionpaperotp::create([
                'externalexamcenter_id' => $this->externalexamcenter_id,
                'exam_id' => $this->exam_id,
                'examschedule_id' => $this->examschedule_id,
                'otp' => $otp
            ]);
        }else{
            $qpotp->otp = $otp;
            $qpotp->save();
        }
        $resp = $this->http_response($mobile,$otp);
        //return $mobile . $resp;
        
        Session::put('messages','OTP sent');
        return redirect(url('examcenter/questionpaper').'?examschedule_id='.$this->examschedule_id);
    }
    public function http_response($mobile, $otp)

    {
    
         
    
    
    
            // we fork the process so we don't have to wait for a timeout
    
    
                // we are the parent
    
                $ch = curl_init();

		$baseURL= "https://smsgw.sms.gov.in/failsafe/HttpLink?username=depwd.sms&pin=De%40Pw%23789&";
		$replyTo ="RCIGOV";
		$messageBody = "Your one time password is ".$otp.". Rehabilitation Council of India";
		$messageBody = urlencode($messageBody);
    		$dlt_entity_id = '1401370180000040261';
    		$dlt_template_id = '1407165908962485291';
		$URI= $baseURL;
		$URI.="signature=".$replyTo;
		$URI .= "&mnumber=".$mobile;
   		$URI .= "&message=".$messageBody;
		$URI .= "&dlt_entity_id=".$dlt_entity_id;
		$URI .= "&dlt_template_id=".$dlt_template_id;
 
                curl_setopt($ch, CURLOPT_URL, $URI);
    
                curl_setopt($ch, CURLOPT_HEADER, 0);
    
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

		$httpCode = curl_exec($ch);
    
    
                curl_close($ch);

                return $httpCode;
    
                
    
    
    
          
        }
}