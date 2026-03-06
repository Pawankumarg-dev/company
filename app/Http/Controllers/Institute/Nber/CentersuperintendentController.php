<?php

namespace App\Http\Controllers\Nber;

use App\Centersuperintendent;
use App\Clo;
use App\Exam;
use App\Externalexamcenter;
use App\Nbercloupdate;
use App\Nbercsupdate;
use App\Nodalofficer;
use App\Title;
use App\User;
use Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class CentersuperintendentController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index($eid) {
        $exam = Exam::find($eid);
        unset($eid);

        $css = Centersuperintendent::where("exam_id", $exam->id)->get();

        return view('nber.theoryexams.css.index', compact('exam', 'css'));
    }

    public function addcs($eid) {
        $exam = Exam::find($eid);
        unset($eid);

        $user_id = User::find(Auth::user()->id)->id;

        $nodalofficers = Nodalofficer::where("exam_id", $exam->id)->get();
        $externalexamcenters = Externalexamcenter::where("active_status", 1)->orderBy("code")->get();
        $titles = Title::all();

        return view('nber.theoryexams.css.addcsdetails', compact('exam', 'nodalofficers', 'externalexamcenters', 'titles', 'user_id'));
    }

    public function addcsdetails(Request $request) {
        $cs = Centersuperintendent::create([
            "exam_id" => $request->exam_id,
            "nodalofficer_id" => $request->nodalofficer_id,
            "externalexamcenter_id" => $request->externalexamcenter_id,
            "type" => $request->type,
            "code" => $request->code == '' ? '' : $request->code,
            "password" => $request->password == '' ? '' : $request->password,
            "title_id" => $request->title_id,
            "name" => $request->name,
            "email1" => $request->email1,
            "email2" => $request->email2 == '' ? null : $request->email2,
            "contactnumber1" => $request->contactnumber1,
            "contactnumber2" => $request->contactnumber2 == '' ? null : $request->contactnumber2,
            "user_id" => $request->user_id,
            "active_status" => 1,
        ]);

        Nbercsupdate::create([
            "user_id" => $request->user_id,
            "centersuperintendent_id" => $cs->id,
            "remarks" => "added CS details"
        ]);

        return redirect('/nber/theoryexams/cs/'.$request->exam_id);
    }

    public function updatecs($eid, $csid) {
        $exam = Exam::find($eid);
        $cs = Centersuperintendent::find($csid);
        unset($eid);
        unset($csid);

        $user_id = User::find(Auth::user()->id)->id;

        $nodalofficers = Nodalofficer::where("exam_id", $exam->id)->get();
        $externalexamcenters = Externalexamcenter::where("active_status", 1)->orderBy("code")->get();
        $titles = Title::all();

        return view('nber.theoryexams.css.updatecsdetails', compact('exam', 'nodalofficers', 'externalexamcenters', 'titles', 'user_id', 'cs'));
    }

    public function updatecsdetails(Request  $request) {
        $cs = Centersuperintendent::find($request->cs_id);

        $cs->update([
            "nodalofficer_id" => $request->nodalofficer_id,
            "externalexamcenter_id" => $request->externalexamcenter_id,
            "type" => $request->type,
            "code" => $request->code == '' ? '' : $request->code,
            "password" => $request->password == '' ? '' : $request->password,
            "title_id" => $request->title_id,
            "name" => $request->name,
            "email1" => $request->email1,
            "email2" => $request->email2,
            "contactnumber1" => $request->contactnumber1,
            "contactnumber2" => $request->contactnumber2
        ]);

        Nbercsupdate::create([
            "user_id" => $request->user_id,
            "cs_id" => $cs->id,
            "remarks" => "updated CS details"
        ]);

        return redirect('/nber/theoryexams/cs/'.$request->exam_id);
    }

    public function sendemailtocs(Request $request) {

        $data = "";
        try {

            $cs = Centersuperintendent::where("id", $request->cs_id)->first();

            if($cs->type = "Centre Superintendent") $cstype = "CS"; else $cstype = "ECI";
            $subject = "Appointment of ".$cs->type." ".$cstype." for March 2021 Examinations for RCI recognized courses";

            $cs_name = $cs->title->title.' '.$cs->name;
            $cs_email = $cs->email1;

            $nodalofficer_name = $cs->nodalofficer->name;
            $nodalofficer_email = $cs->nodalofficer->email1;

            if($cs->exam_id == '14') {
                $pdf = PDF::loadView('nber.theoryexams.css.mar2021exam_csattachment', compact('cs', 'cstype'))->setPaper('a4', 'portrait');
                $view = 'nber.theoryexams.css.mar2021exam_csemail';

                Mail::send($view, ['cs' => $cs, 'cstype' => $cstype], function($message) use ($cs_email, $cs_name, $nodalofficer_email, $nodalofficer_name, $pdf, $subject) {
                    $message->to($cs_email, $cs_name)
                        ->cc($nodalofficer_email, $nodalofficer_name)
                        ->attachData($pdf->output(), "Appointment Letter.pdf")
                        ->subject($subject)
                        ->from('niepmd.examinations@gmail.com','NIEPMD-NBER, Chennai');
                });
            }

            $data = 1;

            Nbercsupdate::create([
                "user_id" => User::find(Auth::user()->id)->id,
                "centersuperintendent_id" => $cs->id,
                "remarks" => "sent appointment email to CS"
            ]);

        }catch (\Exception $ex){
            $data = $ex->getMessage();
        }

        return response()->json($data);
    }
}
