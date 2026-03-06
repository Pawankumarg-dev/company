<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Candidate;
use App\Supplimentaryresult;
use App\Supplimentaryapplication;
use PDF;
use App\Services\Result\SupplementaryMarksheetService;
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

class GenerateSupplimentaryMarksheet extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $cid;
    public $supplimentaryService;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cid, SupplementaryMarksheetService $supp)
    {
        $this->cid = $cid;
        $this->supplimentaryService = $supp;
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

        echo 'Generated';
        $result = \App\Supplimentaryresult::where('candidate_id',$cid)->first();
        if(!is_null($result->marksheet_sl_no_first_year)){
            $this->generatems($cid,1);
        }

        if(!is_null($result->marksheet_sl_no_second_year)){
            $this->generatems($cid,2);
        }
        if(!is_null($result->slno_certificate)){
            $this->generatecertificate($cid);
        }
        $result->status_id = 1;
        $result->save();
        shell_exec(app_path().'/mscpermission.sh');

    }
    public function generatems($cid,$term){
        echo "Generating ".$term. "Marksheet";
        $applications = Supplimentaryapplication::where('candidate_id',$cid)->whereHas('subject',function($q) use($term){
            $q->where('syear',$term);
        })->get();
        $candidate = Candidate::find($cid);
        $d = new DNS2D();
        $sa = \App\Supplimentaryapplicant::where('candidate_id',$cid)->first();
        $aid = $sa->id;
        $rid = $sa->randstrig;
        $d->setStorPath('/var/www/rcinber/storage/framework/cache/');    
        $barcode =  $d->getBarcodeHTML(url("marksheet").$aid.'/'.$rid.'/'.$term.'/24', 'QRCODE',2.5,2.5);
        $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
        $file = '/var/www/html/rcinber/public/files/marksheet/24/'.$term.'_'.$rid.'_'.$applicantid.'.pdf';
        echo $file;
        //return $candidate->supplimentaryresults->first();
        view()->share('applications',$applications);
        view()->share('candidate',$candidate);
        view()->share('term',$term);
        view()->share('barcode',$barcode);
        $pdf = PDF::loadView('common.marksheet_supp')->setPaper('a4','landscape');
        $output = $pdf->output();
        file_put_contents($file, $output);
        unset($pdf);
        unset($output); 
    }

    
    public function generatecertificate($cid){
        $candidate = Candidate::find($cid);
        echo "Generating Certificate: ";

        $d = new DNS2D();
        $sa = \App\Supplimentaryapplicant::where('candidate_id',$cid)->first();
        $aid = $sa->id;
        $rid = $sa->randstrig;
        $d->setStorPath('/var/www/rcinber/storage/framework/cache/'); 
        $applicantid = str_pad($sa->id,5,'0',STR_PAD_LEFT);
        $file = '/var/www/html/rcinber/public/files/certificate/24/'.$rid.'_'.$applicantid.'.pdf';
        echo $file;
        $barcode =  $d->getBarcodeHTML(url('certificate/24/').$rid.'/'.$applicantid, 'QRCODE',2.5,2.5);
        view()->share('candidate',$candidate);
        view()->share('barcode',$barcode);
 	    $pdf = PDF::loadView('common.certificate_supp')->setPaper('a4','portrait');
	    $output = $pdf->output();
        file_put_contents($file, $output);
        unset($pdf);
        unset($output);
    }
}
