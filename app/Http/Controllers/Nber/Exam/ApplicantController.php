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
    protected $case;

    public function __construct(ApplicantService $applicant, HelperService $helper)
    {
       $this->middleware(['role:nber']);
        $this->ApplicantService = $applicant;
        $this->exam_id = Session::get('exam_id');
        $this->exam = Exam::find($this->exam_id);
        $this->ApplicantService->assignmodel($this->exam_id);
        $this->helperService = $helper;
        $this->case = app()->request->has('case') ? app()->request->case : 'all';
    }
    public function index(Request $r)
    {
        $nber_id = $this->helperService->getNberID();
        if($r->has('ttiwiseexcel')){
	        ini_set('memory_limit','-1');
            $applications = $this->ApplicantService->getTheoryStats($nber_id);
            //return $applications[1];
            Excel::create('applications', function ($excel) use($applications){
                $excel->sheet('applications', function ($sheet) use($applications){
                    $sheet->loadview('nber.exam.applicants.ttiwiseexcel',[
                        'applications' => $applications  
                    ]);
                });
            })->export('xls');
        }
        // if($r->has('excel')){
        //     set_time_limit(300);
        //     $nber_id = $this->helperService->getNberID();
        //     $applications = $this->ApplicantService->getAllapplications($nber_id);
        //     Excel::create('applications', function ($excel) use($applications){
        //         $excel->sheet('applications', function ($sheet) use($applications){
        //             $sheet->loadview('nber.exam.applicants.excel',[
        //                 'applications' => $applications
        //             ]);
        //         });
        //     })->export('xls');
        // }
        $programme = $this->ApplicantService->getProgramme($r);
        $institute = $this->ApplicantService->getInstitute($r);
        $academicyear = $this->ApplicantService->getAcademicyear($r);
        if($r->has('excel')){
            set_time_limit(300);

            ini_set('memory_limit','-1');
            ini_set('max_execution_time',300);
            $applicants= $this->ApplicantService->getApplicants(0);
            Excel::create('applications', function ($excel) use($applicants){
                $excel->sheet('applications', function ($sheet) use($applicants){
                    $sheet->loadview('nber.exam.applicants.excel',[
                        'applicants' => $applicants
                    ]);
                });
            })->export('xls');
        }
        if($r->has('allapplications')){
            set_time_limit(300);
            ini_set('memory_limit','-1');
            ini_set('max_execution_time',300);
            $applications = $this->ApplicantService->getAllapplications($nber_id);
            Excel::create('applications', function ($excel) use($applications){
                $excel->sheet('applications', function ($sheet) use($applications){
                    $sheet->loadview('nber.exam.applicants.excelallapplications',[
                        'applications' => $applications
                    ]);
                });
            })->export('xls');
        }
        //$applicants= $this->ApplicantService->getApplicants(100);
        //$programme_ids = $this->ApplicantService->getProgrammeIDs();
        //return 'B4';
        $nber_id = $this->helperService->getNberID();
        if($r->has('programme_id')){
            $programme_id = $r->programme_id;
            $applicants = \App\Allapplicant::where('exam_id',$this->exam_id)->whereHas('candidate',function($q) use($nber_id, $programme_id) {
                $q->whereHas('approvedprogramme',function($p) use($nber_id, $programme_id){
                    $p->where('programme_id',$programme_id);
                });
            })->paginate(100);
            if($r->has('institute_id')){
                $institute_id = $r->institute_id;
                $programme_id = $r->programme_id;
                $applicants = \App\Allapplicant::where('exam_id',$this->exam_id)->whereHas('candidate',function($q) use($nber_id, $institute_id, $programme_id) {
                    $q->whereHas('approvedprogramme',function($p) use($nber_id, $institute_id,$programme_id){
                        $p->where('institute_id',$institute_id);
                        $p->where('programme_id',$programme_id);
                    });
                })->paginate(100);
            }

        }else{
            if($r->has('institute_id')){
                $institute_id = $r->institute_id;
                $applicants = \App\Allapplicant::where('exam_id',$this->exam_id)->whereHas('candidate',function($q) use($nber_id, $institute_id) {
                    $q->whereHas('approvedprogramme',function($p) use($nber_id, $institute_id){
                        $p->where('institute_id',$institute_id);
                        
                    });
                })->paginate(100);

            }else{
                $applicants = \App\Allapplicant::where('exam_id',$this->exam_id)->whereHas('candidate',function($q) use($nber_id) {
                    $q->whereHas('approvedprogramme',function($p) use($nber_id){
                        $p->whereHas('programme', function ($s) use ($nber_id){
                            $s->where('nber_id',$nber_id);
                        });
                    });
                })->paginate(100);
            }
        }

     //   return $applicants;
        //return $applicants->paginate(100);

        $programmes = $this->helperService->getProgrammes();
        
        //$programme_ids = $this->helperService->getProgrammes(1)->pluck('id')->toArray();

        $institute_ids = \App\Approvedprogramme::whereHas('programme', function($q) use ($nber_id){
            $q->where('nber_id',$nber_id);
            $q->where('academicyear_id','>',8);
        })->pluck('institute_id')->unique()->toArray();

        
        $institutes = \App\Institute::whereIn('id',$institute_ids)->get();

        //$institutes = $this->ApplicantService->getInstitutes();
        $academicyears = \App\Academicyear::where('id','>',7)->where('id','<',12)->get();
        $exam = $this->exam;
        $nber = $this->helperService->getNberShortCode();
        $case = $this->case;
        //return $case;
        return view('nber.exam.applicants.index',compact(
            'applicants',
            'programmes',
            'institutes',
            'exam',
            'programme',
            'institute',
            'academicyears',
            'academicyear',
            'nber',
            'case'
        ));
    }

    public function show($id,Request $r)
    {
        $applicant = $this->ApplicantService->getApplicant($id);

        $exam_center = null;

        //$exam_center = $this->ApplicantService->getExamcenter($applicant->institute,2);
        $exam = $this->exam;

        $institute = \App\Institute::find($applicant->institute_id);
        if($applicant->candidate->approvedprogramme->transferred_to > 0){
            $institute = \App\Institute::find($applicant->candidate->approvedprogramme->transferred_to);
        }
        
	 if($r->has('practical')){
            if($r->has('term')){
                $term = $r->term;
            }else{
                Session::flash('error','Please select Term');
                return back();
            }

            if($applicant->first_year_practical_ht < 1 && $applicant->second_year_practical_ht < 1 ){
                Session::flash('error','Not Generated');
                return back();
            }
            if(!file_exists(public_path().'/files/enrolment/photos/'.$applicant->candidate->photo)){
                Session::flash('error','Photo not found');
                return back();
            }
            $ht = \App\Practicalhallticket::where('candidate_id',$applicant->candidate_id)->where('exam_id',27)->first();
          //  $ht->downloaded += 2;
           // $ht->save();
           // $exam_center = $this->ApplicantService->getExamcenter($applicant->institute,2);
            $exam = $this->exam;

            if($r->has('downloadht')){
                $format = 'html';
                if($applicant->candidate->approvedprogramme->institute_id == 1057){
                    return view('common.exam.hallticket_p_cbid',compact(
                        'term',
                        'format',
                        'exam',
                        'institute',
                        'applicant'
                    ));    
                }
                return view('common.exam.hallticket_p',compact(
                    'term',
                    'format',
                    'exam',
                    'institute',
                    'applicant'
                ));
            }

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
            // if($applicant->candidate_id == 63025){
            //     return view('common.exam.hallticket_additional',compact(
            //         'applicant',
            //         'exam_center',
            //         'term',
            //         'format',
            //         'exam',
            //         'institute'
            //     ));    
            // }

            // if($applicant->first_year_theory_ht == 0 && $applicant->second_year_theory_ht == 0 ){
            //     Session::flash('error','Not Generated');
            //     return back();
            // }
            if(!file_exists(public_path().'/files/enrolment/photos/'.$applicant->candidate->photo)){
                Session::flash('error','Photo not found');
                return back();
            }
            if(!file_exists(public_path().'/files/enrolment/signature/'.$applicant->candidate->signature) || is_null($applicant->candidate->signature) || $applicant->candidate->signature == ''){
                Session::flash('error','Signature not found');
                return back();
            }
            
                $ht = \App\Hallticket::where('candidate_id',$applicant->candidate_id)->where('exam_id',27)->first();
              // $ht->downloaded += 2;
               // $ht->save();
            
            
            $district_id = $applicant->candidate->district_id;
            $exam_center = $this->ApplicantService->getExamcenter($applicant->institute,2,$district_id);
            $exam = $this->exam;
    
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
                
                return view('common.exam.hallticket_new',compact(
                    'applicant',
                    'exam_center',
                    'term',
                    'format',
                    'exam'

                ));
            }

        }
        
        //$fy_count = $this->ApplicantService->getNumberOfPapers(1);
        //$sy_count = $this->ApplicantService->getNumberOfPapers(2);
        $fy_count = 0;
        $sy_count = 0;

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
