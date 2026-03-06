<?php

namespace App\Http\Controllers\Examcenter;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Externalexamcenter;
use App\Examtimetable;
use App\Approvedprogramme;
use App\Subject;
use App\Currentapplication;
use App\Examattendancesheet;
use Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Hash;
use App\Services\Common\QuestionpaperdownloadService;
use Symfony\Component\HttpFoundation\Response;

class ExamController extends Controller
{
    private $qpService;
    public function __construct(QuestionpaperdownloadService $qp)
    {
        $this->middleware(['role:examcenter']);
        $this->qpService = $qp;
        
    }
    public function download($sid){
        //$examtimetable =\App\Examtimetable::find($sid);
        $examschedule = \App\Examschedule::find($sid);
        return view('examcenter.downloadqp',compact('examschedule'));
    }
    public function downloadqp(Request $r){
//        return '';

       $download = $this->qpService->downloadquestionpaper(6,$r);
       if($download!=false){
            $header = [
                'Content-Type'=> 'application/pdf',
                'Content-Description' => 'Question Paper'
            ];
            return response()->file('/var/www/html/rcinber/public/'.$download,$header); 
       }
       return back();
    }
    public function index(){
        
        //Session::put('messages','Exam Login is closed');
        //return redirect('logout');
        $ec_id =  Externalexamcenter::where('user_id',Auth::user()->id)->first()->id;
        
        $timetables = Examtimetable::where('exam_id',22)->where('examdate','>','2023-09-01')->whereHas('subject',function($q){
            $q->where('subjecttype_id',1)->where('programme_id', '!=', 38);
        })->groupBy('examdate','starttime')->get();

        if(Auth::user()->id == 58638){
            $timetables = Examtimetable::where('exam_id',22)->whereHas('subject',function($q){
                $q->where('subjecttype_id',1);
            })->groupBy('examdate','starttime')->get(); 
        }

        if($ec_id==1584){
            return view('examcenters.dlindex',compact('timetables'));
        }
        return view('examcenters.index',compact('timetables'));
    }

    public function profile(){
      //  return 'Exam Center Login is closed';

        $ec = Externalexamcenter::where('user_id',Auth::user()->id)->first();
        return view('examcenters.profile',compact('ec'));
    }

    public function verifymobile(Request $r){
     //   return 'Exam Center Login is closed';

        $user_id =  Externalexamcenter::where('user_id',Auth::user()->id)->first()->user_id;
        $otp = $r->otp;
        $user = \App\User::where('id',$user_id)->first();
        if(Hash::check($otp,$user->confirmation_code)){
            $user->confirmed = 1;
            $user->save();
            return response()->json('success');
        }else{
            return response()->json(['error'=>'Could not verify OTP']);
        }
    }

    public function sendotp(){
        //return 'Exam Center Login is closed';

        $apiKey = urlencode('NGU1MDM1NzY3ODc0MzM2NjRlNzQ2NDQ0NWEzMTczNGY=');
        $examcenter =  Externalexamcenter::where('user_id',Auth::user()->id)->first();
        $mobileno = $examcenter->contactnumber1;
        $numbers='91'.$mobileno;
        $numbers = array($numbers);
        $sender = urlencode('DLNBER');
        $otp = rand(1000, 9999);
        //$otp = 1234;
        $message = rawurlencode("Dear Principal, the one time password for NBER-RCI portal is ".$otp.". REHABILITATION COUNCIL OF INDIA");
        $numbers = implode(',', $numbers);
        try{
            $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
            $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
        }catch(Exception $e){
            return response()->json(['error'=>'Could not send OTP']);
        }

        $user = \App\User::where('id',$examcenter->user_id)->first();
        $user->confirmation_code = Hash::make($otp);
        $user->save();
        return response()->json('success');

    }

