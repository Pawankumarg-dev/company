<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Candidate;
use App\Currentapplication;
use App\Reevaluationapplication;
use App\Currentapplicant;
use PDF;

use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

class GenerateMarksheet extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $cid;
    public $term;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cid,$term)
    {
        $this->cid = $cid;

        $this->term = $term;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cid = $this->cid;

        $term = $this->term;

        echo $cid;
        echo $term;
        //$currentapplicant = Currentapplicant::find($cid);

        $candidate = Candidate::find($cid);
        // echo 'Ver: '.$candidate->new_changes;
        
//        if($candidate->new_changes > 0){
	  if(!is_null($candidate)){  
          $generate = false;
/*            if($term==1 &&  $candidate->currentapplicant->current_version_term_one < $candidate->new_changes){
                $generate = true;
            }
            if($term==2 &&  $candidate->currentapplicant->current_version_term_two < $candidate->new_changes){
                $generate = true;
            }
  */          $generate = true;
            echo $generate ? 'Yes' : 'No';
            $applications = Currentapplication::where('candidate_id',$candidate->id)->where('term',$term)->get();
            if(1){
                if($applications->count() > 0){
                    
                    $aid = $candidate->currentapplicant_id;
                    $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
                    $rid = $candidate->currentapplicant->randstrig;
                    $file = '/var/www/html/rcinber/public/files/marksheet/22/'.$term.'_'.$rid.'_'.$applicantid.'.pdf';
                    echo $file;
                // if(!file_exists($file)){
                        $headers = array(
                            'Content-Type: application/pdf',
                        );
                        $d = new DNS2D();
                        $d->setStorPath('/var/www/html/rcinber/storage/framework/cache/');    
                         $barcode =  $d->getBarcodeHTML('https://rcinber.org.in/marksheet/'.$aid.'/'.$rid.'/'.$term.'/22', 'QRCODE',2.5,2.5);
                        view()->share('candidate',$candidate);
                        view()->share('barcode',$barcode);
                        view()->share('applicantid',$applicantid);
                        view()->share('term',$term);
                        view()->share('applications',$applications);
                        $pdf = PDF::loadView('common.sep2023marksheet')->setPaper('a4', 'landscape');
                        $output = $pdf->output();
                        file_put_contents($file, $output);
                        unset($pdf);
                        unset($output); 
                        echo 'Marksheet Generated';
                        shell_exec(app_path().'/mscpermission.sh');

                    /*}else{
                        echo 'Already exsits';
                    } */
                }else{
                    echo 'No Applications Found';
                }
           //     $currentapplicant = \App\Currentapplicant::find($candidate->currentapplicant_id);
                if($term==1){
//                    $currentapplicant->current_version_term_one = $candidate->new_changes;
                }
                if($term==2){
  //                  $currentapplicant->current_version_term_two = $candidate->new_changes;
                }
    //            $currentapplicant->save();

            }
        }else{
            echo 'No new changes';
        }
    }
}
