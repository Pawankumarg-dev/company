<?php

namespace App\Services\Result;
use App\Http\Requests;

use Session;
use Auth;
use DB;


class RemoveDuplicateService
{
    private $candidate_id;

    private $duplicate_subjects = array();

    private $application_ids ;

    private $changes = null; 

    public function __construct()
    {
    }

    public function getResult($candidate_id,$term = null){
        $this->candidate_id = $candidate_id;
        $this->checkDuplicates();
        
        if(!is_null($this->duplicate_subjects) && is_array($this->duplicate_subjects) &&  count($this->duplicate_subjects) > 0){
            return   ['status'=>'duplicates','data' => $this->duplicate_subjects];
        }
        return  ['status'=>'goodtogo','data' => $this->duplicate_subjects];
    }

    public function updateSubjectResult($candidate_id){
        $this->candidate_id = $candidate_id;
        $applications = \App\Application::where('candidate_id',$this->candidate_id)->get();
        $this->updateSubjectResultFor($applications);
        return $this->changes;
    }

    private function updateSubjectResultFor($applications,$exam_id = null){
        foreach($applications as $ca){
            $external_mark = $ca->external_mark;
            if($exam_id == 22){
                $external_mark = $ca->reevaluation_mark > $external_mark ? $ca->reevaluation_mark : $external_mark;
            }
            $external_mark = $external_mark + $ca->grace;
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
                if($exam_id == 22){

                }else{
                    if($ca->result_id==0){
                        $this->changes .= '<li> Changed result of subject ' . $ca->subject->scode . ' from Fail to Pass </li>'  ;
                        $ca->result_id = 1;
                        $ca->save();
                    }
                }
            }
        }
    }

    public function getDuplicates(){
        $sql = ("
            select 
                a.id,
                exam_id,
                subject_id,
                internal_mark,
                external_mark,
                if(internalattendance_id=1,'P',if(internalattendance_id=2,'Ab','NM')) as internalattendance,
                if(externalattendance_id=1,'P',if(externalattendance_id=2,'Ab','NM')) as externalattendance,
                result_id,
                reevaluation_mark,
                reevaluation_result_id,
                grace,
                e.name as exam,
                s.scode as scode, 
                s.sname as sname
            from (
                select 
                    id,
                    exam_id,
                    subject_id,
                    internal_mark,
                    external_mark,
                    internalattendance_id,
                    externalattendance_id,
                    result_id,
                    external_mark as reevaluation_mark,
                    result_id as reevaluation_result_id,
                    grace
                from applications  a
                where 
                    candidate_id = " . $this->candidate_id ."  
                    and subject_id in  (".$this->duplicate_subjects.") 
                    and result_id = 1
                union all
                select 
                    id,
                    exam_id,
                    subject_id,
                    internal_mark,
                    external_mark,
                    internalattendance_id,
                    externalattendance_id,
                    result_id,
                    reevaluation_mark,
                    reevaluation_result_id,
                    grace
                from currentapplications  
                where candidate_id = " . $this->candidate_id ." 
                and subject_id in  (".$this->duplicate_subjects.") 
                and (result_id =1 or reevaluation_result_id = 1)
            ) as a 
            left join exams e on e.id = a.exam_id
            left join subjects s on s.id = a.subject_id
            order by subject_id, exam_id;
        ");
        return DB::select($sql);
    }


    public function checkDuplicates(){
        $sql = ("
            select group_concat(subject_id) as subject_ids from(
                select 
                    subject_id, count(*) as countofattempts
                from (
                    select 
                        exam_id,
                        subject_id
                    from applications  a
                    where candidate_id = " . $this->candidate_id ."  
                    and ignore_entry = 0 and result_id = 1
                    union all
                    select 
                        exam_id,
                        subject_id
                    from currentapplications  
                    where candidate_id = " . $this->candidate_id ."  
                    and ignore_entry = 0 
                    and  (result_id =1 or reevaluation_result_id = 1)
                ) as a
                group by subject_id
                having countofattempts > 1
            ) as t
        ");
        $duplicate_subjects = DB::select($sql);
        $this->duplicate_subjects = $duplicate_subjects[0]->subject_ids;
    }

    public function markDuplicate($r){
        $this->candidate_id = $r->candidate_id;
        foreach(explode(',',$r->subject_ids) as $subject_id){
            $applications = \App\Application::where('candidate_id',$this->candidate_id)
                            ->where('result_id',1)
                            ->where('subject_id',$subject_id)
                            ->get();
            foreach($applications as $application){
                $application->ignore_entry = 1;
                $application->save();
            }
            $currentapplications = \App\Currentapplication::where('candidate_id',$this->candidate_id)
                            ->where('result_id',1)
                            ->where('subject_id',$subject_id)
                            ->get();
            foreach($currentapplications as $application){
                $application->ignore_entry = 1;
                $application->save();
            }
        }
        $notdone = null;
        foreach(explode(',',$r->subject_ids) as $sid){
            $field = 'subject_'.$sid;
            if(is_null($r->$field)){
                $notdone = 'notcompleted';
            }else{
                $application_field = 'application_'.$r->$field;
                $exam_id =  $r->$application_field;
                
                if($exam_id==22){
                    $app= \App\Currentapplication::find($r->$field);
                }else{
                    $app= \App\Application::find($r->$field);

                }
                $app->ignore_entry = 0;
                $app->save();
            }
        }
        if(!is_null($notdone)){
            Session::flash('error','Please choose one for each subjet(s)');
            return back();
        }
        Session::flash('messages','Update, Please generate the marksheet');
        return redirect('nber/candidate/'.$this->candidate_id);
    }
}