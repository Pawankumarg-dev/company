<?php
    namespace App\Http\Controllers\Student\Exam;

    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use App\Services\Common\HelperService;
    use App\Services\Applications\ExamService;
    use App\Studentlogin;
    use Session;

    class MainExamApplicationController extends Controller{

        private $examService;
        private $helperService;

        public function __construct(Request $r) {
            $this->examService = new ExamService();
            $this->helperService = new HelperService();
        }

        public function index(){
            $allapplications = \App\Allapplication::where('candidate_id',$this->helperService->getCandidateID())->where('blocked',0)->get();
            //return view('student.exam.result',compact('allapplications'));
            //return '';
            //return \Auth::user()->id;
            $exam = $this->examService->getExam();
            $subjects = $this->examService->getSubjects();
            //return $subjects;
            //return $this->helperService->getCandidateID();
            //return $subjects;
            //return $subjects->count();
            $languages = \App\Language::all();
            $applicant =  $this->examService->getApplicant();
            $login= Studentlogin::where('candidate_id',$this->helperService->getCandidateID())->first();
            $noofsubjects = 0;
            $reason = $this->examService->getReason();
            //return $reason;
            if(is_null($subjects)){
                $noofsubjects = null;
            }else{
                $noofsubjects = $subjects->count();
            }
            if(is_null($login)){
                Studentlogin::create([
                    'candidate_id' => $this->helperService->getCandidateID(),
                    'noofsubjects' => $noofsubjects
                ]);
            }
            $exception =  $this->examService->getabsentNPlusTwo();
            return view('student.exam.application',compact(
                'subjects',
                'exam',
                'languages',
                'applicant',
                'exception',
                'reason'
            ));
        }

        public function store(Request $r){
           

            $applicant = $this->examService->saveApplication();
          
            $payment = "Fresh";
            if(is_null($applicant)){
                $applicant = $this->examService->getApplicant();
                $payment = "Recheck";
                if($r->has('additional') && $r->additional > 0){
                    $this->examService->saveAdditionalPapers($r->additional);
                   Session::flash('messages',"Updated. Payment gateway currently not available, Kindly try again later.");
                   return redirect(url('student/exam/applications'));
                }
            }
            $candidate = $this->helperService->getCandidate();
            if($candidate->approvedprogramme->programme_id == 57){
                $applicant->payment_status = 1;
                $applicant->save();
                return redirect(url('student/exam/applications'));
            }
            if(!is_null($applicant)){
                $npte = $applicant->nplustwoexceptions()->first();
                if($r->exception == 1 &&  $npte->status != 1 ){
                    Session::flash('messages','Please make the payment once approved');
                    return redirect(url('student/exam/applications'));
                }else{
                    if(is_null($npte) || $npte->status == 1){
                       Session::flash('messages',"Payment gateway currently not available, Kindly try again later.");
                       return redirect(url('student/exam/applications'));
            
                        return view('student.exam.payonline',compact(
                            'candidate',
                            'applicant',
                            'payment'
                        ));
                    }
                }
            }
            Session::flash('messages',"Exam application are closed");
            return redirect(url('student/exam/applications'));
        }
    }