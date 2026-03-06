<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;
use App\Application;
use App\Approvedprogramme;
use App\Exam;
use App\Institute;
use App\Mark;
use App\Programme;
use App\Subject;
use App\Candidate;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Session;
class MarkVerifyController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function show_applied_list($e_id) {
        $exam = Exam::where('id', $e_id)->first();

        $ap_ids = Application::where('exam_id', $exam->id)->groupBy('approvedprogramme_id')->pluck('approvedprogramme_id')->toArray();

        $approvedprogrammes = Approvedprogramme::select('approvedprogrammes.id', 'approvedprogrammes.institute_id', 'approvedprogrammes.programme_id', 'approvedprogrammes.academicyear_id')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->whereIn('approvedprogrammes.id', $ap_ids)->orderBy('institutes.code')->orderBy('programmes.sortorder')
            ->orderBy('academicyears.year', 'desc')
            ->get();

        return view('nber.exammarksverify.show_applied_list', compact('exam', 'approvedprogrammes'));
    }

    public function show_marks($e_id, $ap_id) {
        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $applications = Application::where('exam_id', $exam->id)->where('approvedprogramme_id', $approvedprogramme->id)
            ->get();

        $application_ids = $applications->pluck('id')->toArray();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();
        $subjects = Subject::whereIn('id', $subject_ids)->orderBy('syear')->orderBy('subjecttype_id')
            ->orderBy('sortorder')->get();

        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();
        $candidates = Candidate::whereIn('id', $candidate_ids)->orderBy('enrolmentno')->whereNotNull('enrolmentno')->get();

        return view('nber.marksverify.verifymarks', compact('exam', 'approvedprogramme', 'applications', 'subjects', 'candidates', 'marks'));

    }

    public function view_internal_theory_marks($e_id, $ap_id) {
        $title = "Internal Theory";

        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->join("candidates", "candidates.id", "=", "applications.candidate_id")
            ->where('applications.exam_id', $exam->id)->where('applications.approvedprogramme_id', $approvedprogramme->id)
            ->where('subjects.subjecttype_id', '=', '1')
            ->whereNotNull('candidates.enrolmentno')
            ->orderBy('candidates.enrolmentno')
            ->orderBy('subjects.subjecttype_id')
            ->orderBy('subjects.syear', 'desc')
            ->orderBy('subjects.sortorder')->get();

        $application_ids = $applications->pluck('id')->toArray();
        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();
        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();

        $subjects = Subject::whereIn('id', $subject_ids)->orderBy('syear')->orderBy('sortorder')->get();
        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        return view('nber.exammarksverify.viewinternaltheorymarks', compact('exam', 'approvedprogramme', 'applications', 'marks', 'subjects', 'candidates', 'title'));

    }

    public function view_external_theory_marks($e_id, $ap_id) {
        /*
        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $subjects = Subject::where('programme_id', $approvedprogramme->programme->id)->where('subjecttype_id', '1')
            ->orderBy('syear')->orderBy('sortorder')->get();
        $subject_ids = $subjects->pluck('id')->toArray();

        $applications = Application::where('approvedprogramme_id', $approvedprogramme->id)->whereIn('subject_id', $subject_ids)->get();

        $application_ids = $applications->pluck('id')->toArray();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();
        $candidates = Candidate::whereIn('id', $candidate_ids)->orderBy('enrolmentno')->whereNotNull('enrolmentno')->get();

        return view('nber.exammarksverify.theory_marks', compact('exam', 'approvedprogramme', 'applications', 'subjects', 'candidates', 'marks'));
        */

        $title = "External Theory";

        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->join("candidates", "candidates.id", "=", "applications.candidate_id")
            ->where('applications.exam_id', $exam->id)->where('applications.approvedprogramme_id', $approvedprogramme->id)
            ->where('subjects.subjecttype_id', '=', '1')
            ->whereNotNull('candidates.enrolmentno')
            ->orderBy('candidates.enrolmentno')
            ->orderBy('subjects.subjecttype_id')
            ->orderBy('subjects.syear', 'desc')
            ->orderBy('subjects.sortorder')->get();

        $application_ids = $applications->pluck('id')->toArray();
        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();
        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();

        $subjects = Subject::whereIn('id', $subject_ids)->orderBy('syear')->orderBy('sortorder')->get();
        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        return view('nber.exammarksverify.viewexternaltheorymarks', compact('exam', 'approvedprogramme', 'applications', 'marks', 'subjects', 'candidates', 'title'));

    }

    public function view_internal_practical_marks($e_id, $ap_id) {
        $title = "Internal Practical";

        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->join("candidates", "candidates.id", "=", "applications.candidate_id")
            ->where('applications.exam_id', $exam->id)->where('applications.approvedprogramme_id', $approvedprogramme->id)
            ->where('subjects.subjecttype_id', '=', '2')
            ->whereNotNull('candidates.enrolmentno')
            ->orderBy('candidates.enrolmentno')
            ->orderBy('subjects.subjecttype_id')
            ->orderBy('subjects.syear', 'desc')
            ->orderBy('subjects.sortorder')->get();

        $application_ids = $applications->pluck('id')->toArray();
        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();
        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();

        $subjects = Subject::whereIn('id', $subject_ids)->orderBy('syear')->orderBy('sortorder')->get();
        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        return view('nber.exammarksverify.viewinternalpracticalmarks', compact('exam', 'approvedprogramme', 'applications', 'marks', 'subjects', 'candidates', 'title'));
    }

    public function view_external_practical_marks($e_id, $ap_id) {
        $title = "External Practical";

        $exam = Exam::where('id', $e_id)->first();

        $approvedprogramme = Approvedprogramme::where('id', $ap_id)->first();

        $applications = Application::select("applications.*")
            ->join("subjects", "subjects.id", "=", "applications.subject_id")
            ->join("candidates", "candidates.id", "=", "applications.candidate_id")
            ->where('applications.exam_id', $exam->id)->where('applications.approvedprogramme_id', $approvedprogramme->id)
            ->where('subjects.subjecttype_id', '=', '2')
            ->whereNotNull('candidates.enrolmentno')
            ->orderBy('candidates.enrolmentno')
            ->orderBy('subjects.subjecttype_id')
            ->orderBy('subjects.syear', 'desc')
            ->orderBy('subjects.sortorder')->get();

        $application_ids = $applications->pluck('id')->toArray();
        $candidate_ids = $applications->unique('candidate_id')->pluck('candidate_id')->toArray();
        $subject_ids = $applications->unique('subject_id')->pluck('subject_id')->toArray();

        $subjects = Subject::whereIn('id', $subject_ids)->orderBy('syear')->orderBy('sortorder')->get();
        $candidates = Candidate::whereIn('id', $candidate_ids)->whereNotNull('enrolmentno')
            ->orderBy('enrolmentno')->get();
        $marks = Mark::whereIn('application_id', $application_ids)->get();

        return view('nber.exammarksverify.viewexternalpracticalmarks', compact('exam', 'approvedprogramme', 'applications', 'marks', 'subjects', 'candidates', 'title'));
    }



    public function verify_marks_re()
{

            $exam_id = 27;
        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;


                 $subjects = DB::table('reevaluationapplicationsubjects AS rs')
                    ->join('reevaluationapplications AS ra','rs.reevaluationapplication_id','=','ra.id')
                    ->join('subjects as s','s.id','=','rs.subject_id')
                    ->join('examcenters AS ec',function($join) use ($exam_id){
                $join->on('ec.institute_id','=','ra.institute_id');
                $join->where('ec.exam_id','=',$exam_id);
            })
              ->join('externalexamcenters', 'externalexamcenters.id','=','ec.externalexamcenter_id')
                    ->join('evaluationcenterdetails as ed',function($join) use ($exam_id){
                        $join->on('ed.externalexamcenter_id','=','ec.externalexamcenter_id');
                        $join->where('ed.exam_id','=',$exam_id);
                    })
                    ->join('evaluationcenters AS ev', 'ev.id', '=', 'ed.evaluationcenter_id')
                    ->where('ra.orderstatus_id',1)
                    ->where('rs.exam_id',$exam_id)
                     ->where('ra.nber_id',$nber_id)
                    ->whereNull('rs.verified')

                     
                    ->selectRaw('s.sname,s.scode,ev.name,ed.evaluationcenter_id,s.id')
                    ->groupBy('ev.id', 's.id')
                    ->orderBy('ev.name')
                    ->orderBy('s.id')
                    ->get();

    return view('nber.exammarksverify.reevalutionmarkverify', compact('subjects'));
}

