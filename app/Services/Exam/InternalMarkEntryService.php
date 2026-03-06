<?php

namespace App\Services\Exam;
use App\Http\Requests;

use Session;
use Auth;
use Illuminate\Support\Facades\Hash;
use DB;

use App\Services\Common\HelperService;

class InternalMarkEntryService
{
    private $helperService;
    public function __construct(HelperService $helper)
    {
        $this->helperService = $helper;

    }
    public function uploadmarksheet($request){
        $marksheet = \App\Internalmarksheet::where('approvedprogramme_id',$request->approvedprogramme_id)
                        ->where('exam_id',$request->exam_id)
                        ->where('term',$request->syear)
                        ->where('subjecttype_id',$request->subjecttype_id)
                        ->first();
        // if(is_null($marksheet) || (!is_null($marksheet) && $marksheet->id > 9655 )){                
            $file = $request->marksheet;
            if(!is_file($file)){
                Session::flash('error','Please choose a file');
                return false;
            }
        
            $fname = $request->exam_id.'_'.$request->approvedprogramme_id. "_" . $request->syear.'_'.$request->subjecttype_id;
            $destination = public_path()."/files/internalmarksheets/".$fname;
            try{
                move_uploaded_file( $file, $destination);
            }catch(Exception $e){
                Session::flash('error','Upload Failed!');
                return false;
            }
        // }else{
        //     Session::flash('messages','File was already uploaded');
        //     return true;
        // }
        
        if(is_null($marksheet)){
            \App\Internalmarksheet::create([
                'exam_id' => $request->exam_id,
                'term' => $request->syear,
                'subjecttype_id' => $request->subjecttype_id,
                'approvedprogramme_id' => $request->approvedprogramme_id,
                'filename' => $fname
            ]);
        }else{
            //if($marksheet->id > 9655){
                $marksheet->filename = $fname;
                $marksheet->save();
           // }else{
            //    Session::flash('messages','File was already uploaded');
             //   return true;
           // }
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
            (
            select subject_id, reevaluated_result_id as result_id from newapplications na
            where candidate_id = '.$candidate_id . ' 
            union
            select subject_id, reevaluation_result_id as result_id from currentapplications ca
            where candidate_id = '.$candidate_id .'
            union 
            select subject_id,  result_id from applications a
            where candidate_id = '.$candidate_id .'
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
    public function getInternalFailedSubject($r,$programme_id){
        $candidate_id = $r->candidate_id;

        $sql = ' select s.id, s.scode, st.type as type, s.sname, s.syear, s.has_alternative, s.imax_marks, im.internal, im.attendance from subjects s 
        left join programmes p on p.id = s.programme_id
        left join subjecttypes st on st.id = s.subjecttype_id
        left join newinternalmarks im on im.candidate_id = ' . $candidate_id.' and im.subject_id = s.id  and im.exam_id = 27  
        where  s.syear = '.$r->syear.' and   s.subjecttype_id = '.$r->subjecttype_id.' and   p.id = '.$programme_id.'  and  s.id  not in (
        select distinct t2.subject_id  from (
            select   subject_id,  sum(if(result_id=1,1,0)) as result_id from
            (
            select subject_id, if(na.internal_mark>=s.imin_marks,1,0) as result_id from newapplications na
            left join subjects s on s.id = na.subject_id
            where candidate_id = '.$candidate_id .' and s.is_internal = 1 
            union 
            select subject_id, if(ca.internal_mark>=s.imin_marks,1,0) as result_id from currentapplications ca
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
            $subjectsql .= " sum(if(im.subject_id=". $subject->id." , 
                            if(im.attendance=1,if(im.internal=0,-1,im.internal),-2), 0)) as '".$subject->scode . "'
                             , " ;
        }
        return $subjectsql;
    }

    public function checkInternalMarkentry($id,$r){

        $sql = 'SELECT sum(internal) as total from candidates c  inner join newinternalmarks im on im.candidate_id = c.id and im.exam_id = '.$r->exam_id .' inner join subjects s on s.id = im.subject_id and s.syear = ' . $r->syear .'  and s.subjecttype_id = '.$r->subjecttype_id .'  where c.approvedprogramme_id = ' . $id ;
        $result  = DB::select($sql)[0];
        return $result;
        
    }   
    
    public function getCandidates($subjects,$id,$r,$supplementary = null){
        $subjectsql = $this->getSubjetsSQL($subjects);
        $clause ='';
        if($supplementary == 'Yes'){
            $clause = $this->getSupplementaryClause($r->subjecttype_id,$r->syear);
        }
        $sql = 'select ';
        $sql .= $subjectsql;
        $sql .=' 
                c.id as cid,
                c.name,
                c.enrolmentno
            from candidates c
            left join newinternalmarks im on im.candidate_id = c.id and im.exam_id = ' .$r->exam_id .' 
            left join attendances a on a.candidate_id = c.id and a.exam_id = ' .$r->exam_id .'
            left join approvedprogrammes ap on ap.id = c.approvedprogramme_id
            where 
                c.approvedprogramme_id = ' . $id .
                ' and (
                (
                    (a.attendance_t >= 75 
                    and a.attendance_p >= 75 and ap.programme_id not in (37,62))  or
                    (a.attendance_t >= 80 
                    and a.attendance_p >= 90 and ap.programme_id  in (37,62)) 
                )
                or ap.academicyear_id < 13 )
                and c.deleted_at is null 
                and  c.status_id != 9 '. $clause . '
            group by c.id
            order by c.enrolmentno
        ';
// echo $sql;
// die();
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
        //$clause .= ' and coursecompleted_status != 1 ';
        return $clause;
    }

    public function getSubjects($programme_id,$r){
        if($programme_id != 70){
        return \App\Subject::where('programme_id',$programme_id)
                        ->where('subjecttype_id',$r->subjecttype_id)
                        ->where('syear',$r->syear)
                        ->where('is_internal',1)
                        ->where('alternative',0)
                        ->orderBy('sortorder')
                        ->get();
        }else{
            return \App\Subject::where('programme_id',$programme_id)
                        ->where('subjecttype_id',$r->subjecttype_id)
                        ->where('syear',$r->syear)
                        ->where('is_internal',1)
                        ->where('dummy',0)
                        ->orderBy('sortorder')
                        ->get();
            
        }
    }

    public function getMarksheet($id,$r){
        return \App\Internalmarksheet::where('approvedprogramme_id',$id)
                        ->where('term',$r->syear)
                        ->where('subjecttype_id',$r->subjecttype_id)
                        ->where('exam_id',$r->exam_id)
                        ->first();
    }
    
    public function saveMarks($id,$r){
        $approvedprogramme = \App\Approvedprogramme::find($id);
        $programme_id = $approvedprogramme->programme_id;
        $subjects = $this->getSubjects($programme_id,$r);
        foreach($approvedprogramme->candidates as $c){
            //if(!$this->helperService->checkIfPublished($c->id)){
                foreach($subjects as $s){
                    $marks_field = $c->id.'_'.$s->id;
                    $attendance_field = 'att_'.$marks_field;
                    if($r->has($marks_field) || $r->has($attendance_field)){
                        $internal_mark = \App\Newinternalmark::where('candidate_id',$c->id)
                                        ->where('exam_id',$r->exam_id)
                                        ->where('subject_id',$s->id)
                                        ->first();
                        $attendace = 1;
                        if($r->has($attendance_field)){
                            $attendace = 2;
                        }
                        $mark = $r->$marks_field;
                        if($attendace == 2){
                            $mark = null;
                        }
                        if(is_null($internal_mark)){
                            \App\Newinternalmark::create([
                                'exam_id' => $r->exam_id,
                                'candidate_id' => $c->id,
                                'approvedprogramme_id' => $c->approvedprogramme_id,
                                'subject_id' => $s->id,
                                'internal' =>  $mark,
                                'attendance' => $attendace
                            ]);
                        }else{
                            $internal_mark->internal = $r->$marks_field;
                            $internal_mark->attendance = $attendace;
                            $internal_mark->save();
                        }
                    }
                }
            //}
        }
        Session::flash('messages','Updated');
    }

}