    public function uploadsheet(Request $r){
        //return 'Exam Center Login is closed';

        $destination = public_path()."/files/examattendancefiles/";
        $file = $r->file('filename');
        $ex = explode('.', $file);
        $extn = end($ex);
        $filename = '22'.$r->apid. "." . $extn ;
        $file->move($destination, $filename);
        Examattendancesheet::create([
            'approvedprogramme_id' => $r->approvedprogramme_id,
            'subject_id' => $r->subject_id,
            'filename' => $file,
            'exam_id' => 22
        ]);
        Session::put('messages','Uploaded');
        return back();
    }
    public function saveattendance(Request $r){
        //return 'Exam Center Login is closed';

        $applications = Currentapplication::where('approvedprogramme_id',$r->approvedprogramme_id)->where('subject_id',$r->subject_id)->get();
        $nber_id = Approvedprogramme::find($r->approvedprogramme_id)->programme->nber_id;
        $message = '';
        $examcenter_id = Externalexamcenter::where('user_id',Auth::user()->id)->first()->id;
        foreach($applications as $application){
            $attendance = 'attendence_'.$application->id;
            $ansbookletfield = 'ansbookno_'.$application->id;
            $application->externalattendance_id = $r->$attendance;
            if($r->$attendance < 1){
                $message = 'Kindly Mark Attendance for all the Students';
            }
            if($r->$ansbookletfield =='' && $r->$attendance ==1){
                $message = 'Kindly Mark Attendance for all the Students with Answerbooklet Number';
            }else{
                $application->dummy_number = $r->$ansbookletfield; 
            }
            $application->externalexamcenter_id = $examcenter_id;
            $application->save();
        }   
        if($message==''){
            Session::put('messages','Updated');
        }else{
            Session::put('error',$message);
        }
        return back();
    }
    public function attendancemarkging(Request $r){
        //return 'Exam Center Login is closed';

        $ec_id =  Externalexamcenter::where('user_id',Auth::user()->id)->first()->id;

        $examdate = $r->examdate;
        $starttime = $r->starttime;
        $endtime = $r->endtime;
        $examcenter_id = Externalexamcenter::where('user_id',Auth::user()->id)->first()->id;
        $institute_ids  = DB::select("select distinct institute_id from kvttis where externalexamcenter_id = " . $examcenter_id);
        $approvedprogrammes =    Approvedprogramme::whereIn('institute_id',array_pluck($institute_ids,'institute_id'))->get();
        if($ec_id==1584){
            $institute_ids  =  DB::select("select id from institutes where rci_code like '%DL%'");
            $approvedprogrammes =    Approvedprogramme::whereIn('institute_id',array_pluck($institute_ids,'id'))->get();
        }
        return view('examcenters.attendance.index',compact('examdate','starttime','endtime','approvedprogrammes'));
    }

    public function marktheattendance($apid,$subject_id,Request $r){
        //return 'Exam Center Login is closed';

        $ec_id =  Externalexamcenter::where('user_id',Auth::user()->id)->first()->id;

        $examdate = $r->examdate;
        $starttime = $r->starttime;
        $endtime = $r->endtime;
        $examcenter_id = Externalexamcenter::where('user_id',Auth::user()->id)->first()->id;
        $institute_ids  = DB::select("select distinct institute_id from kvttis where externalexamcenter_id = " . $examcenter_id);
        $approvedprogramme_ids =    Approvedprogramme::whereIn('institute_id',array_pluck($institute_ids,'institute_id'))->pluck('id')->toArray();

        if($ec_id==1584){
            $institute_ids  =  DB::select("select id from institutes where rci_code like '%DL%'");
            $approvedprogramme_ids =    Approvedprogramme::whereIn('institute_id',array_pluck($institute_ids,'id'))->orderBy('programme_id')->pluck('id')->toArray();
        }
        if(in_array($apid, $approvedprogramme_ids)){
            $timetable= Examtimetable::where('subject_id',$subject_id)->where('exam_id',22)->first();
            if($examdate==$timetable->examdate && $starttime == $timetable->starttime){
                $applications = Currentapplication::where('approvedprogramme_id',$apid)->where('subject_id',$subject_id)->get();
                $approvedprogramme = Approvedprogramme::find($apid);
            }else{
                return redirect('/examcenter');
            }
            return view('examcenters.attendance.mark',compact('examdate','starttime','endtime','applications','approvedprogramme'));
        }else{
            return redirect('/examcenter');
        }
    }

    public function list(Request $r){
        //return 'Exam Center Login is closed';

        $examdate = $r->examdate;
        $starttime = $r->starttime;
        $endtime = $r->endtime;
        $examcenter_id = Externalexamcenter::where('user_id',Auth::user()->id)->first()->id;
        $institute_ids  = DB::select("select distinct institute_id from kvttis where externalexamcenter_id = " . $examcenter_id);
        $approvedprogrammes =    Approvedprogramme::whereIn('institute_id',array_pluck($institute_ids,'institute_id'))->get();
        return view('examcenters.studentlist',compact('examdate','starttime','endtime','approvedprogrammes'));
    }

