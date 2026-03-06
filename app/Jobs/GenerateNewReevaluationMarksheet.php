<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Candidate;
use App\Newresultreevaluation;
use App\Newapplication;
use PDF;
use App\Services\Result\SupplementaryMarksheetService;
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

class GenerateNewReevaluationMarksheet extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $cid;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cid)
    {
        $this->cid = $cid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cid = $this->cid;

        echo $cid;

//        $this->supplimentaryService->generateMarksheet($cid);

     //   echo 'Generated';
        $result = \App\Newresultreevaluation::where('candidate_id',$cid)->first();
        echo $result;
        if(!is_null($result) && !is_null($result->marksheet_sl_no_first_year)){
            $this->generatems($cid,1);
            $result->status_id = 1;
        $result->save();
        }

        if(!is_null($result) && !is_null($result->marksheet_sl_no_second_year)){
            $this->generatems($cid,2);
            $result->status_id = 1;
        $result->save();
        }
        if(!is_null($result) &&  !is_null($result->slno_certificate)){
            $this->generatecertificate($cid);
            $result->status_id = 1;
        $result->save();
        }
        

        shell_exec(app_path().'/mscpermission.sh');

    }
    public function generatems($cid,$term){
        echo "Generating";
        $applications = Newapplication::where('candidate_id',$cid)->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
        })->get();
        $hastheory = Newapplication::where('candidate_id',$cid)->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
            $q->where('subjecttype_id',1);
        })->count();
        
        $haspractical = Newapplication::where('candidate_id',$cid)->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
            $q->where('subjecttype_id',2);
        })->count();

        $candidate = Candidate::find($cid);
        $d = new DNS2D();
        $sa = \App\Newapplicant::where('candidate_id',$cid)->first();
        $aid = $sa->id;
        $rid = $sa->randstrig;
        echo $cid;
        $d->setStorPath('/var/www/rcinber/storage/framework/cache/');    
        $barcode =  $d->getBarcodeHTML(url("marksheet/RE/").$aid.'/'.$rid.'/'.$term.'/25', 'QRCODE',2.5,2.5);
        $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
        $file = '/var/www/html/rcinber/public/files/marksheet/25/RE_'.$term.'_'.$rid.'_'.$applicantid.'.pdf';
        echo $file;
        //return $candidate->supplimentaryresults->first();
        view()->share('applications',$applications);
        view()->share('candidate',$candidate);
        view()->share('term',$term);
        view()->share('barcode',$barcode);
        view()->share('hastheory',$hastheory);
        view()->share('haspractical',$haspractical);
        $pdf = PDF::loadView('common.marksheet_new_reevaluation')->setPaper('a4','landscape');
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
        $sa = \App\Newapplicant::where('candidate_id',$cid)->first();
        $aid = $sa->id;
        $rid = $sa->randstrig;

        $d->setStorPath('/var/www/rcinber/storage/framework/cache/'); 
        $applicantid = str_pad($sa->id,5,'0',STR_PAD_LEFT);
        $file = '/var/www/html/rcinber/public/files/certificate/25/RE_'.$rid.'_'.$applicantid.'.pdf';
        $barcode =  $d->getBarcodeHTML(url('certificate/25/RE/').$rid.'/'.$applicantid, 'QRCODE',2.5,2.5);
        view()->share('candidate',$candidate);
        view()->share('barcode',$barcode);
 	    $pdf = PDF::loadView('common.certificate_new_reevaluation')->setPaper('a4','portrait');
	    $output = $pdf->output();
        file_put_contents($file, $output);
        unset($pdf);
        unset($output);
    }
}
