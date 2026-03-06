<?php

namespace App\Http\Controllers\Nber\Exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\Exam\ApplicationService;
use App\Services\Common\Downloadable;
use Session;

use DB;

class ApplicationController extends Controller
{
    private $helperService;
    private $page;
    private $type;
    private $nber_id;

    public function __construct(HelperService $help)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $help;
        $this->type = app()->request->has('type') ? app()->request->type : 'all';
        $this->nber_id = app()->request->has('showall') && $this->helperService->isRCILogin() ? $this->helperService->getNberORRCIID() : $this->helperService->getNberID();
        $this->nber_id = $this->helperService->getNberORRCIID();
        $this->page =  (new ApplicationService($this->nber_id,$this->type));
    }

    public function index(Request $r){
      $results = $this->page->getList();
      $title = $this->page->getTitle();
      $type = $this->page->getType($r);
      $programmes = $this->page->getProgrammes();
      return $this->nber_id;
      return (new Downloadable('nber/exam','applications',compact(
        'results',
        'title',
        'type',
        'programmes'
      ),$title))->load();
    }

    public function show($id){
      $institute =  $this->page->getGPSDetailsOfInstitute($id);
      //return $institute;
      return view('nber/verify/gps/verify',compact(
        'institute'
      ));
    }

    public function update($id, Request $r){
      $institute = \App\Institute::find($id);
      $verified = $r->verified == 0 ? 1 : 0;
      $institute->verified = $verified;
      $institute->save();
      Session::put('messages','Updated');
      return back();
    }

}
