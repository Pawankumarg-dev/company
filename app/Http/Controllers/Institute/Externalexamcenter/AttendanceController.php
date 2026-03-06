<?php

namespace App\Http\Controllers\Externalexamcenter;

use App\Application;
use App\Approvedprogramme;
use App\Candidate;
use App\Demo;
use App\Exam;
use App\Examanswersheet;
use App\Examtimetable;
use App\Externalexamcenter;
use App\Externalexamcenterdetail;
use App\Institute;
use App\Language;
use App\Mark;
use App\Markexamattendance;
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

class AttendanceController extends Controller
{
    //
    public function showattendancelist($eid, $excid, $etid) {
        $exam = Exam::find($eid);

        $title = $exam->name." Examinations - Mark Attendance - Show List Page";
        $externalexamcenter = Externalexamcenter::find($excid);
        $examtimetable = Examtimetable::where('id', $etid)->first();

        $applications = Application::where("applications.externalexamcenter_id", $excid)->where("applications.exam_id", $eid)
            ->where("applications.examtimetable_id", $etid)->where("hallticket_status", 1)
            ->join("marks", "marks.application_id", "=", "applications.id")
            ->where("marks.internalresult_id", "1")
            ->get();

        $approvedprogramme_ids = $applications->pluck('approvedprogramme_id')->unique()->toArray();

        $approvedprogrammes = Approvedprogramme::select("approvedprogrammes.*")
            ->join("institutes", "institutes.id", "=", "approvedprogrammes.institute_id")
            ->join("academicyears", "academicyears.id", "=", "approvedprogrammes.academicyear_id")
            ->whereIn("approvedprogrammes.id", $approvedprogramme_ids)
            ->orderBy("institutes.code")
            ->orderBy("academicyears.year")
            ->get();

        return view('externalexamcenter.attendancesheets.showmarkattendancelist', compact('title','exam', 'externalexamcenter', 'examtimetable', 'approvedprogrammes'));
    }

    public function showinstitutes($eid, $excid, $etid) {
        $exam = Exam::find($eid);

        $title = $exam->name." Examinations - Show Institutes";
        $externalexamcenter = Externalexamcenter::find($excid);
        $examtimetable = Examtimetable::where('id', $etid)->first();

        /*
        $approvedprogramme_ids = Application::
            join("marks", "marks.application_id", "=", "applications.id")
            ->where("applications.externalexamcenter_id", $excid)->where("applications.exam_id", $eid)
            ->where("applications.examtimetable_id", $etid)->where("hallticket_status", 1)
            ->where("marks.internalresult_id", "1")
            ->groupBy("applications.approvedprogramme_id")
            ->pluck('applications.approvedprogramme_id')
            ->toArray();

        foreach ($approvedprogramme_ids as $ap)
            echo $ap."<br>";

        $appliedapprovedprogramme_ids = Application::where('externalexamcenter_id', $excid)->where('examtimetable_id', $etid)
            ->where('hallticket_status', 1)->groupBy('approvedprogramme_id')->pluck('approvedprogramme_id')->toArray();

        $approvedprogramme_ids = Application::whereIn('approvedprogramme_id', $appliedapprovedprogramme_ids)
            ->whereHas('mark', function($query) {
                $query->where('marks.internalresult_id', 1)->limit(1);
            })->groupBy('approvedprogramme_id')->pluck('approvedprogramme_id')->toArray();
         */

        $approvedprogramme_ids = Application::where('externalexamcenter_id', $excid)->where('examtimetable_id', $etid)
            ->where('hallticket_status', 1)
            ->groupBy('approvedprogramme_id')
            ->whereHas('mark', function($query) {
            $query->where('marks.internalresult_id', 1);
        })->pluck('approvedprogramme_id')->toArray();

        $approvedprogrammes = Approvedprogramme::whereIn('id', $approvedprogramme_ids)->get();

        $attendanceapprovedprogramme_ids = Markexamattendance::where('externalexamcenter_id', $excid)->where('examtimetable_id', $etid)->groupBy('approvedprogramme_id')->get(['approvedprogramme_id']);
        return view('externalexamcenter.attendancesheets.showinstitutes', compact('title','exam', 'externalexamcenter', 'examtimetable', 'approvedprogrammes', 'attendanceapprovedprogramme_ids'));
    }

