<?php

namespace App\Http\Controllers\Reports\Monitoring;

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
       $this->middleware(['role:reports']);
        $this->helperService = $help;
        $type = app()->request->has('type') ? app()->request->type : 'all';
        $this->page =  (new Attendance($type));
    }
    public function index(Request $r){
      
      $results = $this->page->getExamCenters();
      $title = $this->page->getTitle();
      $type = $this->page->getType();
      $schedules  = $this->page->getSchedules();
      return (new Downloadable('reports/monitoring','attendance',compact(
        'results',
        'title',
        'type',
        'schedules'
      ),$title))->load();
    }
    public function show($id,Request $r){
      $schedule_id = $r->examschedule_id == 'all' ? null :  $r->examschedule_id;
      $approvedprogrammes = $this->page->getApprovedprogrammes($id,$schedule_id);
      if(!is_null($schedule_id)){
        $schedule = $this->page->getSchedule($schedule_id);
      }else{
        $schedule = null;
      }
      $examcenter = $this->page->getExamCenter($id);
      return view('reports.monitoring.attendance.index',compact(
        'approvedprogrammes',
        'schedule',
        'examcenter'
      ));
    }
}
