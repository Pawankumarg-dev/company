<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


use App\Http\Requests;
use App\Approvedprogramme;
use App\User;
use App\Institute;
use App\Status;
use App\Programme;
use App\Candidate;
use Auth;
use Session;
use DB;

class ApprovedprogrammeController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }
    public function import(){
        /*
        $candidates = DB::table('tbl_cenrolled')->where('enrolment_year','4')->orderBy('batch')->orderBy('centrecode')->get();
        //echo $candidates->count();
        $oldbatch = '';
        $oldcentrecode = '';
        foreach($candidates as $c){
            if($oldbatch!=$c->batch or $oldcentrecode != $c->centrecode){
                echo '<br />----------------------------<br />';
                $userid = User::where('username',$c->centrecode)->with('institute')->first()->id;
                $institute = Institute::where('user_id',$userid)->first();
                echo $institute->name;
                $batch = DB::table('tbl_batch')->where('bid',$c->batch)->first();
                $pid = $batch->pid;
                if($pid == 10) {$pid = 8;}
                if($pid == 11) {$pid = 10;}
                if($pid == 12) {$pid = 14;}
                $ap =  Approvedprogramme::create(['institute_id'=>$institute->id,'programme_id'=>$pid,'academicyear_id'=>'2','status_id'=>'2','maxintake'=>25]);
                echo $ap->id;
                echo '<br />----------------------------<br />';
            }

            if($c->enrolmentno!=''){
                //$email = $c->emailid;
                $email = $c->enrolmentno . '@' . $c->enrolmentno . '.' . $c->centrecode;
            $candidate = Candidate::create(['approvedprogramme_id'=>$ap->id,
                            'enrolmentno' => $c->enrolmentno,
                            'name' => $c->sname,
                            'fathername' => $c->fhname,
                            'mothername' => $c->mname,
                            'percentage' => $c->pmarks_hsc,
                            'dob' => $c->dob,
                            'address' => $c->address1,
                            'pincode' => $c->pincode,
                            'contactnumber' => $c->mnumber,
                            'email' => $email,
                            'photo' => $c->cphotos,
                            'doc_mark' => $c->dsslc,
                            'doc_dob' => $c->dsslc,
                            'doc_disability' => $c->ddisability,
                            'doc_community' => $c->dscst,
                            'community_id' => $c->community,
                            'disability_id' => $c->distype,
                            'gender_id' => $c->gender
                        ]);
        }
            echo $c->sname . ' ' . $c->batch . ' ' . $c->centrecode . ' >> '. $candidate->id;
            echo '<br />';

            $oldbatch = $c->batch;
            $oldcentrecode = $c->centrecode;

        }
        echo " !! SHUBAM !!";
        */
    }
    public function index(Request $r){

        $status = '';
        $institute = '';
        $programme = '';
        $programmes = Approvedprogramme::where('id','!=','0')->where('academicyear_id',Session::get('academicyear_id'));
        if($r->has('i')){
            $programmes = $programmes->where('institute_id',$r->i);
            $institute = Institute::find($r->i)->user->username;
        }
        if($r->has('s')){
            $programmes = $programmes->where('status_id',$r->s);
            $status = Status::find($r->s)->status;
        }
        if($r->has('p')){
            $programmes = $programmes->where('programme_id',$r->p);
            $programme = Programme::find($r->p)->course_name;
        }
        $programmes = $programmes->paginate(20);
        return view('nber.applications.institutes',compact('programmes','status','institute','programme'));

    }
    public function changestatus($status_id,$id){
        $ap = Approvedprogramme::find($id);
        $ap->update(['status_id'=>$status_id]);
        $ap->update(['updated_by'=>Auth::user()->id]);
        Session::put('message','updated');
        return back()->withInput();
    }

    public function generateenrolment($id){
        $ap = Approvedprogramme::find($id);
        $candidates = Candidate::where('approvedprogramme_id', $ap->id)->orderBy('enrolmentno')->get();
        $candidate_count = $candidates->count();

        foreach ($candidates as $c) {
            if($c->status_id == 2) {
                if(is_null($c->enrolmentno) || $c->enrolmentno == '') {
                    for($i=1; $i<=$candidate_count;$i++) {
                        $enrolmentno = $ap->programme->enrolmentcode . '19' . str_pad($ap->institute->enrolmentcode,3,'0',STR_PAD_LEFT). str_pad($i,2,'0',STR_PAD_LEFT);

                        if($candidates->where('enrolmentno', $enrolmentno)->count() == 0) {
                            $c->update(['enrolmentno' => $enrolmentno]);
                            break;
                        }
                    }
                }
            }
        }

    }

    public function updateenno(Request $request){

        $c  = Candidate::find($request->id);
        $c->update(['enrolmentno'=>$request->enno]);

    }
}


