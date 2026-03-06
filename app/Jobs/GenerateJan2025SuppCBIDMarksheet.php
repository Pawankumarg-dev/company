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

class GenerateJan2025SuppCBIDMarksheet extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    //public $cid;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->cid = $cid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$cid = $this->cid;

        //echo $cid;

//        $this->supplimentaryService->generateMarksheet($cid);

     //   echo 'Generated';
        //$result = \App\Allresult::where('candidate_id',$cid)->first();
        //echo $result;
        $results = \App\Allresult::whereIN('status_id',[2,3,4])->get();
        foreach($results as $result){
            if($result->candidate->approvedprogramme->programme_id == 57){
                if(!is_null($result->marksheet_sl_no_first_year)){
                    $this->generatems($result->candidate_id,1);
                    $result->status_id = 4;
                    $result->version = $result->version+1;
                }
                if(!is_null($result->marksheet_sl_no_second_year)){
                    $this->generatems($result->candidate_id,2);
                    $result->status_id = 4;
                    $result->version = $result->version+1;
                }
                if(!is_null($result->slno_certificate)){
                    $this->generatecertificate($result->candidate_id);
                    $result->status_id = 4;
                    $result->version = $result->version+1;
                }
                $result->save();
            }
        }
        shell_exec(app_path().'/mscpermission.sh');

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


    public function generatems($cid,$term){
        echo "Generating ";
        $applications = Allapplication::where('candidate_id',$cid)->where('exam_id',26)->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
        })->get();
        $hastheory = Allapplication::where('candidate_id',$cid)->where('exam_id',26)->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
            $q->where('subjecttype_id',1);
        })->count();
        
        $haspractical = Allapplication::where('candidate_id',$cid)->where('exam_id',26)->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
            $q->where('subjecttype_id',2);
        })->count();

        $candidate = Candidate::find($cid);
        $d = new DNS2D();
        $sa = \App\Allapplicant::where('candidate_id',$cid)->where('exam_id',26)->first();
        $aid = $sa->id;
        $rid = $sa->randstrig;
        if(is_null($rid)){
            $rid= $this->generateRandomString();
            $sa->randstrig = $rid;
            $sa->save();
        }
        echo $cid;
        $d->setStorPath('/var/www/rcinber/storage/framework/cache/');    
        $barcode =  $d->getBarcodeHTML(url("marksheet").$aid.'/'.$rid.'/'.$term.'/26', 'QRCODE',2.5,2.5);
        $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
        $file = '/var/www/html/rcinber/public/files/marksheet/26/'.$term.'_'.$rid.'_'.$applicantid.'.pdf';
        echo $file;
        //return $candidate->supplimentaryresults->first();
        view()->share('applications',$applications);
        view()->share('candidate',$candidate);
        view()->share('term',$term);
        view()->share('barcode',$barcode);
        view()->share('hastheory',$hastheory);
        view()->share('haspractical',$haspractical);
        $pdf = PDF::loadView('common.marksheet_jan_2025_cbid_html')->setPaper('a4','landscape');
        echo 'PDF Generated';
        $output = $pdf->output();
        file_put_contents($file, $output);
        echo "FILE OUTPUT";
        unset($pdf);
        unset($output); 
    }

    
    public function generatecertificate($cid){
        $candidate = Candidate::find($cid);
        $d = new DNS2D();
        $sa = \App\Allapplicant::where('candidate_id',$cid)->where('exam_id',26)->first();
        $aid = $sa->id;
        $rid = $sa->randstrig;

        $d->setStorPath('/var/www/rcinber/storage/framework/cache/'); 
        $applicantid = str_pad($sa->id,5,'0',STR_PAD_LEFT);
        $file = '/var/www/html/rcinber/public/files/certificate/26/'.$rid.'_'.$applicantid.'.pdf';
        $barcode =  $d->getBarcodeHTML(url('certificate/26/').$rid.'/'.$applicantid, 'QRCODE',2.5,2.5);
        view()->share('candidate',$candidate);
        view()->share('barcode',$barcode);
 	    $pdf = PDF::loadView('common.certificate_jan_2025_supp')->setPaper('a4','portrait');
	    $output = $pdf->output();
        file_put_contents($file, $output);
        unset($pdf);
        unset($output);
    }
}
