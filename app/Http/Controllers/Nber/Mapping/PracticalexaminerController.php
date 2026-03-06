<?php

namespace App\Http\Controllers\Nber\Mapping;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\Mapping\PracticalExaminerMapping;
use App\Services\Common\Downloadable;
use PDF;
use Auth;

use Session;
use DB;
use Illuminate\Support\Facades\Hash;


class PracticalexaminerController extends Controller
{
    private $helperService;
    private $page;

    public function __construct(HelperService $help)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $help;
        $type = app()->request->has('type') ? app()->request->type : 'all';
        $this->page =  (new PracticalExaminerMapping($type));
    }
    public function index(Request $r){
      set_time_limit(300);
      ini_set('memory_limit','-1');
      ini_set('max_execution_time',300);
      $results = $this->page->getPracticalExaminers();
      $title = $this->page->getTitle();
      $type = $this->page->getType();
      $faculties = $this->page->getListofFaculties();
      //return $faculties;
      return (new Downloadable('nber/mapping','practicalexaminers',compact(
        'results',
        'title',
        'type',
        'faculties'
      ),$title))->load();
    }

    public function store(Request $r){
      //$programme_ids =  \App\Subject::whereIn('id',$r->subjects)->pluck('programme_id')->unique();
      // Session::put('messages','Closed');
      // return back();
      // $existing =  \App\Practicalexam::where('institute_id',$r->institute_id)->where('faculty_id',$r->faculty_id)->where('exam_id',27)->get();
      // if($existing->count() > 0 ){
      //   foreach($existing as $ex){
      //     $ex->start_date = $r->start_date;
      //     $ex->end_date = $r->end_date;
      //     $ex->save();
      //     if(!is_null($ex->start_date)){
      //       Session::put('messages','Already emailed the password to the examiner. Updated the dates');
      //       return back();
      //     }
      //   }
      // }
      // foreach($existing as $ex){
      //   DB::table('practicalexam_subject')->where('practicalexam_id', $ex->id)->delete();
      //   $ex->delete();
      // }
      if($r->has('subjects')){
        foreach($r->subjects as $s){
          $subject = \App\Subject::find($s);
          $pe = \App\Practicalexam::where('institute_id',$r->institute_id)->where('faculty_id',$r->faculty_id)->where('exam_id',27)->where('programme_id',$subject->programme_id)->first();
          $progamme = \App\Programme::find($subject->programme_id);
          if(is_null($pe)){
            $pe = \App\Practicalexam::create([
              'institute_id' => $r->institute_id,
              'faculty_id' => $r->faculty_id,
              'exam_id' => 27,
              'programme_id' => $subject->programme_id,
              'course_id' => $progamme->course_id,
              'start_date' => $r->start_date,
              'end_date' => $r->end_date
            ]);
          }else{
              $pe->start_date = $r->start_date;
              $pe->end_date = $r->end_date;
              $pe->save();
          }
          $pe->subjects()->attach($s);
        }
        Session::put('messages','Updated');
      }else{
        Session::put('messages','Removed');
      }
      return back();
    }
}