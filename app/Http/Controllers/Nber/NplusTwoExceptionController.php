<?php


namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class NplusTwoExceptionController extends Controller{
    public function show($id){
        $exception = \App\Nplustwoexception::where('candidate_id',$id)->first();
        $candidate = \App\Candidate::find($id);
        $applications = \App\Allapplication::where('candidate_id',$id)->get();
        return view('nber.exam.applicants.approve',compact(
            'exception',
            'candidate',
            'applications'
        ));
    }
    public function update($id,Request $r){
        return 'Closed';
        $exception = \App\Nplustwoexception::find($id);
        $exception->status = $r->status;
        $exception->save();
        if($r->status == 1){
            Session::put('messages','Approved');
        }
        if($r->status == 2){
            Session::put('messages','Rejected');
        }
        return redirect(url('nber/exam/applicants').'?case=special');
    }
}