<?php

namespace App\Http\Controllers\Evaluationcenter;

use App\Evaluationcenter;
use App\Evaluationcenterdetail;
use App\Exam;
use App\Externalexamcenter;
use App\Markexamattendance;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    //
    public function index() {
        $title = "Evaluation Center Login Page";

        return view('evaluationcenter.index', compact('title'));
    }

    public function checklogin(Request $request) {
        $validator = validator($request->all());

        $evaluationcenter = Evaluationcenter::where('code', trim(strtoupper($request->evaluationcenter_code)))->where('active_status', '1')->first();

        $validator->after(function ($validator) use ($request, $evaluationcenter) {
            if(is_null($request->evaluationcenter_code) || is_null($request->evaluationcenter_password)) {
                if(is_null($request->evaluationcenter_code) && is_null($request->evaluationcenter_password)) {
                    $validator->errors()->add('evaluationcenter_code', 'Please enter the login credentials');
                    $validator->errors()->add('evaluationcenter_password', '');
                }
            }
            else {
                if(is_null($evaluationcenter)) {
                    $validator->errors()->add('evaluationcenter_code', 'Please enter the valid login credentials');
                }
                else {
                    if(trim(strtoupper($request->evaluationcenter_password)) != $evaluationcenter->password) {
                        $validator->errors()->add('evaluationcenter_code', 'Please enter the valid login credentials');
                    }
                }
            }
        });

        $this->validateWith($validator);

        //return redirect('/evaluationcenter/'.$evaluationcenter->id.'/'.'18');
        return redirect('/evaluationcenter/'.$evaluationcenter->id);
    }

    public function showHomePage($ecid) {
        $evaluationcenter = Evaluationcenter::find($ecid);

        if(!is_null($evaluationcenter)) {
            $title = $evaluationcenter->code." - Evaluation Center";

            $exams = Exam::where('evaluation_status', 1)->get();

            return view('evaluationcenter.home', compact('title', 'evaluationcenter', 'exams'));
        }
        else {
            return redirect('/evaluationcenter');
        }
    }

    public function showBundleNumbers($ecid, $eid) {
        $exam = Exam::find($eid);
        $evaluationcenter = Evaluationcenter::where('id', $ecid)->where('active_status', '1')->first();
        $title = $exam->name." - Evaluation Center";

        $evaluationcenterdetails = Evaluationcenterdetail::where("evaluationcenter_id", $evaluationcenter->id)
            ->where("exam_id", $exam->id)
            ->where('active_status', '1')->get();

        $remarks = Evaluationcenterdetail::where("evaluationcenter_id", $evaluationcenter->id)
            ->where("exam_id", $exam->id)
            ->where('active_status', '1')->first()->remarks;

        $examcenter_ids = $evaluationcenterdetails->unique('externalexamcenter_id')->pluck('externalexamcenter_id')->toArray();

        $externalexamcenters = Externalexamcenter::whereIn("id", $examcenter_ids)->get();

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

        return view('evaluationcenter.show_bundle_numbers', compact('exam', 'evaluationcenter', 'title', 'markexamattendances', 'remarks'));
    }

    public function showhome($ecid, $eid) {
        $exam = Exam::find($eid);
        $evaluationcenter = Evaluationcenter::where('id', $ecid)->where('active_status', '1')->first();
        $title = $exam->name." - Evaluation Center";

        $evaluationcenterdetails = Evaluationcenterdetail::where("evaluationcenter_id", $evaluationcenter->id)
            ->where("exam_id", $exam->id)
            ->where('active_status', '1')->get();

        $remarks = Evaluationcenterdetail::where("evaluationcenter_id", $evaluationcenter->id)
            ->where("exam_id", $exam->id)
            ->where('active_status', '1')->first()->remarks;

        $examcenter_ids = $evaluationcenterdetails->unique('externalexamcenter_id')->pluck('externalexamcenter_id')->toArray();

        $externalexamcenters = Externalexamcenter::whereIn("id", $examcenter_ids)->get();

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

        return view('evaluationcenter.home', compact('exam', 'evaluationcenter', 'title', 'markexamattendances', 'remarks'));
    }

    public function printfoilsheet($ecid, $eid, $bno) {
        $exam = Exam::find($eid);
        $evaluationcenter = Evaluationcenter::where('id', $ecid)->where('active_status', '1')->first();
        $title = $exam->name." - Evaluations";

        $markexamattendances = Markexamattendance::where("exam_id", $exam->id)->where("externalattendance_id", '1')->where("bundle_number", $bno)->get();
        $common = Markexamattendance::where("exam_id", $exam->id)->where("externalattendance_id", '1')->where("bundle_number", $bno)->first();

        return view('evaluationcenter.printfoilsheet', compact('exam', 'evaluationcenter', 'title', 'markexamattendances', 'common'));
    }

    public function printbundlenos($ecid, $eid) {
        $exam = Exam::find($eid);
        $evaluationcenter = Evaluationcenter::where('id', $ecid)->where('active_status', '1')->first();
        $title = $exam->name." - Evaluations Print Bundle Numbers";

        $evaluationcenterdetails = Evaluationcenterdetail::where("evaluationcenter_id", $evaluationcenter->id)
            ->where("exam_id", $exam->id)
            ->where('active_status', '1')->get();

        $examcenter_ids = $evaluationcenterdetails->unique('externalexamcenter_id')->pluck('externalexamcenter_id')->toArray();

        $externalexamcenters = Externalexamcenter::whereIn("id", $examcenter_ids)->get();

        $markexamattendances = Markexamattendance::where("exam_id", $exam->id)
            ->whereIn("externalexamcenter_id", $examcenter_ids)->where("externalattendance_id", '1')
            ->whereNotNull("bundle_number")->groupBy("bundle_number")->get();

        return view('evaluationcenter.printbundlenumbers', compact('exam', 'evaluationcenter', 'title', 'markexamattendances'));
    }

    public function showmarkforms($ecid, $eid, $bno) {
        $exam = Exam::find($eid);
        $evaluationcenter = Evaluationcenter::where('id', $ecid)->where('active_status', '1')->first();
        $title = $exam->name." - Evaluations - Online Mark Entry";

        $markexamattendances = Markexamattendance::where("exam_id", $exam->id)->where("externalattendance_id", '1')->where("bundle_number", $bno)->get();
        $common = Markexamattendance::where("exam_id", $exam->id)->where("externalattendance_id", '1')->where("bundle_number", $bno)->first();

        return view('evaluationcenter.updatemarkforms', compact('exam', 'evaluationcenter', 'title', 'markexamattendances', 'common'));
    }

    public function updatemarks(Request $request)    {
        $sno = 0;

        foreach ($request->markexamattendance_id as $id) {
            $markexamattendance = Markexamattendance::find($id);

            $mark = '';
            if($request->mark[$sno] != '') {
                $mark = $request->mark[$sno];

                $markexamattendance->application->mark->update([
                    "external" => $mark,
                    "externalattendance_id" => 1,
                    "externalresult_id" => $request->externalresult_id[$sno],
                ]);
            }
            else {
                $mark = null;
            }

            $markexamattendance->update([
                "mark" => $mark
            ]);

            $sno++;
        }

        return redirect('/evaluationcenter/marks/viewmarks/'.$request->evaluationcenter_id.'/'.$request->exam_id.'/'.$request->bundle_number);
    }

    public function viewmarks($ecid, $eid, $bno) {
        $exam = Exam::find($eid);
        $evaluationcenter = Evaluationcenter::where('id', $ecid)->where('active_status', '1')->first();
        $title = $exam->name." - Evaluations - Online Mark Entry";

        $markexamattendances = Markexamattendance::where("exam_id", $exam->id)->where("externalattendance_id", '1')->where("bundle_number", $bno)->get();
        $common = Markexamattendance::where("exam_id", $exam->id)->where("externalattendance_id", '1')->where("bundle_number", $bno)->first();

        return view('evaluationcenter.viewmarks', compact('exam', 'evaluationcenter', 'title', 'markexamattendances', 'common'));
    }
}
