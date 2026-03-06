<?php

namespace App\Http\Controllers\Nber;

use App\Application;
use App\Approvedprogramme;
use App\Candidate;
use App\Exam;
use App\Examtimetable;
use App\Externalexamcenter;
use App\Externalexamcenterdetail;
use App\Institute;
use App\Subject;
use FontLib\TrueType\Collection;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\Common\HelperService;
class ExamcenterController extends Controller
{
    // 
        private $helperService; 

    public function __construct(HelperService $helper)
    {
        
       $this->middleware(['role:nber']);
        $this->helperService =  $helper;
    }

    public function updateevaluationcenter(Request $r){

        $excevc = \App\Evaluationcenterdetail::where('exam_id',22)->where('externalexamcenter_id',$r->externalexamcenter_id)->first();
        if(is_null($excevc)){
            \App\Evaluationcenterdetail::create([
                'externalexamcenter_id' => $r->externalexamcenter_id,
                'evaluationcenter_id' => $r->evaluationcenter_id,
                'exam_id' => 22,
                'active_status' => 1
            ]);
        }else{
            $excevc->evaluationcenter_id = $r->evaluationcenter_id;
            $excevc->save();
        }
        return back();
    }

    public function email($id){
        $ec = \App\Externalexamcenter::where('code',$id)->first();
        return view('nber.letter',compact('ec'));
    }
    public function report(){
        $examcenters = DB::table('examstats')
                        ->select('*')
                        ->groupBy('externalexamcenter_id')
                        ->join()
                        ->get();
        return $examcenters;
    }
    public function index(){
        $collections = Externalexamcenter::paginate(1000);
    	$link = 'externalexamcenters';
        $text ="Examination Centers";
        $evaluationcenters = \App\Evaluationcenter::where('active_status',1)->get();
        return view('nber.examinationcenters.index',compact('collections','link','text','evaluationcenters'));
    }

    public function create(Request $r){
        Externalexamcenter::create([
            'code' => $r->code,
            'address' => $r->address,
            'state' => $r->state,
            'contactnumber1' => $r->contactnumber1,
            'email1' =>$r->email1,
            'cloname' => $r->cloname
        ]);
        return back();
    }

    public function update(Request $r){
        $examcenter = Externalexamcenter::find($r->id);
        $examcenter->update([
            'code' => $r->code,
            'address' => $r->address,
            'state' => $r->state,
            'contactnumber1' => $r->contactnumber1,
            'email1' =>$r->email1,
            'cloname' => $r->cloname
        ]);
        return back();
    }
    public function index_old() {
        $exam = Exam::where('id', '11')->first();

        $externalexamcenterdetails = Externalexamcenterdetail::select('externalexamcenterdetails.*')
            ->join("institutes", "institutes.id", "=", "externalexamcenterdetails.institute_id")
            ->join("externalexamcenters", "externalexamcenters.id", "=", "externalexamcenterdetails.externalexamcenter_id")
            ->where('externalexamcenterdetails.exam_id', $exam->id)
            ->where('active_status', '1')
            ->orderBy("externalexamcenters.code")
            ->orderBy("institutes.code")
            ->get();

        return view('nber.externalexamcenters.index', compact('externalexamcenterdetails', 'exam', 'externalexamcenters'));
    }

    public function download_students_count($e_id, $excenter_id) {
        $exam = Exam::where('id', $e_id)->first();
        $externalexamcenter = Externalexamcenter::where('id', $excenter_id)->first();

        $externalexamcenterdetail = Externalexamcenterdetail::where('exam_id', $exam->id)
            ->where('externalexamcenter_id', $externalexamcenter->id)->get();

        $institute_ids = $externalexamcenterdetail->pluck('institute_id')->toArray();

        $approvedprogramme_ids  = Approvedprogramme::whereIn('institute_id', $institute_ids)->pluck('id')->toArray();

        $applications = Application::select('id', 'subject_id', 'candidate_id')->where('exam_id', $exam->id)
            ->whereIn('approvedprogramme_id', $approvedprogramme_ids)->get();
        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();

        $examtimetables = Examtimetable::where('exam_id', $exam->id)->whereIn('subject_id', $subject_ids)->groupBy('startdate')->orderBy('startdate')->get();

        $examdates = Examtimetable::select('examdate')->where('exam_id', $exam->id)->whereIn('subject_id', $subject_ids)->groupBy('examdate')->orderBy('examdate')->get();

        return view('nber.externalexamcenters.downloadstudentscount', compact('exam','externalexamcenter', 'applications', 'examtimetables', 'examdates'));

    }

    public function download_students_count1($e_id, $excenter_id) {
        $exam = Exam::where('id', $e_id)->first();
        $externalexamcenter = Externalexamcenter::where('id', $excenter_id)->first();

        $externalexamcenterdetail = Externalexamcenterdetail::where('exam_id', $exam->id)
            ->where('externalexamcenter_id', $externalexamcenter->id)->get();

        $institute_ids = $externalexamcenterdetail->pluck('institute_id')->toArray();

        $approvedprogramme_ids  = Approvedprogramme::whereIn('institute_id', $institute_ids)->pluck('id')->toArray();

        $applications = Application::select('applications.id', 'applications.subject_id', 'applications.candidate_id')
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->where("subjects.subjecttype_id", 1)
            ->where('exam_id', $exam->id)
            ->whereIn('approvedprogramme_id', $approvedprogramme_ids)->get();
        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();
        $subjects = Subject::whereIn('id', $subject_ids)->get();

        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();

        $candidates = Candidate::whereIn('id', $candidate_ids)->get();

        $examtimetables = Examtimetable::where('exam_id', $exam->id)->whereIn('subject_id', $subject_ids)->orderBy('startdate')->get();

        $commonexamtimetables = Examtimetable::where('exam_id', $exam->id)->whereIn('subject_id', $subject_ids)->groupBy('startdate')->orderBy('startdate')->get();
        $examdates = Examtimetable::select('examdate')->where('exam_id', $exam->id)->whereIn('subject_id', $subject_ids)->groupBy('examdate')->orderBy('examdate')->get();

        return view('nber.externalexamcenters.sample', compact('exam','externalexamcenter', 'applications', 'examtimetables', 'examdates', 'candidates', 'subjects'));

    }

