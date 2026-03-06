<?php

namespace App\Http\Controllers\Evaluationcenter;

use App\Evaluationcenter;
use App\Exam;
use App\Examtimetable;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class QuestionpaperController extends Controller
{
    //
    public function showquestionpapers($exid, $evcid) {
        $exam = Exam::find($exid);

        $evaluationcenter = Evaluationcenter::find($evcid);

        $title = $evaluationcenter->code." - ".$exam->name." Examination";

        $examtimetables = Examtimetable::where('exam_id', $exid)->orderBy('examdate')->orderBy('starttime')->get();

        $examdates = $examtimetables->pluck('examdate')->unique()->toArray();

        $examstarttimes = $examtimetables->pluck('starttime')->unique()->toArray();

        return view('evaluationcenter.showquestionpapers', compact('title','exam', 'evaluationcenter', 'examtimetables', 'examdates', 'examstarttimes'));
    }

    public function downloadquestionpaper($exttid) {
        $examtimetable = Examtimetable::where('id', $exttid)->first();

        if(!is_null($examtimetable)){
            if(!is_null($examtimetable->questionpaper)) {
                /*
                $file = public_path().'/files/questionpapers/'.$examtimetable->questionpaper;
                return Response::download($file);
                */
                $headers = array(
                    'Content-Type' => 'application/pdf',
                );
                $filepath = public_path().'/files/questionpapers/'.$examtimetable->questionpaper;
                $filename = $examtimetable->startdate->format('d-m-Y').' '.$examtimetable->subject->scode.'.'.pathinfo($filepath, PATHINFO_EXTENSION);
                return response()->download($filepath, $filename, $headers);
            }
        }
    }
}
