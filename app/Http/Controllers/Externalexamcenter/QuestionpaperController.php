<?php

namespace App\Http\Controllers\Externalexamcenter;

use App\Application;
use App\Approvedprogramme;
use App\Candidate;
use App\Demo;
use App\Downloadquestionpaperupdate;
use App\Exam;
use App\Examtimetable;
use App\Externalexamcenter;
use App\Externalexamcenterdetail;
use App\Institute;
use App\Mark;
use App\Subject;
use DateTime;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use File;
use Input;
use Response;
use PDF;
use Carbon\Carbon;

class QuestionpaperController extends Controller
{
    //
    public function showquestionpapers($eid, $excid) {
        $exam = Exam::find($eid);
        $title = $exam->name." Examinations - Question Paper Download Page";
        $externalexamcenter = Externalexamcenter::where('id', $excid)->where('active_status', '1')->first();
        $todaydate = Carbon::now();

        $applications = Application::join("examtimetables", "examtimetables.id", "=", "applications.examtimetable_id")
            ->where("applications.externalexamcenter_id", $externalexamcenter->id)
            ->where("applications.hallticket_status", "1")
            ->where("applications.exam_id", $eid)
            ->where("examtimetables.examdate", $todaydate->toDateString())
            ->groupBy("examtimetables.id")
            ->get();

        $examtimetable_ids = $applications->unique('examtimetable_id')->pluck("examtimetable_id")->toArray();

        $examtimetables = Examtimetable::whereIn("id", $examtimetable_ids)->get();

        return view("externalexamcenter.questionpapers.showquestionpaperslist", compact('title', 'exam', 'externalexamcenter', 'examtimetables', 'todaydate'));
    }

    public function downloadquestionpaper($etid){
        $examtimetable = Examtimetable::where('id', $etid)->first();

        if(!is_null($examtimetable)){
            if(!is_null($examtimetable->questionpaper)) {
                $file = public_path().'/files/questionpapers/'.$examtimetable->questionpaper;
                return Response::download($file);
            }
        }
    }

    public function getquestionpaperdownloadinfo(Request $request) {
        Downloadquestionpaperupdate::create([
            "externalexamcenter_id" => $request->excid,
            "examtimetable_id" => $request->etid,
            "download" => 1
        ]);

        $data = '1';
        return response()->json($data);
    }
}
