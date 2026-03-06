<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Candidate;
use App\Currentapplication;
use App\Reevaluationapplication;
use App\Reevaluationapplicationsubject;
use App\Subject;
use App\Application;
use App\Slno;

use App\Currentapplicant;

use PDF;

use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

use Auth;

class ReleaseMarksheetRevaluation extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        ini_set('memory_limit', '4048M');

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $count = 0;
        $currentapplicants = Currentapplicant::where('gracemark_processed',1)
                            ->where('reeevaluationapplication_id','>',0)
                            ->where('gracemark_marksheet_processing',2)
                            ->where('candidate_id',49864)
                            ->get();
        //$currentapplicants  = Currentapplicant::whereIn('candidate_id',[111514])->get();
        echo 'BEGIN:: '. PHP_EOL;
        foreach($currentapplicants as $currentapplicant){
            $reevaluationapplication = \App\Reevaluationapplication::where('candidate_id',$currentapplicant->candidate_id)
                                                                    ->where('exam_id',22)
                                                                    ->where('orderstatus_id',1)
                                                                 //   ->where('status_id',10)
                                                                    ->first();


            if(!is_null($reevaluationapplication)){
                echo 'Processing)'. PHP_EOL;
                $reevalretotal = \App\Reevaluationapplicationsubject::where('reevaluationapplication_id',$reevaluationapplication->id)->sum('reevaluation_applystatus') +
                \App\Reevaluationapplicationsubject::where('reevaluationapplication_id',$reevaluationapplication->id)->sum('retotalling_applystatus') ;
                echo 'Total' . $reevalretotal . PHP_EOL;
                if($reevalretotal>0){
                    $cid = $currentapplicant->candidate_id;
                    $count = $count + 1;
                    if($currentapplicant->withheld != 1){
                        echo $count . ' ) Processing: '.$cid . ',' . $currentapplicant->candidate->approvedprogramme->academicyear->year .' '.  $currentapplicant->candidate->approvedprogramme->programme->course_name . ' ' . PHP_EOL;
                        $currentapplications = Currentapplication::where('candidate_id',$cid)->get();
                        $publish = 1;
                        $passed_subjects_term_one = 0;
                        $passed_subjects_term_two = 0;
                        $first_year_total = 0;
                        $second_year_total = 0;
                        $first_year_total = Currentapplication::where('candidate_id',$cid)->whereHas('subject',function($q){
                            $q->where('syear',1);
                        })->sum('internal_mark') 
                        + 
                        Currentapplication::where('candidate_id',$cid)->whereHas('subject',function($q){
                            $q->where('syear',1);
                        })->sum('reevaluation_mark') 
                        +
                        Currentapplication::where('candidate_id',$cid)->whereHas('subject',function($q){
                            $q->where('syear',1);
                        })->sum('grace') 
                        ;

                        $second_year_total = Currentapplication::where('candidate_id',$cid)->whereHas('subject',function($q){
                            $q->where('syear',2);
                        })->sum('internal_mark') 
                        + 
                        Currentapplication::where('candidate_id',$cid)->whereHas('subject',function($q){
                            $q->where('syear',2);
                        })->sum('reevaluation_mark') 
                        +   
                        Currentapplication::where('candidate_id',$cid)->whereHas('subject',function($q){
                            $q->where('syear',2);
                        })->sum('grace');
                    

                        //if($currentapplicant->attendance == 1){
                            foreach($currentapplications as $ca){
                                $external_mark = $ca->reevaluation_mark + $ca->grace;
                                if(
                                    ($ca->internalattendance_id == 1 || $ca->subject->is_internal == 0) 
                                    && 
                                    ($ca->internal_mark >= $ca->subject->imin_marks ||  $ca->subject->is_internal == 0 )
                                    &&
                                    ($ca->externalattendance_id == 1 || $ca->subject->is_external == 0) 
                                    &&
                                    ($external_mark >= $ca->subject->emin_marks ||  $ca->subject->is_external == 0 )
                                    && 
                                    (!is_null($ca->external_mark) ||  $ca->subject->is_external == 0)
                                    &&
                                    (!is_null($ca->internal_mark) ||  $ca->subject->is_internal == 0)
                                ){
                                    echo 'Inside loop '. PHP_EOL;
                                    $ca->reevaluation_result_id = 1;
                                    if($ca->subject->syear==1){
                                        $passed_subjects_term_one ++; 
                                    }
                                    if($ca->subject->syear==2){
                                        $passed_subjects_term_two ++; 
                                    }
                                }else{
                                    $ca->reevaluation_result_id = 0;
                                }
                                if($ca->internalattendance_id == 0 && $ca->subject->is_internal == 1){
                                    $publish = 0;
                                }
                                if($ca->externalattendance_id == 0 && $ca->subject->is_external == 1){
                                    $publish = 0;
                                }
                                $ca->save();
                            }
                        //}
                        if(!$publish == 0){
                            //$nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
                            $candidate = \App\Candidate::find($currentapplicant->candidate_id);
                            $nber_id = $candidate->approvedprogramme->programme->nber_id;
                            if($currentapplicant->approvedprogramme->academicyear_id == 10 && $currentapplicant->approvedprogramme->programme->numberofterms == 1){
                                if($passed_subjects_term_one == $currentapplicant->papers_required_to_pass_this_year){
                                    $currentapplicant->reevaluation_term_one_result_id = 1;
                                    $currentapplicant->reevaluation_final_result = 1;
                                    $candidate->coursecompleted_status = 1;
                                    $currentapplicant->reevaluation_result_percentage = round(($first_year_total / $currentapplicant->approvedprogramme->programme->first_year_max) * 100,2);
                                    if($currentapplicant->reevaluation_slno_certificate < 1){
                                        $slno = \App\Slno::where('nber_id', $nber_id)->where('key_val','slno_certificate')->first();
                                        $slno_certificate = $slno->slno;
                                        $slno_certificate ++;
                                        $slno->slno = $slno_certificate;
                                        $slno->save();
                                        $currentapplicant->reevaluation_slno_certificate = $slno_certificate;
                                    }
                                    $currentapplicant->reevaluation_certificate_date = date("Y-m-d");
                                    $currentapplicant->save();
                                    //$job = (new \App\Jobs\GenerateCertificate($currentapplicant->candidate_id))->onQueue('missingcertificate');
                                    $this->generateCertificate($currentapplicant->candidate_id);
                                    echo 'Certificate Generated'. PHP_EOL;
                                    //$this->dispatch($job);
                                }else{
                                    $currentapplicant->reevaluation_term_one_result_id = 0;
                                    $currentapplicant->reevaluation_final_result = 0;
                                    $candidate->coursecompleted_status = 0;
                                }
                                if($currentapplicant->reevaluation_sl_no_marksheet_term_one < 1){
                                    $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_one')->first();
                                    $sl_no_marksheet_term_one = $slno->slno;
                                    $sl_no_marksheet_term_one ++;
                                    $currentapplicant->reevaluation_sl_no_marksheet_term_one = $sl_no_marksheet_term_one;
                                    $slno->slno = $sl_no_marksheet_term_one;
                                    $slno->save();
                                }
                                $currentapplicant->reevaluation_first_year_total = $first_year_total;
                                $currentapplicant->reevaluation_marksheetissuded_date = date("Y-m-d");
                                $currentapplicant->save();
                                $candidate->save();
                                //$job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,1))->onQueue('missingms');
                                $this->generateMarksheet($currentapplicant->candidate_id,1);
                                //$this->dispatch($job);
                                echo 'Generate 1st year Marksheet'.PHP_EOL;
                            }

                            if($currentapplicant->approvedprogramme->academicyear_id == 10 && $currentapplicant->approvedprogramme->programme->numberofterms == 2){
                                if($passed_subjects_term_one == $currentapplicant->papers_required_to_pass_this_year){
                                    $currentapplicant->reevaluation_term_one_result_id = 1;
                                    $currentapplicant->reevaluation_result_percentage = round(($first_year_total / $currentapplicant->approvedprogramme->programme->first_year_max) * 100,2);
                                }else{
                                    $currentapplicant->reevaluation_term_one_result_id = 0;
                                }
                                $currentapplicant->reevaluation_final_result = 0;
                                
                                $currentapplicant->reevaluation_first_year_total = $first_year_total;
                                if($currentapplicant->reevaluation_sl_no_marksheet_term_one < 1){
                                    $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_one')->first();
                                    $sl_no_marksheet_term_one = $slno->slno;
                                    $sl_no_marksheet_term_one ++;
                                    $currentapplicant->reevaluation_sl_no_marksheet_term_one = $sl_no_marksheet_term_one;
                                    $slno->slno = $sl_no_marksheet_term_one;
                                    $slno->save();
                                }
                                $currentapplicant->reevaluation_marksheetissuded_date = date("Y-m-d");
                                $currentapplicant->save();
                                //$job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,1))->onQueue('missingms');
                                $this->generateMarksheet($currentapplicant->candidate_id,1);
                                //$this->dispatch($job);
                                echo 'Generate 1st year Marksheet'.PHP_EOL;
                            }
                            if($currentapplicant->approvedprogramme->academicyear_id == 9 && $currentapplicant->approvedprogramme->programme->numberofterms == 2){
                                echo ' In the loop '. $passed_subjects_term_two .''. PHP_EOL;
                                
                                $papers_passed_last_year = Application::where('candidate_id',$cid)->where('result_id',1)->count();
                                $papers_passed_last_year_marks = Application::where('candidate_id',$cid)->where('result_id',1)->get();
                                $previous_exam_total =  $papers_passed_last_year_marks->sum('external_mark') + $papers_passed_last_year_marks->sum('internal_mark') + $papers_passed_last_year_marks->sum('grace');
                                /*foreach($papers_passed_last_year_marks as $pm){
                                    if($ca->subject->is_external == 1){
                                        $previous_exam_total = $previous_exam_total + $pm->external_mark;
                                    }
                                    if($ca->subject->is_internal == 1){
                                        $previous_exam_total = $previous_exam_total + $pm->internal_mark;
                                    }
                                }
                                return $previous_exam_total; */
                                if($passed_subjects_term_one + $papers_passed_last_year == $currentapplicant->papers_required_to_pass_previous_year){
                                    $currentapplicant->reevaluation_term_one_result_id = 1;
                                }else{
                                    $currentapplicant->reevaluation_term_one_result_id = 0;
                                    $currentapplicant->reevaluation_final_result = 0;
                                    $candidate->coursecompleted_status = 0;
                                }
                                if($passed_subjects_term_two == $currentapplicant->papers_required_to_pass_this_year){
                                    $currentapplicant->reevaluation_term_two_result_id = 1;
                                }else{
                                    $currentapplicant->reevaluation_term_two_result_id = 0;
                                    $currentapplicant->reevaluation_final_result = 0;
                                    $candidate->coursecompleted_status = 0;
                                }
                                $currentapplicant->save();
                                //return $first_year_total . ',' . $second_year_total . ',' . $previous_exam_total;
                                if($currentapplicant->reevaluation_term_two_result_id == 1 && $currentapplicant->reevaluation_term_one_result_id == 1){
                                    $currentapplicant->reevaluation_final_result = 1;
                                    $candidate->coursecompleted_status = 1;
                                    $currentapplicant->reevaluation_result_percentage = round((($first_year_total + $second_year_total + $previous_exam_total) / ($currentapplicant->approvedprogramme->programme->first_year_max + $currentapplicant->approvedprogramme->programme->second_year_max)) * 100,2);
                                    if($currentapplicant->reevaluation_slno_certificate < 1){
                                        $slno = Slno::where('nber_id', $nber_id)->where('key_val','slno_certificate')->first();
                                        $slno_certificate = $slno->slno;
                                        $slno_certificate ++;
                                        $slno->slno = $slno_certificate;
                                        $slno->save();
                                        $currentapplicant->reevaluation_slno_certificate = $slno_certificate;
                                    }
                                    $currentapplicant->reevaluation_certificate_date = date("Y-m-d");
                                    $currentapplicant->save();
                                    $candidate->save();
                                    //$job = (new \App\Jobs\GenerateCertificate($currentapplicant->candidate_id))->onQueue('missingcertificate');
                                    $this->generateCertificate($currentapplicant->candidate_id);
                                    //$this->dispatch($job);
                                    echo 'Generate Certificate'. PHP_EOL;
                                }
                                if($currentapplicant->reevaluation_sl_no_marksheet_term_one < 1 && $currentapplicant->first_year_pappers > 0){
                                    $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_one')->first();
                                    $sl_no_marksheet_term_one = $slno->slno;
                                    $sl_no_marksheet_term_one ++;
                                    $currentapplicant->reevaluation_sl_no_marksheet_term_one = $sl_no_marksheet_term_one;
                                    $slno->slno = $sl_no_marksheet_term_one;
                                    $slno->save();
                                }
                                if($currentapplicant->reevaluation_sl_no_marksheet_term_two < 1){
                                    $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_two')->first();
                                    $sl_no_marksheet_term_two = $slno->slno;
                                    $sl_no_marksheet_term_two ++;
                                    $currentapplicant->reevaluation_sl_no_marksheet_term_two = $sl_no_marksheet_term_two;
                                    $slno->slno = $sl_no_marksheet_term_two;
                                    $slno->save();
                                }
                                $currentapplicant->reevaluation_first_year_total = $first_year_total;
                                $currentapplicant->reevaluation_second_year_total = $second_year_total;
                                $currentapplicant->reevaluation_marksheetissuded_date = date("Y-m-d");
                                $currentapplicant->save();
                                if($currentapplicant->first_year_pappers > 0){
                                    //$job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,1))->onQueue('missingms');
                                    $this->generateMarksheet($currentapplicant->candidate_id,1);
                                    echo 'Generate 1st year Marksheet'.PHP_EOL;
                                    //$this->dispatch($job);
                                }
                                $this->generateMarksheet($currentapplicant->candidate_id,2);
                                echo 'Generate 2nd year Marksheet'.PHP_EOL;
                                
                            }
                        }
                        $currentapplicant->gracemark_marksheet_processing = 2;
                        $currentapplicant->save();
                    }
                }else{
                    echo 'Only Photocopy'. PHP_EOL;
                }
            }else{
                echo 'No Revaluation Application'. PHP_EOL;
            }
            
        }

    }

    public function  generateCertificate($cid){
        $candidate = Candidate::find($cid);
        $rid = $candidate->currentapplicant->randstrig;
        $applicantid = str_pad($candidate->currentapplicant_id,5,'0',STR_PAD_LEFT);
        $file = '/var/www/html/rcinber/public/files/certificate/22/RE_'.$rid.'_'.$applicantid.'.pdf';
        //if(!file_exists($file)){
            $headers = array(
                'Content-Type: application/pdf',
            );
            $d = new DNS2D();
            $d->setStorPath('/var/www/html/rcinber/storage/framework/cache/');    
            $barcode =  $d->getBarcodeHTML('https://rcinber.org.in/certificate/22/RE/'.$rid.'/'.$applicantid, 'QRCODE',2.5,2.5);
            view()->share('candidate',$candidate);
            view()->share('barcode',$barcode);
            $headers = array(
                'Content-Type: application/pdf',
            );
            $pdf = PDF::loadView('common.recertificate')->setPaper('a4', 'portrait');
            $output = $pdf->output();
            file_put_contents($file, $output);
            unset($pdf);
            unset($output);
            return '1';
    }
    public function  generateMarksheet($cid,$term){

        $candidate = Candidate::find($cid);
        
        $applications = Currentapplication::where('candidate_id',$cid)->where('term',$term)->get();
        if($applications->count() > 0){
            $aid = $candidate->currentapplicant_id;
            $applicantid = str_pad($aid,5,'0',STR_PAD_LEFT);
            $rid = $candidate->currentapplicant->randstrig;
            $file = '/var/www/html/rcinber/public/files/marksheet/22/RE_'.$term.'_'.$rid.'_'.$applicantid.'.pdf';
            //if(!file_exists($file)){
                $headers = array(
                    'Content-Type: application/pdf',
                );
                $d = new DNS2D();
                $d->setStorPath('/var/www/html/rcinber/storage/framework/cache/');    
                $barcode =  $d->getBarcodeHTML('https://rcinber.org.in/marksheet/RE/'.$aid.'/'.$rid.'/'.$term.'/22', 'QRCODE',2.5,2.5);
                view()->share('candidate',$candidate);
                view()->share('barcode',$barcode);
                view()->share('applicantid',$applicantid);
                view()->share('term',$term);
                view()->share('applications',$applications);
                $pdf = PDF::loadView('common.remarksheet')->setPaper('a4', 'landscape');
                $output = $pdf->output();
                file_put_contents($file, $output);
                unset($pdf);
                unset($output); 
              //  echo 'Generated';
           // }
        }else{
            //echo 'Zero';
        }
        return '1';
    }

    public function failed()
    {
        echo 'Failed';

    }

}
