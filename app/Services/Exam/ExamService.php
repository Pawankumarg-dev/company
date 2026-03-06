<?php

namespace App\Services\Exam;
use App\Http\Requests;
use App\Currentapplicant;
use App\Supplimentaryapplicant;
use Session;
use App\Services\Common\HelperService;

use App\Examcenter;
use App\Examschedule;

class ExamService
{
    private $exam_id;
    private $externalexamcenter_id;
    private $helper;


    public function __construct(HelperService $helper)
    {
        $this->helper = $helper;
        $this->exam_id = Session::get('exam_id');

    }

    public function getStates(){
        $examcenter = Examcenter::where('exam_id',$this->exam_id)
        ->where('externalexamcenter_id',$this->externalexamcenter_id)
        ->first();
        return $examcenter  ? $examcenter->states->pluck('pivot')  : null;
    }

    public function getInstituteIDs($pivot){
        $i = 0;
        $institutes = [];
        if(!is_null($pivot)){
            foreach($pivot as $p){
                if($p->statezone_id > 0){
                    $districts = \App\Statedistrict::where('statezone_id',$p->statezone_id)->pluck('name');
                    if($districts->count() > 0){
                        $state_institutes = \App\Institute::whereIn('rci_district',$districts)->pluck('id');
                    }
                }else{
                    $state_institutes = \App\Institute::where('state_id',$p->lgstate_id)->pluck('id');
                }
                //$institutes []= $state_institutes;
                foreach($state_institutes as $st){
                array_push($institutes, $st);
                }
                $i++;
            }
        }
        return $institutes;
        return $institutes ? $institutes->pluck('id') : '';
    }

    public function getSubjectIDs($institute_ids,$exam_id = null){
        if($exam_id == 25){
            return  \App\Newapplication::whereHas('newapplicant',function($q) use($institute_ids){
                $q->whereIn('institute_id',$institute_ids);
            })->groupBy('subject_id')->pluck('subject_id');
        }else{
            return  \App\Supplimentaryapplication::whereHas('supplimentaryapplicant',function($q) use($institute_ids){
                $q->whereIn('institute_id',$institute_ids);
            //  $q->where('payment_status',1);
                $q->where('block',null);
            })->groupBy('subject_id')->pluck('subject_id');
        }
    }

    public function getExamscheduleIDs($subject_ids){
        return \App\Examtimetable::where('exam_id',$this->exam_id)->whereIn('subject_id',$subject_ids)->pluck('examschedule_id')->unique();
    }

    public function     getSchedules($exam_id = null,$externalexamcenter_id = null){
        $this->assignVariable($exam_id,$externalexamcenter_id);
        if(is_null($this->externalexamcenter_id) || $this->externalexamcenter_id ==0 ){
            return Examschedule::where('exam_id',$this->exam_id)->orderBy('examdate','asc')->orderBy('starttime','asc')->get();
        }
        if($exam_id==25){
            $institute_ids = \App\Examcenter::where('externalexamcenter_id',$externalexamcenter_id)->pluck('institute_id');
            $subject_ids = $this->getSubjectIDs($institute_ids,25);

        }else{
            $pivot =  $this->getStates();
            $institute_ids = $this->getInstituteIDs($pivot);
            $subject_ids = $this->getSubjectIDs($institute_ids);
        }
            $schedule_ids = $this->getExamscheduleIDs($subject_ids);
            $schedules = \App\Examschedule::whereIn('id',$schedule_ids)->orderBy('examdate','asc')->orderBy('starttime','asc')->get();
            return $schedules;
    }
    
    public function getApprovedProgrammes($exam_id, $externalexamcenter_id,$schedule_id){
        $this->assignVariable($exam_id,$externalexamcenter_id);
        if($exam_id==25){
            $institute_ids = \App\Examcenter::where('externalexamcenter_id',$externalexamcenter_id)->pluck('institute_id');
            $subject_ids = $this->getSubjectIDs($institute_ids,25);
        }else{
            $pivot =  $this->getStates();
            $institute_ids = $this->getInstituteIDs($pivot);
            $subject_ids = $this->getSubjectsOftheSchedule($schedule_id);
        }

        if($exam_id==25){
            return  \App\Newapplicant::whereIn('institute_id',$institute_ids)
            ->whereHas('applications',function($q) use($subject_ids){
                $q->whereIn('subject_id',$subject_ids);
            })
            ->groupBy('approvedprogramme_id')->get();
        }else{
        return  \App\Supplimentaryapplicant::whereIn('institute_id',$institute_ids)
            ->whereHas('applications',function($q) use($subject_ids){
                $q->whereIn('subject_id',$subject_ids);
            })
            ->groupBy('approvedprogramme_id')->get();
        }
    }

