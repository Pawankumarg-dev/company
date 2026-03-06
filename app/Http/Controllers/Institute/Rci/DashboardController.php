<?php

namespace App\Http\Controllers\Rci;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Approvedprogramme;
use App\Candidate;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:rci']);
    }
    public function index(){
        $aps = \App\Approvedprogramme::where('academicyear_id','>',7)->where('academicyear_id','!=',11)->get();
        foreach($aps as $ap){
            $ap->registered_count = $ap->candidates->count();
            $ap->save();
        }
        return view('rci.dashboard.index');
    }
    public function print(){
        return view('rci.dashboard.print');
    }
    public function intake(){
        return view('rci.reports.intake');
    }
    public function sms(){
        $approvedprogrammes   = Approvedprogramme::where('academicyear_id',11)->pluck('id');
        $candidates = Candidate::whereIn('approvedprogramme_id',$approvedprogrammes)->paginate(2000);
        
        return view('rci.master.sms',compact('candidates'));
    }
    public function issues(){
        return view('rci.issues.index');
    }
}
