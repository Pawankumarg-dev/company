<?php

namespace App\Http\Controllers\Rci;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Academicyear;
use App\Programme;
use App\Incidentalfee;
use App\Masterlist;
use Session;

class AcademicyearController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:rci']);
    }
    public function defineincidentalpayments(){
        $programmes = Programme::all();
        $academicyear = Academicyear::where('current',1)->first();
        $incidentalcharges = Incidentalfee::where('academicyear_id',$academicyear->id)->get();
        foreach($programmes as $programme){
            $incidentalcharge = Incidentalfee::where([
                ['programme_id','=',$programme->id],
                ['academicyear_id','=',$academicyear->id]
            ])->get();
            if($programme->active_status == 1){
                if($incidentalcharge->count()==0){
                    for($i=1;$i <= $programme->numberofterms;$i++){
                        Incidentalfee::create([
                            'programme_id' => $programme->id,
                            'academicyear_id' => $academicyear->id,
                            'term' => $i,
                            'fee' => 4000,
                        ]);
                    }
                }
            }else{
                if($incidentalcharge->count() > 0){
                   // $incidentalcharge->delete();
                }
            }
        }
        $collections = Incidentalfee::where('academicyear_id',$academicyear->id)->orderBy('programme_id')->paginate(20);
        $link = 'incidentalcharges';
        $text = "Affiliation Fees";
        return view('rci.master.academicyears.incidentalcharges',compact('collections','link','text'));
    }
    public function updateincidentalfee(Request $r){
        $fee = Incidentalfee::find($r->id);
        $fee->fee = $r->fee;
        $fee->save();
        Session::put('message','Updated;');
        return back();
    }
    public function index(){
    	$collections = Academicyear::orderby('created_at','desc')->paginate(10);
    	$link = 'academicyears';
    	$text = 'Academicyears (Master data)';
        $yesno = collect([
            (object) [
                'id' => 0,
                'value' => 'No'
            ],
            (object) [
                'id' => 1,
                'value' => 'Yes'
            ]
        ]);
    	return view('rci.master.academicyears.index',compact('collections','link','text','yesno'));
    }
    public function create(Request $request){
        $request->previous_academicyear_id  =  Academicyear::where('current',1)->first()->id;
        if($request->current == 1){
            Academicyear::query()->update(['current' => 0]);
        }
    	$newyear = Academicyear::create($request->all());
       /* $approvedprogrammes = Masterlist::where('academicyear_id',$request->previous_academicyear_id)->get();
        foreach($approvedprogrammes as $ap){
         //   $ap->academicyear_id = $newyear->id;
            Masterlist::create([
                'institute_id' => $ap->institute_id,
                'programme_id' => $ap->programme_id,
                'academicyear_id' => $newyear->id,
                'status_id' => 1,
                'maxintake' => $ap->maxintake,
                'current_term' => $ap->current_term,
                'allotted_count' => $ap->allotted_count,
                'registered_count' => $ap->registered_count,
                'enrolment_count' => 0,
                'verificationpending_count'=>0,
                'approved_count' =>0,
                'pending_count' => 0,
                'rejected_count' => 0
            ]);
        } */
    	return back();
    }
    public function update(Request $request){
    	$academicyear = Academicyear::find($request->id);
        Academicyear::query()->update(['current' => 0]);
    	$academicyear->update($request->except('id'));
    	return back();
    }
    public function changeayid($id){
        $academicyear= Academicyear::find($id);
        $academicyearname = $academicyear->year;
        Session::put('academicyear',$academicyearname);
        Session::put('academicyear_id',$id);
        return back();
    }
}