    public function markattendanceform($eid, $excid, $etid, $apid) {
        if(Markexamattendance::where('exam_id', $eid)->where('externalexamcenter_id', $excid)->where('examtimetable_id', $etid)->where('approvedprogramme_id', $apid)->exists()) {
            return redirect('/externalexamcenter/attendance/showenteredmarks/'.$eid.'/'.$excid.'/'.$etid.'/'.$apid);
        }
        else {
            $exam = Exam::find($eid);

            $title = $exam->name." Examinations - Mark Attendance Form";
            $externalexamcenter = Externalexamcenter::find($excid);
            $examtimetable = Examtimetable::where('id', $etid)->first();
            $languages = Language::orderBy("language")->get(['id', 'language']);

            $applications = Application::where('approvedprogramme_id', $apid)->where('hallticket_status', 1)
                ->where('exam_id', $eid)->where('externalexamcenter_id', $excid)->where('examtimetable_id', $etid)
                ->where('exam_id', $eid)->where('externalexamcenter_id', $excid)->where('examtimetable_id', $etid)
                ->whereHas('mark', function($query) {
                    $query->where('marks.internalresult_id', 1)->select('marks.application_id');
                })->with('candidate')->get()->sortBy('candidate.enrolmentno');

            /*
            $applications = Application::select("applications.*")
                ->join("marks", "marks.application_id", "=", "applications.id")
                ->join("candidates", "candidates.id", "=", "applications.candidate_id")
                ->where("applications.externalexamcenter_id", $excid)->where("applications.exam_id", $eid)
                ->where("applications.examtimetable_id", $etid)->where("hallticket_status", 1)
                ->where("applications.approvedprogramme_id", $apid)
                ->where("marks.internalresult_id", "1")
                ->groupBy("marks.application_id")
                ->orderBy("candidates.enrolmentno")
                ->get();
            $approvedprogrammes = Approvedprogramme::where('id', $apid)->get();
            */

            $approvedprogramme = Approvedprogramme::find($apid);

            return view('externalexamcenter.attendancesheets.showmarkattendanceform', compact('title','exam', 'externalexamcenter', 'examtimetable', 'approvedprogramme', 'languages', 'applications'));
        }
    }

    public function addattendances(Request $request) {
        $exam = Exam::find($request->exam_id);
        $externalexamcenter = Externalexamcenter::find($request->externalexamcenter_id);
        $examtimetable = Examtimetable::where('id', $request->examtimetable_id)->first();
        $approvedprogramme = Approvedprogramme::find($request->approvedprogramme_id);

        $file = $request->file('filename');
        $filename = $externalexamcenter->code.$approvedprogramme->institute->code.$approvedprogramme->academicyear->year.$examtimetable->examdate->format('dmY').$examtimetable->subject->scode.".pdf";
        $destination = public_path() . "/files/examattendancefiles/";
        $file->move($destination, $filename);

        for($i = 0; $i < count($request->application_id); $i++) {
            $markexamattendance = Markexamattendance::where('exam_id', $request->exam_id)
                ->where('externalexamcenter_id', $request->externalexamcenter_id)
                ->where('examtimetable_id', $request->examtimetable_id)
                ->where("application_id", $request->application_id[$i])->first();

            $dummy_number = null;
            if(Examanswersheet::where('serialnumber', strtoupper(trim($request->answerbookletno[$i])))->count() != 0) {
                $dummy_number = Examanswersheet::where('serialnumber', strtoupper(trim($request->answerbookletno[$i])))->first()->dummy_number;
            }

            if($request->has('language_id.'.$i))
                if($request->ext_attendance[$i] == 2 || $request->ext_attendance[$i] == "2") {
                    $language_id = 13;
                }
                else {
                    $language_id = $request->language_id[$i];
                }
            else
                $language_id = 13;

            if(is_null($markexamattendance)) {
                Markexamattendance::create([
                    "exam_id" => $request->exam_id,
                    "externalexamcenter_id" => $request->externalexamcenter_id,
                    "examtimetable_id" => $request->examtimetable_id,
                    "approvedprogramme_id" => $request->approvedprogramme_id,
                    "application_id" => $request->application_id[$i],
                    "externalattendance_id" => $request->ext_attendance[$i],
                    "answersheet_serialnumber" => strtoupper(trim($request->answerbookletno[$i])),
                    "dummy_number" => $dummy_number,
                    "language_id" => $language_id,
                    "filename" => $filename,
                ]);
            }
            else {
                $markexamattendance->update([
                    "answersheet_serialnumber" => strtoupper(trim($request->answerbookletno[$i])),
                    "dummy_number" => $dummy_number,
                    "externalattendance_id" => $request->ext_attendance[$i],
                    "language_id" => $language_id
                ]);
            }
        }

        //return redirect('/externalexamcenter/attendance/show/'.$request->exam_id.'/'.$request->externalexamcenter_id.'/'.$request->examtimetable_id);
        return redirect('/externalexamcenter/attendance/showenteredmarks/'.$request->exam_id.'/'.$request->externalexamcenter_id.'/'.$request->examtimetable_id.'/'.$request->approvedprogramme_id);
    }

