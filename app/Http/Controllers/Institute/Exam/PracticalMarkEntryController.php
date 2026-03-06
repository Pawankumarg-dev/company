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
use App\Services\Exam\ExternalMarkEntryService;
use DB;
use Exception;


class PracticalMarkEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $helperService;
    protected $markentryService;

    public function __construct(HelperService $helper, ExternalMarkEntryService $markentry)
    {
        $this->middleware(['role:institute']);
        $this->helperService = $helper;
        $this->markentryService = $markentry;

    }

    public function index(Request $r)
    {

       
    }

    public function show($id,Request $r)
    {
        if($r->subjecttype_id != 2){
            return false;
        }
        $subjecttype = \App\Subjecttype::find($r->subjecttype_id);
        $exam  = \App\Exam::find($r->exam_id);
        $approvedprogramme = \App\Approvedprogramme::find($id);
        $programme_id = $approvedprogramme->programme_id;
        $syear = $r->syear;
     //   $subjectIDs = $this->markentryService->getSubjectIDs($programme_id,$r);
        $subjects = $this->markentryService->getSubjects($programme_id,$r);
        $supplementary = null;
        if($r->has('supplementary')){
            $supplementary  = "Yes";
        }
        $marks = $this->markentryService->getCandidates($subjects,$id);        
        $marksheet = $this->markentryService->getMarksheet($id,$r);
        return view('institute.exam.practicalmarkentry.show',compact(
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
        return "Closed";
        if($r->subjecttype_id != 2){
            return false;
        }
        $approvedprogramme = \App\Approvedprogramme::find($id);
        $programme_id = $approvedprogramme->programme_id;
        $subjecttype = \App\Subjecttype::find($r->subjecttype_id);
        $exam  = \App\Exam::find($r->exam_id);
        $syear = $r->syear;
        $subjects = $this->markentryService->getSubjects($programme_id,$r);
        $supplementary = null;
        if($r->has('supplementary')){
            $supplementary  ="Yes";
        }
        $marks = $this->markentryService->getCandidates($subjects,$id);  
        $marksheet = $this->markentryService->getMarksheet($id,$r);
        return view('institute.exam.practicalmarkentry.edit',compact(
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


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return "Closed";
        // if($request->has('candidate_id')){
        //     $approvedprogramme = \App\Approvedprogramme::find($id);
        //     $programme_id = $approvedprogramme->programme_id;
        //     if($request->has('internal')){
        //         $result  = $this->markentryService->getInternalFailedSubject($request,$programme_id);
        //     }else{
        //         $result  = $this->markentryService->getFailedSubject($request,$programme_id);
        //     }
        //     return $result;
        // }
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
        return redirect('/institute/exam/practicalmarkentry/'.$id.'?exam_id='.$request->exam_id.'&subjecttype_id='.$request->subjecttype_id.'&syear='.$request->syear.$supplementary);
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
