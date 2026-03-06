<?php

namespace App\Services\Exam;
use App\Http\Requests;
use App\Currentapplicant;
use App\Supplimentaryapplicant;
use Session;
use App\Services\Common\HelperService;
use DB;

class ApplicantService
{
    private $applicant;
    private $model;
    private $applicationmodel;
    private $applicant_id_field;
    private $exam_id;
    private $programme_id;
    private $institute_id;
    private $helper;
    private $academicyear_id;
    private $case;

    public function __construct(HelperService $helper)
    {
        $this->helper = $helper;
        $this->exam_id = Session::get('exam_id');
        $this->case = app()->request->has('case') ? app()->request->case : 'all';

    }

    public function getProgrammeIDs(){
        $programme_ids = $this->helper->getProgrammes()->pluck('id')->toArray();
        return $programme_ids;
    }
    public function getApplicants($paginate,$apid = null){
        
        $programme_ids  = $this->getProgrammeIDs();        
        
        $applicants = $this->model::where('exam_id',$this->exam_id)->whereNull('deleted_at')->whereIn('programme_id',$programme_ids);
        //return $applicants->get();
        if(!is_null($apid)){
            $applicants = $applicants->where('approvedprogramme_id',$apid);
        }else{
            if(!is_null($this->programme_id)){
                $applicants = $applicants->where('programme_id',$this->programme_id);
            }
            if(!is_null($this->institute_id)){
                $applicants = $applicants->where('institute_id',$this->institute_id);
            }
            if(!is_null($this->academicyear_id)){
                $applicants = $applicants->whereHas('approvedprogramme',function($q){
                    $q->where('academicyear_id',$this->academicyear_id);
                });
            }
        }
        if($this->case == 'special'){
            $applicants = $applicants->where('nplustwoexception',1);
        }
        if($paginate==0){
            return $applicants->get();
        }
        return $applicants->paginate($paginate);
        
    }

    public function getTheoryStats($nber_id){
       // $exam_id = Session::get('exam_id');

        $sql = "
        select 
            s.state_name as state_name,
            su.scode as subject_code,
            su.sname as subject_name,
            eec.code as exam_center_code,
            eec.name as exam_center,
            evc.code as evaluation_center_code, 
            evc.name as evaluation_center,
            eec.contactperson,
            eec.contactnumber1 as contact_number,
            eec.email1 as email,
            p.abbreviation as course,
            i.rci_code as institute_code,
            i.name as institute_name,
            y.year as batch,
            es.description as examdetails,
            es.examdate as examdate,
            es.starttime as starttime,
            if(ep.scan_copy=1,'Uploaded','Pending') as scan_copy,
            ep.theory as no_of_students,
            ep.attendance as no_of_students_attendance_marked,
            ep.present as present,
            ep.absent as absent,
            ep.evaluated as evaluation_completed
        from exampapers ep
        left join externalexamcenters eec on eec.id = ep.externalexamcenter_id
        left join programmes p on p.id = ep.programme_id
        left join institutes i on i.id = ep.institute_id
        left join approvedprogrammes ap on ap.id = ep.approvedprogramme_id
        left join academicyears y on y.id = ap.academicyear_id
        left join lgstates s on s.id = i.state_id
        left join evaluationcenterdetails evcd on evcd.externalexamcenter_id = eec.id and evcd.exam_id = 25
        left join evaluationcenters evc on evc.id = evcd.evaluationcenter_id
        left join examschedules es on es.id = ep.examschedule_id
        left join subjects su on su.id = ep.subject_id
        where  p.nber_id = " . $nber_id . " or ". $nber_id . " = 0";
        ;
        $result  = DB::select($sql);
        
        $rVal = array_map(function ($value) {
            return (array)$value;
        }, $result); 
        return $rVal;

    }

    public function getAllapplications($nber_id){
        if($this->exam_id == 25){
            return \App\Newapplication::whereHas('newapplicant',function($q) use($nber_id){
                $q->whereHas('programme',function($p) use($nber_id){
                    $p->where('nber_id',$nber_id);
                });
            })->get();
        }
        if($this->exam_id == 26){
            return \App\Allapplication::where('exam_id',26)->whereHas('candidate',function($s) use($nber_id){
                $s->whereHas('approvedprogramme',function($q) use($nber_id){
                    $q->whereHas('programme',function($p) use($nber_id){
                        $p->where('nber_id',$nber_id);
                    });
                });
            })->get();
        }
        if($this->exam_id == 27){
            // return \App\Allapplication::where('exam_id',27)->whereHas('candidate',function($s) use($nber_id){
            //     $s->whereHas('approvedprogramme',function($q) use($nber_id){
            //         $q->whereHas('programme',function($p) use($nber_id){
            //             $p->where('nber_id',$nber_id);
            //         });
            //     });
            // })->get();
            return collect(DB::select("CALL getApplications(27,".$nber_id.")"));
            //return \App\Allapplication::where('exam_id',27)->where('nber_id',$nber_id)->get();
        }
        return \App\Supplimentaryapplication::whereHas('supplimentaryapplicant',function($q) use($nber_id){
            $q->where('block',null);
            $q->whereHas('programme',function($p) use($nber_id){
                $p->where('nber_id',$nber_id);
            });
        })->get();
    }

