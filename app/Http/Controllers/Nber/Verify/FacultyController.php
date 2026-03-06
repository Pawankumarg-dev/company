<?php

namespace App\Http\Controllers\Nber\Verify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\Faculty\VerifyFaculty;
use App\Services\Common\Downloadable;
use Session;
use App\FacultyResponsibility;
use App\FacultyLanguage;
use DB;

class FacultyController extends Controller
{
    private $helperService;
    private $page;
    private $type;

    public function __construct(HelperService $help)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $help;
        $this->type = app()->request->has('type') ? app()->request->type : 'all';
        $this->page =  (new VerifyFaculty($this->helperService->getNberID(),$this->type));
    }

    public function index(Request $r){
      $results = $this->page->getFaculties();
      $title = $this->page->getTitle();
      $type = $this->page->getType($r);
      return (new Downloadable('nber/verify','faculties',compact(
        'results',
        'title',
        'type'
      ),$title))->load();
    }

    public function show($id){
      $faculties =  $this->page->getFacultyDetailsOfInstitute($id);
      $institute = \App\Institute::find($id);
      //return $faculties;
      return view('nber/verify/faculties/verify',compact(
        'faculties',
        'institute'
      ));
    }

    public function update($id, Request $r){
      $faculty = \App\Faculty::find($id);
      $verified = $r->verified == 0 ? 1 : 0;
      $faculty->verified = $verified;
      $faculty->save();
      Session::put('messages','Updated');
      return back();
    }

}
