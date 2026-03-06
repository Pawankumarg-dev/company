<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\Exam\GeotaggedphotouploadService;
use Maatwebsite\Excel\Facades\Excel;

use DB;
use App\Http\Requests;

class GeotaggedphotoController extends Controller
{
    private $helperService;
    private $gtService;

    public function __construct(HelperService $help,GeotaggedphotouploadService $gt)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $help;
        $this->gtService = $gt;
    }
    public function index(Request $r){
        if($r->has('institute')){
            //$institute_ids = \App\Newapplicant::pluck('institute_id')->unique()->toArray();
            $sql = ' select id, rci_code, name from institutes where id in(select distinct institute_id from newapplicants) order by rci_code';
            $result = DB::select($sql);
            $institutes = array_map(function ($value) {
                return (array)$value;
            }, $result);
            
            return view('nber.geotaggedphotos.institutes',compact('institutes'));
        }
        if($r->has('excel')){
            $nber_id = $this->helperService->getNberID();
            $sql = "
            SELECT
                t1.rci_code,
                t1.name AS Institute,
                t1.abbreviation AS course,
                t1.scode AS subject_code,
                t1.sname AS subject_name,
                t1.year AS batch,
                t1.no_of_students,
                t1.no_of_applications,
                t1.no_of_external_marks_uploaded,
                case t1.is_external when 1  then t1.no_of_applications - t1.no_of_external_marks_uploaded else 0 end AS pending_external_entries,
                t1.no_of_internal_marks_uploaded,
                case t1.is_internal when 1  then  t1.no_of_applications - t1.no_of_internal_marks_uploaded else 0 end  AS pending_internal_entries,
                group_concat(DISTINCT pe.name) AS examiner,
                group_concat(DISTINCT mobile) AS contact_no,
                group_concat(DISTINCT email) AS email
            FROM (
                SELECT
                    i.id AS iid,
                    p.course_id AS pid,
                    ap.id AS apid,
                    i.rci_code,
                    i.name,
                    p.abbreviation,
                    y.year,
                    count(DISTINCT na.candidate_id) AS no_of_students,
                    count(*) AS no_of_applications,
                    sum( if(ifnull(`external_mark`, 0) > 0 or externalattendance_id = 2 , 1, 0)) as no_of_external_marks_uploaded,
                    sum( if(ifnull(`internal_mark`, 0) > 0 or internalattendance_id = 2 , 1, 0)) as no_of_internal_marks_uploaded,
                    s.scode,
                    s.sname,
		            s.id as sid,
                    s.is_internal,
                    s.is_external
                FROM
                    newapplications na
                LEFT JOIN subjects s ON s.id = na.subject_id
                LEFT JOIN newapplicants a ON a.id = na.newapplicant_id
                LEFT JOIN programmes p ON p.id = a.programme_id
                LEFT JOIN institutes i ON i.id = a.institute_id
                LEFT JOIN approvedprogrammes ap ON ap.id = a.approvedprogramme_id
                LEFT JOIN academicyears y ON y.id = ap.academicyear_id
            WHERE
                s. `subjecttype_id` = 2 and p.nber_id = " . $nber_id. "
            GROUP BY
                a.approvedprogramme_id,
                na.subject_id) AS t1
                LEFT JOIN practicalexams e ON e.institute_id = t1.iid AND e.course_id = t1.pid
                LEFT JOIN practicalexaminers pe ON pe.id = e.practicalexaminer_id
            GROUP BY
                t1.apid, t1.sid
            HAVING
                pending_external_entries > 0 or pending_internal_entries > 0

                ";
            $result = DB::select($sql);
            $progress = array_map(function ($value) {
                return (array)$value;
            }, $result);
            //return $progress;
            Excel::create('PEprogress', function ($excel) use($progress){
                $excel->sheet('progress', function ($sheet) use($progress){
                    $sheet->loadview('nber.geotaggedphotos.ttiwiseexcel',[
                        'progress' => $progress
                    ]);
                });
            })->export('xls');
        }
        $date = \Carbon\Carbon::now()->toDateString();
        if($r->has('date')){
            $date = $r->date;
        }
        $gtphotos = \App\Geotaggedphoto::where('exam_date',$date)->get();
        $nber_id = $this->helperService->getNberID();
        $type = 'date';
        return view('nber.geotaggedphotos.index',compact('gtphotos','nber_id','date','type'));
    }

    public function show($id, Request $r){
        if($r->has('institute')){
            $awardlists = \App\Awardlisttemplate::where('institute_id',$id)->get();
            if($r->has('photos')){
                
                $gtphotos = \App\Geotaggedphoto::whereHas('practicalexam',function($q) use ($id){
                    $q->where('institute_id',$id);
                })->get();
                
                $nber_id = $this->helperService->getNberID();
                $instite = \App\Institute::find($id);
                $date =  $instite->rci_code . ' - ' . $instite->name;
                $type = 'institute';
                $iid = $id;
                return view('nber.geotaggedphotos.index',compact('gtphotos','nber_id','date','type','iid'));
            }
        }else{
        $date = $id;
            if($date==0){
                $awardlists = \App\Awardlisttemplate::all();
            }else{
                $awardlists = \App\Awardlisttemplate::where('exam_date',$date)->get();
            }
        }
        $count = 0; $ofzero =0 ;
        /*foreach($awardlists as $list){
            foreach($list->subjects as $s){
                if($s->pivot->marks_upload == 0 ){
                    $ofzero ++;
                    $na = \App\Newapplication::whereHas('newapplicant',function($q) use($list) {
                        $q->where('approvedprogramme_id',$list->approvedprogramme_id);
                    })->where('subject_id',$s->id)->first();
                    if(!is_null($na)){
                        if($na->external_mark>0){
                            $s->pivot->marks_upload = 1;
                            $s->pivot->save();
                            $count++;
                        }
                    }
                }
            }
        }
        */
        $nber_id = $this->helperService->getNberID();
        return view('nber.geotaggedphotos.show',compact('awardlists','nber_id'));
    }
}
