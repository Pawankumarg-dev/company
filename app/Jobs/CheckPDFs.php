<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Newresult;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use File;

class CheckPDFs extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

	public $filename;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            $results = Newresult::all();
            //$results = Newresult::where('candidate_id',127349)->get();
            foreach($results as $r){
                $term = 1;
                $sa = \App\Newapplicant::where('candidate_id',$r->candidate_id)->first();
                $rid = $sa->randstrig;
                $aid = $sa->id;
                $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);

                if($r->first_year_marksheet == 1){
                    $r->check_first_year_marksheet_pdf  = 0;
                    $file = $this->marksheetexists(1,$rid,$applicantid);
                    if($file){
                        $r->check_first_year_marksheet_pdf  = 1;
                    }
                }else{
                    $r->check_first_year_marksheet_pdf = 2;
                }
                if($r->second_year_marksheet == 1){
                    $r->check_second_year_marksheet_pdf =0 ;
                    $file = $this->marksheetexists(2,$rid,$applicantid);
                    if($file){
                        $r->check_second_year_marksheet_pdf  = 1;
                    }
                }else{
                    $r->check_second_year_marksheet_pdf = 2;
                }

                if($r->final_year_result == 1){
                    $r->check_certificate_pdf = 0;
                    $file = $this->certificateexists($rid,$applicantid);
                    if($file){
                        $r->check_certificate_pdf = 1;
                    }
                }else{
                    $r->check_certificate_pdf = 2;
                }
                echo $r;

                $r->save();
            }

           /*$results = Newresult::where('status_id',3)->get();
            foreach($results as $r){
                $count = \App\Newapplication::where('candidate_id',$r->candidate_id)->count();
                echo $count;
                $r->check_first_year_marksheet_pdf = $count;
                $r->save();
            } */
    }

    public function marksheetexists($term,$rid,$applicantid){
        $file = '/var/www/html/rcinber/public/files/marksheet/25/'.$term.'_'.$rid.'_'.$applicantid.'.pdf';
        return $this->fileexists($file);
    }

    public function certificateexists($rid,$applicantid){
        $file = '/var/www/html/rcinber/public/files/certificate/25/'.$rid.'_'.$applicantid.'.pdf';
        return $this->fileexists($file);
    }

    public function fileexists($file){
        echo $file;
        if(file_exists($file)){
            return true;
        }
        return false;
    }
}
