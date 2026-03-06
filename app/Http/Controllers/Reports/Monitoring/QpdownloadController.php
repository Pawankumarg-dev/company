<?php

namespace App\Http\Controllers\Reports\Monitoring;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\Monitoring\Qpdownload;
use App\Services\Common\Downloadable;


use DB;


class QpdownloadController extends Controller
{
    private $helperService;

    public function __construct(HelperService $help)
    {
       $this->middleware(['role:reports']);
        $this->helperService = $help;
    }
    public function index(Request $r){
      $type = $r->has('type') ? $r->type : 'all';
      $forms =  (new Qpdownload($type));
      $results = $forms->getQPDownloadStats();
      $title = $forms->getTitle();
      $type = $forms->getType($r);
      $schedules  = $forms->getSchedules();
      return (new Downloadable('reports/monitoring','qpdownload',compact(
        'results',
        'title',
        'type',
        'schedules'
      ),$title))->load();
    }
    public function edit($id, Request $r){
      if($r->has('requirement')){
        if($r->req == 'otp'){
            $examschedule_id = 67;
            $this->verifyotp($id,$examschedule_id);
            $examschedule_id = 68;
            $this->verifyotp($id,$examschedule_id);
        }
        if($r->req == 're1'){
          $examschedule_id = 67;
          $this->redownload($id,$examschedule_id);
          $examschedule_id = 68;
          $this->redownload($id,$examschedule_id);
        }
      }
      return back();
      Session::put('messages','Updated');
    }
    public function redownload($id){
      $histories = \App\Questionpaperdownloadhistory::where('externalexamcenter_id',$id)->where('exam_id',27)->first();
      foreach($histories as $h){
        $h->deleted_at = $h->created_at;
        $h->save();
      }
    }
    public function verifyotp($id,$examschedule_id){
      $otp = \App\Questionpaperotp::where('externalexamcenter_id',$id)->where('exam_id',27)->where('examschedule_id',$examschedule_id)->first();
          if(is_null($otp)){
              \App\Questionpaperotp::create([
                      'externalexamcenter_id' => $id,
                      'examschedule_id' => $examschedule_id,
                      'verified' =>1 ,
                      'exam_id' => 27
              ]);
          }else{
              $otp->verified = 1;
              $otp->save();
          }
    }
}
