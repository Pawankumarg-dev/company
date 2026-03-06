<?php

namespace App\Http\Controllers\Evaluationcenter;

use App\Evaluationcenter;
use App\Evaluationcenterdetail;
use App\Exam;
use App\Examanswersheet;
use App\Markexamattendance;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    //
    public function showonlineattendance($ecid, $eid, $bno) {
        $exam = Exam::find($eid);
        $evaluationcenter = Evaluationcenter::where('id', $ecid)->where('active_status', '1')->first();
        $title = $exam->name." - Evaluations - Update Online Exam Attendance";

        $remarks = Evaluationcenterdetail::where("evaluationcenter_id", $evaluationcenter->id)
            ->where("exam_id", $exam->id)
            ->where('active_status', '1')->first()->remarks;

        $markexamattendances = Markexamattendance::where("exam_id", $exam->id)->where("externalattendance_id", '1')->where("bundle_number", $bno)->get();
        $common = Markexamattendance::where("exam_id", $exam->id)->where("externalattendance_id", '1')->where("bundle_number", $bno)->first();

        return view('evaluationcenter.showonlineattendance', compact('exam', 'evaluationcenter', 'title', 'markexamattendances', 'common', 'remarks'));
    }

    public function updateonlineattendanceform($ecid, $eid, $bno) {
        $exam = Exam::find($eid);
        $evaluationcenter = Evaluationcenter::where('id', $ecid)->where('active_status', '1')->first();
        $title = $exam->name." - Evaluations - Update Online Exam Attendance";

        $remarks = Evaluationcenterdetail::where("evaluationcenter_id", $evaluationcenter->id)
            ->where("exam_id", $exam->id)
            ->where('active_status', '1')->first()->remarks;

        $markexamattendances = Markexamattendance::where("exam_id", $exam->id)->where("externalattendance_id", '1')->where("bundle_number", $bno)->get();
        $common = Markexamattendance::where("exam_id", $exam->id)->where("externalattendance_id", '1')->where("bundle_number", $bno)->first();

        return view('evaluationcenter.updateonlineattendanceform', compact('exam', 'evaluationcenter', 'title', 'markexamattendances', 'common', 'remarks'));
    }

    public function updateonlineattendance(Request $request) {
        for($i = 0; $i < count($request->markexamattendance_id); $i++) {
            $markexamattendance = Markexamattendance::find($request->markexamattendance_id[$i]);

            $dummy_number = null;
            if(Examanswersheet::where('serialnumber', strtoupper(trim($request->answersheet_serialnumber[$i])))->count() != 0) {
                $dummy_number = Examanswersheet::where('serialnumber', strtoupper(trim($request->answersheet_serialnumber[$i])))->first()->dummy_number;
            }

            $markexamattendance->update([
                "answersheet_serialnumber" => strtoupper(trim($request->answersheet_serialnumber[$i])),
                "dummy_number" => $dummy_number,
            ]);
        }

        return redirect('/evaluationcenter/onlineattendance/showonlineattendance/'.$request->evaluationcenter_id.'/'.$request->exam_id.'/'.$request->bundle_number);
    }
}
