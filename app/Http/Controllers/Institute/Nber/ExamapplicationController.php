<?php
namespace App\Http\Controllers\Nber;
use App\Academicyear;
use App\Approvedprogramme;
use App\Candidate;
use App\Examinationfee;
use App\Examinationpayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Application;
use App\Subject;
use App\Institute;
use App\Status;
use App\Programme;
use App\Exam;
use Session;
use DB;

class ExamapplicationController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }
    /*
    public function index(Request $request){
        $examlist = Exam::where('academicyear_id', Session::get('academicyear_id'))->pluck('id')->toArray();
        $collections = Application::whereIn('exam_id',$examlist)
                       ->select('applications.*', DB::raw('group_concat(subject_id) as subjects'))
                       ->groupBy('candidate_id');
        $text = 'Exam Applications';

        if($request->has('i')){
            $i = $request->i;
            $collections = $collections->whereHas('approvedprogramme',function($q) use($i){
                $q->where('institute_id',$i);
            });
            $ccode = Institute::find($i)->user->username;
            $text .=  ' - '. $ccode;
            $breadcrumblinkto = 'programmeapplications?i='. $i;
            $breadcrumblinktext = " Programme List - " . $ccode;
        }
        if($request->has('p')){
            $p = $request->p;
            $collections = $collections->whereHas('approvedprogramme',function($q) use($p){
                $q->where('programme_id',$p);
            });
            $text .= ' - '. Programme::find($p)->course_name;
        }
        if($request->has('s')){
            $collections = $collections->where('status_id',$request->s);
            $text .= ' - '.  Status::find($request->s)->status;
        }

        $collections = $collections->paginate(20);

        $link = 'examapplications';
        $subjects = Subject::all();
        return view('nber.applications.exam',compact('collections','text','link','subjects','breadcrumblinkto','breadcrumblinktext'));
    }
    public function updatestatus($id,Request $request){
        //echo $id;
        $applications = Application::where('candidate_id',$request->cid);
        $applications->update(['status_id'=>$id]);
        return back();
        echo json_encode($request->all());
    }
    public function index() {
        $exams = Exam::orderBy('date', 'desc')->get();

        return view('nber.examapplications.index', compact('exams'));
    }
    */


    public function showbatches($e_id) {
        $exam = Exam::where('id', $e_id)->first();

        //$applications = Application::where('exam_id', $exam->id)->select('id', 'approvedprogramme_id', 'subject_id')->get();
        //$ap_ids = $applications->unique('approvedprogramme_id')->pluck('approvedprogramme_id')->toArray();

        $ap_ids = Application::where('exam_id', $exam->id)->groupBy('approvedprogramme_id')->pluck('approvedprogramme_id')->toArray();

         $approvedprogrammes = Approvedprogramme::select('approvedprogrammes.id', 'approvedprogrammes.institute_id', 'approvedprogrammes.programme_id', 'approvedprogrammes.academicyear_id')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->whereIn('approvedprogrammes.id', $ap_ids)->orderBy('institutes.code')->orderBy('programmes.sortorder')
            ->orderBy('academicyears.year', 'desc')
            ->get();


         /*
        $i_ids = $approvedprogrammes->pluck('institute_id')->toArray();
        $p_ids = $approvedprogrammes->pluck('programme_id')->toArray();
        $ay_ids = $approvedprogrammes->pluck('academicyear_id')->toArray();

        $institutes = Institute::whereIn('id', $i_ids)->orderBy('code')->get();
        $programmes = Programme::whereIn('id', $p_ids)->orderBy('sortorder')->get();
        $academicyears = Academicyear::whereIn('id', $ay_ids)->orderBy('year')->get();
         */

        return view('nber.examapplications.showbatches', compact('exam', 'approvedprogrammes'));
    }

    public function showcandidates($e_id, $ap_id) {
        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $candidate_ids = Candidate::where('approvedprogramme_id', $approvedprogramme->id)->pluck('id')->toArray();

        $applications = Application::where('exam_id', $exam->id)->whereIn('candidate_id', $candidate_ids)->get();
        $applied_candidateids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();

        $candidates = Candidate::whereIn('id', $applied_candidateids)->orderBy('enrolmentno')->get();

        return view('nber.examapplications.showcandidates', compact('exam', 'approvedprogramme', 'candidates', 'applications'));
    }

    public function showapplications($e_id, $c_id) {
        $exam = Exam::where('id', $e_id)->first();

        $candidate = Candidate::where('id', $c_id)->first();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->join("candidates", "candidates.id", "=", "applications.candidate_id")
            ->where('exam_id', $exam->id)->where('candidate_id', $candidate->id)
            ->orderBy('subjects.syear', 'desc')
            ->orderBy('subjects.subjecttype_id')
            ->orderBy('subjects.sortorder')->get();

        return view('nber.examapplications.showapplications', compact('exam', 'candidate', 'applications'));
    }

    public function deleteapplication($app_id) {
        $application = Application::where('id', $app_id)->first();
        $candidate = $application->candidate;
        $exam = $application->exam;

        $application->delete();

        if(Application::where('exam_id', $exam->id)->where('candidate_id', $candidate->id)->count() == '0') {
            $examinationfee = Examinationfee::where('exam_id', $exam->id)->where('programme_id', $candidate->approvedprogramme->programme_id)->where('academicyear_id', $candidate->approvedprogramme->academicyear_id)->first();

            $examinationpayment = Examinationpayment::where('examinationfee_id', $examinationfee->id)->where('candidate_id', $candidate->id)->first();

            if(!is_null($examinationpayment))
                $examinationpayment->delete();

            return redirect('/nber/examapplications/'.$exam->id.'/show-candidates/'.$candidate->approvedprogramme_id);
        }

        return back();
    }

    public function applicationcount($ap_id, $exam_id) {

        $applications = Application::where('exam_id', $exam_id)->where('approvedprogramme_id', $ap_id)->get();

        return $applications;
    }

    public function showapplieddetails($eid){
        if(Exam::where('id', $eid)->count() === 0) {
            return redirect('/nber/exams');
        }
    }
}
