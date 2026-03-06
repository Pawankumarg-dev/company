<?php

namespace App\Services\Exam;
use App\Http\Requests;

use Session;
use Auth;
use Illuminate\Support\Facades\Hash;
use DB;

use App\Services\Common\HelperService;

class ExternalMarkEntryService
{
    private $helperService;
    public function __construct(HelperService $helper)
    {
        $this->helperService = $helper;

    }
    public function uploadmarksheet($request){
        if($request->subjecttype_id == 1){
            return false;
        }
        $file = $request->marksheet;
        if(!is_file($file)){
            Session::flash('error','Please choose a file');
            return false;
        }
        $fname = $request->exam_id.'_'.$request->approvedprogramme_id. "_" . $request->syear.'_'.$request->subjecttype_id;
        $destination = public_path()."/files/externalmarksheets/".$fname;
        try{
            move_uploaded_file( $file, $destination);
        }catch(Exception $e){
            Session::flash('error','Upload Failed!');
            return false;
        }
        
        $marksheet = \App\Externalmarksheet::where('approvedprogramme_id',$request->approvedprogramme_id)
                        ->where('exam_id',$request->exam_id)
                        ->where('term',$request->syear)
                        ->where('subjecttype_id',$request->subjecttype_id)
                        ->first();
        if(is_null($marksheet)){
            \App\Externalmarksheet::create([
                'exam_id' => $request->exam_id,
                'term' => $request->syear,
                'subjecttype_id' => $request->subjecttype_id,
                'approvedprogramme_id' => $request->approvedprogramme_id,
                'filename' => $fname
            ]);
        }else{
            $marksheet->filename = $fname;
            $marksheet->save();
        }
        Session::flash('messages','File Uploaded');
        return true;
    }
    public function getFailedSubject($r,$programme_id){
        $candidate_id = $r->candidate_id;

        $sql = ' select s.id, s.scode, st.type as type, s.sname, s.syear, s.has_alternative from subjects s 
        left join programmes p on p.id = s.programme_id
        left join subjecttypes st on st.id = s.subjecttype_id
        where  s.syear = '.$r->syear.' and   s.subjecttype_id = '.$r->subjecttype_id.' and   p.id = '.$programme_id.'  and  s.id  not in (
        select distinct t2.subject_id  from (
            select   subject_id,  sum(if(result_id=1,1,0)) as result_id from
            (select subject_id, reevaluation_result_id as result_id from currentapplications ca
            where candidate_id = '.$candidate_id .'
            union 
            select subject_id,  result_id from applications a
            where candidate_id = '.$candidate_id .'
            ) as t1
            
            group by subject_id
            having result_id != 0 ) as t2
            left join subjects s on s.id = t2.subject_id 
            where s.alternative = 0 and s.is_internal = 1fsave
            ) 
            order by s.syear, s.subjecttype_id, s.sortorder';
            $result  = DB::select($sql);
            $subjects = array_map(function ($value) {
                return (array)$value;
            }, $result); 
            return $subjects;

    }
    public function getInternalFailedSubject($r,$programme_id){
        $candidate_id = $r->candidate_id;

        $sql = ' select s.id, s.scode, st.type as type, s.sname, s.syear, s.has_alternative, s.imax_marks, im.internal, im.attendance from subjects s 
        left join programmes p on p.id = s.programme_id
        left join subjecttypes st on st.id = s.subjecttype_id
        left join newinternalmarks im on im.candidate_id = ' . $candidate_id.' and im.subject_id = s.id 
        where  s.syear = '.$r->syear.' and   s.subjecttype_id = '.$r->subjecttype_id.' and   p.id = '.$programme_id.'  and  s.id  not in (
        select distinct t2.subject_id  from (
            select   subject_id,  sum(if(result_id=1,1,0)) as result_id from
            (select subject_id, if(ca.internal_mark>=s.imin_marks,1,0) as result_id from currentapplications ca
            left join subjects s on s.id = ca.subject_id
            where candidate_id = '.$candidate_id .' and s.is_internal = 1
            union 
            select subject_id, if(a.internal_mark>=s.imin_marks,1,0) as  result_id from applications a
            left join subjects s on s.id = a.subject_id
            where candidate_id = '.$candidate_id .' and s.is_internal = 1
            ) as t1
            
            group by subject_id
            having result_id != 0 ) as t2
            left join subjects s on s.id = t2.subject_id 
            where s.alternative = 0 and s.is_internal = 1
            ) 
            order by s.syear, s.subjecttype_id, s.sortorder';
            $result  = DB::select($sql);
            $subjects = array_map(function ($value) {
                return (array)$value;
            }, $result); 
            return $subjects;

    }
    public function getSubjetsSQL($subjects){
        $subjectsql = '';
        foreach($subjects as $subject){
            $subjectsql .= " sum(if(aa.subject_id=". $subject->id." , 
                            if(aa.attendance_ex=1,if(aa.mark_ex=0,-1,aa.mark_ex), if(aa.attendance_ex=2,-2,0) ), 0)) as '".$subject->scode . "'
                             , " ;
        }
        return $subjectsql;
    }
    public function getCandidates($subjects,$id){

        $subjectsql = $this->getSubjetsSQL($subjects);
        $sql = "
            SELECT 
            ".
                $subjectsql
            ."
            c.id as cid,
                c.enrolmentno,
                c.name
            
            FROM 
                allapplications aa
            INNER JOIN
                subjects s
            ON 
                s.id = aa.subject_id
            INNER JOIN
                candidates c
            ON 
                c.id = aa.candidate_id
            WHERE 
                c.approvedprogramme_id = " . $id . "
            GROUP BY
                c.id
        ";
        $result  = DB::select($sql);
        $candidates = array_map(function ($value) {
            return (array)$value;
        }, $result); 
        return $candidates;
    }

    public function getSupplementaryClause($subjecttype_id,$syear){
        $clause = ' and ';
        if($syear == 1){
            if($subjecttype_id == 2){
                $clause .= ' ifnull(practical_first_year_passed,0) < practical_first_year ';
            }
            if($subjecttype_id == 1){
                $clause .= ' ifnull(theroy_first_year_passed,0) < theroy_first_year ';
            }
        }
        if($syear == 2){
            if($subjecttype_id == 2){
                $clause .= ' ifnull(practical_second_year_passed,0) < practical_second_year ';
            }
            if($subjecttype_id == 1){
                $clause .= ' ifnull(theroy_second_year_passed,0) < theroy_second_year ';
            }
        }
        return $clause;
    }
    public function getSubjectIDs($programme_id,$r){
        return \App\Subject::where('programme_id',$programme_id)
                        ->where('subjecttype_id',$r->subjecttype_id)
                        ->where('syear',$r->syear)
                        ->where('is_internal',1)
                        ->where('alternative',0)
                        ->orderBy('sortorder')
                        ->pluck('id');
    }

    public function getSubjects($programme_id,$r){
        return \App\Subject::where('programme_id',$programme_id)
                        ->where('subjecttype_id',$r->subjecttype_id)
                        ->where('syear',$r->syear)
                        ->where('is_internal',1)
                        ->where('alternative',0)
                        ->orderBy('sortorder')
                        ->get();
    }

    public function getMarksheet($id,$r){
        return \App\Externalmarksheet::where('approvedprogramme_id',$id)
                        ->where('term',$r->syear)
                        ->where('subjecttype_id',$r->subjecttype_id)
                        ->where('exam_id',$r->exam_id)
                        ->first();
    }
    
    public function saveMarks($id,$r){
        if($r->subjecttype_id == 1){
            return false;
        }
        $approvedprogramme = \App\Approvedprogramme::find($id);
        $programme_id = $approvedprogramme->programme_id;
        $subjects = $this->getSubjects($programme_id,$r);
        foreach($approvedprogramme->candidates as $c){
       //     if(!$this->helperService->checkIfPublished($c->id)){
                foreach($subjects as $s){
                    $marks_field = $c->id.'_'.$s->id;
                    $attendance_field = 'att_'.$marks_field;
                    if($r->has($marks_field) || $r->has($attendance_field)){
                            
                            $attendace = 1;
                        if($r->has($attendance_field)){
                            $attendace = 2;
                        }
                        $mark = $r->$marks_field;
                        if($attendace == 2){
                            $mark = null;
                        }
                            $allapplication = \App\Allapplication::where('subject_id',$s->id)->where('candidate_id',$c->id)->where('exam_id',$r->exam_id)->first();

                           
                            $allapplication->mark_ex = $r->$marks_field;
                            $allapplication->attendance_ex= $attendace;
                            $allapplication->save();
                    }
                }
           // }
        }
        Session::flash('messages','Updated');
    }
}

