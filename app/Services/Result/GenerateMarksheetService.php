<?php

namespace App\Services\Result;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Currentapplication;

use Session;
use Auth;
use DB;
use App\Slno;


class GenerateMarksheetService
{
    private $candidate;
    private $noofterms;
    private $academicyear_id;
    private $exam;
    private $exam_accademicyear_id;
    private $cid;
    private $exam_id;
    private $term;
    private $applicationmodel;
    private $reevaluation;
    private $applicantmodel;
    private $applications;
    private $noofsubjects;
    private $programme;
    private $approvedprogramme;
    private $resultPercentage;

    public function __construct()
    {
    }

    public function generateMarksheet($cid,$exam_id,$term,$reevaluation = false){
        $this->cid  = $cid;
        $this->exam_id = $exam_id;
        $this->term = $term;
        $this->reevaluation = $reevaluation;
        $this->setCandidate();
        $this->checkIfCandidateExists();
        if($this->checkIfTermIsRight()){
           return $this->getAllApplications();
        }else{
            Session::flash('error','Please check the term!');
            return back();
        }
    }

    private function setCandidate(){
        $this->candidate =  \App\Candidate::find($this->cid);
        $this->approvedprogramme = $this->candidate->approvedprogramme;
        $this->programme = $this->approvedprogramme->programme;
        $this->noofterms = $this->programme->numberofterms;
        $this->academicyear_id = $this->candidate->approvedprogramme->academicyear_id;
        $this->exam = \App\Exam::find($this->exam_id);
        $this->exam_accademicyear_id = $this->exam->academicyear_id;
        $this->noofsubjects = \App\Subject::where('programme_id',$this->programme->id)->where('syear',$this->term)->where('alternative','!=',1)->count();
        if($this->exam_id == 22){
            $this->applicationmodel = '\App\Currentapplication';
            $this->applicantmodel = '\App\Currentapplicant';
        }
        if($this->exam_id == 24){
            $this->applicationmodel = '\App\Supplimentaryapplication';
            $this->applicantmodel = '\App\Supplimentaryapplicant';
        }
    }

    private function checkIfCandidateExists(){
        if(is_null($this->candidate)){
            Session::put('error','Candidate not found');
            return back();
        }
    }

    private function getAllApplications(){
        if($this->term == 2){
            $this->term = 1;
            $this->noofsubjects = \App\Subject::where('programme_id',$this->programme->id)->where('syear',$this->term)->where('alternative','!=',1)->count();
            $term_one_result =  $this->getTermResult(true);
//		return $term_one_result;
		 $this->term = 2;
            $this->noofsubjects = \App\Subject::where('programme_id',$this->programme->id)->where('syear',$this->term)->where('alternative','!=',1)->count();
        }
        //return $term_one_result;
        $this->applications = $this->applicationmodel::where('candidate_id',$this->cid)->where('term',$this->term);
        $result = $this->getTermResult() ? 1 : 0;
        
        /*return json_encode([
            'result' => $this->getTermResult(),
            'applications' => 
        ]); */
        $applications = $this->applications->get();
        
        $currentapplicant = \App\Currentapplicant::where('candidate_id',$this->cid)->first();
        if($applications->count() < 1){
            if($this->term==1){
                $currentapplicant->sl_no_marksheet_term_one = null;
                $currentapplicant->reevaluation_term_one_result_id = null;
            }else{
                $currentapplicant->sl_no_marksheet_term_two = null;
                $currentapplicant->reevaluation_term_two_result_id = null;
            }
            $currentapplicant->save();
            Session::put('messages','Not applications found');
            return back();
        }
        if($currentapplicant->withheld == 1){
            Session::put('messages','Result Withheld');
            return back();
        }
        
        $total_mark = Currentapplication::where('candidate_id',$this->cid)->whereHas('subject',function($q){
            $q->where('syear',$this->term);
        })->sum('internal_mark') 
        + 
        Currentapplication::where('candidate_id',$this->cid)->whereHas('subject',function($q){
            $q->where('syear',$this->term);
        })->sum('reevaluation_mark') 
        +
        Currentapplication::where('candidate_id',$this->cid)->whereHas('subject',function($q){
            $q->where('syear',$this->term);
        })->sum('grace') 
        ;
        if($currentapplicant->attendance == 1){
            $nber_id = $this->candidate->approvedprogramme->programme->nber_id;
            if($this->term==1){
                $currentapplicant->term_one_result_id = $result;
                $currentapplicant->reevaluation_term_one_result_id = $result;
                if($currentapplicant->sl_no_marksheet_term_one < 1){
                    $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_one')->first();
                    $sl_no_marksheet_term_one = $slno->slno;
                    $sl_no_marksheet_term_one ++;
                    $currentapplicant->sl_no_marksheet_term_one = $sl_no_marksheet_term_one;
                    $slno->slno = $sl_no_marksheet_term_one;
                    $slno->save();
                }
                $currentapplicant->first_year_total = $total_mark;
                $currentapplicant->reevaluation_first_year_total = $total_mark;
                $currentapplicant->marksheetissuded_date = date("Y-m-d");
                $currentapplicant->reevaluation_marksheetissuded_date = date("Y-m-d");
                $currentapplicant->save();
            }
            if($this->term==2){
                $currentapplicant->term_one_result_id = $term_one_result;
                $currentapplicant->term_two_result_id = $result;
                $currentapplicant->reevaluation_term_two_result_id = $result;
                if($currentapplicant->sl_no_marksheet_term_two < 1){
                    $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_two')->first();
                    $sl_no_marksheet_term_two = $slno->slno;
                    $sl_no_marksheet_term_two ++;
                    $currentapplicant->sl_no_marksheet_term_two = $sl_no_marksheet_term_two;
                    $slno->slno = $sl_no_marksheet_term_two;
                    $slno->save();
                }
                $currentapplicant->second_year_total = $total_mark;
                $currentapplicant->reevaluation_second_year_total = $total_mark;
                $currentapplicant->marksheetissuded_date = date("Y-m-d");
                $currentapplicant->reevaluation_marksheetissuded_date = date("Y-m-d");
                
                $currentapplicant->save();
            }
            $certificate = false;
            if($this->noofterms == 1 && $currentapplicant->term_one_result_id == 1 ){
                $certificate = true;
            }
            if($this->noofterms == 2 && $currentapplicant->term_one_result_id == 1 && $currentapplicant->term_two_result_id == 1 ){
                $certificate = true;
            }
            $this->candidate->new_changes = $this->candidate->new_changes + 1;
            $this->candidate->save();
            if($certificate){
                $this->calculatePercentage();
                $this->candidate->coursecompleted_status = 1;
                $this->candidate->save();
                $currentapplicant->final_result = 1;
                $currentapplicant->result_percentage = $this->resultPercentage;
                if($currentapplicant->slno_certificate < 1){
                    $slno = Slno::where('nber_id', $nber_id)->where('key_val','slno_certificate')->first();
                    $slno_certificate = $slno->slno;
                    $slno_certificate ++;
                    $slno->slno = $slno_certificate;
                    $slno->save();
                    $currentapplicant->slno_certificate = $slno_certificate;
                }
                $currentapplicant->certificate_date = date("Y-m-d");
                $currentapplicant->reevaluation_certificate_date = date("Y-m-d");
                $currentapplicant->save();
                return true;
            }
            return false;
        }else{
            Session::put('messages','Attendance is less than 75%');
            return back();
        }
    }

