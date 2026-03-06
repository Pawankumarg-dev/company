<?php

namespace App\Services\Result;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Currentapplication;
use App\Supplimentaryresult;
use App\Supplimentaryapplication;
use Session;
use Auth;
use DB;
use App\Slno;


class SupplementaryMarksheetService
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
    private $applicantmodel;
    private $applications;
    private $noofsubjects_fy;
    private $noofsubjects_sy;
    private $applied_subjects_fy;
    private $applied_subjects_sy;
    private $programme;
    private $approvedprogramme;
    private $resultPercentage;
    private $result_fy;
    private $result_sy;
    private $result_final;
    private $result;
    private $generatecertificate = false;
    public function __construct()
    {
    }

    public function generateMarksheet($cid){
        $this->cid  = $cid;
        $this->exam_id = 25;
        if($this->setCandidate()){
            $this->term = 1;
           // $this->getAllApplications(); 
            $marksheet1 = ['fy_result' => $this->result_fy, 'applications' => $this->applications];
            $marksheet2 = null;
           // if($this->noofterms == 2){
                $this->term = 2;
             //   $this->getAllApplications();
                $marksheet2 = ['sy_result' => $this->result_sy, 'applications' => $this->applications];
            //}
            return ([$marksheet1,$marksheet2]);
            /* Geenerate certificate */
		$this->result->marksheet_sl_no_second_year = 112;
		$this->result->save();
        }
    }

    private function setCandidate(){
        
        $this->candidate =  \App\Candidate::find($this->cid);
        if($this->candidate->supplimentaryresults()->count()>0){
            return false;
        }
        $this->approvedprogramme = $this->candidate->approvedprogramme;
        $this->programme = $this->approvedprogramme->programme;
        $this->noofterms = $this->programme->numberofterms;
        $this->academicyear_id = $this->candidate->approvedprogramme->academicyear_id;
        $this->exam = \App\Exam::find($this->exam_id);
        $this->noofsubjects_fy = \App\Subject::where('programme_id',$this->programme->id)->where('syear',1)->where('alternative','!=',1)->count();
        $this->noofsubjects_sy = \App\Subject::where('programme_id',$this->programme->id)->where('syear',2)->where('alternative','!=',1)->count();
        $this->applied_subjects_fy = \App\Supplimentaryapplication::whereHas('subject',function($q){
            $q->where('syear',1);
        })->count();
        $this->applied_subjects_sy = \App\Supplimentaryapplication::whereHas('subject',function($q){
            $q->where('syear',2);
        })->count();
        $this->applicationmodel = '\App\Supplimentaryapplication';
        $this->applicantmodel = '\App\Supplimentaryapplicant';
        $this->result = Supplimentaryresult::create([
            'candidate_id' => $this->cid
        ]);
	return true;
    }

    private function checkIfCandidateExists(){
        if(is_null($this->candidate)){
            $this->result->status_id = 0;
            $this->result->save();
            return false;
        }
        
        return true;
    }

    private function getAllApplications(){
  
        $this->applications = $this->applicationmodel::where('candidate_id',$this->cid)->whereHas('subject',function($q){
            $q->where('syear',$this->term);
        });
        if($this->term == 1){
            $result_fy = $this->getTermResult() ? 1 : 0;
            $this->result->first_year_result = $result_fy;
            $this->result->save();
        }
        if($this->term == 2){
            $result_sy = $this->getTermResult() ? 1 : 0;
            $this->result->second_year_result = $result_sy;
            $this->result->save();
        }
        /*return json_encode([
            'result' => $this->getTermResult(),
            'applications' => 
        ]); */
        $applications = $this->applications->get();
        
        $supplimentaryapplicant = \App\Supplimentaryapplicant::where('candidate_id',$this->cid)->first();
        
        
        $total_mark = Supplimentaryapplication::where('candidate_id',$this->cid)->whereHas('subject',function($q){
            $q->where('syear',$this->term);
        })->sum('internal_mark') 
        + 
        Supplimentaryapplication::where('candidate_id',$this->cid)->whereHas('subject',function($q){
            $q->where('syear',$this->term);
        })->sum('external_mark') 
        +
        Supplimentaryapplication::where('candidate_id',$this->cid)->whereHas('subject',function($q){
            $q->where('syear',$this->term);
        })->sum('grace') ;
        //if($currentapplicant->attendance == 1){
        $nber_id = $this->candidate->approvedprogramme->programme->nber_id;
        if($this->term==1 && $applications->count() > 0){
            $this->result->first_year_result = $result_fy;
            $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_one')->first();
            $sl_no_marksheet_term_one = $slno->slno;
            $sl_no_marksheet_term_one ++;
            $this->result->marksheet_sl_no_first_year = $sl_no_marksheet_term_one;
            $slno->slno = $sl_no_marksheet_term_one;
                $slno->save();
            $this->result->first_year_total = $total_mark;
            $this->result->marksheetissuded_date = date("Y-m-d");
            $this->result->save();
        }
	$this->result->marksheet_sl_no_second_year = 123;
$this->result->save();
        if($this->term==2 && $applications->count() > 0){
            $this->result->second_year_result = $result_sy;
            $slno = Slno::where('nber_id', $nber_id)->where('key_val','sl_no_marksheet_term_two')->first();
            $sl_no_marksheet_term_two = $slno->slno;
            $sl_no_marksheet_term_two ++;
            $this->result->marksheet_sl_no_second_year = $sl_no_marksheet_term_two;
            $slno->slno = $sl_no_marksheet_term_two;
                $slno->save();
            $this->result->second_year_total = $total_mark;
            $this->result->marksheetissuded_date = date("Y-m-d");
            $this->result->save();
        }
        if($this->noofterms == 1 && $this->result->first_year_result == 1 ){
            $this->generatecertificate = true;
        }
        if($this->noofterms == 2 && $this->result->first_year_result == 1 && $this->result->second_year_result == 1 ){
            $this->generatecertificate = true;
        }
        //$this->candidate->new_changes = $this->candidate->new_changes + 1;
        //$this->candidate->save();
        if($this->generatecertificate){
            $this->calculatePercentage();
            $this->candidate->coursecompleted_status = 1;
            $this->candidate->save();
            $this->result->final_year_result = 1;
            $this->result->final_percentage=$this->resultPercentage;
            //$currentapplicant->result_percentage = $this->resultPercentage;
            
            $slno = Slno::where('nber_id', $nber_id)->where('key_val','slno_certificate')->first();
            $slno_certificate = $slno->slno;
            $slno_certificate ++;
            $slno->slno = $slno_certificate;
            $slno->save();
            $this->result->slno_certificate = $slno_certificate;
            $this->result->certificate_date = date("Y-m-d");
            $this->result->save();
            return true;
        }else{
            $this->result->final_year_result = 0;
            $this->result->save();
        }
        
        return false;
      /*  }else{
            Session::put('messages','Attendance is less than 75%');
            return back();
        }*/
    }

    public function calculatePercentage(){
        $max = $this->programme->first_year_max;
        if($this->programme->numberofterms == 2){
            $max += $this->programme->second_year_max;
        }
        $sql = "
            SELECT sum(total) as total FROM 
            (
                SELECT sum(if(s.is_internal =1,ifnull(internal_mark,0),0)) + sum(if(s.is_external =1,ifnull(external_mark,0),0)) + sum(ifnull(grace,0)) as total
                FROM supplimentaryapplications ca 
                LEFT JOIN subjects s on s.id = ca.subject_id
                WHERE ca.result_id = 1 and ca.candidate_id = " . $this->cid ."
                
                UNION    
                
                SELECT sum(if(s.is_internal =1,ifnull(internal_mark,0),0)) + sum(if(s.is_external =1,ifnull(reevaluation_mark,0),0)) + sum(ifnull(grace,0)) as total
                FROM currentapplications ca 
                LEFT JOIN subjects s on s.id = ca.subject_id
                WHERE ca.result_id = 1 and ca.candidate_id = " . $this->cid . "
                
                UNION
                
                SELECT sum(if(s.is_internal =1,ifnull(internal_mark,0),0)) + sum(if(s.is_external =1,ifnull(external_mark,0),0)) + sum(ifnull(grace,0)) as total
                FROM applications ca 
                LEFT JOIN subjects s on s.id = ca.subject_id
                WHERE ca.result_id = 1 and ca.candidate_id = " . $this->cid . "
            ) as m
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

    private function getTermResult(){
        if($this->exam_accademicyear_id == ($this->academicyear_id + $this->noofterms - 1)){
            return $this->checkPaperCount();
        }else{
            return $this->checkPaperCount(true);
        }
    }

 

    private function checkPaperCount($checkinprevious=false){
        $supplimentaryapplication_count = $this->applicationmodel::where('candidate_id',$this->cid)->whereHas('subject',function($q){
            $q->where('syear',$this->term);
        })->where('result_id',1)->count();
        $currentapplication_count = \App\Currentapplication::where('candidate_id',$this->cid)->where('term',$this->term)->where('reevaluation_result_id',1)->count();
        if($checkinprevious){
            $passedpreviously_count = \App\Application::where('candidate_id',$this->cid)->where('term',$this->term)->where('result_id',1)->count();
        }
       $term_noofsubjects = $this->term ? 'noofsubjects_fy' : 'noofsubjects_2y';
       return ((($supplimentaryapplication_count + $currentapplication_count + $passedpreviously_count ) == $this->$term_noofsubjects)) ? true : false;
    }

}
