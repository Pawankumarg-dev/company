<?php

namespace App\Services\Evaluation;
use App\Http\Requests;
use App\Currentapplicant;
use App\Supplimentaryapplicant;
use Session;
use App\Services\Common\HelperService;

use App\Examcenter;
use App\Examschedule;

use DB;
use Auth;

class EvaluationService
{
    private $exam_id;
    private $externalexamcenter_ids;
    private $helper;
    private $evaluationcenter_id;
    private $evaluationcenters;


    public function __construct(HelperService $helper)
    {
        $this->helper = $helper;
        $this->exam_id = $this->helper->getScheduledExamID();
    }

    public function getEvaluationcenter($id){
        return  \App\Evaluationcenter::find($id);
    }

    public function  getExamcenters($id){
        return \App\Evaluationcenterdetail::where('exam_id',$this->exam_id)
                        ->where('evaluationcenter_id',$id)
                        ->get();
    }
    public function getExternalexamcenterIDs($id){
        return \App\Evaluationcenterdetail::where('exam_id',$this->exam_id)
                        ->where('evaluationcenter_id',$id)
                        ->pluck('externalexamcenter_id')->toArray();
    }

    public function getExamcenterIDs($externalexamcenter_ids){
        return \App\Examcenter::whereIn('externalexamcenter_id',$externalexamcenter_ids)
                        ->where('exam_id',$this->exam_id)
                        ->pluck('id')->toArray();
    }

    public function getCourses($examcenter_ids){
        $programme_ids =  \App\Allexampaper::whereIn('externalexamcenter_id',$examcenter_ids)->where('exam_id',$this->exam_id)->pluck('programme_id')->unique()->toArray();
        
        $course_ids = \App\Programme::whereIn('id',$programme_ids)->pluck('course_id')->unique()->toArray();
        return \App\Course::whereIn('id',$course_ids)->get();
    }

