<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Candidate;
use App\Newresult;
use App\Newapplication;
use PDF;
use App\Services\Result\SupplementaryMarksheetService;
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use App\Services\Common\HelperService;
use Illuminate\Support\Facades\Hash;
use  App\Services\DBService;

class checkIfPhotoExists extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    private $helperService;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->helperService = new HelperService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$this->resetPwd();
        echo "Starting";
        $applicants= \App\Allapplicant::where('exam_id',27)->where('blocked',0)->get();
        $count = 1;
        foreach($applicants as $applicant){
            if(!is_null($applicant->candidate)){
                echo $count . PHP_EOL;
                $count++;
                if(!file_exists(public_path().'/files/enrolment/photos/'.$applicant->candidate->photo)){
                    $applicant->blocked = 1;
                }else{
                    $applicant->blocked = 2;
                }
                $applicant->save();
            }else{
                echo "Application ID". $applicant->id;
            }
        }
        echo "Completed";
       }
}
