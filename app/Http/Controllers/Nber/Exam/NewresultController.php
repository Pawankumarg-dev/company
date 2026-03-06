<?php

namespace App\Http\Controllers\Nber\Exam;

use App\Allresult;
use App\Http\Controllers\Controller;
use App\Services\Result\SupplementaryMarksheetService;
use Illuminate\Http\Request;
use App\Newapplication;
use App\Newapplicant;
use App\Newresult;
use App\Candidate;
use App\Newresultreevaluation;
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

use App\Services\DBService;

use App\Services\Common\HelperService;

use PDF;
use App\Certificategeneratehistory;
use App\Reevaluation;
use Auth;
use Session;

class NewresultController extends Controller
{
    private $helperService;
    private $nber_id;

    public function __construct(HelperService $helper)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $helper;
        $this->nber_id = $this->helperService->getNberID();
    }

    public function generateallreevaluation(){
  
      $sas = Newresultreevaluation::where('status_id',5)->get();
     // $sas = Newresult::where('candidate_id',98689)->get();
      //$sas = Newresult::where('candidate_id',84432)->get();
      foreach($sas as $sa){
            $newapplicant = \App\Newapplicant::find($sa->candidate_id);
           // if(!is_null($newapplicant) &&  $newapplicant->attendance == 1 && $newapplicant->malpractice != 1){
              $job = (new \App\Jobs\GenerateNewReevaluationMarksheet($sa->candidate_id))->onQueue('march2025');
              $this->dispatch($job);
            //}
      }
      //$job = (new \App\Jobs\CheckPDFs())->onQueue('checkpdf');
      //$this->dispatch($job);
      return 'Jobs Created';
  }
    public function generateall(){
        /*$sas = Newresult::whereHas('candidate',function($q){
          $q->whereHas('approvedprogramme',function($r){
            $r->whereHas('programme',function($p){
              $p->course_id = 13;
            });
          });
        })->get(); 
        $term = 2;
        $sa = \App\Newapplicant::where('candidate_id',127349)->first();
        $rid = $sa->randstrig;
        $aid = $sa->id;
        $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
        $file  =         $file = '/var/www/html/rcinber/public/files/marksheet/25/'.$term.'_'.$rid.'_'.$applicantid.'.pdf';
        if(file_exists($file)){
            return 'true';
        }
        return 'false';*/
        $sas = Newresult::where('status_id',5)->get();
       // $sas = Newresult::where('candidate_id',98689)->get();
        //$sas = Newresult::where('candidate_id',84432)->get();
        foreach($sas as $sa){
              $newapplicant = \App\Newapplicant::find($sa->candidate_id);
             // if(!is_null($newapplicant) &&  $newapplicant->attendance == 1 && $newapplicant->malpractice != 1){
                $job = (new \App\Jobs\GenerateNewMarksheet($sa->candidate_id))->onQueue('march2025');
                $this->dispatch($job);
              //}
        }
        //$job = (new \App\Jobs\CheckPDFs())->onQueue('checkpdf');
        //$this->dispatch($job);
        Session::flash('messages','Generated, Please refresh');
        return back();
    }
    

    public function generaterev2024($cid,$terms,$mark){

      Certificategeneratehistory::create([
        'user_id' => Auth::user()->id,
        'exam_id'=>25,
        'candidate_id'=>$cid

      ]);

      if($terms==2 && $mark==1){
        $sp = "generatenewResultTwoYearCourse2024JulyReevaluation_cid($cid)";
        $courses = (new DBService)->callSP($sp);
      }            
      if($terms==1 && $mark==1){
         $sp = "generatenewResultOneYearCourse2024JulyReevaluation($cid)";
        $courses = (new DBService)->callSP($sp);
      }


      $sas = Newresultreevaluation::where('candidate_id',$cid)->get();
     
      foreach($sas as $sa){
            $newapplicant = \App\Newapplicant::find($sa->candidate_id);
              $job = (new \App\Jobs\GenerateNewReevaluationMarksheet($sa->candidate_id))->onQueue('march2025');
              $this->dispatch($job);
      }

      Session::flash('messages','Generated, Please refresh');
      return back();
  }





    public function june2025(){

      $exam_id=27;

        $sas = Allresult::where('exam_id',$exam_id)->where('allresults.status_id',5)->get();
      foreach($sas as $sa){
        $job = (new \App\Jobs\Generate_after_Jan2025SuppMarksheet($sa->candidate_id,$exam_id))->onQueue('june2025first');
        $this->dispatch($job);
      }

      
// $sas = \App\Reevaluationapplication::where('exam_id', $exam_id)
//     ->where('orderstatus_id', 1)
//     ->whereIn('candidate_id', [76039,76806,77119,90853,97410,128421,134712,136522,137030,137056,137305,143723,155227,158683,159141,161010,164132,164134,162418,136072])
//     ->get();
//           foreach($sas as $sa){
//         $job = (new \App\Jobs\Generate_after_Jan2025SuppMarksheet_rev($sa->candidate_id,$exam_id))->onQueue('june2025first');
//         $this->dispatch($job);
//       }


      return 'done';



    }




    public function generatesup2025($cid,$terms,$exam_id,$mark){

      Certificategeneratehistory::create([
        'user_id' => Auth::user()->id,
        'exam_id'=>$exam_id,
        'candidate_id'=>$cid

      ]);


        $sas = Allresult::where('candidate_id',$cid)->where('exam_id',$exam_id)->where('status_id',1)->first();


        $job = (new \App\Jobs\Generate_after_Jan2025SuppMarksheet($sas->candidate_id,$exam_id))->onQueue('march2025');
        $this->dispatch($job);
      

      if($terms==2 && $mark==1){
        $sp = "generatenewResultTwoYearCourse2025june_candidate($exam_id,$cid)";
        $courses = (new DBService)->callSP($sp);
      }
            
      if($terms==1 && $mark==1){
         $sp = "generatenewResultOneYearCourse2025june_candidate($exam_id,$cid)";
        $courses = (new DBService)->callSP($sp);
      }
        $job = (new \App\Jobs\Generate_after_Jan2025SuppMarksheet($cid,$exam_id))->onQueue('march2025');

      // $job = (new \App\Jobs\GenerateJan2025SuppMarksheet($cid))->onQueue('march2025');
      // $this->dispatch($job);

      Session::flash('messages','Generated, Please refresh');
      return back();
  }

    public function generatemain2024($cid,$terms,$mark){

      Certificategeneratehistory::create([
        'user_id' => Auth::user()->id,
        'exam_id'=>25,
        'candidate_id'=>$cid

      ]);
      
      if($terms==2 && $mark==1){
        $sp = "generatenewResultTwoYearCourse2024JulyCID($cid)";
      
        $courses = (new DBService)->callSP($sp);
      }
            
      if($terms==1 && $mark==1){
         $sp = "generatenewResultOneYearCourse2024JulyInsert($cid)";
        $courses = (new DBService)->callSP($sp);
      }
      $sas = Newresult::where('candidate_id',$cid)->get();

      foreach($sas as $sa){
            $newapplicant = \App\Newapplicant::find($sa->candidate_id);
              $job = (new \App\Jobs\GenerateNewMarksheet($sa->candidate_id))->onQueue('march2025');
              $this->dispatch($job);
      }
      Session::flash('messages','Generated, Please refresh');
      return back();
  }



    public function generateallreval(){

      $sas = Newresultreevaluation::where('status_id',5)->get();
      foreach($sas as $sa){
            $newapplicant = \App\Newresultreevaluation::find($sa->candidate_id);
              $job = (new \App\Jobs\GenerateRevalutionMarksheet($sa->candidate_id))->onQueue('march2025');
              $this->dispatch($job);
      } 
      Session::flash('messages','Generated, Please refresh');
      return back();
  }

  


    public function show($cid){
       $job = (new \App\Jobs\GenerateNewMarksheet($cid))->onQueue('newms'); 
        $this->dispatch($job);
        return back();
    }


    public function downloadmsjan2025($exam_id,$cid,$term){
 
       $sa = \App\Allapplicant::where('candidate_id',$cid)->where('exam_id',$exam_id)->first();
       $aid = $sa->id;
       $rid = $sa->randstrig;
       $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
      return redirect(url('/files/marksheet')."/".$exam_id."/".$term.'_'.$rid.'_'.$applicantid.'.pdf?v='.$sa->candidate->allresults()->first()->version);
   }

     public function downloadmsjan2025_re($exam_id,$cid,$term){
 
       $sa = \App\Allapplicant::where('candidate_id',$cid)->where('exam_id',$exam_id)->first();
       $aid = $sa->id;
       $rid = $sa->randstrig;
       $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
      return redirect(url('/files/marksheet')."/".$exam_id."/RE_".$term.'_'.$rid.'_'.$applicantid.'.pdf?v='.$sa->candidate->allresults()->first()->version);
   }

    public function downloadms($cid,$term){
       /* 
        $applications = Newapplication::where('candidate_id',$cid)->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
        })->get();
        $candidate = Candidate::find($cid);
        $d = new DNS2D(); */
        $sa = \App\Newapplicant::where('candidate_id',$cid)->first();
        $aid = $sa->id;
        $rid = $sa->randstrig;
        //$d->setStorPath('/var/www/rcinber/storage/framework/cache/');    
        //$barcode =  $d->getBarcodeHTML(url("marksheet").$aid.'/'.$rid.'/'.$term.'/24', 'QRCODE',2.5,2.5);
        $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
        /*$file = '/var/www/html/rcinber/public/files/marksheet/24/'.$term.'_'.$rid.'_'.$applicantid.'.pdf';
        //return $candidate->supplimentaryresults->first();
        view()->share('applications',$applications);
        view()->share('candidate',$candidate);
        view()->share('term',$term);
        view()->share('barcode',$barcode);
        $pdf = PDF::loadView('common.marksheet_supp')->setPaper('a4','landscape');
        $output = $pdf->output();
        file_put_contents($file, $output);
        unset($pdf);
        unset($output); */
	return redirect(url('/files/marksheet/25')."/".$term.'_'.$rid.'_'.$applicantid.'.pdf?v='.$sa->candidate->newresults()->first()->version);
        //return view('common.marksheet_supp',compact('applications','candidate','term','barcode'));
    }

    public function downloadmsrev($cid,$term){
       $sa = \App\Newapplicant::where('candidate_id',$cid)->first();
       $aid = $sa->id;
       $rid = $sa->randstrig;
       $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
        return redirect(url('/files/marksheet/25')."/RE_".$term.'_'.$rid.'_'.$applicantid.'.pdf?v='.$sa->candidate->newresultreevaluations()->first()->version);
   }

    public function downloadcert($cid){
      /*  $candidate = Candidate::find($cid);
        $d = new DNS2D();*/
        $sa = \App\Newapplicant::where('candidate_id',$cid)->first();
      //  $aid = $sa->id;
        $rid = $sa->randstrig;
      //  $d->setStorPath('/var/www/rcinber/storage/framework/cache/'); 
        $applicantid = str_pad($sa->id,5,'0',STR_PAD_LEFT);
        /*$file = '/var/www/html/rcinber/public/files/certificate/24/'.$rid.'_'.$applicantid.'.pdf';
   
        $barcode =  $d->getBarcodeHTML(url('certificate/24/').$rid.'/'.$applicantid, 'QRCODE',2.5,2.5);
        //return $candidate->supplimentaryresults->first();
        view()->share('candidate',$candidate);
        view()->share('barcode',$barcode);
 	$pdf = PDF::loadView('common.certificate_supp')->setPaper('a4','portrait');
	$output = $pdf->output();
        file_put_contents($file, $output);
        unset($pdf);
        unset($output); */
	return redirect(url('/files/certificate/25').'/'.$rid.'_'.$applicantid.'.pdf?v='.$sa->candidate->newresults()->first()->version);
	
     //   return view('common.certificate_supp',compact('applications','candidate','term','barcode'));
    }



    public function downloadcertjan2025($exam_id,$cid){
        $sa = \App\Allapplicant::where('candidate_id',$cid)->where('exam_id',$exam_id)->first();
        $rid = $sa->randstrig;
        $applicantid = str_pad($sa->id,5,'0',STR_PAD_LEFT);
  	    return redirect(url('/files/certificate').'/'.$exam_id.'/'.$rid.'_'.$applicantid.'.pdf?v='.$sa->candidate->allresults()->first()->version);
	
    }
    public function downloadcertjan2025_re($exam_id,$cid){
        $sa = \App\Allapplicant::where('candidate_id',$cid)->where('exam_id',$exam_id)->first();
        $rid = $sa->randstrig;
        $applicantid = str_pad($sa->id,5,'0',STR_PAD_LEFT);
  	    return redirect(url('/files/certificate').'/'.$exam_id.'/RE_'.$rid.'_'.$applicantid.'.pdf?v='.$sa->candidate->allresults()->first()->version);
    }

    public function downloadcertrev($cid){
        $sa = \App\Newapplicant::where('candidate_id',$cid)->first();
        $rid = $sa->randstrig;
        $applicantid = str_pad($sa->id,5,'0',STR_PAD_LEFT);
        return redirect(url('/files/certificate/25').'/RE_'.$rid.'_'.$applicantid.'.pdf?v='.$sa->candidate->newresultreevaluations()->first()->version);
    }
}