    public function getExamPapers($examcenter_ids,$course_id = null,$subject_ids=null){
        
        //return \App\Institute::whereIn('examcenter_se_24',$examcenter_ids)->pluck('id')->toArray();
//         $papers =  \App\Allexampaper::whereIn('externalexamcenter_id',$examcenter_ids)->where('exam_id',27);
//         if(!is_null($course_id)){
//             $programme_ids = $this->getProgammeIDs($course_id);
//             $papers= $papers->whereIn('programme_id',$programme_ids);                
//         }
//         if(!is_null($subject_ids)){
//             $papers= $papers->whereIn('subject_id',$subject_ids);   
//             return $papers->get();             
//         }
        
//         return $papers->selectRaw('
//     *, 
//     SUM(theory) AS sum_of_theory, 
//     SUM(absent) AS sum_of_absent, 
//     SUM(attendance) AS sum_of_attendance, 
//     SUM(evaluated) AS sum_of_evaluated, 
//     SUM(present) AS sum_of_present, 
//     GROUP_CONCAT(DISTINCT(approvedprogramme_id)) AS approveprogram_ids,
//         GROUP_CONCAT(DISTINCT(externalexamcenter_id)) AS externalexamcenter_ids

// ')
// ->groupBy('subject_id')
// ->get();




        $papers =  \App\Allexamstudent::whereIn('externalexamcenter_id',$examcenter_ids)->where('exam_id',27);
        
         if(!is_null($course_id)){
            $programme_ids = $this->getProgammeIDs($course_id);
            $papers= $papers->whereIn('programme_id',$programme_ids);                
        }
        if(!is_null($subject_ids)){
            $papers= $papers->whereIn('subject_id',$subject_ids);   
            return $papers->get();             
        }
        
          return $papers->selectRaw('
    *, 
    count(*) AS sum_of_theory, 
        SUM(CASE WHEN attendance = 2 THEN 1 ELSE 0 END) AS sum_of_absent,
        SUM(CASE WHEN attendance = 1 THEN 1 ELSE 0 END) AS sum_of_present,
    GROUP_CONCAT(DISTINCT(approvedprogramme_id)) AS approveprogram_ids,
        GROUP_CONCAT(DISTINCT(externalexamcenter_id)) AS externalexamcenter_ids,
        GROUP_CONCAT(DISTINCT(alternativesubject_id)) AS alternativesubject_id

')
->groupBy('subject_id')
->get();









    }

    public function getInstituteIDs($examcenter_ids,$course_id = null){
        //return \App\Institute::whereIn('examcenter_se_24',$examcenter_ids)->pluck('id')->toArray();
        $papers =  \App\Exampaper::whereIn('externalexamcenter_id',$examcenter_ids);
        if(is_null($course_id)){
            $programme_ids = $this->getProgammeIDs($course_id);
            $papers= $papers->whereIn('programme_id',$programme_ids);                
        }
        return $papers->pluck('institute_id')
                        ->unique()
                        ->toArray();
    }

    public function getProgammeIDs($course_id){
        return  \App\Programme::where('course_id',$course_id)->pluck('id')->toArray();
    }

    public function getStats($institute_ids,$nber_id = null, $subjects = null,$course_id = null){
        
        $sql = 'select p.abbreviation, ';
    
        if(!is_null($subjects)){
            $sql .= 's.scode, s.sname, s.id, ';
        }
        $sql .="    count(*) as nofpappers, n.name_code as nber, 
                    sum(if(sa.externalattendance_id=1,1,0)) as present,
                    sum(if(sa.externalattendance_id=2,1,0)) as absent,
                    sum(if(sa.externalattendance_id is null,1,0)) as pending,
                    sum(if(sa.external_mark is not null,1,0)) as evaluated,
                    es.examdate,
                    es.description,
                    es.starttime,
                    es.endtime,
                    p.id as programme_id
                from newapplications sa
                left join newapplicants a on a.id = sa.newapplicant_id
                left join programmes p on p.id = a.programme_id ";
        if(!is_null($course_id)){
            $sql .= ' and p.course_id = '. $course_id;
        }
        $sql .= "         left join examtimetables tt on tt.subject_id = sa.subject_id and tt.exam_id = 25 
                left join examschedules es on es.id = tt.examschedule_id
                left join nbers n on n.id = p.nber_id ";
        if(!is_null($subjects)){   
            $sql .= " left join subjects s on s.id = sa.subject_id ";
        }
        $sql .= ' where es.id is not null and  a.institute_id in ('.implode(',',$institute_ids).') '; 
        if(!is_null($course_id)){
            $sql .= ' and p.course_id = '. $course_id;
        }
        if(!is_null($nber_id)){
            $sql .= '  and p.nber_id = '. $nber_id;
        }
        $sql .='  ';
        $sql .= " group by a.programme_id";
        if(!is_null($subjects)){   
            $sql .= " , sa.subject_id    ";
        }
        $sql .="  order by es.description, n.id, p.course_id ";
        if(!is_null($subjects)){   
            $sql .= " , s.id    ";
        }
        //return $sql;
        return  DB::select($sql);
    }

    public function getApprovedprogrammes($institute_ids,$subject_id,$attedance = null){
       /* $apids = \App\Newapplicant::whereIn('institute_id',$institute_ids)
            ->whereHas('applications',function($q) use($subject_id,$attedance){
                $q->where('subject_id',$subject_id);
                if(!is_null($attedance)){
                    $q->where('externalattendance_id',1);
                }
            })
          //  ->where('block',null)
            ->groupBy('approvedprogramme_id')
            ->pluck('approvedprogramme_id')->toArray(); */
        $apids = \App\Exampaper::whereIn('institute_id',$institute_ids)->where('subject_id',$subject_id)
                    ->groupBy('approvedprogramme_id')
                    ->pluck('approvedprogramme_id')->toArray();
        return \App\Approvedprogramme::whereIn('id',$apids)->get();
    }

    public function isDEO(){
        return Auth::user()->usertype_id == 8 ? true : false;
    }
}
