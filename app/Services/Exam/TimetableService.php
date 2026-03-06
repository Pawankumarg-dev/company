<?php

namespace App\Services\Exam;
use App\Http\Requests;
use DB;

use Session;
use Auth;
use App\Services\Common\HelperService;

class TimetableService
{
    private $helperService;
    private $language_ids; 
    public function __construct(HelperService $helper)
    {
        $this->helperService = $helper;

    }
    public function getTimetable($programme_id,$exam_id){
        return \App\Examtimetable::where('exam_id',$exam_id)
        ->whereHas('subject',function($q) use($programme_id){
            $q->where('programme_id',$programme_id);
        });
    }
    public function getSubjectIDs($schedule_id){
        $nber_id = $this->helperService->getNberID();
        return \App\Examtimetable::where('examschedule_id',$schedule_id)->whereHas('subject',function($q) use($nber_id){
            $q->whereHas('programme',function($r) use($nber_id){
                $r->where('nber_id',$nber_id);
            });
        })->pluck('subject_id');   
    }
    public function getSchedule($subject_id){
        return \App\Examschedule::where('exam_id',27)->whereHas('examtimetables',function($q) use($subject_id){
            $q->where('subject_id',$subject_id);
        })->first();
    }

    public function getLanguageIds($exam_id,$subject_id){
        $subject = \App\Subject::find($subject_id);
        if($subject->alternative == 1){
            $subject_id= $subject->alternative_of;
        }
        $sql = 'select group_concat(distinct na.language_id) as language_ids from allapplications a
        left join allapplicants na on na.id = a.applicant_id
        where subject_id = '. $subject_id . ' and na.exam_id = ' . $exam_id;
        $result = DB::select($sql);
        $this->language_ids = explode(',',array_pluck($result,'language_ids')[0]);
    }
    public function getLanguages($exam_id,$subject_id){
        $this->getLanguageIds($exam_id,$subject_id);
        return \App\Language::whereIn('id',$this->language_ids)->get();
    }
    public function getNonLanguages(){
        return \App\Language::whereNotIn('id',$this->language_ids)->get();
    }

    
 
 



}

