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

class ProcessGracemark extends Job implements ShouldQueue
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
        echo 'BEGIN : '.PHP_EOL;
        $gf = \App\Gracemarksfilter::all();
        foreach($gf as $g){
            if(!($g->reevaluationapplication_id > 0)){
                $eligible_first_year_papers = $g->eligible_first_year_papers;
                $eligible_second_year_papers = $g->eligible_second_year_papers;
                $currentapplicant = \App\Currentapplicant::where('candidate_id',$g->candidate_id)->first();
                echo '.';
                if($currentapplicant->gracemark_processed != 1  && $currentapplicant->modify_mark != 1 && $currentapplicant->class_room_attendnace_missing != 1){
                //    if(($g->programme->nber_id==2 && $g->approvedprogramme->academicyear_id < 10)){
                        if(!is_null($currentapplicant->candidate)){
                            echo $g->id. ' Processing:' . $currentapplicant->candidate->name . '('. $currentapplicant->candidate->enrolmentno . ')'. PHP_EOL;
                        }
                        if($eligible_first_year_papers>0){
                            echo 'First Year: Eligible'. PHP_EOL;
                            $no_of_subjects_grace_marks_already_given_first_year = $g->first_year_gracemark_given_no_of_papers;
                            $grace_marks_given_first_year = $g->first_year_gracemark_given;
                            $ca = \App\Currentapplication::where('candidate_id', $g->candidate_id)->whereHas('subject',function($q){
                                $q->where('syear',1)->where('subjecttype_id',1);
                            })->where('result_id',0)->get();
                            $eligible_no_of_papers_first_year = 4 - $no_of_subjects_grace_marks_already_given_first_year;
                            $eligible_marks_first_year = 10 - $grace_marks_given_first_year;
                            $subject_count = 0;
                            $given_grace = 0;
                            foreach($ca as $failed_subject){
                                if($failed_subject->subject->imin_marks <= $failed_subject->internal_mark) {
                                    $min_mark = $failed_subject->subject->emin_marks;
                                    $grace_required = $min_mark - $failed_subject->external_mark ;
                                    if($grace_required < 4){
                                        if($given_grace < $eligible_marks_first_year){
                                            if($subject_count <= $eligible_no_of_papers_first_year){
                                                if($given_grace + $grace_required <= $eligible_marks_first_year){
                                                    $subject_count ++;
                                                    $given_grace +=  $grace_required;
                                                    $failed_subject->grace = $grace_required;
                                                    $failed_subject->save();
                                                }
                                            }
                                        }
                                        
                                    }
                                }
                            }
                        }
                        if($eligible_second_year_papers>0){
                            echo 'Second Year: Eligible'. PHP_EOL;
                            $no_of_subjects_grace_marks_already_given_second_year = $g->second_year_gracemark_given_no_of_papers;
                            $grace_marks_given_second_year = $g->second_year_gracemark_given;
                            $ca = \App\Currentapplication::where('candidate_id', $g->candidate_id)->whereHas('subject',function($q){
                                $q->where('syear',2)->where('subjecttype_id',1);
                            })->where('result_id',0)->get();
                            $eligible_no_of_papers_second_year = 4 - $no_of_subjects_grace_marks_already_given_second_year;
                            $eligible_marks_second_year = 10 - $grace_marks_given_second_year;
                            $subject_count = 0;
                            $given_grace = 0;
                            foreach($ca as $failed_subject){
                                if($failed_subject->subject->imin_marks <= $failed_subject->internal_mark) {
                                    $min_mark = $failed_subject->subject->emin_marks;
                                    $grace_required = $min_mark - $failed_subject->external_mark ;
                                    if($grace_required < 4){
                                        if($given_grace < $eligible_marks_second_year){
                                            if($subject_count < $eligible_no_of_papers_second_year){
                                                if($given_grace + $grace_required < $eligible_marks_second_year){
                                                    $subject_count ++;
                                                    $given_grace +=  $grace_required;
                                                    $failed_subject->grace = $grace_required;
                                                    $failed_subject->save();
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                   // }
                    $currentapplicant->gracemark_processed = 1;
                    $currentapplicant->save();
                }
            }
        }
        echo 'END : '.PHP_EOL;
    }

       

    public function failed()
    {
        echo 'Failed';

    }


  
}