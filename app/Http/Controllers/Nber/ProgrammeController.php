<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Programmegroup;

use App\Programme;

use App\Nber;

use Session;

use Auth;

class ProgrammeController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }
    public function index(){
        $approval = collect([
            (object) [
                'id' => 0,
                'value' => 'Not required'
            ],
            (object) [
                'id' => 1,
                'value' => 'Required'
            ]
        ]);
        $status = collect([
            (object) [
                'id' => 0,
                'value' => 'Discontinued'
            ],
            (object) [
                'id' => 1,
                'value' => 'Active'
            ]
        ]);
        $authority = collect([
            (object) [
                'id' => 'RCI',
                'value' => 'RCI'
            ],
            (object) [
                'id' => 'NT',
                'value' => 'NT'
            ]
        ]);

        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
    	$collections = Programme::where('nber_id',$nber_id)->where('active_status',1)->orderBy('programmegroup_id')->paginate(100);
    	$link = 'programmes';
    	$text = 'Programmes';
    	$programmegroups = Programmegroup::all();
        $nbers = Nber::where('id',$nber_id)->get();
    	return view('nber.programmes.index',compact('collections','link','text','nbers','programmegroups','approval','status','authority'));
    }
    public function create(Request $request){
    	$programme = Programme::create($request->all());
        $programme->nber_id =  \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
        $programme->save();
        Session::put('messages','Created');
    	return back();
    }
    public function update(Request $request){
    	$programme = Programme::find($request->id);
    	$programme->update($request->except('id','nber_id'));
    	Session::put('messages','Updated');
    	return  back();

    }
}
