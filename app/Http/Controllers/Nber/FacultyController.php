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
use DB;
use App\course;

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

        $instituteIds = $institutes->pluck('id');
  
        if($r->has('institute_id')){
         $faculties = Faculty::where('institute_id',$r->institute_id)->get();
         $institute_id = $r->institute_id;       
        } 

        else{
            $faculties = Faculty::whereIn('institute_id', $instituteIds)->get();
            }      
        return view('nber.faculties.index',compact(
            'institutes','faculties','institute_id'    
        ));
              
    }

    public function course_list(Request $r){    

        $courses =DB::select("select c.id, c.name from approvedprogrammes ap 
		inner join programmes p  on p.id = ap.programme_id
		inner join courses c on c.id = p.course_id 
		where ap.academicyear_id > 8 and c.nber_id = 4 
		GROUP BY c.id ");

        $institutes = [];
        if($r->has('course_id')){
            $id=$r->course_id;
            $institutes = DB::select("SELECT
	programmes.course_id, 
	institutes.`name`, 
	institutes.rci_code,
    institutes.id as institute_id,
	(SELECT count(*)
     FROM faculties
     WHERE faculties.institute_id = institutes.id) AS total_faculty
FROM
	programmes
	INNER JOIN
	approvedprogrammes
	ON 
		programmes.id = approvedprogrammes.programme_id
	INNER JOIN
	institutes
	ON 
		approvedprogrammes.institute_id = institutes.id where programmes.course_id=$r->course_id");
           } 
        return view('nber.faculties.coordinator',compact('courses','institutes','id'));
              
    }
    public function faculty_list(Request $request){    

        echo $request->institute_id;
        
        die();
        $faculties = Faculty::where('institute_id',$r->institute_id)->get();

              
    }
    


   
}