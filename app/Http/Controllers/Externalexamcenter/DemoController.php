<?php

namespace App\Http\Controllers\Externalexamcenter;

use App\Demo;
use App\Demoexamattendance;
use App\Demoexternalexamcenter;
use App\Exam;
use App\Examtimetable;
use App\Externalexamcenter;
use App\Language;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Session;
use File;
use Input;
use Response;
use PDF;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DemoController extends Controller
{
    //
    public function index() {
        $exam = "Demo Exam";
        $title = "Demo Exam Center - Login Page";

        return view('externalexamcenter.demo.index', compact('exam', 'title'));
    }

    public function checklogin(Request $request) {
        $validator = validator($request->all());
        $demoexternalexamcenter = Demoexternalexamcenter::where('code', strtoupper($request->demoexternalexamcenter_code))->where('active_status', 1)->first();

        $validator->after(function ($validator) use ($request, $demoexternalexamcenter) {
            if(is_null($request->demoexternalexamcenter_code) || is_null($request->demoexternalexamcenter_password)) {
                if(is_null($request->demoexternalexamcenter_code) && is_null($request->demoexternalexamcenter_password)) {
                    $validator->errors()->add('demoexternalexamcenter_code', 'Please enter the login credentials');
                    $validator->errors()->add('demoexternalexamcenter_password', '');
                }
            }
            else {
                if(is_null($demoexternalexamcenter)) {
                    $validator->errors()->add('demoexternalexamcenter_code', 'Please enter the valid login credentials');
                }
                else {
                    if(strtolower($request->demoexternalexamcenter_password) != $demoexternalexamcenter->password) {
                        $validator->errors()->add('demoexternalexamcenter_code', 'Please enter the valid login credentials');
                    }
                }
            }
        });

        $this->validateWith($validator);
        return redirect('/demoexternalexamcenter/showhomepage');
    }

    public function showhomepage() {
        $exam = "Demo Exam";
        $title = "Demo Exam Center - Home Page";

        return view('externalexamcenter.demo.showhomepage', compact('exam', 'title'));
    }

    public function demoattendancesheet() {
        $exam = "Demo Exam";
        $title = "Demo Exam Center - Demo Attendance Sheet";

        return view('externalexamcenter.demo.demoattendancesheet', compact('exam', 'title'));
    }

    public function downloaddemoattendancesheet($id) {
        $exam = "Demo";
        $title = "Demo Exam Center - Demo Attendance Sheet";

        return view('externalexamcenter.demo.downloaddemoattendancesheet', compact('exam', 'title', 'id'));
    }

    public function demoquestionpaper() {
        $exam = "Demo";
        $title = "Demo Exam Center - Demo Question Paper";
        $externalexamcenter = Demoexternalexamcenter::find(1);

        return view('externalexamcenter.demo.demoquestionpaper', compact('exam', 'title', 'externalexamcenter'));
    }

    public function downloaddemoquestionpaper($id) {
        $file = public_path().'/files/documents/Subject-'.$id.'.pdf';
        return Response::download($file);
    }

    public function markattendance($id) {
        $exam = "Demo";
        $title = "Demo Exam Center - Demo Mark Attendance";
        $externalexamcenter = Demoexternalexamcenter::find(1);
        $languages = Language::orderBy("language")->get();

        return view('externalexamcenter.demo.markdemoattendance', compact('exam', 'title', 'externalexamcenter', 'id', 'languages'));
    }

    public function addattendance(Request $request) {
        $count = Demoexamattendance::where('filename', 'like', "D2021C".'%')->get();
        $filecount = $count->unique('filename')->count();
        $filecount++;
        $file = $request->file('filename');

        $reference_number = "D2021C".str_pad($filecount, 3, '0', STR_PAD_LEFT);
        $filename = $reference_number . '.' . $file->getClientOriginalExtension();
        $destination = public_path() . "/files/demoexamattendancefiles/";
        $file->move($destination, $filename);

        $sno = 1;

       for ($i=0; $i<5; $i++) {
           $attendance = $request->ext_attendance[$i];

           $language_id = 13;
           $answersheet_serialnumber = null;

           if($attendance == 1) {
                $language_id = $request->language_id[$i];
               $answersheet_serialnumber = $request->answerbookletno[$i];
           }

           Demoexamattendance::create([
               "exam" => "Demo Exam",
               "subject_id" => $request->id,
               "enrolmentno" => $sno.$sno.$sno.$sno.$sno,
               "name" => "Name-".$sno,
               "language_id" => $language_id,
               "externalattendance_id" => $attendance,
               "filename" => $filename,
               "answersheet_serialnumber" => $answersheet_serialnumber,
           ]);
           $sno++;
        }

       return redirect('/demoexternalexamcenter/demoattendancesheet/viewmarkedattendance/'.$request->id);
    }

    public function viewmarkedattendance($id) {
        $exam = "Demo";
        $title = "Demo Exam Center - Demo View Marked Attendance";
        $externalexamcenter = Demoexternalexamcenter::find(1);
        $demoexamattendances = Demoexamattendance::where("subject_id", $id)->get();
        $filename = $demoexamattendances->unique('filename')->first()->filename;

        return view('externalexamcenter.demo.viewmarkedattendance', compact('id','exam', 'title', 'externalexamcenter', 'demoexamattendances', 'filename'));
    }

    public function showupdateattendances($eid, $ectid) {
        $exam = Exam::where('id', '14')->first();
        $title = $exam->name." - Mark Attendance";

        $externalexamcenter = Externalexamcenter::find($ectid);
        $languages = Language::orderBy("language")->get();

        return view('externalexamcenter.demo.showupdate', compact('exam', 'title', 'externalexamcenter', 'languages'));
    }

    public function updateattendances($eid, $ectid) {

    }
}
