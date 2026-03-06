<?php

namespace App\Http\Controllers\Rci;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Programmegroup;

use App\Academicsystem;

use Session;

class ProgrammegroupController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:rci']);
    }
    public function index(){
    	$collections = Programmegroup::paginate(10);
    	$link = 'programmegroups';
    	$text = 'Programme Groups (Master data)';
    	$academicsystems = Academicsystem::all();
        $yesno = collect([
            (object) [
                'id' => 1,
                'value' => 'Required'
            ],
            (object) [
                'id' => 0,
                'value' => 'Not Mandatory'
            ]
        ]);
    	return view('rci.master.programmes.groups',compact('yesno','collections','link','text','academicsystems'));
    }
    public function settings(){
        $collections = Programmegroup::paginate(10);
        $link = 'programmegroups';
        $text = 'Settings';
        $academicsystems = Academicsystem::all();
        return view('nber.settings',compact('collections','link','text','academicsystems'));
    }
    public function create(Request $request){
    	Programmegroup::create($request->all());
        Session::put('messages','Created');
    	return back();
    }
    public function update(Request $request){
    	$programmegroup = Programmegroup::find($request->id);
    	$programmegroup->update($request->except('id'));
        Session::put('messages','Updated');
    	return  back();
    }
}