    public function printlist(Request $r){
        //return 'Exam Center Login is closed';

        $ec_id =  Externalexamcenter::where('user_id',Auth::user()->id)->first()->id;
        $examdate = $r->examdate;
        $starttime = $r->starttime;
        $endtime = $r->endtime;
        $examcenter = Externalexamcenter::where('user_id',Auth::user()->id)->first();
        $institute_ids  = DB::select("select distinct institute_id from kvttis where externalexamcenter_id = " . $examcenter->id);
        $approvedprogrammes =    Approvedprogramme::whereIn('institute_id',array_pluck($institute_ids,'institute_id'))->get();
        if($ec_id==1584){
            $institute_ids  =  DB::select("select id from institutes where rci_code like '%DL%'");
            $approvedprogrammes =    Approvedprogramme::whereIn('institute_id',array_pluck($institute_ids,'id'))->get();
        }
        return view('examcenters.printstudentlist',compact('examdate','starttime','endtime','approvedprogrammes','examcenter'));
    }

    public function timetable(){
        //return 'Exam Center Login is closed';

        $examcenter_id = Externalexamcenter::where('user_id',Auth::user()->id)->first()->id;
        $institute_ids  = DB::select("select distinct institute_id from kvttis where externalexamcenter_id = " . $examcenter_id);
        $programme_ids =    Approvedprogramme::whereIn('institute_id',array_pluck($institute_ids,'institute_id'))->pluck('programme_id');
        $subjects = Subject::whereIn('programme_id',$programme_ids)->where('subjecttype_id',1)->pluck('id');
        $timetables= Examtimetable::whereIn('subject_id',$subjects)->where('exam_id',22)->get();
        return view('examcenters.timetable',compact('timetables'));
    }
    public function institutes(){
        //return 'Exam Center Login is closed';

        $examcenter_id = Externalexamcenter::where('user_id',Auth::user()->id)->first()->id;
        $institute_ids  = DB::select("select distinct institute_id from kvttis where externalexamcenter_id = " . $examcenter_id);
        $approvedprogrammes =    Approvedprogramme::whereIn('institute_id',array_pluck($institute_ids,'institute_id'))->orderBy('institute_id')->get();
        return view('examcenters.institutes',compact('approvedprogrammes'));
    }
    public function roomallocation(Request $r){
        //return 'Exam Center Login is closed';

        $ec_id =  Externalexamcenter::where('user_id',Auth::user()->id)->first()->id;
        $examdate = $r->examdate;
        $starttime = $r->starttime;
        $endtime = $r->endtime;
        $languages = \App\Language::all()->pluck('language');
        $examcenter_id = Externalexamcenter::where('user_id',Auth::user()->id)->first()->id;
        $institute_ids  = DB::select("select distinct institute_id from kvttis where externalexamcenter_id = " . $examcenter_id);
        $approvedprogramme_ids =    Approvedprogramme::whereIn('institute_id',array_pluck($institute_ids,'institute_id'))->orderBy('programme_id')->pluck('id');

        if($ec_id==1584){
            $institute_ids  =  DB::select("select id from institutes where rci_code like '%DL%'");
            $approvedprogramme_ids =    Approvedprogramme::whereIn('institute_id',array_pluck($institute_ids,'id'))->orderBy('programme_id')->pluck('id');
        }
       // $approvedprogrammes =    Approvedprogramme::whereIn('institute_id',array_pluck($institute_ids,'institute_id'))->get();
       $applications = \App\Currentapplication::whereIn('approvedprogramme_id',$approvedprogramme_ids)->whereHas('subject',function($q) use ($examdate, $starttime){
        $q->whereHas('examtimetables',function($p) use ($examdate,$starttime){
            $p->where('exam_id',22)->where('examdate',$examdate)->where('starttime',str_replace("'",'',$starttime));
        });
        })->with('candidate')->with('subject')->get(); 
        return view('examcenters.roomallocation',compact('examdate','starttime','endtime','applications'));
    }
    
}
