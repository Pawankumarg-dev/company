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
use App\Subjectofevaluator;
use DB;

class FacultyrespController extends Controller
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
      $results = $this->page->getallFaculties();
      $title = $this->page->getTitle();
      $type = $this->page->getType($r);
      return (new Downloadable('nber/verify','facultiesresp',compact(
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
    public function update(Request $request, $id)
    {
      $role = $request->input('role');
      $status = $request->input('status');
      $cid = $request->input('cid');
      $faculty = FacultyResponsibility::where('faculty_id',$id)->where('responsibility_type',$role)->where('course_id',$cid)->first();
      if(is_null($faculty)){
        $faculty = FacultyResponsibility::where('faculty_id',$id)->where('responsibility_type',$role)->first();
      }
        if ($role == 'CLO') {
            if($status==1){
              $faculty->clo_verified = false;
            }else{
              $faculty->clo_verified = true;
            }
        } elseif ($role == 'Practical Examiner') {
            if($status==1){
              $faculty->practical_examiner_verified = false;
            }else{
              $faculty->practical_examiner_verified = true;
            }
        } elseif ($role == 'Evaluator') {
            // $evaluators = \App\Subjectofevaluator::where('exam_id',27)->where('faculty_id',$id)->get();
            // foreach($evaluators as $e){
            //   $e->delete();
            // }
            if($status==1){
              $faculty->evaluator_verified = false;
            }else{
              $faculty->evaluator_verified = true;
              $subjects = $request->subjects;
              $languages = \App\FacultyLanguage::where('faculty_id',$id)->get();
              foreach($languages as $l){
                foreach(explode($subjects,',') as $s){
                  $soe = \App\Subjectofevaluator::where(
                    [
                      'exam_id' => 27,
                    'faculty_id' => $id,
                    'language_id' => $l->language_id,
                    'subject_id' => $s
                    ]
                  )->first();
                  if(is_null($soe)){
                    \App\Subjectofevaluator::create([
                      'exam_id' => 27,
                      'faculty_id' => $id,
                      'language_id' => $l->language_id,
                      'subject_id' => $s
                    ]);
                  }
                }
              }
            }

        }
      
        $faculty->save();
    
        return response()->json(['message' => 'Verification updated successfully']);
    }


}
