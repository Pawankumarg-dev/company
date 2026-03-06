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
use Illuminate\Support\Facades\DB;

class ProcessGracemarkforReevaluation extends Job implements ShouldQueue
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
        $gf = \App\Gracemarksfilter::where('reevaluationapplication_id', '>', 0)->whereHas('currentapplicant',function($q){
            $q->where('attendance',0);
        })->get();
        $count = 1; 

        foreach($gf as $g){
            if(($g->reevaluationapplication_id > 0)){
                $data = DB::table("gracemarksfilters as gf")
                        ->join('currentapplications as c','c.candidate_id','=','gf.candidate_id')
                        ->join('subjects as s','s.id','=','c.subject_id')
                        ->join('reevaluationapplicationsubjects as rs', function($join){
                            $join->on('rs.candidate_id','=','gf.candidate_id');
                            $join->on('rs.subject_id','=','c.subject_id');
                        })
                        ->where('gf.id','=',$g->id)
                        ->selectRaw("
                        sum(if(
                            c.result_id = 0 and 
                            s.syear = 1 and 
                            s.subjecttype_id = 1 and 
                            s.is_external  and 
                            s.emin_marks > (if(rs.reevaluated_marks >  c.external_mark, rs.reevaluated_marks, c.external_mark))  and 
                            s.emin_marks < (if(rs.reevaluated_marks >  c.external_mark, rs.reevaluated_marks, c.external_mark) + 4) and  
                            s.imin_marks <= c.internal_mark 
                        , 1 , 0)) as	first_year_eligible_subjects,
                        sum(if(
                            c.result_id = 0 and 
                            s.syear = 2 and 
                            s.subjecttype_id = 1 and 
                            s.is_external  and 
                            s.emin_marks > (if(rs.reevaluated_marks >  c.external_mark, rs.reevaluated_marks, c.external_mark))  and 
                            s.emin_marks < (if(rs.reevaluated_marks >  c.external_mark, rs.reevaluated_marks, c.external_mark)  + 4 ) and  
                            s.imin_marks <= c.internal_mark 
                        , 1, 0))  as	second_year_eligible_subjects
                        ")->first();
                echo $data->second_year_eligible_subjects;
                $eligible_first_year_papers = $data->first_year_eligible_subjects;
                $eligible_second_year_papers = $data->second_year_eligible_subjects;
                $currentapplicant = \App\Currentapplicant::where('candidate_id',$g->candidate_id)->first();
                echo $eligible_first_year_papers;
                echo $eligible_second_year_papers;
                $can_process = 1;
                //if($currentapplicant->modify_mark != 1 && $currentapplicant->class_room_attendnace_missing != 1){
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
                                    $external_mark = $failed_subject->external_mark;
                                    $rs = Reevaluationapplicationsubject::where('candidate_id',$failed_subject->candidate_id)->where('subject_id',$failed_subject->subject_id)->first();
                                    if(!is_null($rs)){
                                        if($rs->active_status == 1){
                                            $can_process = 0;
                                        }else{
                                            if($rs->no_change != 1){
                                                if($rs->reevaluated_marks > $external_mark){
                                                    $external_mark = $rs->reevaluated_marks;
                                                }
                                            }
                                        }
                                    }
                                    $grace_required = $min_mark - $external_mark  ;
                                    if($can_process == 1 && $grace_required < 4){
                                        if($given_grace < $eligible_marks_first_year){
                                            if($subject_count < $eligible_no_of_papers_first_year){
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
                                    $external_mark = $failed_subject->external_mark;
                                    $rs = Reevaluationapplicationsubject::where('candidate_id',$failed_subject->candidate_id)->where('subject_id',$failed_subject->subject_id)->first();
                                    if(!is_null($rs)){
                                        if($rs->active_status == 1){
                                            $can_process = 0;
                                        }else{
                                            if($rs->no_change != 1){
                                                if($rs->reevaluated_marks > $external_mark){
                                                    $external_mark = $rs->reevaluated_marks;
                                                }
                                            }
                                        }
                                    }
                                    $grace_required = $min_mark - $external_mark  ;
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
                    if($can_process){
                        $currentapplicant->gracemark_processed = 1;
                    }
                    $currentapplicant->save();
                //}else{
                  //  echo '.'.PHP_EOL;
                //}
                
            }
        }
        echo 'END : '.PHP_EOL;
    }

       

    public function failed()
    {
        echo 'Failed';

    }


  
}