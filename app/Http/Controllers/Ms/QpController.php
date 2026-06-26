<?php

namespace App\Http\Controllers\Ms;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests;

use App\Services\DBService;
use Session;

use Auth;
use DB;
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
        $this->exam_id = 28;
    }
    public function index(){
        $sp = "getQPUploadStatus(".$this->exam_id.")";
        $status = (new DBService)->callSP($sp);
        return view('ms.stats',compact('status'));
    }
    public function releaseqp(Request $r){
        // $examschedules = \App\Examschedule::where('exam_id',$this->exam_id)->groupBy('examdate')->groupBy('starttime')->orderBy('examdate','asc')->orderBy('starttime','asc')->get();
       
       $examschedules = DB::table('examschedules')
    ->where('exam_id',$this->exam_id)
    ->select(DB::raw('GROUP_CONCAT(id) as id'),'examdate','starttime')
    ->groupBy('examdate', 'starttime')
    ->orderBy('examdate', 'asc')
    ->orderBy('starttime', 'asc')
    ->get();
        $schedule = null;
        $timetable = null;
        if($r->has('examschedule_id')){

        
            // $sp = "getExamtimetable(".$r->examschedule_id.")";
            // $timetable = (new DBService)->callSP($sp);
$sid = explode(',', $r->examschedule_id);
$timetable = DB::table('examtimetables as tt')
    ->join('subjects as s', 's.id', '=', 'tt.subject_id')
    ->join('programmes as p', 'p.id', '=', 's.programme_id')
    ->join('nbers as n', 'n.id', '=', 'p.nber_id')
    ->whereIn('tt.examschedule_id', $sid) // $sid should be array
    ->select(
        'tt.id',
        'n.short_name_code as nber',
        'p.abbreviation as course',
        's.scode',
        's.sname'
    )
    ->get();

            $schedule = \App\Examschedule::find($r->examschedule_id);
        }
        return view('ms.release',compact('examschedules','schedule','timetable'));
    }
    public function publish(Request $r){



        
$examschedule = \App\Examschedule::find($r->examschedule_id);

$examschedule2 = \App\Examschedule::where('examdate', $examschedule->examdate)
    ->where('starttime', $examschedule->starttime)
    ->get();

foreach ($examschedule2 as $schedule) {

    // ✅ Update qpset
    $schedule->qpset = $r->set;
    $schedule->save();

    // ✅ Get papers for THIS schedule (fix here)
    $exampapers = \App\Allexampaper::where('examschedule_id', $schedule->id)->get();
    // $exampapers = \App\Exampaper::where('examschedule_id', $schedule->id)->get();
    foreach ($exampapers as $ep) {
        $ep->password = $this->generateRandomString(8);
        $ep->save();
    }


$exampapers_access = \App\Allexampaper::where('examschedule_id', $schedule->id)
    ->get()
    ->unique('omr_code');

foreach ($exampapers_access as $ep) {

    $qps = DB::table('examtimetable_language')
        ->where('exam_id', $this->exam_id)
        ->where('omr_code', $ep->omr_code)
        ->get();
    foreach ($qps as $qp) 
        {
        $column = 'question_paper_' . $r->set;
            $filePath = public_path('files/questionpapers/' . $this->exam_id . '/' . $qp->$column);
            if (file_exists($filePath)) {
                chmod($filePath, 0755);
            }
    }
}

}
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