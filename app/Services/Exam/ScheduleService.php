<?php

namespace App\Services\Exam;
use App\Http\Requests;
use DB;
use Session;
use Auth;
use App\Services\Common\HelperService;


class ScheduleService
{
    private $helperService;
    public function __construct(HelperService $helper)
    {
        $this->helperService = $helper;

    }
    public function getSchedule($exam_id){
        return \App\Examschedule::where('exam_id',$exam_id)->get();
    }
    public function getCandidatesCount($programme_id){
        return \App\Viewapplicant::where('programme_id',$programme_id)
        ->where('exam_id',Session::get('exam_id'))
        // ->where('payment_status',1)
        // ->where('block','!=',1)
        ->count();
    }
    public function getSubjectIDs($schedule_id,$exam_id){
        return \App\Examtimetable::where('exam_id',$exam_id)->where('examschedule_id',$schedule_id)->pluck('subject_id')->toArray();
    }
    public function getEmailIDs($exam_id,$schedule,$min,$max,$sid,$language_id = null){
        $nber_id = $this->helperService->getNberID();

        /*$year = $schedule->year;
        if($sid==0){
            $subject_ids = $schedule->examtimetables->pluck('subject_id')->toArray();
        }else{
            $subject_ids= explode(' ',$sid);
        }
        $nber_subjects = \App\Subject::whereHas('programme',function($q) use($nber_id){
            $q->where('nber_id',$nber_id);
        })->whereIn('id',$subject_ids)->pluck('id')->toArray();
        $sql = 'select group_concat(distinct eec.email1) as emails from newapplications a
        left join newapplicants na on na.id = a.newapplicant_id
        left join institutes i on i.id = na.institute_id
        left join examcenters ec on ec.institute_id = i.id
        left join externalexamcenters eec on eec.id = ec.externalexamcenter_id
        where subject_id in ('. implode(",",$nber_subjects) . ')  and na.exam_id = ' . $exam_id .' 
        and eec.'.$year.'_year_strenght >= '.$min. ' and eec.'.$year.'_year_strenght < '.$max . ' 
        group by eec.id'; */
        $sql = "select distinct eec.email1 as emails from exampapers ep
        left join programmes p on ep.programme_id = p.id
        left join externalexamcenters eec on eec.id = ep.externalexamcenter_id
        where ep.examschedule_id = " . $schedule->id. "  and p.nber_id = ". $nber_id ;
        if($sid>0){
            $sql .= " and ep.subject_id=" . $sid;
        }
        $sql .=" group by eec.id";
         $result = DB::select($sql);
         $emailsarray = array_pluck($result,'emails');
         $emails = implode($emailsarray, ' ');
         return $emails;
     }
}

