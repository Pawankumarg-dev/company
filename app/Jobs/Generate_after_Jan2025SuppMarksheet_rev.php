<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Candidate;
use App\Allresult;
use App\Allapplication;
use PDF;
use App\Services\Result\SupplementaryMarksheetService;
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

class Generate_after_Jan2025SuppMarksheet_rev extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
public $exam_id;
 public $cid;
    public function __construct($cid,$exam_id)
    {
        $this->cid = $cid;
                $this->exam_id = $exam_id;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cid = $this->cid;
        $exam_id = $this->exam_id;

        echo $cid;
        echo $exam_id;


//        $this->supplimentaryService->generateMarksheet($cid);

     //   echo 'Generated';
        $result = \App\Allresult::where('candidate_id',$cid)->where('exam_id',$exam_id)->first();
        //echo $result;
        // $results = \App\Allresult::get();
        if(!is_null($result)){

        $candidate = Candidate::find($cid);


            if(!is_null($result->marksheet_sl_no_first_year_re) && $candidate->approvedprogramme->programme_id!=57){
                $this->generatems($result->candidate_id,1,$exam_id);
                $result->status_id = 1;
            }
            if(!is_null($result->marksheet_sl_no_second_year_re) && $candidate->approvedprogramme->programme_id!=57){
                $this->generatems($result->candidate_id,2,$exam_id);
                $result->status_id = 1;
            }

             if(!is_null($result->marksheet_sl_no_first_year_re) && $candidate->approvedprogramme->programme_id==57){
                $this->cbid_generatems($result->candidate_id,1,$exam_id);
                $result->status_id = 1;
            }


            if(!is_null($result->slno_certificate_re)){
                $this->generatecertificate($result->candidate_id,$exam_id);
                $result->status_id = 1;
                
            }
            // $result->save();
            shell_exec(app_path().'/mscpermission.sh');
        }
        
    }

    
    public function generateRandomString() {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    public function generatems($cid,$term,$exam_id){
        echo "Generating ";
        $applications = Allapplication::where('candidate_id',$cid)->where('exam_id',$exam_id)->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
        })->get();
        $hastheory = Allapplication::where('candidate_id',$cid)->where('exam_id',$exam_id)->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
            $q->where('subjecttype_id',1);
        })->count();
        
        $haspractical = Allapplication::where('candidate_id',$cid)->where('exam_id',$exam_id)->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
            $q->where('subjecttype_id',2);
        })->count();

        $candidate = Candidate::find($cid);
        $d = new DNS2D();
        $sa = \App\Allapplicant::where('candidate_id',$cid)->where('exam_id',$exam_id)->first();
        $aid = $sa->id;
        $rid = $sa->randstrig;
        if(is_null($rid)){
            $rid= $this->generateRandomString();
            $sa->randstrig = $rid;
            $sa->save();
        }
                $result_data = \App\Allresult::where('candidate_id',$cid)->where('exam_id',$exam_id)->first();

        echo $cid;
        $d->setStorPath('/var/www/rcinber/storage/framework/cache/');    

        $barcode =  $d->getBarcodeHTML(url("marksheet/RE/").$aid.'/'.$rid.'/'.$term.'/'.$exam_id.'', 'QRCODE',2.5,2.5);
        $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
        $file = '/var/www/html/rcinber/public/files/marksheet/'.$exam_id.'/RE_'.$term.'_'.$rid.'_'.$applicantid.'.pdf';

        echo $file;
        view()->share('result_data',$result_data);

        //return $candidate->supplimentaryresults->first();
        view()->share('applications',$applications);
        view()->share('candidate',$candidate);
        view()->share('term',$term);
        view()->share('barcode',$barcode);
        view()->share('hastheory',$hastheory);
        view()->share('haspractical',$haspractical);
        $pdf = PDF::loadView('common.marksheet_jan_2025_rev')->setPaper('a4','landscape');
        echo 'PDF Generated';
        $output = $pdf->output();
        file_put_contents($file, $output);
        echo "FILE OUTPUT";
        unset($pdf);
        unset($output); 
    }


        public function cbid_generatems($cid,$term,$exam_id){
        echo "Generating ";
        $applications = Allapplication::where('candidate_id',$cid)->where('exam_id',$exam_id)->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
        })->get();


        $hastheory = Allapplication::where('candidate_id',$cid)->where('exam_id',$exam_id)->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
            $q->where('subjecttype_id',1);
        })->count();
        
        $haspractical = Allapplication::where('candidate_id',$cid)->where('exam_id',$exam_id)->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
            $q->where('subjecttype_id',2);
        })->count();

        $candidate = Candidate::find($cid);
        $d = new DNS2D();
        $sa = \App\Allapplicant::where('candidate_id',$cid)->where('exam_id',$exam_id)->first();
        $aid = $sa->id;
        $rid = $sa->randstrig;
        if(is_null($rid)){
            $rid= $this->generateRandomString();
            $sa->randstrig = $rid;
            $sa->save();
        }
        $result = \App\Allresult::where('candidate_id',$cid)->where('exam_id',$exam_id)->first();

        echo $cid;
        $d->setStorPath('/var/www/rcinber/storage/framework/cache/');    
        $barcode =  $d->getBarcodeHTML(url("marksheet/RE/").$aid.'/'.$rid.'/'.$term.'/'.$exam_id.'', 'QRCODE',2.5,2.5);
        $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
        $file = '/var/www/html/rcinber/public/files/marksheet/'.$exam_id.'/RE_'.$term.'_'.$rid.'_'.$applicantid.'.pdf';
        echo $file;
        //return $candidate->supplimentaryresults->first();
        view()->share('applications',$applications);
        view()->share('candidate',$candidate);
        view()->share('term',$term);
        view()->share('barcode',$barcode);
        view()->share('hastheory',$hastheory);
        view()->share('haspractical',$haspractical);
                view()->share('result_data',$result);

        $pdf = PDF::loadView('common.marksheet_jan_2025_cbid_html_rev')->setPaper('a4','landscape');
        echo 'PDF Generated';
        $output = $pdf->output();
        file_put_contents($file, $output);
        echo "FILE OUTPUT";
        unset($pdf);
        unset($output); 
    }

    
    public function generatecertificate($cid,$exam_id){
        echo 'certificate';
        $candidate = Candidate::find($cid);
        $d = new DNS2D();
        $sa = \App\Allapplicant::where('candidate_id',$cid)->where('exam_id',$exam_id)->first();
        $aid = $sa->id;
        $rid = $sa->randstrig;
        $d->setStorPath('/var/www/rcinber/storage/framework/cache/'); 
        $applicantid = str_pad($sa->id,5,'0',STR_PAD_LEFT);
        $file = '/var/www/html/rcinber/public/files/certificate/'.$exam_id.'/RE_'.$rid.'_'.$applicantid.'.pdf';
        $barcode =  $d->getBarcodeHTML(url('certificate/'.$exam_id.'/RE').'/'.$rid.'/'.$applicantid, 'QRCODE',2.5,2.5);
        view()->share('candidate',$candidate);
        view()->share('barcode',$barcode);
 	    $pdf = PDF::loadView('common.certificate_jan_2025_supp_re')->setPaper('a4','portrait');
	    $output = $pdf->output();
        file_put_contents($file, $output);
        unset($pdf);
        unset($output);
    }
}
