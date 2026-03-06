<?php

namespace App\Http\Controllers\Rci;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Programmegroup;

use App\Programme;

use App\Nber;

use Session;

class ProgrammeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:rci']);
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
    	$collections = Programme::orderBy('programmegroup_id')->paginate(100);

    	$link = 'programmes';
    	$text = 'Programmes (Master data)';
    	$programmegroups = Programmegroup::all();
        $nbers = Nber::all();
    	return view('rci.master.programmes.index',compact('collections','link','text','nbers','programmegroups','approval','status','authority'));
    }
    public function create(Request $request){
    	Programme::create($request->all());
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
