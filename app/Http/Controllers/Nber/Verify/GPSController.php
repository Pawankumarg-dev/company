<?php

namespace App\Http\Controllers\Nber\Verify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\GPS\VerifyGPS;
use App\Services\Common\Downloadable;
use Session;

use DB;

class GPSController extends Controller
{
    private $helperService;
    private $page;
    private $type;

    public function __construct(HelperService $help)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $help;
        $this->type = app()->request->has('type') ? app()->request->type : 'all';
        $this->page =  (new VerifyGPS($this->helperService->getNberORRCIID(),$this->type));
    }

    public function index(Request $r){
      $results = $this->page->getInstitutes();
      $title = $this->page->getTitle();
      $type = $this->page->getType($r);
      return (new Downloadable('nber/verify','gps',compact(
        'results',
        'title',
        'type'
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
