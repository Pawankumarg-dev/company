<?php

namespace App\Http\Controllers\Nber;

use App\Application;
use App\Evaluationcenter;
use App\Evaluationcenterdetail;
use App\Exam;
use App\Exambundlenumber;
use App\Externalexamcenter;
use App\Mark;
use App\Markexamattendance;
use App\Subject;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;


class EvaluationController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index() {
        $exams = Exam::orderBy('sortorder', 'desc')->get();

        return view('nber.evaluations.index', compact('exams'));
    }

    public function showgeneratepage() {
        return view('nber.evaluations.dummynumbers.showgeneratepage');
    }

    public function generatebarcode(Request $request) {
        $data_format_prefix = $request->data_format_prefix;
        $starting_value = (int) $request->starting_value;
        $quantity = (int) $request->quantity;

        $filename = 'Dummy Number';
        $sheetname = '1';

        Excel::create($filename, function ($excel) use($sheetname, $data_format_prefix, $starting_value, $quantity){
            $excel->sheet($sheetname, function ($sheet) use($data_format_prefix, $starting_value, $quantity){
                $sheet->loadview('nber.evaluations.dummynumbers.generatebarcode', compact('data_format_prefix', 'starting_value', 'quantity'));
            });
        })->export('xlsx');

    }

    public function showexambundles() {
        $exams = Exam::where('exambundle_status', '1')->get();

        return view('nber.evaluations.bundlenumbers.index', compact('exams'));
    }

    public function listexambundles($eid) {
        $exam = Exam::find($eid);

        $applications = Application::select('subject_id', 'bundle_number')->where('exam_id', $exam->id)
            ->groupBy('bundle_number')->whereNotNull('bundle_number')->get();

        return view('nber.evaluations.bundlenumbers.listexambundles', compact('exam', 'applications'));
    }

    public function printfoilsheet($eid, $bundle_number) {
        $exam = Exam::find($eid);

        $applications = Application::where('exam_id', $exam->id)->where('bundle_number', $bundle_number)
            ->orderBy('dummy_number')->get();

        $subject_id = Application::where('exam_id', $exam->id)->where('bundle_number', $bundle_number)->first()->subject_id;

        $subject = Subject::where('id', $subject_id)->first();

        return view('nber.evaluations.bundlenumbers.printfoilsheet', compact('exam', 'bundle_number', 'applications', 'subject'));
    }

    public function showmarks($eid, $bundle_number) {
        $exam = Exam::find($eid);

        $applications = Application::where('exam_id', $exam->id)->where('bundle_number', $bundle_number)
            ->orderBy('dummy_number')->get();

        $marks = Mark::whereIn('application_id', $applications->pluck('id')->toArray())->get();

        return view('nber.evaluations.bundlenumbers.showmarks', compact('exam', 'bundle_number', 'applications', 'marks'));
    }

    public function updatemarks($eid, $bundle_number) {
        $exam = Exam::find($eid);

        $applications = Application::where('exam_id', $exam->id)->where('bundle_number', $bundle_number)
            ->orderBy('dummy_number')->get();

        $marks = Mark::whereIn('application_id', $applications->pluck('id')->toArray())->get();

        return view('nber.evaluations.bundlenumbers.updatemarks', compact('exam', 'bundle_number', 'applications', 'marks'));
    }

    public function updatemarksdata(Request $request)
    {
        $sno = 0;
        foreach ($request->application_id as $appid) {
            $application = Application::where('id', $appid)->first();
            $mark = Mark::where('application_id', $application->id)->first();

            if ($request->ext_mark[$sno] < $application->subject->emin_marks) {
                $externalresult_id = '0';
                $external_lock = '0';
            }
            else {
                $externalresult_id = '1';
                $external_lock = '1';
            }

            if (!is_null($mark)) {
                if($mark->internal == "" || $mark->external == "Abs") {
                    $total_mark = $request->ext_mark[$sno];
                }
                else {
                    $total_mark = (int) $mark->internal + (int) $request->ext_mark[$sno];
                }

                $mark->update([
                    "external" => $request->ext_mark[$sno],
                    "candidate_id" => $application->candidate_id,
                    "externalresult_id" => $externalresult_id,
                    "external_lock" => $external_lock,
                    "total_mark" => $total_mark,
                ]);
            }
            else {
                Mark::create([
                    "application_id" => $application->id,
                    "exam_id" => $request->exam_id,
                    "candidate_id" => $application->candidate_id,
                    "subject_id" => $application->subject->id,
                    "internalresult_id" => "0",
                    "internal_lock" => "0",
                    "external" => $request->ext_mark[$sno],
                    "externalresult_id" => $externalresult_id,
                    "external_lock" => $external_lock,
                    "total_mark" => $request->ext_mark[$sno],
                ]);
            }
            $sno++;
        }

        return redirect('/nber/evaluations/bundles/showmarks/'.$request->exam_id.'/'.$request->bundle_number);
    }

    public function examinationcenterlists($eid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/evaluations/');
        }
        else {
            /*
            $examcenters = Externalexamcenter::with('markexamattendances', function ($query) use($eid) {
                $query->where('')
            });
            */

            $examcenter_ids = Application::where('exam_id', $eid)->groupBy('externalexamcenter_id')->pluck('externalexamcenter_id')->toArray();
            $examcenters = Externalexamcenter::whereIn('id', $examcenter_ids)->orderBy('code')->get();

            return view('nber.evaluations.examinationcenters.examinationcenterlists', compact('exam', 'examcenters'));
        }
    }

    public function evaluationcenterlists($eid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/evaluations/');
        }
        else {
            $evaluationcenter_ids = Evaluationcenterdetail::where('exam_id', $eid)->groupBy('evaluationcenter_id')->pluck('evaluationcenter_id')->toArray();
            $evaluationcenters = Evaluationcenter::whereIn('id', $evaluationcenter_ids)->orderBy('code')->get();

            return view('nber.evaluations.evaluationcenters.evaluationcenterlists', compact('exam', 'evaluationcenters'));
        }
    }

    public function evaluationcentershowbundles($eid, $evcid) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/evaluations');
        }
        else {
            $evaluationcenter = Evaluationcenter::find($evcid);

            if(is_null($evaluationcenter)) {
                return redirect('/nber/evaluations/evaluationcenterlists/'.$exam->id);
            }
            else {
                $evaluationcenterdetails = Evaluationcenterdetail::where("evaluationcenter_id", $evaluationcenter->id)
                    ->where("exam_id", $exam->id)
                    ->where('active_status', '1')->get();

                $examcenter_ids = $evaluationcenterdetails->unique('externalexamcenter_id')->pluck('externalexamcenter_id')->toArray();

                $markexamattendances = Markexamattendance::select("markexamattendances.*")->where("markexamattendances.exam_id", $exam->id)
                    ->join("applications", "applications.id", "=", "markexamattendances.application_id")
                    ->join("approvedprogrammes", "approvedprogrammes.id", "=", "applications.approvedprogramme_id")
                    ->join("programmes", "programmes.id", "=", "approvedprogrammes.programme_id")
                    ->join("institutes", "institutes.id", "=", "approvedprogrammes.institute_id")
                    ->join("subjects", "subjects.id", "=", "applications.subject_id")
                    ->join("languages", "languages.id", "=", "markexamattendances.language_id")
                    ->where("markexamattendances.exam_id", $exam->id)
                    ->whereIn("markexamattendances.externalexamcenter_id", $examcenter_ids)->where("markexamattendances.externalattendance_id", '1')
                    ->whereNotNull("markexamattendances.bundle_number")
                    ->orderBy("programmes.sortorder")
                    ->orderBy("programmes.sortorder")
                    ->orderBy("subjects.sortorder")
                    ->orderBy("languages.id")
                    ->orderBy("markexamattendances.bundle_number")
                    ->groupBy("markexamattendances.bundle_number")
                    ->get();

                unset($evaluationcenterdetails);
                unset($examcenter_ids);

                return view('nber.evaluations.evaluationcenters.evaluationcentershowbundles', compact('exam', 'evaluationcenter', 'markexamattendances'));
            }
        }
    }

    public function evaluationcenterviewfoilsheets($eid, $evcid, $bno) {
        $exam = Exam::find($eid);

        if(is_null($exam)) {
            return redirect('/nber/evaluations');
        }
        else {
            $evaluationcenter = Evaluationcenter::find($evcid);

            if(is_null($evaluationcenter)) {
                return redirect('/nber/evaluations/evaluationcenterlists/'.$exam->id);
            }
            else {
                $markexamattendances = Markexamattendance::where("exam_id", $exam->id)->where("externalattendance_id", '1')->where("bundle_number", $bno)->get();
                $common = Markexamattendance::where("exam_id", $exam->id)->where("externalattendance_id", '1')->where("bundle_number", $bno)->first();

                return view('nber.evaluations.evaluationcenters.evaluationcenterviewfoilsheets', compact('exam', 'evaluationcenter', 'markexamattendances', 'common'));
            }
        }
    }

    public function sample($eid, $evcid, $bno) {
        echo 'hi';
    }
}
