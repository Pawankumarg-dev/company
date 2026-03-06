<?php

namespace App\Http\Controllers\Nber;

use App\City;
use App\Community;
use App\Disability;
use App\Gender;
use App\Salutation;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;


use App\Http\Requests;
use App\Candidate;
use App\User;
use App\Institute;
use App\Status;
use App\Approvedprogramme;
use App\Programme;

use Auth;
use Session;
use Image;

class CandidateController extends Controller
{
	 public function __construct()
    {
       $this->middleware(['role:nber']);
    }
	public function listCandidates($id){
		$ap = Approvedprogramme::find($id);
        if($ap && $ap->programme->nber_id == \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id){
            $enable = 0;
			$candidates = Candidate::where('approvedprogramme_id',$ap->id)->get();
			return view('nber.candidates.index',compact('candidates','ap'));
        }else{
            return redirect('/');
        }
	}
    public function index(Request $r){
    	$status = '';
		$institute = '';
		$programme = '';
		$i='';
		$candidates = Candidate::where('id','!=','0')->whereHas('approvedprogramme',function($q) {
                $q->where('academicyear_id', Session::get('academicyear_id'));
            });
    	if($r->has('s')){
    		$candidates = $candidates->where('status_id',$r->s);
			$status = Status::find($r->s)->status;
    	}
    	if($r->has('i')){
    		$apids = Approvedprogramme::where('institute_id',$r->i)->get(['id'])->toArray();
			$candidates = $candidates->whereIn('approvedprogramme_id',$apids);
			$institute = Institute::find($r->i)->user->username;
		}
		if($r->has('p')){
			$candidates = $candidates->where('approvedprogramme_id',$r->p);
			$ap  = Approvedprogramme::find($r->p);
			$programme = $ap->programme->course_name;
			$institute = $ap->institute->user->username;
			$i=$ap->institute->id;
		}
		if($r->has('c')){
			$approvedprogrammeids = Approvedprogramme::where('programme_id',$r->c)->get(['id'])->toArray();
			$candidates = $candidates->whereIn('approvedprogramme_id',$approvedprogrammeids);
			$programme =  Programme::find($r->c)->course_name;
		}
    	$candidates = $candidates->orderBy('enrolmentno')->paginate(20);
    	
    	return view('nber.applications.candidates',compact('candidates','status','institute','programme','i'));
    }
	public function changestatus($status_id,$id,Request $request){
		$c = Candidate::find($id);
		
		$c->update(['status_id'=>$status_id]);
		$c->update(['updated_by'=>Auth::user()->id]);
		$comment = ' updated status to '. Status::find($status_id)->status ;
		if($request->has('comment')){
			$comment .= ' with note: '. $request->comment;
		}
		$c->candidateapprovals()->create(['user_id'=>Auth::user()->id,'comment'=>$comment]);
		Session::put('messages','updated');

		$candidateApprovalStatuses = Candidate::where('approvedprogramme_id', $c->approvedprogramme_id)->get(['enrolmentno', 'status_id']);
		$enrolmentCount = Candidate::where('approvedprogramme_id', $c->approvedprogramme_id)->whereNotNull('enrolmentno')->count();

		$c->approvedprogramme->update([
            "registered_count" => $candidateApprovalStatuses->count(),
            "enrolment_count" => $enrolmentCount,
            "verificationpending_count" => $candidateApprovalStatuses->where('status_id', 6)->count(),
            "approved_count" => $candidateApprovalStatuses->where('status_id', 2)->count(),
            "pending_count" => $candidateApprovalStatuses->where('status_id', 1)->count(),
            "rejected_count" => $candidateApprovalStatuses->where('status_id', 3)->count(),
        ]);

		unset($candidateApprovalStatuses);

		return back()->withInput();
	}

    public function calculateCandidateVerificationsCount($apid) {
        $approvedprogramme = Approvedprogramme::find($apid);
    }

	public function crop(Request $request){
			$data = $request->all();
			$left = intval($data['left']);
			$top = intval($data['top']);
			$height = intval($data['height']);
			$width =  intval($data['width']);
			$filename = $data['filename'];
			
			$cid= $data['cid'];
			$candidate = Candidate::find($cid);
			$candidate->update(['photo'=>'cropped/'.$filename]);
			$file ="files/enrolment/photos/".$filename;
			$saveas  = "files/enrolment/photos/cropped/".$filename;
			$img = Image::make($file);
			$img->crop($width,$height,$left,$top)->save($saveas);
			return 'success';
	}
	public function show($id){
		$candidate = Candidate::find($id);
		$c = $candidate;
		//return view('nber.candidates.show',compact('c'));
		return view('nber.candidates.view_details',compact('candidate','c'));
	}
  /*  public function edit($id){
        $candidate = Candidate::find($id);
        return $this->createoredit($candidate->approvedprogramme_id,$candidate);
    }
    private function createoredit($apid,$candidate=null){

        $ap = Approvedprogramme::find($apid);
        if($ap){
            if($ap->institute->user_id==Auth::user()->id){
                $cities=City::all();
                $genders=Gender::all();
                $communities = Community::all();
                $programme = $ap->programme;
                $disabilities = Disability::all();
                $salutations = Salutation::all();
                if($candidate){
                    return view('institute.candidates.edit',compact('apid','candidate','salutations','cities','genders','communities','disabilities','institute','programme'));
                }
            }
        }
        return redirect('/');
    } */
	
}
