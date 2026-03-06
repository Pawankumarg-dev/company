<?php

namespace App\Http\Controllers\Nber;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Faculty;
use App\Institute;
use App\User;
use App\Approvedprogramme;
use App\Programme;
use App\Services\Common\HelperService;
use Session;
use Auth;

class FacultyController extends Controller
{

    public function __construct(HelperService $helper)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $helper;
    }
    public function index(Request $r){    
        $institutes = $this->helperService->getInsitututeList();
        $faculties = null;
        $institute_id = null;
        if($r->has('institute_id')){
         $faculties = Faculty::where('institute_id',$r->institute_id)->get();
         $institute_id = $r->institute_id;       
        }       
        return view('nber.faculties.index',compact(
            'institutes','faculties','institute_id'    
        ));
              
    }

   
}