<?php

namespace App\Http\Controllers\Nber\Monitoring;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\Monitoring\Evaluationprogress;
use App\Services\Common\Downloadable;
use PDF;
use Auth;

use Session;
use DB;
use Illuminate\Support\Facades\Hash;


class EvaluationprogressController extends Controller
{
    private $helperService;
    private $page;



    public function __construct(HelperService $help)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $help;
        $type = app()->request->has('type') ? app()->request->type : 'all';
        $this->page =  (new Evaluationprogress($type));
    }
    public function index(Request $r){
      $results = $this->page->getData();
      $title = $this->page->getTitle();
      $type = $this->page->getType();
      return (new Downloadable('nber/monitoring','evaluationprogress',compact(
        'results',
        'title',
        'type'
      ),$title))->load();
    }
  
    
}
