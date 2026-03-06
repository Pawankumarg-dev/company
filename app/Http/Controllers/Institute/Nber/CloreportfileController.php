<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Cloreportfile;

use App\Exam;


class CloreportfileController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }
    public function index(){
    	$collections = Cloreportfile::paginate(10);
    	$link = 'cloreportfiles';
    	$text = 'CLO Report Files';
    	$exams = Exam::all();
    	return view('nber.clo.files',compact('collections','link','text','exams'));
    }
    public function create(Request $request){
    	Cloreportfile::create($request->all());
    	return back();//redirect('/cloreportfiles');
    }
    public function update(Request $request){
    	$cloreportfile = Cloreportfile::find($request->id);
    	$cloreportfile->update($request->except('id'));
    	return  back();// redirect('/cloreportfiles');
    }
}
