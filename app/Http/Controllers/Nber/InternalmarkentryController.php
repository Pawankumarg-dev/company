<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests;

use App\Newinternalmark;

use App\Services\Common\HelperService;

use App\Services\Exam\InternalMarkEntryService;

use DB;

class InternalmarkentryController extends Controller
{
    private $helperService; 
    private $markentryService;

    public function __construct(HelperService $helper, InternalMarkEntryService $markentry)
    {
       $this->middleware(['role:nber']);
        $this->helperService =  $helper;
        $this->markentryService = $markentry;
    }
	
	 public function index(Request $r){

        if($r->has('institute_id')){
            $isntitute_id = $r->institute_id;
            $insitute_id = $r->institute_id;
            $nber_id = $this->helperService->getNberID();
         /*   $sql = 'select a.approvedprogramme_id as apid, p.numberofterms, p.abbreviation as course, y.year as batch , sum(if(ifnull(na.internalattendance_id,0)=0,0,1)) as immarked from newapplications na 
            left join newapplicants a on a.id = na.newapplicant_id
            left join programmes p on p.id = a.programme_id
            left join approvedprogrammes ap on ap.id = a.approvedprogramme_id
            left join academicyears y on y.id = ap.academicyear_id
            left join courses c on c.id = p.course_id
            left join institutes i on i.id = a.institute_id
            where p.nber_id = ' . $nber_id.' and i.id = ' . $isntitute_id.'
            group by a.approvedprogramme_id
            having immarked = 0 order by c.id, p.id, y.id '; */
            $sql = '
            select a.approvedprogramme_id as apid, p.numberofterms, p.abbreviation as course, y.year as batch, sum(if(ifnull(na.internalattendance_id,0)=0,1,0)) as immarked from newapplications na 
        left join newapplicants a on a.id = na.newapplicant_id
        left join programmes p on p.id = a.programme_id
        left join approvedprogrammes ap on ap.id = a.approvedprogramme_id
        left join academicyears y on y.id = ap.academicyear_id
        left join institutes i on i.id = a.institute_id
        left join courses c on c.id = p.course_id
        left join subjects s on s.id = na.subject_id
        where p.nber_id = '.$nber_id.' and i.id = ' . $isntitute_id.' and   s.is_internal = 1 
        group by a.approvedprogramme_id
        having immarked > 0  order by c.id, p.id, y.id ';
            $result  = DB::select($sql);
            $institute = \App\Institute::find($isntitute_id);
            $courses = array_map(function ($value) {
                return (array)$value;
            }, $result); 
            return view('nber.internalmarkentry.institute',compact('courses','institute','insitute_id'));
        }
        $nber_id = $this->helperService->getNberID();
        $sql = '

select distinct a.institute_id as id,    i.rci_code,  i.name, sum(if(ifnull(na.internalattendance_id,0)=0,1,0)) as immarked from newapplications na 
        left join newapplicants a on a.id = na.newapplicant_id
        left join programmes p on p.id = a.programme_id
        left join approvedprogrammes ap on ap.id = a.approvedprogramme_id
        left join institutes i on i.id = a.institute_id
        left join subjects s on s.id = na.subject_id
        where p.nber_id = '.$nber_id.' and  s.is_internal = 1 
        group by a.approvedprogramme_id
        having immarked > 0 
        
        ';
       /* if($nber_id==2){
            $sql .= ' union select 776 as id , "RJ150" as rci_code, "Shyam University Department of Special Education" as name , 10 as inmarked';
        }*/
        $result  = DB::select($sql);
    
        $institutes = array_map(function ($value) {
            return (array)$value;
        }, $result); 
        return view('nber.internalmarkentry.index',compact('institutes'));
     }

     public function show($id,Request $r)
    {
        $subjecttype = \App\Subjecttype::find($r->subjecttype_id);
        $exam  = \App\Exam::find(25);
        $approvedprogramme = \App\Approvedprogramme::find($id);
        $institute_id =  $approvedprogramme->institute_id;
        $programme_id = $approvedprogramme->programme_id;
        $syear = $r->syear;
        $subjects = $this->markentryService->getSubjects($programme_id,$r);
        $supplementary = null;
        if($r->has('supplementary')){
            $supplementary  = "Yes";
        }
        $marks = $this->markentryService->getCandidates($subjects,$id,$r,$supplementary);        
        $marksheet = $this->markentryService->getMarksheet($id,$r);
        return view('nber.internalmarkentry.markentry.show',compact(
            'marks',
            'exam',
            'subjecttype',
            'subjects',
            'approvedprogramme',
            'syear',
            'marksheet',
            'supplementary'
        )); 
    }


    public function edit($id,Request $r)
    {
        $approvedprogramme = \App\Approvedprogramme::find($id);
        $programme_id = $approvedprogramme->programme_id;
        $subjecttype = \App\Subjecttype::find($r->subjecttype_id);
        $exam  = \App\Exam::find(25);
        $syear = $r->syear;
        $subjects = $this->markentryService->getSubjects($programme_id,$r);
        $supplementary = null;
        if($r->has('supplementary')){
            $supplementary  ="Yes";
        }
        $marks = $this->markentryService->getCandidates($subjects,$id,$r,$supplementary);  
        $marksheet = $this->markentryService->getMarksheet($id,$r);
        return view('nber.internalmarkentry.markentry.edit',compact(
            'marks',
            'exam',
            'subjecttype',
            'subjects',
            'approvedprogramme',
            'syear',
            'marksheet',
            'supplementary'
        )); 
    }

    public function update(Request $request, $id)
    {
        
        if($request->has('candidate_id')){
            $approvedprogramme = \App\Approvedprogramme::find($id);
            $programme_id = $approvedprogramme->programme_id;
            if($request->has('internal')){
                $result  = $this->markentryService->getInternalFailedSubject($request,$programme_id);
            }else{
                $result  = $this->markentryService->getFailedSubject($request,$programme_id);
            }
            return $result;
        }
        if($request->has('uploadsheet')){
            $this->markentryService->uploadmarksheet($request);
        }else{
            $this->markentryService->saveMarks($id,$request);
        }
        $supplementary = '';
        if($request->has('supplementary')){
            $supplementary = '&supplementary=Yes';
            return back();
        }
        return redirect('nber/internalmarkentry/'.$id.'?exam_id='.$request->exam_id.'&subjecttype_id='.$request->subjecttype_id.'&syear='.$request->syear.$supplementary);
    }

}
