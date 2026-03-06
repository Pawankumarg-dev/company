<?php

namespace App\Http\Controllers\Nber\Monitoring;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\Monitoring\Attendance;
use App\Services\Common\Downloadable;


use DB;


class AttendanceController extends Controller
{
    private $helperService;
    private $page;

    public function __construct(HelperService $help)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $help;
        $type = app()->request->has('type') ? app()->request->type : 'all';
        $this->page =  (new Attendance($type));
    }
    public function index(Request $r){
      
      $results = $this->page->getExamCenters();
      $title = $this->page->getTitle();
      $type = $this->page->getType();
      $schedules  = $this->page->getSchedules();
      return (new Downloadable('nber/monitoring','attendance',compact(
        'results',
        'title',
        'type',
        'schedules'
      ),$title))->load();
    }
    public function show($id,Request $r){




     
      $schedule_id = $r->examschedule_id == 'all' ? null :  $r->examschedule_id;
      
      $approvedprogrammes = $this->page->getApprovedprogrammes($id,$schedule_id);
// $nber_id=4;

// $approvedprogrammes = \App\Allexampaper::select('allexampapers.*', 'programmes.*')
//     ->where('exam_id', 27)
//     ->where('externalexamcenter_id', $id)
//     ->where('examschedule_id', $schedule_id)
//     ->join('programmes', function ($join) use ($nber_id) {
//         $join->on('allexampapers.programme_id', '=', 'programmes.id')
//              ->where('programmes.nber_id', '=', $nber_id);
//     })
//     ->get();

// return $approvedprogrammes;

      if(!is_null($schedule_id)){
        $schedule = \App\Examschedule::find($schedule_id);
      }else{
        $schedule = null;
      }
      // $examcenter = $this->page->getExamCenter($id);
$examcenter =\App\Externalexamcenter::find($id);

// $examcente='';
// $schedule='';
      return view('nber.monitoring.attendance.index',compact(
        'approvedprogrammes',
        'schedule',
        'examcenter'
      ));
    }
}
// NBERrciapp##1616