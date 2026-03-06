<?php

namespace App\Http\Controllers\Institute\Exam;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Exam\ApplicantService; 
use App\Services\Common\HelperService;
use Session;
use App\Exam;
use PDF;

use App\Http\Requests\Backlog\StoreApplicantRequest;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $ApplicantService;
    protected $exam_id;
    protected $helperService;
    protected $exam;

    public function __construct(ApplicantService $applicant, HelperService $helper)
    {
        $this->middleware(['role:institute']);
        $this->ApplicantService = $applicant;
        $this->helperService = $helper;
        $this->initiate();

    }

    private function initiate(){
        $this->exam_id = Session::get('exam_id');
        $this->exam = Exam::find($this->exam_id);
        $this->ApplicantService->assignmodel($this->exam_id);
    }
    public function index(Request $r)
    {
        Session::put('exam_id',24);
        if($r->has('exam_id')){
            Session::put('exam_id',$r->exam_id);
        }
        $this->initiate();
        $r['institute_id'] = $this->helperService->getInstituteID();
        $institute = $this->ApplicantService->getInstitute($r);
        $apid = null;
        $ap = null;
        if($r->has('approvedprogramme_id')){
            $apid = $r->approvedprogramme_id;
            $ap= \App\Approvedprogramme::find($apid);
        }
        $applicants= $this->ApplicantService->getApplicants(100,$apid);
        $exam = $this->exam;
        
        return view('institute.exam.applicants.index',compact(
            'applicants',
            'exam',
            'ap'
        ));
    }

    public function show($id,Request $r)
    {
        $applicant = $this->ApplicantService->getApplicant($id);
        $candidate = \App\Candidate::find($applicant->candidate_id);
        if($r->has('practical')){
            if($r->has('term')){
                $term = $r->term;
            }else{
                Session::flash('error','Please select Term');
                return back();
            }
            $subjects = $this->ApplicantService->getEligiblePracticalSubjects($candidate->id,$term);
            if(count($subjects)==0){
                Session::flash('error','Internal marks not found or Failed in internal');
                return redirect('/institute/exam/applicants/?exam_id=25&approvedprogramme_id='.$candidate->approvedprogramme_id);
            }
            $institute = \App\Institute::find($candidate->approvedprogramme->institute_id);    
            if($r->has('downloadht')){
                $format = 'html';
                return view('common.exam.hallticket_p',compact(
                    'subjects',
                    'term',
                    'format',
                    'exam',
                    'institute',
                    'applicant'
                ));
            }

        }
        $applicant = $this->ApplicantService->getApplicant($id);
        $exam_center = $this->ApplicantService->getExamcenter($applicant->institute,2);
        $exam = $this->exam;

        $institute = \App\Institute::find($applicant->institute_id);
       /* if($applicant->candidate->approvedprogramme->transferred_to > 0){
            $institute = \App\Institute::find($applicant->candidate->approvedprogramme->transferred_to);
        }
        */
        if($r->has('downloadht') && $applicant->block !=1){
            
            $term = 0;
            $format = 'pdf';
            if($r->has('term')){
                $term = $r->term;
            }else{
                Session::flash('error','Please select Term');
                return back();
            }
            $format = 'html';
            /*if($applicant->candidate_id == 63025){
                return view('common.exam.hallticket_additional',compact(
                    'applicant',
                    'exam_center',
                    'term',
                    'format',
                    'exam',
                    'institute'
                ));    
            }*/
            return view('common.exam.hallticket_new',compact(
                'applicant',
                'exam_center',
                'term',
                'format',
                'exam',
                'institute'
            ));
            view()->share('applicant',$applicant);
            view()->share('exam_center',$exam_center);
            view()->share('term',$term);
            view()->share('format',$format);
            view()->share('exam',$exam);
            $headers = array(
                'Content-Type: application/pdf',
            );
            try{
                $format = 'html';
                return view('common.exam.hallticket_new',compact(
                    'applicant',
                    'exam_center',
                    'term',
                    'format',
                    'exam'
                ));
                //$pdf = PDF::loadView('common.exam.hallticket')->setPaper('a4', 'portrait');
                //return $pdf->download('hallticket_'.$applicant->candidate->enrolmentno.'_term_'.$term.'.pdf');
            }catch(\Exception $e){
                $format = 'html';
                return view('common.exam.hallticket_new',compact(
                    'applicant',
                    'exam_center',
                    'term',
                    'format',
                    'exam'
                ));
            }

        }
        
        $fy_count = $this->ApplicantService->getNumberOfPapers(1);
        $sy_count = $this->ApplicantService->getNumberOfPapers(2);
        

        return view('institute.exam.applicants.show',compact(
            'applicant',
            'exam',
            'exam_center',
            'fy_count',
            'sy_count'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