    public function calculatePercentage(){
        $max = $this->programme->first_year_max;
        if($this->programme->numberofterms == 2){
            $max += $this->programme->second_year_max;
        }
        $sql = "
            SELECT sum(total) as total FROM 
            (SELECT sum(if(s.is_internal =1,ifnull(internal_mark,0),0)) + sum(if(s.is_external =1,ifnull(reevaluation_mark,0),0)) + sum(ifnull(grace,0)) as total
            FROM currentapplications ca 
            LEFT JOIN subjects s on s.id = ca.subject_id
            WHERE ca.result_id = 1 and ca.candidate_id = " . $this->cid . "
            UNION
            SELECT sum(if(s.is_internal =1,ifnull(internal_mark,0),0)) + sum(if(s.is_external =1,ifnull(external_mark,0),0)) + sum(ifnull(grace,0)) as total
            FROM applications ca 
            LEFT JOIN subjects s on s.id = ca.subject_id
            WHERE ca.result_id = 1 and ca.candidate_id = " . $this->cid . ") as m
        ";
        $total = DB::select($sql);
        $totalMark = array_pluck($total,'total')[0];
        //$this->resultPercentage = $totalMark;
        $this->resultPercentage =  round((($totalMark/$max) * 100),2);
    }


    private function checkIfTermIsRight(){
        if($this->term > $this->noofterms){
            return false;
        }
        //if(($this->exam_accademicyear_id - $this->academicyear_id - $this->noofterms + 1) < 0){
        //if($this->academicyear_id )
          //  return false;
        //}
        return true;
    }

    private function getTermResult($checkinprevious=false){
        if($checkinprevious== true){
            return $this->reevaluationStatus(true);
        }else{
            if($this->exam_accademicyear_id == ($this->academicyear_id + $this->noofterms - 1)){
                return $this->reevaluationStatus();
            }else{
                return $this->reevaluationStatus(true);
            }
        }
        
    }

    private function reevaluationStatus($checkinprevious = false){
        if($this->reevaluation){
            if($this->exam->examtype_id == 1){
                return $this->checkPaperCount('reevaluation_result_id',$checkinprevious);
            }else{  
                Session::flash('error','Revaluation not applicable on this exam');
                return back();
            }
        }
        return $this->checkPaperCount('result_id',$checkinprevious);
    }

    private function checkPaperCount($field,$checkinprevious){
        $applications = $this->applicationmodel::where('candidate_id',$this->cid)->where('term',$this->term);
        $passedpreviously = 0;
        if($checkinprevious){
            $passedpreviously = \App\Application::where('candidate_id',$this->cid)->where('term',$this->term)->where('result_id',1)->count();
        }
       // return $this->cid. ','. $this->term. ','.  $applications->where($field,1)->count() . ',' . $passedpreviously . ', '. $this->noofsubjects;
   //	return  ['app_count'=>$applications->where($field,1)->count(),'pre'=>$passedpreviously,'noofsujects'=>$this->noofsubjects];
	     return ((($applications->where($field,1)->count() + $passedpreviously) == $this->noofsubjects)) ? true : false;
    }

}
