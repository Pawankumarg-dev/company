<?php

namespace App\Http\Controllers\Rci;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Nber;
use Session;

class NberController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:rci']);
    }
    public function index(){
        $collections = Nber::paginate(10);
    	$link = 'nbers';
    	$text = 'NBERs (Master data)';
        return view('rci.master.nbers.index',compact('collections','link','text'));
    }
    public function store(Request $request){
    	Nber::create($request->all());
        Session::put('messages','Created');
    	return back();
    }
    public function update(Request $request){
    	$nber = Nber::find($request->id);
    	$nber->update($request->except('id'));
        Session::put('messages','Updated');
    	return back();

    }
}
