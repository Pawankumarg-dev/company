<?php

namespace App\Services\Backlog;
use App\Http\Requests;
use App\Currentapplicant;
use Session;


class ApplicantService
{
    private $applicant;
    private $model;
    private $applicationmodel;
    private $applicant_id_field;
    private $exam_id;


    public function store($r){
        $this->assignmodel($r->exam_id);
        if(!$this->checkIfExisting($r)){
            $this->createEntry($r);
        }
    }

    public function assignmodel($exam_id){
        $this->exam_id = $exam_id;
        if($exam_id == 22){
            $this->model = "\App\Currentapplicant";
            $this->applicationmodel = "\App\Currentapplication";
            $this->applicant_id_field = 'currentapplicant_id';
        }else{
            if($exam_id == 25){
                $this->applicationmodel = "\App\Newapplication";
                $this->model = "\App\Newapplicant";
                $this->applicant_id_field = 'newapplicant_id';
            
            }else{
                if($exam_id == 24){
                    $this->applicationmodel = "\App\Newpplication";
                    $this->model = "\App\Newapplicant";
                    $this->applicant_id_field = 'newapplicant_id';
                }else{
                    $this->applicationmodel = "\App\Application";
                    $this->model = "\App\Oldapplicant";
                    $this->applicant_id_field = 'applicant_id';
                }
            }
        }
    }

    public function checkIfExisting($r){
        $this->applicant = $this->model::where('candidate_id',$r->candidate_id)->where('exam_id',$r->exam_id)->first();
        // if(!is_null($this->applicant)){
        //     Session::flash('error',"Please choose the subject from respective exam's table below");
        //     return true;
        // }else{
        //     return false;
        // }
        return false;
    }

    public function createEntry($r){
        if(is_null($this->applicant)){
            $this->applicant = $this->model::create([
                'approvedprogramme_id' => $r->approvedprogramme_id,
                'candidate_id'=> $r->candidate_id,
                'exam_id' =>  $r->exam_id
            ]);
        }
        $syear = \App\Subject::find($r->subject_id)->syear;
        if($r->exam_id == 25){
            $application = $this->applicationmodel::create([
                'candidate_id' => $r->candidate_id,
                'subject_id' => $r->subject_id,
                'internalattendance_id' => 1,
                'externalattendance_id' => 1,
                'internal_mark' => 0,
                'external_mark' => 0,
                "externalexamcenter_id" => 1,
                $this->applicant_id_field => $this->applicant->id
            ]);     
        }else{
            $application = $this->applicationmodel::create([
                'candidate_id' => $r->candidate_id,
                'exam_id' => $r->exam_id,
                'subject_id' => $r->subject_id,
                'internalattendance_id' => 1,
                'externalattendance_id' => 1,
                'internal_mark' => 0,
                'external_mark' => 0,
                'approvedprogramme_id' => $r->approvedprogramme_id,
                'term' => $syear,
                'language_id' => 2,
                "payment_status" => "Not Entered",
                "active_status" => 1,
                "status_id" => 6,
                "linkopen_number" => 1,
                "penalty" => "No",
                "externalexamcenter_id" => 1,
                $this->applicant_id_field => $this->applicant->id
            ]);     
        }   
        Session::flash('messages','Created' . $this->applicant->id . ', ' . $application->id);
    }
}
