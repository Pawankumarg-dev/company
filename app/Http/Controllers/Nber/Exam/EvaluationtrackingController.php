<?php

namespace App\Http\Controllers\Nber\Exam;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


use App\Services\Common\HelperService;

use PDF;
use DB;

class EvaluationtrackingController extends Controller
{
    private $helperService;
    private $nber_id;

    public function __construct(HelperService $helper)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $helper;
        $this->nber_id = $this->helperService->getNberID();
    }

    public function index(){
	ini_set('memory_limit','-1');
        // $exampapers = \App\Allexampaper::whereHas('programme',function($q){
        //     $q->where('nber_id',$this->nber_id);
        // })->get();
        // return view('nber.exam.evaluationtracking.index',compact(
        //     'exampapers'
        // ));


 $sql="SELECT
	programmes.abbreviation,
evaluationcenters.name as center_name,
	count(allexamstudents.id) AS total_paper, 
	 SUM(CASE WHEN attendance = 2 THEN 1 ELSE 0 END) AS sum_of_absent,
   SUM(CASE WHEN attendance = 1 THEN 1 ELSE 0 END) AS sum_of_present,
	    SUM(CASE WHEN attendance is NULL THEN 1 ELSE 0 END) AS attendance_notmark,
				    SUM(CASE WHEN external_mark is NOT NULL THEN 1 ELSE 0 END) AS marks_enter
FROM
	evaluationcenterdetails
	INNER JOIN
	allexamstudents
	ON 
		evaluationcenterdetails.externalexamcenter_id = allexamstudents.externalexamcenter_id
	INNER JOIN
	programmes
	ON 
		allexamstudents.programme_id = programmes.id
			INNER JOIN
	evaluationcenters
	ON 
		evaluationcenterdetails.evaluationcenter_id = evaluationcenters.id
		
WHERE
	allexamstudents.exam_id = 27 AND
	programmes.nber_id = " . $this->nber_id ." group by evaluationcenters.id,programmes.id ORDER BY programmes.abbreviation,evaluationcenters.name";



    $exampapers  = DB::select($sql);

 return view('nber.exam.evaluationtracking.index',compact(
            'exampapers'
        ));
        
    }
}
