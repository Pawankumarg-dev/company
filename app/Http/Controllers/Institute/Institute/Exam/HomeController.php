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

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $helperService;


    public function __construct(HelperService $helper)
    {
        $this->middleware(['role:institute']);
        $this->helperService = $helper;

    }

    public function index(Request $r)
    {
       
    }

    public function show($id,Request $r)
    {
        Session::put('exam_id',$id);
        $institute = $this->helperService->getInstitute();
        $current_ay_id = Academicyear::where('current',1)->first()->id;
        $exam = Exam::find(25);
        
        $approvedprogrammes = Approvedprogramme::where('institute_id',$institute->id)
        ->where('academicyear_id','<=',$current_ay_id)
        ->where('academicyear_id','>',$current_ay_id - 4)
        ->orderBy('academicyear_id','desc')->get();
        return view('institute.exam.home.show',compact('approvedprogrammes','exam','current_ay_id')); 
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
        //
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
