<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Candidate;
use App\Currentapplication;
use App\Currentapplicant;
use App\Nberstaff;
use App\Applicant;
use App\Application;
use App\Slno;
use PDF;

use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

class GenerateNonCRRMarksheet extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

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
        $currentapplicants = Currentapplicant::where('not_for_crr',1)->get(); 
        echo 'Begin';
        $slno = 0;
        foreach($currentapplicants as $currentapplicant){
            echo 'Start:'. $currentapplicant->id;
            echo $slno;
            $slno = $slno++;
            $currentapplications = Currentapplication::where('candidate_id',$currentapplicant->candidate_id)->get();
            echo 'Count='.$currentapplications->count();
            $publish = 1;
            $passed_subjects_term_one = 0;
            $passed_subjects_term_two = 0;
            $first_year_total = 0;
            $second_year_total = 0;
            if($currentapplicant->attendance == 1){
                foreach($currentapplications as $ca){
                    if(
                        ($ca->internalattendance_id == 1 || $ca->subject->is_internal == 0) 
                        && 
                        ($ca->internal_mark >= $ca->subject->imin_marks ||  $ca->subject->is_internal == 0 )
                        &&
                        ($ca->externalattendance_id == 1 || $ca->subject->is_external == 0) 
                        &&
                        ($ca->external_mark >= $ca->subject->emin_marks ||  $ca->subject->is_external == 0 )
                        && 
                        (!is_null($ca->external_mark) ||  $ca->subject->is_external == 0)
                        &&
                        (!is_null($ca->internal_mark) ||  $ca->subject->is_internal == 0)
                    ){
                        $ca->result_id = 1;
                        if($ca->subject->syear==1){
                            $passed_subjects_term_one ++; 
                        }
                        if($ca->subject->syear==2){
                            $passed_subjects_term_two ++; 
                        }
                    }else{
                        $ca->result_id = 0;
                    }
                    if($ca->internalattendance_id == 0 && $ca->subject->is_internal == 1){
                        $publish = 0;
                    }
                    if($ca->externalattendance_id == 0 && $ca->subject->is_external == 1){
                        $publish = 0;
                    }
                    if($ca->subject->syear==1){
                        if($ca->subject->is_external == 1){
                            $first_year_total += $ca->external_mark;
                        }
                        if($ca->subject->is_internal == 1){
                            $first_year_total += $ca->internal_mark;
                        }
                    }
                    if($ca->subject->syear==2){
                        if($ca->subject->is_external == 1){
                            $second_year_total += $ca->external_mark;
                        }
                        if($ca->subject->is_internal == 1){
                            $second_year_total += $ca->internal_mark;
                        }
                    }
                    $ca->save();
                    
                }
            }else{
                echo 'Attendance problem';
                return false;
            }
            if($publish == 0){
                echo 'Cannot publish';
                return false;
            }
            //$nber_id = Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
            $nber_id = $currentapplicant->candidate->approvedprogramme->programme->nber_id;
            if($currentapplicant->approvedprogramme->academicyear_id == 10 && $currentapplicant->approvedprogramme->programme->numberofterms == 1){
                echo 'Y:10,NOT:1';
                if($passed_subjects_term_one == $currentapplicant->papers_required_to_pass_this_year){
                    $currentapplicant->term_one_result_id = 1;
                    $currentapplicant->final_result = 1;
                    $currentapplicant->result_percentage = round(($first_year_total / $currentapplicant->approvedprogramme->programme->first_year_max) * 100,2);
                    if($currentapplicant->slno_certificate < 1){
                        $slno = Slno::where('nber_id', $nber_id)->where('key_val','slno_certificate')->first();
                        $slno_certificate = $slno->slno;
                        $slno_certificate ++;
                        $slno->slno = $slno_certificate;
                        $slno->save();
                        $currentapplicant->slno_certificate = $slno_certificate;
                    }
                    $currentapplicant->certificate_date = date("Y-m-d");
                    $currentapplicant->save();
                    
                    $job = (new \App\Jobs\GenerateCertificate($currentapplicant->candidate_id))->onQueue('missingcertificate');
                    $this->dispatch($job);
                }else{
                    $currentapplicant->term_one_result_id = 0;
                    $currentapplicant->final_result = 0;
                }
                if($currentapplicant->sl_no_marksheet_term_one < 1){
                    $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_one')->first();
                    $sl_no_marksheet_term_one = $slno->slno;
                    $sl_no_marksheet_term_one ++;
                    $currentapplicant->sl_no_marksheet_term_one = $sl_no_marksheet_term_one;
                    $slno->slno = $sl_no_marksheet_term_one;
                    
                    $slno->save();
                }
                $currentapplicant->first_year_total = $first_year_total;
                $currentapplicant->marksheetissuded_date = date("Y-m-d");
                $currentapplicant->save();
                $job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,1))->onQueue('missingms');
                $this->dispatch($job);
            }
    
            if($currentapplicant->approvedprogramme->academicyear_id == 10 && $currentapplicant->approvedprogramme->programme->numberofterms == 2){
                echo 'Y:10,NOT:2';
                if($passed_subjects_term_one == $currentapplicant->papers_required_to_pass_this_year){
                    $currentapplicant->term_one_result_id = 1;
                    $currentapplicant->result_percentage = round(($first_year_total / $currentapplicant->approvedprogramme->programme->first_year_max) * 100,2);
                }else{
                    $currentapplicant->term_one_result_id = 0;
                }
                $currentapplicant->final_result = 0;
                $currentapplicant->first_year_total = $first_year_total;
                if($currentapplicant->sl_no_marksheet_term_one < 1){
                    $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_one')->first();
                    $sl_no_marksheet_term_one = $slno->slno;
                    $sl_no_marksheet_term_one ++;
                    $currentapplicant->sl_no_marksheet_term_one = $sl_no_marksheet_term_one;
                    $slno->slno = $sl_no_marksheet_term_one;
                    $slno->save();
                }
                $currentapplicant->marksheetissuded_date = date("Y-m-d");
                $currentapplicant->save();
                $job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,1))->onQueue('missingms');
                $this->dispatch($job);
            }
            if($currentapplicant->approvedprogramme->academicyear_id == 9 && $currentapplicant->approvedprogramme->programme->numberofterms == 2){
                echo 'Y:9,NOT:2';
                $papers_passed_last_year = Application::where('candidate_id',$cid)->where('result_id',1)->count();
                $papers_passed_last_year_marks = Application::where('candidate_id',$cid)->where('result_id',1)->get();
                $previous_exam_total =  $papers_passed_last_year_marks->sum('external_mark') + $papers_passed_last_year_marks->sum('internal_mark');
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
                    $currentapplicant->term_one_result_id = 1;
                }else{
                    $currentapplicant->term_one_result_id = 0;
                    $currentapplicant->final_result = 0;
                }
                if($passed_subjects_term_two == $currentapplicant->papers_required_to_pass_this_year){
                    $currentapplicant->term_two_result_id = 1;
                }else{
                    $currentapplicant->term_two_result_id = 0;
                    $currentapplicant->final_result = 0;
                }
                $currentapplicant->save();
                //return $first_year_total . ',' . $second_year_total . ',' . $previous_exam_total;
                if($currentapplicant->term_two_result_id == 1 && $currentapplicant->term_one_result_id == 1){
                    $currentapplicant->final_result = 1;
                    $currentapplicant->result_percentage = round((($first_year_total + $second_year_total + $previous_exam_total) / ($currentapplicant->approvedprogramme->programme->first_year_max + $currentapplicant->approvedprogramme->programme->second_year_max)) * 100,2);
                    if($currentapplicant->slno_certificate < 1){
                        $slno = Slno::where('nber_id', $nber_id)->where('key_val','slno_certificate')->first();
                        $slno_certificate = $slno->slno;
                        $slno_certificate ++;
                        $slno->slno = $slno_certificate;
                        $slno->save();
                        $currentapplicant->slno_certificate = $slno_certificate;
                    }
                    $currentapplicant->certificate_date = date("Y-m-d");
                    $currentapplicant->save();
                    $job = (new \App\Jobs\GenerateCertificate($currentapplicant->candidate_id))->onQueue('missingcertificate');
                    $this->dispatch($job);
                }
                if($currentapplicant->sl_no_marksheet_term_one < 1 && $currentapplicant->first_year_pappers > 0){
                    $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_one')->first();
                    $sl_no_marksheet_term_one = $slno->slno;
                    $sl_no_marksheet_term_one ++;
                    $currentapplicant->sl_no_marksheet_term_one = $sl_no_marksheet_term_one;
                    $slno->slno = $sl_no_marksheet_term_one;
                    $slno->save();
                }
                if($currentapplicant->sl_no_marksheet_term_two < 1){
                    $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_two')->first();
                    $sl_no_marksheet_term_two = $slno->slno;
                    $sl_no_marksheet_term_two ++;
                    $currentapplicant->sl_no_marksheet_term_two = $sl_no_marksheet_term_two;
                    $slno->slno = $sl_no_marksheet_term_two;
                    $slno->save();
                }
                $currentapplicant->first_year_total = $first_year_total;
                $currentapplicant->second_year_total = $second_year_total;
                $currentapplicant->marksheetissuded_date = date("Y-m-d");
                $currentapplicant->save();
                if($currentapplicant->first_year_pappers > 0){
                    
                    $job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,1))->onQueue('missingms');
                    $this->dispatch($job);
                }
    
    
                $job = (new \App\Jobs\GenerateMarksheet($currentapplicant->candidate_id,2))->onQueue('missingms');
                $this->dispatch($job);
                echo $currentapplicant->id;
            }
            echo 'EOP:' . $currentapplicant->id;            
        }
        echo "Completed";
    }
}