    public function assignmodel($exam_id){
        $this->exam_id = $exam_id;
        if($exam_id == 22){
            $this->model = "\App\Currentapplicant";
            $this->applicationmodel = "\App\Currentapplication";
            $this->applicant_id_field = 'currentapplicant_id';
        }elseif($exam_id == 24){
            $this->applicationmodel = "\App\Supplimentaryapplication";
            $this->model = "\App\Supplimentaryapplicant";
            $this->applicant_id_field = 'supplimentaryapplicant_id';
        }elseif($exam_id == 25){
            $this->applicationmodel = "\App\Newapplication";
            $this->model = "\App\Newapplicant";
            $this->applicant_id_field = 'newapplicant_id';
        }elseif($exam_id > 25){
            $this->applicationmodel = "\App\Viewapplication";
            $this->model = "\App\Viewapplicant";
            $this->applicant_id_field = 'application_id';
        }
        else{
            $this->applicationmodel = "\App\Application";
            $this->model = "\App\Oldapplicant";
            $this->applicant_id_field = 'applicant_id';
        }
    }
       

    public function getProgramme($r){
        if($r->has('programme_id')){
            $this->programme_id = $r->programme_id;
        }else{
            $this->programme_id = null;
            return null;
        }
        return \App\Programme::find($this->programme_id);
    }

    public function getInstitute($r){
        if($r->has('institute_id')){
            $this->institute_id = $r->institute_id;
        }else{
            $this->institute_id = null;
            return null;
        }
        return \App\Institute::find($this->institute_id);
    }

    public function getInstitutes(){
        if($this->exam_id == 24  || $this->exam_id == 25  || $this->exam_id > 25 ){
            $programme_ids = $this->helper->getProgrammes(1)->pluck('id')->toArray();
            if(is_null($this->programme_id)){
                $institute_ids=$this->model::whereIn('programme_id',$programme_ids);
            }else{
                $institute_ids=$this->model::where('programme_id',$this->programme_id);
            }
            $institute_ids = $institute_ids->groupBy('institute_id')
                            ->pluck('institute_id')
                            ->toArray();
            return \App\Institute::whereIn('id',$institute_ids)->get();
        }else{
            return null;
        }
    }
    
    public function getApplicant($id){
        $this->applicant = $this->model::find($id);
        return $this->applicant;
    }

    public function getEligiblePracticalSubjects($candidate_id,$term){
        $sql = 'select 
            s.id, 
            s.scode, 
            s.sname, 
            a.alternative_paper, 
            s.syear 
        from newapplications a 
        left join subjects s on s.id = a.subject_id
        left join newinternalmarks im on im.candidate_id = a.candidate_id and a.subject_id = im.subject_id
        where 
            a.candidate_id = '.$candidate_id.'
            and s.syear = '.$term.' 
            and s.subjecttype_id = 2 
            and (ifnull(im.internal,0) >= s.imin_marks or a.eligible = 1 )
        order by s.sortorder
        ';
        $result  = DB::select($sql);
        $subjects = array_map(function ($value) {
            return (array)$value;
        }, $result); 
        return $subjects;
    }

    public function getExamcenter($institute,$phase=1,$district_id=null){
        $exam_center = null;

        // if(is_null($institute->state_id) && $this->exam_id != 25){
        //     return null;
        // }
        if($this->exam_id == 27 ){
            $exam_center = \App\Examcenter::where('exam_id',27)->where('institute_id',$institute->id)->first();
            if($institute->id == 1057 && $district_id != 83){
                $exam_center = \App\Examcenter::where('exam_id',27)->whereHas('externalexamcenter',function($q) use($district_id){
                    $q->where('district',$district_id);
                })->where('institute_id',$institute->id)->first();
            }
            // if($phase==2){
            //     $exam_center = $exam_center->where('phase_two',1);
            // }
            // return $exam_center->first();
        }else{
            // $exam_centers = \App\Examcenter::whereHas('states',function($q) use($institute){
            //     $q->where('lgstate_id',$institute->state_id);
        //});
        // if($exam_centers->count()==1){
        //     $exam_center = $exam_centers->first();
        // }
        // if($exam_centers->count()>1){
        //     $institute_rci_district = $institute->rci_district;
        //     $zone_id = \App\Statedistrict::where('name',$institute_rci_district)->first()->statezone_id;
        //     $exam_centers_with_zone = \App\Examcenter::whereHas('states',function($q) use($institute,$zone_id){
        //         $q->where('lgstate_id',$institute->state_id);
        //         $q->where('statezone_id',$zone_id);
        //     });
        //     if($exam_centers_with_zone->count()==1){
        //         $exam_center = $exam_centers_with_zone->first();
        //     }
        // }
        }
        return $exam_center;
    }

    public function isCurrent(){
        if($this->exam_id!= 24){
            Session::flash('error','Not available for this exam');
            return redirect('nber/exam/applicants');
        }
    }

    public function getNumberOfPapers($year){
        $count = 0;
        foreach($this->applicant->applications as $application){
            if($application->subject->syear == $year){
                $count ++;
            }
        }
        return $count;
    }

    public function getAcademicyear($r){
        $this->academicyear_id = null;
        $academicyear = null;
        if($r->has('academicyear_id')){
            $this->academicyear_id = $r->academicyear_id;
            $academicyear = \App\Academicyear::find($r->academicyear_id);
        }
        return $academicyear;
    }
}
