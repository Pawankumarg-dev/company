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
        $exam = Exam::find($id);

        // $approvedprogrammes = Approvedprogramme::where('institute_id',$institute->id)
        // ->where('academicyear_id','<=',$current_ay_id)
        //         // ->where('academicyear_id','<',16)
        //         // ->where('academicyear_id','!=',14)
        // ->where('academicyear_id','>',$current_ay_id - 3)
        // ->orderBy('academicyear_id','desc')->get();

  $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)
    ->where(function ($q) use ($current_ay_id) {

        // For semester system (2 terms) → last 3 years
        $q->whereHas('programme', function ($p) {
                $p->where('numberofterms', 2);
            })
            ->where('academicyear_id', '>', $current_ay_id - 5)
            ->orwhere('academicyear_id', '>', 9);

    })
    ->orWhere(function ($q) use ($institute, $current_ay_id) {

        // For annual system (1 term) → only current year
        $q->where('institute_id', $institute->id)
            ->where('academicyear_id', '>', 9)
            ->whereHas('programme', function ($p) {
                $p->where('numberofterms', 1);
            });

    })
    ->orderBy('academicyear_id', 'desc')
    ->get();
        Session::flash('messages', 'In case of non receipt of affiliation fees as per the details of fees paid submitted by your institute, the results will be withheld till the payment of the fees.यदि आपके संस्थान द्वारा प्रस्तुत शुल्क भुगतान के विवरण के अनुसार संबद्धता शुल्क प्राप्त नहीं होता है, तो शुल्क का भुगतान होने तक परिणाम रोक दिए जाएंगे।');


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
