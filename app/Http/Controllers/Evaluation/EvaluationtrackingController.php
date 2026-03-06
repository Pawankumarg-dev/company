<?php

namespace App\Http\Controllers\Evaluation;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


use App\Services\Common\HelperService;

use PDF;
use App\Services\Evaluation\EvaluationService;

use DB;

class EvaluationtrackingController extends Controller
{
    private $helperService;
    private $evaluationcenter_id;
	private $evaluationService;

    public function __construct(HelperService $helper,EvaluationService $evaluation)
    {
        $this->middleware(['role:evaluationcenter']);
        $this->helperService = $helper;
        $this->evaluationcenter_id = $this->helperService->getEvaluationcenterID();
        $this->evaluationService = $evaluation;

    }

    public function index(){
 ini_set('memory_limit','-1');

        // $exampapers = \App\Allexampaper::where('evaluationcenter_id',$this->evaluationcenter_id)->where('exam_id',27)->get();

		        $evaluationcenter_id =  $this->evaluationService->getExternalexamcenterIDs($this->evaluationcenter_id);

         $exampapers = \App\Allexampaper::where('evaluationcenter_id',$this->evaluationcenter_id)->where('exam_id',27)->get();


		// print_r($evaluationcenter_id);
		// die();

//         $sql = "SELECT
// 	es.examdate as examdate,
// 	ec.code as code,
// 	ec.name as name, 
// 	i.rci_code as rci_code,
// 	i.name as iname,
// 	s.scode as scode,
// 	s.sname as scode,
// 	ep.scan_copy as scan_copy,
// 		sum( if(na.attendance_ex = 1, 1, 0)) AS present,
// 		sum( if(na.attendance_ex = 2, 1, 0)) AS absent,
// 		sum( if(na.attendance_ex is null , 1, 0)) AS pending,
// 		sum( if(na.mark_ex IS NOT NULL, 1, 0)) AS evaluated
// FROM
// 	allapplications na
// 	LEFT JOIN allapplicants a ON a.candidate_id = na.candidate_id and a.exam_id=27
// 	left join exampapers ep on ep.approvedprogramme_id = a.approvedprogramme_id and ep.subject_id = na.subject_id
// 	left join externalexamcenters ec on ec.id = ep.externalexamcenter_id
// 	LEFT JOIN evaluationcenterdetails evcd ON evcd.externalexamcenter_id = ep.externalexamcenter_id AND evcd.exam_id = 27
// 	LEFT JOIN evaluationcenters evc ON evc.id = evcd.evaluationcenter_id
// 	LEFT JOIN subjects s ON s.id = na.subject_id
// 	left join examtimetables et on et.subject_id = s.id and et.exam_id = 27
// 	left join examschedules es on es.id = et.examschedule_id
// 	left join programmes p on p.id = ep.programme_id
// 	left join courses c on c.id = p.course_id
// 	left join institutes i on i.id = ep.institute_id
	
// WHERE
// 	na.exam_id=27 and s.subjecttype_id = 1 and evc.id = " . $this->evaluationcenter_id ."  
// GROUP BY
//     a.approvedprogramme_id";


$sql="SELECT
programmes.id,
	programmes.abbreviation,

	count(allexamstudents.id) AS total_paper, 
	 SUM(CASE WHEN attendance = 2 THEN 1 ELSE 0 END) AS sum_of_absent,
   SUM(CASE WHEN attendance = 1 THEN 1 ELSE 0 END) AS sum_of_present,
	    SUM(CASE WHEN attendance is NULL THEN 1 ELSE 0 END) AS attendance_notmark,
				    SUM(CASE WHEN external_mark is NOT NULL and attendance!=2 THEN 1 ELSE 0 END) AS marks_enter


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
WHERE
	allexamstudents.exam_id = 27 AND
	evaluationcenterdetails.evaluationcenter_id = " . $this->evaluationcenter_id ." group by programmes.id";

    $rVal  = DB::select($sql);
        
    // $rVal = array_map(function ($value) {
    //     return (array)$value;
    // }, $result); 
    // return $rVal;

        return view('evaluationcenters.evaluationtracking.index',compact(
            'rVal'
        ));
    }
}
