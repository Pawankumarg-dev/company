<?php

namespace App\Http\Controllers\Nber;

use App\Exam;
use App\Examtimetable;
use App\Programme;
use App\Subject;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Common\QuestionpaperdownloadService;

class QuestionpaperController extends Controller
{
    private $qpService;
    public function __construct(QuestionpaperdownloadService $qp)
    {
       $this->middleware(['role:nber']);
        $this->qpService = $qp;
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function getFileName($ttid,$lid,$randstring){
        return "25_".$ttid.'_'.$lid.'_'.$randstring.'.pdf';
    }
    public function questionpaperupload($ttid, $lid, Request $request){
        try{
            $file = $request->file;
            $randstring = $this->generateRandomString();
            $filename =$this->getFileName($ttid,$lid,$randstring);
            move_uploaded_file($file,"/var/www/html/rcinber/public/files/questionpapers/".$filename);
            Session::flash('messages','Success');
            $timetable = \App\Examtimetable::find($ttid);
            $timetable->languages()->attach([$lid=>['question_paper'=>$filename,'rand_string'=>$randstring]]);
        }catch(Exception $e){
            Session::flash('error','Could not upload');
        }
        return back();
    }
    public function deletequestionpaperupload($ttid,$lid){
        $timetable = \App\Examtimetable::find($ttid);
        $timetable->languages()->detach($lid);
        Session::flash('messages','Deleted');
        return back();
    }

    public function downloadqp(Request $r){
    $download = $this->qpService->downloadquestionpaper(3,$r);
    //return $download;
       if($download!=false){
            $header = [
                'Content-Type'=> 'application/pdf',
                'Content-Description' => 'Question Paper'
            ];
            return response()->file(public_path().$download,$header); 
       }
       return back();
    }
    public function updatequestionpaperupload($ttid, $lid, Request $request){
        try{
            $file = $request->file;
            $timetable = \App\Examtimetable::find($ttid);
            $filename = $timetable->languages()->where('id',$lid)->first()->pivot->question_paper;
            move_uploaded_file($file,"/var/www/html/rcinber/public/files/questionpapers/".$filename);
            Session::flash('messages','Success');
        }catch(Exception $e){
            Session::flash('error','Could not upload');
        }
        return back();

    }
   

    public function showDetails($e_id) {
        $exam = Exam::find($e_id);

        if ($exam) {
            $examtimetables = Examtimetable::select(
                "examtimetables.*", "programmes.abbreviation as programmeCode",
                "subjects.scode as subjectCode", "subjects.sname as subjectName"
            )->join("subjects", "subjects.id", "=", "examtimetables.subject_id")
                ->join("programmes", "programmes.id", "=", "subjects.programme_id")
                ->where("examtimetables.exam_id", $exam->id)
                ->orderBy("examtimetables.startdate")
                ->orderBy("programmes.sortorder")
                ->orderBy("subjects.syear")
                ->orderBy("subjects.sortorder")
                ->get();

            $examstartdates = Examtimetable::where("exam_id", $exam->id)->groupBy("startdate")->get();

            return view("nber.examquestionpapers.show_details", compact("exam", "examtimetables", "examstartdates"));
        }
        else {
            return redirect("/nber/exams");
        }
    }

    public function updateDetails($e_id, $ett_id) {
        if (Exam::where("id", $e_id)->exists()) {
            $exam = Exam::find($e_id);

            if (Examtimetable::where("id", $ett_id)->where("exam_id", $e_id)->exists()) {
                $examtimetable = Examtimetable::where("id", $ett_id)->where("exam_id", $e_id)
                    ->first();

                $subject = $examtimetable->subject;

                return view("nber.examquestionpapers.update_details", compact("exam", "examtimetable", "subject"));
            }

            return redirect("nber/examquestionpapers/".$e_id);
        }

        return redirect("/nber/exams");
    }

    public function updateQuestionPaperDetails(Request $request) {
        $examtimetable = Examtimetable::find($request->examtimetableId);

        $message = null;

        if ($request->has("password")) {
            $examtimetable->update([
                "password" => $request->password
            ]);

            $message = "Password";
        }

        if ($request->hasFile("filename")) {
            $file = $request->file('filename');

            $filename = $examtimetable->id."_".$examtimetable->subject->scode.".".$file->getClientOriginalExtension();

            $destination = public_path()."/files/questionpapers/";

            if ($file->move($destination, $filename)) {
                $examtimetable->update([
                    "questionpaper" => $filename
                ]);

                $message = is_null($message) ? "Question Paper" : $message."& question paper";
            }
        }

        return redirect("/nber/examquestionpapers/".$examtimetable->exam_id."/".$examtimetable->id)->with(['message' => $message]);
    }
}