    public function showmarkedattendances($eid, $excid, $etid, $apid) {
        $exam = Exam::find($eid);

        $title = $exam->name." Examinations - Mark Attendance Form";
        $externalexamcenter = Externalexamcenter::find($excid);
        $examtimetable = Examtimetable::find($etid);

        $markexamattendances = Markexamattendance::where('exam_id', $eid)->where('externalexamcenter_id', $excid)->where('examtimetable_id', $etid)
            ->where('approvedprogramme_id', $apid) ->get();

        $approvedprogramme = Approvedprogramme::find($apid);

        $filename = Markexamattendance::where('exam_id', $eid)
            ->where('externalexamcenter_id', $excid)
            ->where('examtimetable_id', $etid)
            ->where('approvedprogramme_id', $apid)
            ->whereNotNull('filename')
            ->first()->filename;

        return view('externalexamcenter.attendancesheets.showenteredmarks', compact('title', 'exam', 'externalexamcenter', 'examtimetable', 'markexamattendances', 'approvedprogramme', 'filename'));
    }

    public function updatemarkedattendanceform($eid, $excid, $etid, $apid) {
        $exam = Exam::find($eid);
        $title = $exam->name." Examinations - Update Marked Attendance Form";
        $externalexamcenter = Externalexamcenter::find($excid);
        $examtimetable = Examtimetable::where('id', $etid)->first();
        $languages = Language::orderBy("language")->get(['id', 'language']);

        /*
        $applications = Application::select("applications.*")
            ->join("marks", "marks.application_id", "=", "applications.id")
            ->join("candidates", "candidates.id", "=", "applications.candidate_id")
            ->where("applications.externalexamcenter_id", $externalexamcenter->id)->where("applications.exam_id", $exam->id)
            ->where("applications.examtimetable_id", $examtimetable->id)->where("hallticket_status", 1)
            ->where("marks.internalresult_id", "1")
            ->groupBy("marks.application_id")
            ->orderBy("candidates.enrolmentno")
            ->get();

        $approvedprogramme_ids = $applications->pluck('approvedprogramme_id')->unique()->toArray();

        $approvedprogrammes = Approvedprogramme::select("approvedprogrammes.*")
            ->join("institutes", "institutes.id", "=", "approvedprogrammes.institute_id")
            ->join("academicyears", "academicyears.id", "=", "approvedprogrammes.academicyear_id")
            ->whereIn("approvedprogrammes.id", $approvedprogramme_ids)
            ->orderBy("institutes.code")
            ->orderBy("academicyears.year")
            ->get();
        */
        $approvedprogramme = Approvedprogramme::find($apid);

        $applications = Application::where('approvedprogramme_id', $apid)->where('hallticket_status', 1)
            ->where('exam_id', $eid)->where('externalexamcenter_id', $excid)->where('examtimetable_id', $etid)
            ->where('exam_id', $eid)->where('externalexamcenter_id', $excid)->where('examtimetable_id', $etid)
            ->whereHas('mark', function($query) {
                $query->where('marks.internalresult_id', 1)->select('marks.application_id');
            })->with('candidate')->get()->sortBy('candidate.enrolmentno');

        $markexamattendances = Markexamattendance::where('exam_id', $eid)
            ->where('externalexamcenter_id', $excid)
            ->where('examtimetable_id', $etid)
            ->get();

        $filename = Markexamattendance::where('exam_id', $eid)
            ->where('externalexamcenter_id', $excid)
            ->where('examtimetable_id', $etid)
            ->where('approvedprogramme_id', $apid)
            ->first()->filename;

        return view('externalexamcenter.attendancesheets.showmarkedattendanceupdateform', compact('title','exam', 'externalexamcenter', 'examtimetable', 'approvedprogramme', 'languages', 'applications', 'markexamattendances', 'filename'));
    }

