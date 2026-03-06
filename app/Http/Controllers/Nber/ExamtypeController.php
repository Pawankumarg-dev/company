<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Examtype;



class ExamtypeController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }
    public function index(){
    	$collections = Examtype::paginate(10);
    	$link = 'examtypes';
    	$text = 'Exam Types';
    	return view('nber.examtypes.index',compact('collections','link','text'));
    }
    public function create(Request $request){
    	Examtype::create($request->all());
    	return redirect('/examtypes');
    }
    public function update(Request $request){
    	$examtype = Examtype::find($request->id);
    	$examtype->update($request->except('id'));
    	return redirect('/examtypes');
    }
}
