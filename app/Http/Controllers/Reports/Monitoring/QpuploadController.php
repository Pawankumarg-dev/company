<?php

namespace App\Http\Controllers\Reports\Monitoring;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\Monitoring\Qpupload;
use App\Services\Common\Downloadable;


use DB;


class QpuploadController extends Controller
{
    private $helperService;

    public function __construct(HelperService $help)
    {
       $this->middleware(['role:reports']);
        $this->helperService = $help;
    }
    public function index(Request $r){
      $type = $r->has('type') ? $r->type : 'all';
      $forms =  (new Qpupload($type));
      $results = $forms->getQPuploadStats();
      $title = $forms->getTitle();
      $type = $forms->getType($r);
      $schedules  = $forms->getSchedules();
      return (new Downloadable('reports/monitoring','qpupload',compact(
        'results',
        'title',
        'type',
        'schedules'
      ),$title))->load();
    }
}
