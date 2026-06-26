<?php

namespace App\Http\Controllers\Institute\Exam;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Exam\ApplicantService; 
use App\Services\Common\HelperService;
use Session;
use App\Exam;
use App\Affiliationfee;
use App\Practicalexam;
use PDF;
use App\Attendance;
use App\Http\Requests\Backlog\StoreApplicantRequest;
use DB;
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






        Session::put('exam_id',29); 
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
        // $applicants= $this->ApplicantService->getApplicants(100,$apid);
        $applicants = \App\Allapplicant::where('exam_id',$this->exam_id)->whereHas('candidate',function($q) use($apid) {
            $q->where('approvedprogramme_id',$apid);
        })->paginate(100);
        $exam = $this->exam;
       // return $applicants;



//        if ($ap->programme_id != 57) {

//     $totalAmount = Affiliationfee::where('approvedprogramme_id', $ap->id)
//         ->where('orderstatus_id', 1)
//         ->sum('amount');

//     if ($ap->academicyear_id == 14) {
//         $amount = 10000;
//     } else {
//         $amount = $ap->programme->numberofterms * 10000;
//     }
//     if ($totalAmount < $amount) {
//     Session::flash(
//     'error',
//     'If the affiliation fee has not been paid, please go to the Payment section and complete the payment.If offline or neft  paid, please go to the Payment section and select offline payment. It will be considered after verification; otherwise, we may block marksheet and certificate details. If the affiliation fee has already been paid but the transaction is still incomplete, please contact RCI-NBER. '
// );
      
//         return back();
//     }
// }

$maped = DB::table('approvedprogrammes')
    ->join('programmes', 'approvedprogrammes.programme_id', '=', 'programmes.id')
    ->join('subjects', 'programmes.id', '=', 'subjects.programme_id')
    ->join('candidates', 'candidates.id', '=', 'approvedprogrammes.id')
    
    // Fixed: Using a closure to handle multiple join conditions properly
    ->join('allapplications', function ($join) {
        $join->on('allapplications.candidate_id', '=', 'candidates.id')
             ->on('subjects.id', '=', 'allapplications.subject_id')
             ->where('allapplications.exam_id', '=', 29); // Assuming examid belongs to allappcations
    })

    ->leftJoin('practicalexams', function ($join) {
        $join->on('approvedprogrammes.institute_id', '=', 'practicalexams.institute_id')
             ->on('approvedprogrammes.programme_id', '=', 'practicalexams.programme_id')
             ->whereNull('practicalexams.deleted_at');
    })
    ->leftJoin('practicalexam_subject', 'practicalexams.practicalexaminer_id', '=', 'practicalexam_subject.practicalexam_id')
    ->where('approvedprogrammes.id', $apid)
    ->select([
        DB::raw('COUNT(DISTINCT subjects.id) as total_subject'),
        DB::raw('COUNT(DISTINCT practicalexam_subject.subject_id) as mapped_subject')
    ])
    ->first();
if ($maped->total_subject != $maped->mapped_subject) {
    Session::flash('error', 'Exam Not schedule in 1st slot Please contact consern NBER.');
    return back();
}







        return view('institute.exam.applicants.index',compact(
            'applicants',
            'exam',
            'ap'
        ));
    }

    public function show($id,Request $r)
    {              
         
        if($this->exam_id >30){
            Session::flash('error','Please select valid exam');
            return back();
        }

        // return $id;
        $applicant = $this->ApplicantService->getApplicant($id);

       
        $candidate = \App\Candidate::find($applicant->candidate_id);
        $institute = \App\Institute::find($this->helperService->getInstituteID());
        $exam = $this->exam;
        if($r->has('practical')){
            if($r->has('term')){
                $term = $r->term;
            }else{
                Session::flash('error','Please select Term');
                return back();
            }
            if($candidate->status_id !=2){
                Session::flash('error','Document verification is pending contact to consern NBER');
                return back();
            }


        //         $enrollemnt = \App\Enrolmentfeepayment::where('candidate_id', $candidate->id)->first();
        //     if ($candidate->approvedprogramme->academicyear_id==14 && (!$enrollemnt || $enrollemnt->orderstatus_id != 1)) {

        //    session::flash('error','Enrolment Payment not Done');
        //         return back();
        //     }
            // if ($applicant->payment_status != 1) {
            //     Session::flash('error', 'Examination Payment not Done');
            //     return back();
            // }


            
              if($applicant->first_year_practical_ht < 1 && $applicant->second_year_practical_ht < 1 ){
                Session::flash('error','Not Generated contact to consern NBER');
                return back();
            }

            if(!file_exists(public_path().'/files/enrolment/photos/'.$applicant->candidate->photo)){
                Session::flash('error','Photo not found contact to consern NBER');
                return back();
            }
            if(!file_exists(public_path().'/files/enrolment/signature/'.$applicant->candidate->signature)){
                Session::flash('error','Signature not found contact to consern NBER');
                return back();
            }





            $atten = Attendance::where('candidate_id', $candidate->id)
                ->where('attendance_p', '>=', 75)
                ->count();
            // $numberOfTerms = $candidate->approvedprogramme->programme->numberofterms ?? 0;
            // if ($atten < $numberOfTerms && $candidate->approvedprogramme->academicyear_id != 14){ 
            //     Session::flash('error', 'Attendance is less than 75%');
            //     return back();
            // }
          
            //  if ($candidate->approvedprogramme->academicyear_id == 14 && $atten < 1){ 
            //     Session::flash('error', 'Attendance is less than 75%');
            //     return back();
            // }



            $slot = Practicalexam::where('exam_id', 29)
                ->where('institute_id', $candidate->approvedprogramme->institute_id)
                ->where('programme_id', $candidate->approvedprogramme->programme_id)
                ->first();

            if (!$slot || $slot->slot != 1) {
                Session::flash(
                    'error',
                    'Hall ticket download will be available only after the theory examination. For further assistance, please contact to consern NBER.'
                );
                return back();
            }

            $ht = \App\Practicalhallticket::where('candidate_id',$applicant->candidate_id)->where('exam_id',$this->exam_id)->first();
            $ht->downloaded = 1;
            $ht->save();

            if($r->has('downloadht')){
                $format = 'html';

                if($applicant->candidate->approvedprogramme->programme_id == 57){
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


        $applicant = $this->ApplicantService->getApplicant($id);
        $district_id = $applicant->candidate->district_id;

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
            // if($applicant->first_year_theory_ht == 0 && $applicant->second_year_theory_ht == 0 ){
            //     Session::flash('error','Not Generated');
            //     return back();
            // }
            // if(!file_exists(public_path().'/files/enrolment/photos/'.$applicant->candidate->photo)){
            //     Session::flash('error','Photo not found');
            //     return back();
            // }
            // if(!file_exists(public_path().'/files/enrolment/signature/'.$applicant->candidate->signature) || is_null($applicant->candidate->signature) || $applicant->candidate->signature == ''){
            //     Session::flash('error','Signature not found');
            //     return back();
            // }
            $ht = \App\Hallticket::where('candidate_id',$applicant->candidate_id)->where('exam_id',$this->exam_id)->first();
            $ht->downloaded = 1;
            $ht->save();

            $exam_center = \App\Examcenter::where('id',$ht->examcenter_id)->first();

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