    public function show_attendance_list($e_id, $d_id) {
        $exam = Exam::where('id', $e_id)->first();
        $externalexamcenterdetail = Externalexamcenterdetail::where('id', $d_id)->first();

        $institute = Institute::where('id', $externalexamcenterdetail->institute_id)->first();

        $ap_ids = Approvedprogramme::where('institute_id', $institute->id)->pluck('id')->toArray();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->where('exam_id', $exam->id)->whereIn('approvedprogramme_id', $ap_ids)
            ->where("subjects.subjecttype_id", 1)
            ->get();

        $approvedprogramme_ids = $applications->unique('approvedprogramme_id')->pluck('approvedprogramme_id')->toArray();

        $candidate_ids = $applications->pluck("candidate_id")->toArray();

        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();

        $approvedprogrammes = Approvedprogramme::select("approvedprogrammes.*")
            ->join("academicyears", "academicyears.id", "=", "approvedprogrammes.academicyear_id")
            ->whereIn("approvedprogrammes.id", $approvedprogramme_ids)
            ->orderBy("academicyears.year")
            ->get();

        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();

        $examtimetables = Examtimetable::where('exam_id', $exam->id)->whereIn('subject_id', $subject_ids)->orderBy('startdate')->get();

        return view('nber.externalexamcenters.attendancelist', compact('exam', 'externalexamcenterdetail', 'applications', 'examtimetables', 'approvedprogrammes', 'candidates'));

        }

    public function show_attendance_list2($e_id, $d_id) {
        $exam = Exam::where('id', $e_id)->first();
        $externalexamcenterdetail = Externalexamcenterdetail::where('id', $d_id)->first();

        $institute = Institute::where('id', $externalexamcenterdetail->institute_id)->first();

        $ap_ids = Approvedprogramme::where('institute_id', $institute->id)->pluck('id')->toArray();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->where('exam_id', $exam->id)->whereIn('approvedprogramme_id', $ap_ids)
            ->where("subjects.subjecttype_id", 1)
            ->get();

        $approvedprogramme_ids = $applications->unique('approvedprogramme_id')->pluck('approvedprogramme_id')->toArray();

        $candidate_ids = $applications->pluck("candidate_id")->toArray();

        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();

        $approvedprogrammes = Approvedprogramme::select("approvedprogrammes.*")
            ->join("academicyears", "academicyears.id", "=", "approvedprogrammes.academicyear_id")
            ->whereIn("approvedprogrammes.id", $approvedprogramme_ids)
            ->orderBy("academicyears.year")
            ->get();

        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();

        $examtimetables = Examtimetable::where('exam_id', $exam->id)->whereIn('subject_id', $subject_ids)->orderBy('startdate')->get();

        return view('nber.externalexamcenters.attendancelist2', compact('exam', 'externalexamcenterdetail', 'applications', 'examtimetables', 'approvedprogrammes', 'candidates'));

    }

    public function showexams() {

    }

    
public function all_exam_center(){

    $nber_id = $this->helperService->getNberID();

    $institutes = DB::select("SELECT
    nbers.name_code,
		    institutes.rci_code,

		    institutes.`name`, 

    (SELECT count(*)
     FROM externalexamcenters
     WHERE externalexamcenters.institute_id = institutes.id) AS external_exam_centers,
		 
    institutes.id
FROM
    institutes
INNER JOIN
    approvedprogrammes
    ON institutes.id = approvedprogrammes.institute_id
INNER JOIN
    programmes
    ON approvedprogrammes.programme_id = programmes.id
INNER JOIN
    nbers
    ON nbers.id = programmes.nber_id WHERE institutes.active_status=1 and nbers.id='$nber_id' and institutes.id !='1004'
 
GROUP BY
    institutes.id order by external_exam_centers desc");

    // $institutes = DB::table('institutes')
    // ->join('approvedprogrammes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
    // ->join('programmes', 'approvedprogrammes.programme_id', '=', 'programmes.id')
    // ->join('nbers', 'nbers.id', '=', 'programmes.nber_id')
    // ->leftJoin('externalexamcenters', 'externalexamcenters.institute_id', '=', 'institutes.id')
    // ->select(
    //     'nbers.name_code',
    //     'institutes.rci_code',
    //     'institutes.name',
    //     DB::raw('COUNT(externalexamcenters.id) AS external_exam_centers'),
    //     'institutes.id'
    // )
    // ->where('institutes.active_status', 1)
    // ->groupBy('institutes.id')
    // ->orderByRaw('external_exam_centers DESC')
    // ->get();
    // print($institutes);
    // die();
    return view('nber.externalexamcenters.all-center',compact('institutes'));


}





}
