<?php

namespace App\Http\Controllers\Nber\Exam;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Exam\ApplicantService; 
use App\Services\Common\HelperService;
use Session;
use App\Exam;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

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
       $this->middleware(['role:nber']);
        $this->ApplicantService = $applicant;
        $this->exam_id = Session::get('exam_id');
        $this->exam = Exam::find($this->exam_id);
        $this->ApplicantService->assignmodel($this->exam_id);
        $this->helperService = $helper;

    }
    public function index(Request $r)
    {
        if($r->has('excel')){
            set_time_limit(300);
            $nber_id = $this->helperService->getNberID();
            $applications = $this->ApplicantService->getAllapplications($nber_id);
            Excel::create('applications', function ($excel) use($applications){
                $excel->sheet('applications', function ($sheet) use($applications){
                    $sheet->loadview('nber.exam.applicants.excel',[
                        'applications' => $applications
                    ]);
                });
            })->export('xls');
        }
        $programme = $this->ApplicantService->getProgramme($r);
        $institute = $this->ApplicantService->getInstitute($r);
        $academicyear = $this->ApplicantService->getAcademicyear($r);
        $applicants= $this->ApplicantService->getApplicants(100);

        $programmes = $this->helperService->getProgrammes(1);
        $institutes = $this->ApplicantService->getInstitutes();
        $academicyears = \App\Academicyear::where('id','>',6)->where('id','<',12)->get();
        $exam = $this->exam;
        $nber = $this->helperService->getNberShortCode();
      
        return view('nber.exam.applicants.index',compact(
            'applicants',
            'programmes',
            'institutes',
            'exam',
            'programme',
            'institute',
            'academicyears',
            'academicyear',
            'nber'
        ));
    }

    public function show($id,Request $r)
    {
        $applicant = $this->ApplicantService->getApplicant($id);
        $exam_center = $this->ApplicantService->getExamcenter($applicant->institute,2);
        $exam = $this->exam;

        $institute = \App\Institute::find($applicant->institute_id);
        if($applicant->candidate->approvedprogramme->transferred_to > 0){
            $institute = \App\Institute::find($applicant->candidate->approvedprogramme->transferred_to);
        }
        

        if($r->has('downloadht')){
            $format = 'pdf';
            $term = 0;
            if($r->has('term')){
                $term = $r->term;
            }else{
                Session::flash('error','Please select Term');
                return back();
            }
            if($applicant->candidate_id == 63025){
                return view('common.exam.hallticket_additional',compact(
                    'applicant',
                    'exam_center',
                    'term',
                    'format',
                    'exam',
                    'institute'
                ));    
            }

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
                $pdf = PDF::loadView('common.exam.hallticket')->setPaper('a4', 'portrait');
                return $pdf->download('hallticket_'.$applicant->candidate->enrolmentno.'_term_'.$term.'.pdf');
            }catch(\Exception $e){
                $format = 'html';
                
                return view('common.exam.hallticket',compact(
                    'applicant',
                    'exam_center',
                    'term',
                    'format'
                ));
            }

        }
        
        $fy_count = $this->ApplicantService->getNumberOfPapers(1);
        $sy_count = $this->ApplicantService->getNumberOfPapers(2);
        

        return view('nber.exam.applicants.show',compact(
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
