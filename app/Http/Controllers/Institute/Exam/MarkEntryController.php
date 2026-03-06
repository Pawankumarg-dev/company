<?php

namespace App\Http\Controllers\Institute\Exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Exam;
use Session;
use App\Academicyear;
use App\Approvedprogramme;
use App\Services\Common\HelperService;
use App\Services\Exam\InternalMarkEntryService;
use DB;
use Exception;
use Auth;

class MarkEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $helperService;
    protected $markentryService;

    public function __construct(HelperService $helper, InternalMarkEntryService $markentry)
    {
        $this->middleware(['role:institute']);
        $this->helperService = $helper;
        $this->markentryService = $markentry;

    }

    public function index(Request $r)
    {

       
    }

    public function getTotal($id,$r){
        if(Session::has($id.$r->syear.$r->subjecttype_id."_totalmark")){
            $totalmark = Session::get($id.$r->syear.$r->subjecttype_id."_totalmark");
        }else{
            $totalmark = $this->markentryService->checkInternalMarkentry($id,$r)->total;
            if(is_null($totalmark)){
                $totalmark = 0;
            }
            Session::put($id.$r->syear.$r->subjecttype_id."_totalmark",$totalmark);
        }
        return $totalmark;
    }
    public function show($id,Request $r)
    {

      
        $subjecttype = \App\Subjecttype::find($r->subjecttype_id);
        $exam  = \App\Exam::find($r->exam_id);
        $approvedprogramme = \App\Approvedprogramme::find($id);
        $programme_id = $approvedprogramme->programme_id;
        $syear = $r->syear;
        $subjects = $this->markentryService->getSubjects($programme_id,$r);
        $supplementary = null;
        if($r->has('supplementary')){
            $supplementary  = "Yes";
        }
        $marks = $this->markentryService->getCandidates($subjects,$id,$r,$supplementary);        
        $marksheet = $this->markentryService->getMarksheet($id,$r);
        $totalmark = $this->getTotal($id,$r);
        return view('institute.exam.markentry.show',compact(
            'marks',
            'exam',
            'subjecttype',
            'subjects',
            'approvedprogramme',
            'syear',
            'marksheet',
            'supplementary',
            'totalmark'
        )); 
    }


    public function edit($id,Request $r)
    {
       
        $approvedprogramme = \App\Approvedprogramme::find($id);
//  if($approvedprogramme->institute_id == 'rrrr')
// {






        $programme_id = $approvedprogramme->programme_id;
        $subjecttype = \App\Subjecttype::find($r->subjecttype_id);
        $exam  = \App\Exam::find($r->exam_id);
        $syear = $r->syear;
        $subjects = $this->markentryService->getSubjects($programme_id,$r);
        $supplementary = null;
        if($r->has('supplementary')){
            $supplementary  ="Yes";
        }
        $marks = $this->markentryService->getCandidates($subjects,$id,$r,$supplementary);  
        $marksheet = $this->markentryService->getMarksheet($id,$r);
        $totalmark = $this->getTotal($id,$r);
        return view('institute.exam.markentry.edit',compact(
            'marks',
            'exam',
            'subjecttype',
            'subjects',
            'approvedprogramme',
            'syear',
            'marksheet',
            'supplementary',
            'totalmark'
        )); 
// }        
      
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //return "Closed";
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
        return redirect('/institute/exam/markentry/'.$id.'?exam_id='.$request->exam_id.'&subjecttype_id='.$request->subjecttype_id.'&syear='.$request->syear.$supplementary);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
