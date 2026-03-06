<?php

namespace App\Http\Controllers\Nber;

use App\Application;
use App\Approvedprogramme;
use App\Exam;
use App\Examanswersheet;
use App\Examtimetable;
use App\Externalexamcenter;
use App\Language;
use App\Markexamattendance;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ExamattendanceController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function showExamSchedules($eid, $ecid) {
        $exam = Exam::find($eid);

        if(!is_null($exam)) {
            $examcenter = Externalexamcenter::find($ecid);

            if(!is_null($examcenter)) {
                $examtimetableIds = Application::
                      join("examtimetables", "examtimetables.id", "=", "applications.examtimetable_id")
                    ->where("applications.externalexamcenter_id", $examcenter->id)
                    ->where("applications.hallticket_status", "1")
                    ->where("applications.internalresult_id", 1)
                    ->where("applications.payment_status", "Approved")
                    ->where("applications.exam_id", $exam->id)
                    ->groupBy("examtimetables.id")
                    ->orderBy("examtimetables.startdate")
                    ->orderBy("examtimetables.id")
                    ->pluck('applications.examtimetable_id')
                    ->toArray();

                $examtimetables = Examtimetable::whereIn('id', $examtimetableIds)->orderBy('examdate')->get();

                $commonexamtimetables = Examtimetable::whereIn('id', $examtimetableIds)->orderBy('startdate')->groupBy('startdate')->get();

                $applications = Application::where('exam_id', $exam->id)->where('externalexamcenter_id', $examcenter->id)->whereIn('examtimetable_id', $examtimetableIds)->where('payment_status', "Approved")->where('internalresult_id', 1)->get(['id', 'examtimetable_id']);
                $attendanceCounts = Markexamattendance::whereIn('application_id', $applications->pluck('id')->toArray())->get(['examtimetable_id']);

                unset($examtimetableIds);

                return view('nber.theoryexams.examattendances.show_exam_schedules', compact('exam', 'examcenter', 'examtimetables', 'commonexamtimetables', 'applications', 'attendanceCounts'));
            }
            else {
                unset($examcenter);
                return redirect('/nber/theoryexams/examcentermapping/'.$exam->id);
            }
        }
        else {
            unset($exam);
            return redirect('/nber/exams');
        }
    }

    public function showLists($eid, $ecid, $etid) {
        $exam = Exam::find($eid);

        if(!is_null($exam)) {
            $examcenter = Externalexamcenter::find($ecid);

            if(!is_null($examcenter)) {
                $examtimetable = Examtimetable::find($etid);

                if(!is_null($examtimetable)) {
                    $approvedprogrammeIds = Application::where('externalexamcenter_id', $ecid)->where('examtimetable_id', $etid)
                        ->where('hallticket_status', 1)
                        ->where('internalresult_id', 1)
                        ->groupBy('approvedprogramme_id')
                        ->pluck('approvedprogramme_id')->toArray();

                    $approvedprogrammes = Approvedprogramme::whereIn('id', $approvedprogrammeIds)->get();

                    $attendanceapprovedprogrammeIds = Markexamattendance::where('externalexamcenter_id', $ecid)->where('examtimetable_id', $etid)->groupBy('approvedprogramme_id')->get(['approvedprogramme_id']);
                    return view('nber.theoryexams.examattendances.show_lists', compact('exam', 'examcenter', 'examtimetable', 'approvedprogrammes', 'attendanceapprovedprogrammeIds'));;
                }
                else {
                    unset($examtimetable);
                    return redirect('/nber/theoryexams/examattendances/'.$exam->id.'/'.$examcenter->id);
                }
            }
            else {
                unset($examcenter);
                return redirect('/nber/theoryexams/examcentermapping/'.$exam->id);
            }
        }
        else {
            unset($exam);
            return redirect('/nber/exams');
        }
    }

    public function showUpdateForm($eid, $ecid, $etid, $apid) {
        $exam = Exam::find($eid);

        if(!is_null($exam)) {
            $externalexamcenter = Externalexamcenter::find($ecid);

            if(!is_null($externalexamcenter)) {
                $examtimetable = Examtimetable::find($etid);

                if(!is_null($examtimetable)) {
                    $approvedprogramme = Approvedprogramme::find($apid);

                    if(!is_null($approvedprogramme)) {
                        $languages = Language::orderBy("language")->get(['id', 'language']);

                        $applications = Application::where('approvedprogramme_id', $apid)->where('hallticket_status', 1)
                            ->where('exam_id', $eid)->where('externalexamcenter_id', $ecid)->where('examtimetable_id', $etid)
                            ->where('internalresult_id', 1)
                            ->with('candidate')->get()->sortBy('candidate.enrolmentno');

                        $markexamattendances = Markexamattendance::where('exam_id', $eid)
                            ->where('externalexamcenter_id', $ecid)
                            ->where('examtimetable_id', $etid)
                            ->where('approvedprogramme_id', $apid)
                            ->get();

                        $filename = Markexamattendance::where('exam_id', $eid)
                            ->where('externalexamcenter_id', $ecid)
                            ->where('examtimetable_id', $etid)
                            ->where('approvedprogramme_id', $apid)
                            ->whereNotNull('filename')
                            ->first();

                        $filename = !is_null($filename) ? $filename->filename : null;

                        return view('nber.theoryexams.examattendances.show_update_form', compact('exam', 'externalexamcenter', 'examtimetable', 'approvedprogramme', 'languages', 'applications', 'markexamattendances', 'filename'));
                    }
                    else {
                        unset($approvedprogramme);
                        return redirect('/nber/theoryexams/examattendances/'.$exam->id.'/'.$externalexamcenter->id.'/'.$examtimetable->id);
                    }
                }
                else {
                    unset($examtimetable);
                    return redirect('/nber/theoryexams/examattendances/'.$exam->id.'/'.$externalexamcenter->id);
                }
            }
            else {
                unset($examcenter);
                return redirect('/nber/theoryexams/examcentermapping/'.$exam->id);
            }
        }
        else {
            unset($exam);
            return redirect('/nber/exams');
        }
    }

    public function updateAttendanceDetail(Request $request)
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
                    "language_id" => $language_id
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

        return redirect('/nber/theoryexams/examattendances/showattendances/'.$request->exam_id.'/'.$request->externalexamcenter_id.'/'.$request->examtimetable_id.'/'.$request->approvedprogramme_id);
    }

    public function showAttendances($eid, $ecid, $etid, $apid)
    {
        $exam = Exam::find($eid);

        if(!is_null($exam)) {
            $externalexamcenter = Externalexamcenter::find($ecid);

            if(!is_null($externalexamcenter)) {
                $examtimetable = Examtimetable::find($etid);

                if(!is_null($examtimetable)) {
                    $approvedprogramme = Approvedprogramme::find($apid);

                    if(!is_null($approvedprogramme)) {
                        $markexamattendances = Markexamattendance::where('exam_id', $eid)->where('externalexamcenter_id', $ecid)->where('examtimetable_id', $etid)
                            ->where('approvedprogramme_id', $apid) ->get();

                        $approvedprogramme = Approvedprogramme::find($apid);

                        $filename = Markexamattendance::where('exam_id', $eid)
                            ->where('externalexamcenter_id', $ecid)
                            ->where('examtimetable_id', $etid)
                            ->where('approvedprogramme_id', $apid)
                            ->whereNotNull('filename')
                            ->first();

                        $filename = !is_null($filename) ? $filename->filename : null;

                        return view('nber.theoryexams.examattendances.show_attendances', compact('exam', 'externalexamcenter', 'examtimetable', 'approvedprogramme', 'markexamattendances', 'filename'));
                    }
                    else {
                        unset($approvedprogramme);
                        return redirect('/nber/theoryexams/examattendances/'.$exam->id.'/'.$externalexamcenter->id.'/'.$examtimetable->id);
                    }
                }
                else {
                    unset($examtimetable);
                    return redirect('/nber/theoryexams/examattendances/'.$exam->id.'/'.$externalexamcenter->id);
                }
            }
            else {
                unset($examcenter);
                return redirect('/nber/theoryexams/examcentermapping/'.$exam->id);
            }
        }
        else {
            unset($exam);
            return redirect('/nber/exams');
        }
    }
}
