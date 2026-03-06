<?php

namespace App\Http\Controllers\Ms;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests;

use App\Services\DBService;
use Session;

use Auth;

use App\Services\Common\HelperService;

class QpController extends Controller
{
    private $exam_id;
    private $helper;
    public function __construct(HelperService $help)
    {
        $this->middleware(['role:ms']);
        $this->helper = $help;
        $this->exam_id = $this->helper->getScheduledExamID();
        $this->exam_id = 27;
    }
    public function index(){
        $sp = "getQPUploadStatus(".$this->exam_id.")";
        $status = (new DBService)->callSP($sp);
        return view('ms.stats',compact('status'));
    }
    public function releaseqp(Request $r){
        $examschedules = \App\Examschedule::where('exam_id',$this->exam_id)->groupBy('examdate')->groupBy('starttime')->orderBy('examdate','asc')->orderBy('starttime','asc')->get();
        $schedule = null;
        $timetable = null;
        if($r->has('examschedule_id')){
            $sp = "getExamtimetable(".$r->examschedule_id.")";
            $timetable = (new DBService)->callSP($sp);
            $schedule = \App\Examschedule::find($r->examschedule_id);
        }
        return view('ms.release',compact('examschedules','schedule','timetable'));
    }
    public function publish(Request $r){
        $examschedule = \App\Examschedule::find($r->examschedule_id);
        $examschedule->qpset = $r->set;
        // $exampapers = \App\Exampaper::where('examschedule_id',$r->examschedule_id)->get();
        // foreach($exampapers as $ep){
        //     $password = $this->generateRandomString(8);
        //     $ep->password = $password;
        //     $ep->save();
        // }
        $examschedule->save();
        Session::put('messages','Question Paper Released');
        return back();
    }

    public function generateRandomString($max) {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXY3456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $max; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function show($id,Request $r){
        $timetable =\App\Examtimetable::find($id);
        $examschedule_id = $r->examschedule_id;
            
        $languages = \App\Language::all();
        return view('ms.show',compact(
            'timetable',
            'languages',
            'examschedule_id'
        ));
    }
}
?>