public function verify_marks_re_show(Request $request){
            $exam_id = 27;
$sid=$request->id;
     $subjects = DB::table('reevaluationapplicationsubjects AS rs')
                    ->join('reevaluationapplications AS ra','rs.reevaluationapplication_id','=','ra.id')
                    ->join('subjects as s','s.id','=','rs.subject_id')
                    ->join('examcenters AS ec',function($join) use ($exam_id){
                $join->on('ec.institute_id','=','ra.institute_id');
                $join->where('ec.exam_id','=',$exam_id);
            })
              ->join('externalexamcenters', 'externalexamcenters.id','=','ec.externalexamcenter_id')
                    ->join('evaluationcenterdetails as ed',function($join) use ($exam_id){
                        $join->on('ed.externalexamcenter_id','=','ec.externalexamcenter_id');
                        $join->where('ed.exam_id','=',$exam_id);
                    })

                      ->join('allapplications AS na', function($join) use ($exam_id, $sid) {
                    $join->on('na.candidate_id', '=', 'rs.candidate_id');
                    $join->where('na.exam_id', '=', $exam_id);
                    $join->whereNull('na.deleted_at');
                    $join->where('na.subject_id', '=', $sid);
                }) 
                
                    ->join('evaluationcenters AS ev', 'ev.id', '=', 'ed.evaluationcenter_id')
                    ->where('ra.orderstatus_id',1)
                    ->where('rs.exam_id',$exam_id)
                     ->where('ed.evaluationcenter_id',$request->evaluationcenter_id)
                     ->where('rs.subject_id',$request->id)
                    ->selectRaw('rs.actual_marks,rs.reevaluation_applystatus,rs.retotalling_applystatus,s.sname,na.dummy_number,ed.evaluationcenter_id,rs.subject_id,rs.reevaluated_marks,rs.no_change')
                    ->groupBy('rs.id')
                    ->orderBy('ev.name')
                    ->orderBy('s.id')
                    ->get();

        return view('nber.exammarksverify.reevalutionmarkverifylist', compact('subjects'));

}

public function verify_marks_rev(Request $request)
{


    $exam_id = 27;

    // Update matching records
    $updated = \App\Reevaluationapplicationsubject::where('file', $request->filename)
        ->where('exam_id', $exam_id)
        ->update([
            'verified' => '1',
        ]);

    // Optional: flash a message to show success on redirect
    if ($updated) {

        Session::put('messages','record(s) verified successfully.');

        return redirect('reevaluationcenter/verify-marks');
    } else {
        Session::put('error',"something went wrong");

        return redirect('reevaluationcenter/verify-marks');
    }
}


}
