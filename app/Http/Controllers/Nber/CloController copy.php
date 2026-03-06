<?php

namespace App\Http\Controllers\Nber;

use App\Externalexamcenter;
use App\Nbercloupdate;
use App\Nodalofficer;
use App\Title;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Clo;
use App\User;
use Auth;

use App\Exam;
use Illuminate\Support\Facades\Mail;


class CloController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }
    /*
    public function index(){
    	$collections = Clo::paginate(200);
    	$link = '';
    	$text = 'CLOs';
    	//$exams = Exam::all();
    	return view('nber.clo.users',compact('collections','link','text'));
    }
    */

    public function index($eid) {
        $exam = Exam::find($eid);
        unset($eid);

        $clos = Clo::where("exam_id", $exam->id)->get();

        return view('nber.theoryexams.clos.index', compact('exam', 'clos'));
    }

    public function addclo($eid) {
        $exam = Exam::find($eid);
        unset($eid);

        $user_id = User::find(Auth::user()->id)->id;

        $nodalofficers = Nodalofficer::where("exam_id", $exam->id)->get();
        $externalexamcenters = Externalexamcenter::where("active_status", 1)->orderBy("code")->get();
        $titles = Title::all();

        return view('nber.theoryexams.clos.addclodetails', compact('exam', 'nodalofficers', 'externalexamcenters', 'titles', 'user_id'));
    }

    public function addclodetails(Request $request) {
        $clo = Clo::create([
            "exam_id" => $request->exam_id,
            "nodalofficer_id" => $request->nodalofficer_id,
            "externalexamcenter_id" => $request->externalexamcenter_id,
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

        Nbercloupdate::create([
            "user_id" => $request->user_id,
            "clo_id" => $clo->id,
            "remarks" => "added CLO details"
        ]);

        return redirect('/nber/theoryexams/clo/'.$request->exam_id);
    }

    public function updateclo($eid, $cloid) {
        $exam = Exam::find($eid);
        $clo = Clo::find($cloid);
        unset($eid);
        unset($cloid);

        $user_id = User::find(Auth::user()->id)->id;

        $nodalofficers = Nodalofficer::where("exam_id", $exam->id)->get();
        $externalexamcenters = Externalexamcenter::where("active_status", 1)->orderBy("code")->get();
        $titles = Title::all();

        return view('nber.theoryexams.clos.updateclodetails', compact('exam', 'nodalofficers', 'externalexamcenters', 'titles', 'user_id', 'clo'));
    }

    public function updateclodetails(Request  $request) {
        $clo = Clo::find($request->clo_id);

        $clo->update([
            "nodalofficer_id" => $request->nodalofficer_id,
            "externalexamcenter_id" => $request->externalexamcenter_id,
            "code" => $request->code == '' ? '' : $request->code,
            "password" => $request->password == '' ? '' : $request->password,
            "title_id" => $request->title_id,
            "name" => $request->name,
            "email1" => $request->email1,
            "email2" => $request->email2,
            "contactnumber1" => $request->contactnumber1,
            "contactnumber2" => $request->contactnumber2
        ]);

        Nbercloupdate::create([
            "user_id" => $request->user_id,
            "clo_id" => $clo->id,
            "remarks" => "updated CLO details"
        ]);

        return redirect('/nber/theoryexams/clo/'.$request->exam_id);
    }

    public function sendemailtoclo(Request $request) {
        $data = "";
        try {

            $clo = Clo::where("id", $request->clo_id)->first();

            $clo_name = $clo->title->title.' '.$clo->name;
            $clo_email = $clo->email1;

            $nodalofficer_name = $clo->nodalofficer->name;
            $nodalofficer_email = $clo->nodalofficer->email1;

            if($clo->exam_id == '14') {
                $pdf = PDF::loadView('nber.theoryexams.clos.mar2021exam_cloattachment', compact('clo'))->setPaper('a4', 'portrait');
                $view = 'nber.theoryexams.clos.mar2021exam_cloemail';

                Mail::send($view, ['clo' => $clo], function($message) use ($clo_email, $clo_name,$nodalofficer_email, $nodalofficer_name, $pdf) {
                    $message->from('niepmd.examinations@gmail.com','NIEPMD-NBER, Chennai')
                        ->to($clo_email, $clo_name)
                        ->cc($nodalofficer_email, $nodalofficer_name)
                        ->attachData($pdf->output(), "Appointment Letter.pdf")
                        ->subject('Appointment of Central Level Observer (CLO) for March 2021 Examinations for RCI recognized courses');
                });

                Nbercloupdate::create([
                    "user_id" => User::find(Auth::user()->id)->id,
                    "clo_id" => $clo->id,
                    "remarks" => "sent appointment email to CLO"
                ]);
            }

            $data = 1;

        }catch (\Exception $ex){
            $data = $ex->getMessage();
        }

        return response()->json($data);
    }
}