    public function updateattendances(Request $request)
    {
        for($i = 0; $i < count($request->application_id); $i++) {
            $markexamattendance = Markexamattendance::where('exam_id', $request->exam_id)
                ->where('externalexamcenter_id', $request->externalexamcenter_id)
                ->where('examtimetable_id', $request->examtimetable_id)
                ->where("application_id", $request->application_id[$i])->first();

            $dummy_number = null;
            if(Examanswersheet::where('serialnumber', strtoupper(trim($request->answerbookletno[$i])))->count() != 0) {
                $dummy_number = Examanswersheet::where('serialnumber', strtoupper(trim($request->answerbookletno[$i])))->first()->dummy_number;
            }

            if($request->has('language_id.'.$i))
                if($request->ext_attendance[$i] == 2 || $request->ext_attendance[$i] == "2") {
                    $language_id = 13;
                }
                 else {
                     $language_id = $request->language_id[$i];
                 }
            else
                $language_id = 13;

            if(is_null($markexamattendance)) {
                Markexamattendance::create([
                    "exam_id" => $request->exam_id,
                    "externalexamcenter_id" => $request->externalexamcenter_id,
                    "examtimetable_id" => $request->examtimetable_id,
                    "approvedprogramme_id" => $request->approvedprogramme_id,
                    "application_id" => $request->application_id[$i],
                    "externalattendance_id" => $request->ext_attendance[$i],
                    "answersheet_serialnumber" => strtoupper(trim($request->answerbookletno[$i])),
                    "dummy_number" => $dummy_number,
                    "language_id" => $language_id,
                    "filename" => $request->filename
                ]);
            }
            else {
                $markexamattendance->update([
                    "answersheet_serialnumber" => strtoupper(trim($request->answerbookletno[$i])),
                    "dummy_number" => $dummy_number,
                    "externalattendance_id" => $request->ext_attendance[$i],
                    "language_id" => $language_id,
                    "filename" => $request->filename
                ]);
            }
        }
        return redirect('/externalexamcenter/attendance/showenteredmarks/'.$request->exam_id.'/'.$request->externalexamcenter_id.'/'.$request->examtimetable_id.'/'.$request->approvedprogramme_id);
    }

    public function updateattendancesheetform($eid, $excid, $etid, $apid) {
        $exam = Exam::find($eid);
        $title = $exam->name." Examinations - Update Uploaded Attendance Sheet Form";
        $externalexamcenter = Externalexamcenter::find($excid);
        $examtimetable = Examtimetable::where('id', $etid)->first();
        $approvedprogramme = Approvedprogramme::find($apid);

        //$oldfilename = Markexamattendance::where('exam_id', $eid)->where('externalexamcenter_id', $excid)
            //->where('examtimetable_id', $etid)->where('approvedprogramme_id', $apid)->first()->filename;

        $oldfilename = $externalexamcenter->code.$approvedprogramme->institute->code.$approvedprogramme->academicyear->year.$examtimetable->examdate->format('dmY').$examtimetable->subject->scode.".pdf";

        return view('externalexamcenter.attendancesheets.showupdateattendancesheetform', compact('title','exam', 'externalexamcenter', 'examtimetable', 'approvedprogramme', 'oldfilename'));
    }

    public function updateattendancesheet(Request $request) {
        $destination = public_path()."/files/examattendancefiles/";

        $file = $request->file('filename');

        $file->move($destination, $request->oldfilename);

        $markexamattendances = Markexamattendance::where('exam_id', $request->exam_id)
            ->where('externalexamcenter_id', $request->externalexamcenter_id)
            ->where('examtimetable_id', $request->examtimetable_id)
            ->where('approvedprogramme_id', $request->approvedprogramme_id)
        ->get();

        foreach ($markexamattendances as $markexamattendance) {
            $markexamattendance->update([
                "filename" => $request->oldfilename,
            ]);
        }

        return redirect('/externalexamcenter/attendance/showenteredmarks/'.$request->exam_id.'/'.$request->externalexamcenter_id.'/'.$request->examtimetable_id.'/'.$request->approvedprogramme_id);
    }
}