    public function getProgrammes($exam_id, $externalexamcenter_id,$schedule_id){
        $this->assignVariable($exam_id,$externalexamcenter_id);
        $pivot =  $this->getStates();
        $institute_ids = $this->getInstituteIDs($pivot);
        $subject_ids = $this->getSubjectsOftheSchedule($schedule_id);

        if($exam_id==25){
            return  \App\Newapplicant::whereIn('institute_id',$institute_ids)
            ->whereHas('applications',function($q) use($subject_ids){
                $q->whereIn('subject_id',$subject_ids);
            })
            ->groupBy('programme_id')->get();
        }else{
        return  \App\Supplimentaryapplicant::whereIn('institute_id',$institute_ids)
            ->whereHas('applications',function($q) use($subject_ids){
                $q->whereIn('subject_id',$subject_ids);
            })
            ->groupBy('programme_id')->get();
        }
    }

    public function getSubjectsOftheSchedule($schedule_id){

        return \App\Examtimetable::where('exam_id',$this->exam_id)
                                    ->where('examschedule_id',$schedule_id)
                                    ->pluck('subject_id')
                                    ->toArray();
    }

    public function getStudentList($exam_id, $externalexamcenter_id,$schedule_id,$order){
        if($schedule_id == 93){
            $schedul = \App\Allexampaper::where('exam_id',27)->where('externalexamcenter_id',$externalexamcenter_id)->where('examschedule_id','<>',93)->first();
            if(!is_null($schedul)){
                $schedule_id = $schedul->examschedule_id;
            }
        }
        if($exam_id > 25){
            return \App\Allexamstudent::where('externalexamcenter_id',$externalexamcenter_id)
                                    ->where('examschedule_id',$schedule_id)
                                    ->where('exam_id',$exam_id)
                                    ->orderBy($order)
                                    ->get();
        }else{
            $this->assignVariable($exam_id,$externalexamcenter_id);
            $pivot =  $this->getStates();
            if($exam_id > 24){
                $institute_ids = \App\Examcenter::where('externalexamcenter_id',$externalexamcenter_id)->where('exam_id',$exam_id)->pluck('institute_id');
            }else{
                $institute_ids = $this->getInstituteIDs($pivot);
            }
            $subject_ids = $this->getSubjectsOftheSchedule($schedule_id);

            if($exam_id = 25){
                return  \App\Newapplication::whereIn('subject_id',$subject_ids)
                                    ->whereHas('newapplicant',function($q) use($institute_ids){
                                        $q->whereIn('institute_id',$institute_ids);
                                    //    $q->where('payment_status',1);
                                    })->with('newapplicant')
                                    ->get();
            }
            return  \App\Supplimentaryapplication::whereIn('subject_id',$subject_ids)
                                    ->whereHas('supplimentaryapplicant',function($q) use($institute_ids){
                                        $q->whereIn('institute_id',$institute_ids);
                                    //    $q->where('payment_status',1);
                                        $q->where('block',null);
                                    })->with('supplimentaryapplicant')
                                    ->get();
        }
    }

    public function getStudentCount($exam_id, $externalexamcenter_id,$schedule_id){
        $this->assignVariable($exam_id,$externalexamcenter_id);
        if($exam_id == 25){
            $institute_ids = \App\Examcenter::where('externalexamcenter_id',$externalexamcenter_id)->pluck('institute_id');
        }else{
            $pivot =  $this->getStates();
            $institute_ids = $this->getInstituteIDs($pivot);
        }
        $subject_ids = $this->getSubjectsOftheSchedule($schedule_id);
        if($exam_id == 25){
            return  \App\Newapplication::whereIn('subject_id',$subject_ids)
            ->whereHas('newapplicant',function($q) use($institute_ids){
                $q->whereIn('institute_id',$institute_ids);
            })->count();    
        }
        return  \App\Supplimentaryapplication::whereIn('subject_id',$subject_ids)
                                ->whereHas('supplimentaryapplicant',function($q) use($institute_ids){
                                    $q->whereIn('institute_id',$institute_ids);
                                //    $q->where('payment_status',1);
                                    $q->where('block',null);
                                })->count();
    }

