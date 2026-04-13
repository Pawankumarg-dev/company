<?php

namespace App\Http\Controllers\Nber\Eligible;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\EligibleCandidates\SupplementaryService;
use App\Services\Common\Downloadable;

use DB;

class SupplementaryController extends Controller
{
    private $helperService;
    private $nber_id;

    public function __construct(HelperService $help)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $help;
        $this->nber_id = $this->helperService->getNberID();
    }
    public function index(Request $r){
      $type = $r->has('type') ? $r->type : 'all';
      $forms =  (new SupplementaryService($this->nber_id,$type));
      $results = $forms->getCandidates();
      $title = $forms->getTitle();
      $type = $forms->getType($r);
      $nber_id = $this->nber_id;
      $courses = $forms->getCourses();
      return (new Downloadable('nber/eligiblecandidates','supplementary',compact(
        'results',
        'title',
        'type',
        'nber_id',
        'courses'
      ),$title))->load();
    }

    public function show($id,Request $r){
      $type = $r->has('type') ? $r->type : 'all';
      $forms =  (new SupplementaryService($this->nber_id,$type));
      $programmes = $forms->
      $results = $forms->getCandidates();
      $title = $forms->getTitle();
      $type = $forms->getType($r);
      $nber_id = $this->nber_id;
      $courses = $forms->getCourses();
      return (new Downloadable('nber/eligiblecandidates','supplementary',compact(
        'results',
        'title',
        'type',
        'nber_id',
        'courses'
      ),$title))->load();
    }
}

