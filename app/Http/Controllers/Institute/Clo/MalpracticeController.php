<?php

namespace App\Http\Controllers\Clo;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Malpractice;

use App\Exam;

use Session;
use App\Malpracticefile;


class MalpracticeController extends Controller
{
    public function __construct()
    {
        $this->middleware('clo');
    }
    public function index(){
    	$collections = Malpractice::where('clo_id',Session::get('clo')->id)->paginate(10);
    	$link = 'malpractices';
    	$text = '<i class="fa fa-file"> </i> &nbsp;Malpractice Reports';
    	//$exams = Exam::all();
    	return view('clo.malpractices',compact('collections','link','text'));
    }
    public function create(Request $request){
    	$ml = Malpractice::create($request->all());
        $ml->update(['clo_id'=>Session::get('clo')->id]);
    	return back();//redirect('/malpractices');
    }
    public function update(Request $request){
    	$cloreportfile = Malpractice::find($request->id);
    	$cloreportfile->update($request->except('id'));
        $ml->update(['clo_id'=>Session::get('clo')->id]);
    	return  back();// redirect('/malpractices');
    }
    public function uploadfile($malpractice_id,Request $request){
        //return 'test';
        $rules = [
            'file' => 'required',
            'description' => 'required',
        ];
        $this->validate($request, $rules);
        $file = $request->file;
		$database = \Auth::user()->database_name;

        $clo = Session::get('clo');
        if(!($file->isValid())){
            Session::put('error','Failed to Upload');
            return back();
        }else{
            $ex = explode('.', $path = $request->file->getClientOriginalName());
            $extn = end($ex);
            $filename = $clo->id.'_'.$malpractice_id . '_'. rand(100,10000) . '.' . $extn ;
            move_uploaded_file($file,'files/'.$database."/malpractice/".$filename);
        }
        

        $cloreport = Malpracticefile::create(['malpractice_id'=>$malpractice_id,'description'=>$request->description,'file'=>$filename]);
        Session::put('messages','Uploaded');
        return back();

    }
}