    public function addAlternative($subject_id){
        $subject = \App\Subject::find($subject_id);
        $subject_ids = [$subject->id];
        $checkalternativeof = \App\Subject::where('alternative_of',$subject_id)->first();
        if(!is_null($checkalternativeof)){
            array_push($subject_ids,$checkalternativeof->id);
        }
        if($subject->alternative == 1){
            array_push($subject_ids, $subject->alternative_of);
        }
        return $subject_ids;
    }
    public function getApplicantions($approvedprogramme_id,$subject_id,$present_only=null,$language_id = null,$exam_id = 27,$district_id =0){
        //$subject_ids = $this->addAlternative($subject_id);
        $subject = \App\Subject::find($subject_id);
        if($subject->selective ==1 ){
            $applications =  \App\Allapplication::where('blocked',0)->whereHas('candidate',function($q) use($approvedprogramme_id, $language_id){
                $q->where('approvedprogramme_id',$approvedprogramme_id);
                if(!is_null($language_id)){
                    $q->where('language_id',$language_id);
                }
            })->where('alternativesubject_id',$subject->alternativesubject_id)->where('exam_id',$exam_id);
        }else{
            if($district_id != 0){
                $applications =  \App\Allapplication::where('blocked',0)->whereHas('candidate',function($q) use($approvedprogramme_id, $language_id,$district_id){
                    $q->where('district_id',$district_id);
                    $q->where('approvedprogramme_id',$approvedprogramme_id);
                    if(!is_null($language_id)){
                        $q->where('language_id',$language_id);
                    }
                })->where('subject_id',$subject_id)->where('exam_id',$exam_id);    
            }else{
                $applications =  \App\Allapplication::where('blocked',0)->whereHas('candidate',function($q) use($approvedprogramme_id, $language_id){
                    $q->where('approvedprogramme_id',$approvedprogramme_id);
                    if(!is_null($language_id)){
                        $q->where('language_id',$language_id);
                    }
                })->where('subject_id',$subject_id)->where('exam_id',$exam_id);
            }
            if(!is_null($present_only)){
                $applications->where('attendance_ex',1);
            }
        }
        return $applications->get();
    }


    public function getApplicantions_evalution($approvedprogramme_id,$subject_id,$present_only=null,$language_id = null,$exam_id = 27){
        //$subject_ids = $this->addAlternative($subject_id);
        $subject = \App\Subject::find($subject_id);

        $id =  $this->helperService->getEvaluationcenterID();
        $externalexamcenter_ids =  $this->evaluationService->getExternalexamcenterIDs($id);

        
                $approvedprogramme_id =  \App\Allexampaper::whereIn('externalexamcenter_id',$examcenter_ids)->where('exam_id',27)->pick('approvedprogramme_id');

        if($subject->selective ==1 ){
            
            $applications =  \App\Allapplication::where('blocked',0)->whereHas('candidate',function($q) use($approvedprogramme_id, $language_id){
                $q->where('approvedprogramme_id',$approvedprogramme_id);
                if(!is_null($language_id)){
                    $q->where('language_id',$language_id);
                }
            })->where('alternativesubject_id',$subject->alternativesubject_id)->where('exam_id',$exam_id);
        }
        else
        {
                $applications =  \App\Allapplication::where('blocked',0)->whereHas('candidate',function($q) use($approvedprogramme_id, $language_id){
                    $q->where('approvedprogramme_id',$approvedprogramme_id);
                    if(!is_null($language_id)){
                        $q->where('language_id',$language_id);
                    }
                })->where('subject_id',$subject_id)->where('exam_id',$exam_id);
            }
        return $applications->get();
    }

    public function getAllApplications($institute_ids,$subject_id,$present_only=null,$exam_id = 27){
       // $subject_ids = $this->addAlternative($subject_id);
        $applications =  \App\Allapplication::where('blocked',0)->whereHas('candidate',function($q) use($institute_ids){
            $q->whereHas('approvedprogramme',function($r) use($institute_ids){
                $r->whereIn('institute_id',$institute_ids);
            });
        })->where('subject_id',$subject_id)->where('exam_id',$exam_id);
        if(!is_null($present_only)){
            $applications->where('attendance_ex',1);
        }
        return $applications->get();
    }

    public function getAllApplicationsofTheDay($subject_ids,$exam_id = 26){
        return \App\Allapplication::where('blocked',0)->whereIn('subject_id',$subject_ids)->where('exam_id',27)
        ->get();
    }

    public function assignVariable($exam_id = null,$externalexamcenter_id = null){
        if(!is_null($exam_id)){
            $this->exam_id = $exam_id;
        }
        if(!is_null($externalexamcenter_id)){
            $this->externalexamcenter_id = $externalexamcenter_id;
        }
    }
}
