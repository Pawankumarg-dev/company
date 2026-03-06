<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests;

use App\Programme;

use App\Institute;

use Auth;

use App\Approvedprogramme;

use App\Subject;

use App\Application;

use App\Currentapplication;

use App\Markentry;

use App\Exam;

use App\Oldapplicant;

use App\Currentapplicant;

use Session;

use App\Candidate;

use PDF;

use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;



class MarksheetController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function certificate($cid){
        //$candidate = Candidate::find($cid);
        //$applicant =  Currentapplicant::where('candidate_id',$cid)->first();
        $currentapplicant = Currentapplicant::find($cid);
        if(is_null($currentapplicant->slno_certificate)){
            return "Not Generated";
        }
        $rid = $currentapplicant->randstrig;
        $applicantid = str_pad($cid,5,'0',STR_PAD_LEFT);
        $file = '/var/www/html/rcinber/public/files/certificate/22/'.$rid.'_'.$applicantid.'.pdf';
        $filename = $currentapplicant->candidate->enrolmentno.'.pdf';
        $headers = array(
            'Content-Type: application/pdf',
        );
        if(file_exists($file)){
            return response()->download($file, $filename, $headers);
        }else{
          //  $job = (new \App\Jobs\GenerateCertificate($currentapplicant->candidate_id))->onQueue('pc');
            //$this->gencert($currentapplicant->candidate_id)
           // $this->dispatch($job);
            Session::put('messages','Certificate is being generated. Please wait and try again after few minute.');

            return back();
        }
        //return view('common.certificate',compact('candidate','applicant'));
    }

    private function gencert($cid){
        
        $candidate = Candidate::find($cid);
        $rid = $candidate->currentapplicant->randstrig;
        $applicantid = str_pad($candidate->currentapplicant_id,5,'0',STR_PAD_LEFT);
        $file = '/var/www/html/rcinber/public/files/certificate/22/'.$rid.'_'.$applicantid.'.pdf';
        if(!file_exists($file)){
            $headers = array(
                'Content-Type: application/pdf',
            );
            $d = new DNS2D();
            $d->setStorPath('/var/www/html/rcinber/storage/framework/cache/');    
            $barcode =  $d->getBarcodeHTML('https://rcinber.org.in/certificate/22/'.$rid.'/'.$applicantid, 'QRCODE',2.5,2.5);
            view()->share('candidate',$candidate);
            view()->share('barcode',$barcode);
            $headers = array(
                'Content-Type: application/pdf',
            );
            $pdf = PDF::loadView('common.certificate')->setPaper('a4', 'portrait');
            $output = $pdf->output();
            file_put_contents($file, $output);
            unset($pdf);
            unset($output);
        }else{
            Session::put('messages','Not Generated');
            return back();
        }
    }
    public function recertificate($cid){
        //$candidate = Candidate::find($cid);
        //$applicant =  Currentapplicant::where('candidate_id',$cid)->first();
        $currentapplicant = Currentapplicant::find($cid);
        if(is_null($currentapplicant->reevaluation_slno_certificate)){
            return "Not Generated";
        }
        $rid = $currentapplicant->randstrig;
        $applicantid = str_pad($cid,5,'0',STR_PAD_LEFT);
        $file = '/var/www/html/rcinber/public/files/certificate/22/RE_'.$rid.'_'.$applicantid.'.pdf';
        $filename = $currentapplicant->candidate->enrolmentno.'.pdf';
        $headers = array(
            'Content-Type: application/pdf',
        );
        if(file_exists($file)){
            return response()->download($file, $filename, $headers);
        }else{
          //  $job = (new \App\Jobs\GenerateCertificate($currentapplicant))->onQueue('pc');
          //  $this->dispatch($job);
            Session::put('messages','Not Generated');
            return back();
        }
        //return view('common.certificate',compact('candidate','applicant'));
    }
    public function download($cid,$term){
        //return ">>";
        //$candidate = Candidate::where('id',$cid)->first();
        $currentapplicant = Currentapplicant::find($cid);
        if($term == 1 && is_null($currentapplicant->sl_no_marksheet_term_one)){
            Session::put('messages','Not generated');
            return back();
        }
        if($term == 2 && is_null($currentapplicant->sl_no_marksheet_term_two)){
            Session::put('messages','Not generated');
            return back();
        }
        if($term == 1 && is_null($currentapplicant->term_one_result_id)){
            Session::put('messages','Not generated');
            return back();
        } 
        if($term == 2 && is_null($currentapplicant->term_two_result_id)){
            Session::put('messages','Not generated');
            return back();
        } 
        //$applications = Currentapplication::where('candidate_id',$cid)->where('term',$term)->count();
        //if($applications > 0){
            $applicantid = str_pad($cid,5,'0',STR_PAD_LEFT);
            //$ca  =  Currentapplicant::find($aid);
                $rid = $currentapplicant->randstrig;
                $file = '/var/www/html/rcinber/public/files/marksheet/22/'.$term.'_'.$rid.'_'.$applicantid.'.pdf';
                //$filename = $currentapplicant->candidate->enrolmentno.'.pdf';
                $filename  = $term.'_'.$rid.'_'.$applicantid.'.pdf';
                //return $filename;
                $headers = array(
                    'Content-Type: application/pdf',
                );
                if(file_exists($file)){
                    return response()->download($file, $filename, $headers);
                }else{
                   // $job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,$term))->onQueue('pending');
                    //$this->dispatch($job);
                    Session::put('messages','Not Generated');
                    return back();
                  /*  if($term == 1 ){
                        $ca->term_one_generated_date  = \Carbon\Carbon::now();
                        $ca->term_one_generated_by = Auth::user()->id;
                    }
                    if($term == 2 ){
                        $ca->term_two_generated_date  = \Carbon\Carbon::now();
                        $ca->term_two_generated_by = Auth::user()->id;
                    }
                    $ca->save();
*/
                   // return response()->download($file, $filename, $headers);
                }
              
       /*  }else{
            return 'Not applied for the exam';
        } */
    }


    public function reevaluateddownload($cid,$term){
        //$candidate = Candidate::where('id',$cid)->first();
        $currentapplicant = Currentapplicant::find($cid);
        if($term == 1 && is_null($currentapplicant->reevaluation_sl_no_marksheet_term_one)){
            Session::put('messages','Not generated');
            return back();
        }
        if($term == 2 && is_null($currentapplicant->reevaluation_sl_no_marksheet_term_two)){
            Session::put('messages','Not generated');
            return back();
        }
        if($term == 1 && is_null($currentapplicant->reevaluation_term_one_result_id)){
            Session::put('messages','Not generated');
            return back();
        } 
        if($term == 2 && is_null($currentapplicant->reevaluation_term_two_result_id)){
            Session::put('messages','Not generated');
            return back();
        } 
        //$applications = Currentapplication::where('candidate_id',$cid)->where('term',$term)->count();
        //if($applications > 0){
            $applicantid = str_pad($cid,5,'0',STR_PAD_LEFT);
            //$ca  =  Currentapplicant::find($aid);
                $rid = $currentapplicant->randstrig;
                $file = '/var/www/html/rcinber/public/files/marksheet/22/RE_'.$term.'_'.$rid.'_'.$applicantid.'.pdf';
                //$filename = $currentapplicant->candidate->enrolmentno.'.pdf';
                $filename  = $term.'_'.$rid.'_'.$applicantid.'.pdf';
                //return $filename;
                $headers = array(
                    'Content-Type: application/pdf',
                );
                if(file_exists($file)){
                    return response()->download($file, $filename, $headers);
                }else{
                 //   $job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,$term))->onQueue('pending');
                 //   $this->dispatch($job);
                    Session::put('messages','Marksheet is not generated');
                    return back();
                  /*  if($term == 1 ){
                        $ca->term_one_generated_date  = \Carbon\Carbon::now();
                        $ca->term_one_generated_by = Auth::user()->id;
                    }
                    if($term == 2 ){
                        $ca->term_two_generated_date  = \Carbon\Carbon::now();
                        $ca->term_two_generated_by = Auth::user()->id;
                    }
                    $ca->save();
*/
                   // return response()->download($file, $filename, $headers);
                }
              
       /*  }else{
            return 'Not applied for the exam';
        } */
    }

    public function converttoword($number){
        $words = array(
            '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five',
            '6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten',
            '11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fourteen','15' => 'fifteen',
            '16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty',
            '30' => 'thirty','40' => 'forty','50' => 'fifty','60' => 'sixty','70' => 'seventy',
            '80' => 'eighty','90' => 'ninety');
            
            //First find the length of the number
            $number_length = strlen($number);
            //Initialize an empty array
            $number_array = array(0,0,0,0,0,0,0,0,0);        
            $received_number_array = array();
            
            //Store all received numbers into an array
            for($i=0;$i<$number_length;$i++){    
                  $received_number_array[$i] = substr($number,$i,1);    
              }
        
            //Populate the empty array with the numbers received - most critical operation
            for($i=9-$number_length,$j=0;$i<9;$i++,$j++){ 
                $number_array[$i] = $received_number_array[$j]; 
            }
        
            $number_to_words_string = "";
            //Finding out whether it is teen ? and then multiply by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
            for($i=0,$j=1;$i<9;$i++,$j++){
                //"01,23,45,6,78"
                //"00,10,06,7,42"
                //"00,01,90,0,00"
                if($i==0 || $i==2 || $i==4 || $i==7){
                    if($number_array[$j]==0 || $number_array[$i] == "1"){
                        $number_array[$j] = intval($number_array[$i])*10+$number_array[$j];
                        $number_array[$i] = 0;
                    }
                       
                }
            }
        
            $value = "";
            for($i=0;$i<9;$i++){
                if($i==0 || $i==2 || $i==4 || $i==7){    
                    $value = $number_array[$i]*10; 
                }
                else{ 
                    $value = $number_array[$i];    
                }            
                if($value!=0)         {    $number_to_words_string.= $words["$value"]." "; }
                if($i==1 && $value!=0){    $number_to_words_string.= "Crores "; }
                if($i==3 && $value!=0){    $number_to_words_string.= "Lakhs ";    }
                if($i==5 && $value!=0){    $number_to_words_string.= "Thousand "; }
                if($i==6 && $value!=0){    $number_to_words_string.= "Hundred &amp; "; }            
        
            }
            if($number_length>9){ $number_to_words_string = "Sorry This does not support more than 99 Crores"; }
            return ucwords(strtolower($number_to_words_string));
        
    }
 
}