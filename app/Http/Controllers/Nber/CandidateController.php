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
use App\State;
use App\Lgstate;
use App\District;
use App\Subdistrict;
use App\Village;
use App\Nationality;
use App\Masterlist;
use Session;
use File;
use Input;
use App\Configuration;
use App\Education;
use App\Exam;
use Illuminate\Support\Facades\DB;
use App\Services\Exam\ApplicantService; 
use App\CandidateDataHistory;
use App\Order;
use Illuminate\Support\Facades\Hash;


use Auth;
use Image;

class CandidateController extends Controller
{
    private $applicantService; 
	 public function __construct(ApplicantService $applicant)
    {
       $this->middleware(['role:nber']);
        $this->applicantService  = $applicant;
    }
/*
    public function createeclogin(){
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $ecs = \App\Externalexamcenter::where('reset_pwd',1)->get();
        
        foreach($ecs as $ec){
            $password = substr($ec->code,2)."#".rand(10,99).'@'.strtoupper(substr(str_shuffle($str_result),0,2));
            $user = \App\User::find($ec->user_id);
            $user->password = Hash::make($password);
            $user->save();
            $ec->password = $password;
            $ec->save();
        }
        return 'Done';
    }*/

    public function search(Request $r){
        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
        $institutes = \App\Institute::where('rci_code','like','%'.$r->enrolmentno.'%');
        if(!is_null($institutes) && $institutes->count() == 1){
            return redirect('nber/admissions?search='.$institutes->first()->rci_code);
        }
        $institutes  = $institutes->paginate(10);
        $candidate = Candidate::where('enrolmentno', 'like', '%'.trim($r->enrolmentno).'%')->orWhere('name','like','%'.trim($r->enrolmentno).'%');
        if(Auth::user()->id != 88387){
            
            // $candidate = $candidate->
            // whereHas('approvedprogramme',function($q) use($nber_id){
            //     $q->whereHas('programme',function($p) use($nber_id){
            //         $p->where('nber_id',$nber_id);
            //     });
            // });


            $candidate = DB::table('candidates as c')
    ->join('approvedprogrammes as ap', 'ap.id', '=', 'c.approvedprogramme_id')
    ->join('programmes as p', 'p.id', '=', 'ap.programme_id')
    ->where(function($query) use ($r) {
        $query->where('c.enrolmentno', '=', $r->enrolmentno)
              ->orWhere('c.name', 'like', '%' . trim($r->enrolmentno) . '%');
    })
    ->where('p.nber_id', '=', $nber_id)
    ->select('c.*'); 
        }


        if(is_null($candidate)){
            Session::flash('error','Could not find');
            return back();
        }else{
            if($candidate->count() == 1){
                return redirect('nber/candidate/'.$candidate->first()->id);
            }
        }
        $candidates  = $candidate->paginate(10);
        $key = $r->enrolmentno;
        return view('nber.search.index',compact('candidates','institutes','key'));
    }

    public function enableedit(Request $r){
        if(Auth::user()->id == 88387){
            $candidates = Candidate::where('approvedprogramme_id',$r->apid)->get();
            foreach($candidates as $candidate){
                if($r->has('data_'.$candidate->id)){
                    $candidate->modify_data = 1;
                }else{
                    $candidate->modify_data = 0;
                }
                if(!is_null($candidate->currentapplicant)){
                    $ca = \App\Currentapplicant::where('candidate_id',$candidate->id)->first();
                    
                    if($r->has('incomplete_'.$candidate->id)){
                        $ca->incomplete = 1;
                        $ca->modify_mark = 1;
                    }else{
                        $ca->incomplete = 0;
                        $ca->modify_mark = 0;
                    }
                    if($r->has('mark_'.$candidate->id)){
                        $ca->modify_mark = 1;
                    }else{
                        $ca->modify_mark = 0;
                        if($r->has('incomplete_'.$candidate->id)){
                            $ca->modify_mark = 1;
                        }
                    }
                    
                    $ca->save();
                }
                $candidate->save();
            }
        }
        Session::put('messages','Updated');
        return back();
    }
    public function updatemobile(Request $request){
        //return 'Closed';
        $rules = [
            'contactnumber' => 'required|numeric|min:6000000001:max:9999999999|unique:candidates'
        ];
        $messages = [
            'contactnumber' => 'Please enter valid mobile number',
        ];
        $this->validate($request, $rules,$messages);
        $candidate = Candidate::find($request->id);
        $candidate->contactnumber = $request->contactnumber;
        $candidate->is_mobile_number_verified  = 'No';
        $candidate->is_mobile_edited = 1;
        $candidate->is_duplicate_mobile = 0;
        $candidate->duplicate_mobile_no = 0;
        $candidate->user_id = NULL;
        $candidate->save();
        
        /*if($candidate->user_id > 0){
            $user = User::find($candidate->user_id);
            $user->username = $request->contactnumber;
            $user->save();
        } */
        return response()->json('success');
    }

    public function updatename(Request $request){
        return back();
        $rules = [
            'name' => 'required'
        ];
        $messages = [
            'name' => 'Name cannot be empty!',
        ];
        $this->validate($request, $rules,$messages);
        $candidate = Candidate::find($request->id);
        $candidate->name = $request->name;
        $candidate->save();
        return response()->json('success');
    }
    public function updateeno(Request $request){
        return back();

        $rules = [
            'eno' => 'required'
        ];
        $messages = [
            'eno' => 'Enorlment no cannot be empty!',
        ];
        $this->validate($request, $rules,$messages);
        $candidate = Candidate::find($request->id);
        $candidate->enrolmentno = $request->eno;
        $candidate->save();
        return response()->json('success');
    }

    public function verify(Request $r){
        Session::put('message','Temporarly Disabled');
        // return back();
        $c = Candidate::find($r->id);
        $now = \Carbon\Carbon::now();
        //if($c->status_id != 9 && $c->approvedprogramme->enable_admission == 1 && $now->toDateString() <= \Carbon\Carbon::parse($c->approvedprogramme->enable_admission_till)->toDateString()){
        if($c->status_id != 9){
            $c = Candidate::find($r->id);
            $c->status_id = 2;
            $c->save();
            Session::put('message','Updated');
            $c->candidateapprovals()->create(['user_id'=>Auth::user()->id,'comment'=>'Verified the documents']);
        }
        //}
        //else{
        //    Session::put('message','Option not available ');
        //    return back();
        //}
        return back();
    }

    public function getDistricts(Request $request){
        $state = Lgstate::find($request->state_id);
        if($state !== null){
            $state_code = $state->state_code;
            $data = District::where('state_code',$state_code)->get();
            return response()->json($data);
        }else{
            return response()->json('nodata');
        }
    }
    public function getsubDistricts(Request $request){
        $district = District::find($request->district_id);
        if($district !== null){
            $district_code =  $district->districtCode;
            $data['subdistricts'] = Subdistrict::where('District_Code',$district_code)->get();
            $data['blocks'] = Village::where('District_Code',$district_code)->get();
            return response()->json($data);
        }else{
            return response()->json('nodata');
        }
    }

    public function reject(Request $r){
        Session::put('message','Temporarly Disabled');
        // return back();
        $c = Candidate::find($r->id);
        $now = \Carbon\Carbon::now();
       // if($c->status_id != 9 && $c->approvedprogramme->enable_admission == 1 && $now->toDateString() <= \Carbon\Carbon::parse($c->approvedprogramme->enable_admission_till)->toDateString()){
           // if($c->status_id != 2){
                $c->status_id = 1;
                $c->save();
                Session::put('message','Updated');
                $c->candidateapprovals()->create(['user_id'=>Auth::user()->id,'comment'=> ' Changed status to pending, reason: '. $r->comment ]);
           // }else{
                Session::put('message','Option not available ');
                return back();
            //}
        //}
        return back();
    }
    public function discontinued(Request $r){
        Session::put('message','Temporarly Disabled');
                // return back();

        $candidate = Candidate::find($r->id);
        $candidate->status_id = 9;
        $candidate->save();
        Session::put('message','Updated');
        $candidate->candidateapprovals()->create(['user_id'=>Auth::user()->id,'comment'=> ' Changed status to Discontinued, reason: ']);
        return back();
    }
	public function listCandidates($id){
		$ap = Approvedprogramme::find($id);
        if($ap && $ap->programme->nber_id == \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id){
            $enable = 0;
			$candidates = Candidate::where('approvedprogramme_id',$ap->id)->get();
            $declaration = \App\Admissiondeclaration::where('approvedprogramme_id',$ap->id)->first();
			return view('nber.candidates.index',compact('candidates','ap','declaration'));
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
	public function create($id){
        return back();
        return $this->createoredit($id);
    }
    public function edit($id){
        // return back();
        //return 'Not available';
        $candidate = Candidate::find($id);
        return $this->createoredit($candidate->approvedprogramme_id,$candidate);
    }
    public function delete($id){
        return back();
        $candidate = Candidate::find($id);
        $candidate->delete();
        Session::put('messages','Enrolment data deleted');
        return back();
    }
    private function createoredit($apid,$candidate=null){
        if(!is_null($candidate)){

     $nber_id = Auth::user()->nberstaffs->first()->nber_id;


 if($candidate->approvedprogramme->programme->nber_id != $nber_id){
            return redirect('/');

        }



        // return back();
        $ap = Approvedprogramme::find($apid);
        if($ap){
            //if($ap->institute->user_id==Auth::user()->id){
                $cities=City::all();
                $genders=Gender::all();
                $communities = Community::all();
                $nationalities = Nationality::all();
                $programme = $ap->programme;
               // $disabilities = Disability::all();
              //  $disabilities = Disabilitytype::all();
                $salutations = Salutation::all();
                $states = Lgstate::all();
                $academicsession = $ap->academicyear->accademicsession;
                $minage = $ap->programme->programmegroup->minage;
                $mindate = strtotime($academicsession .' -'.$minage.' year');
                $mindate = date('Y-m-d', $mindate);
                //return $academicsession . ' ' . $minage . ' ' . date('Y-m-d', $mindate);
                $yesno = collect([
                    (object) [
                        'id' => 0,
                        'value' => 'No'
                    ],
                    (object) [
                        'id' => 1,
                        'value' => 'Yes'
                    ]
                ]);
                if($candidate){
                    return view('nber.candidates.edit',compact('mindate','nationalities','yesno','apid','states','candidate','salutations','cities','genders','communities','programme'));
                }else{
                    if($ap->maxintake > $ap->candidates()->count()){
                        return view('nber.candidates.create',compact('mindate','nationalities','yesno','apid','states', 'salutations','cities','genders','communities','institute','programme'));
                    }
                }
           // }
        }
    }else{
        return 'Closed';
    }
        return redirect('/');
    }
   

   
    public function store(Request $request){
        //return "Not avilable";
        return back();
        return $this->storeorupdate($request);
    }
    public function update($id,Request $request){
        // return "Not avilable";
        //  return back();
        $candidate = Candidate::find($id);
        return $this->storeorupdate($request,$candidate);
    }

    public function resetpassword(Request $r){
        $candidate = Candidate::find($r->id);
        $user = User::find($candidate->user_id);
        if(is_null($user)){
            $user = User::where('username',$candidate->contactnumber)->first();
            if(is_null($user)){
                try{
                    $user = \App\User::create([
                        'username' => $candidate->contactnumber,
                        'password' =>  Hash::make($r->password),
                        'confirmed' => 0,
                        'confirmation_code' => '111zzza',
                        'usertype_id' => 3,
                        'email' => $candidate->email,
                        'use_password' => 1
                    ]);
                }catch(Exception $e){
                    Session::flash('error','Could not create user as email/mobile no already exists');
                    return back();
                }
            }
            $user->use_password = 1;
            $candidate->user_id = $user->id;
            $user->save();
            $candidate->save();
        }else{
            $user->password = Hash::make($r->password);
            $user->use_password = 1;
            $user->save();
        }
        Session::flash('messages','Updated');
        return back();
    }
    
    private function storeorupdate($request, $candidate = null){
            //  return back();

        if(!is_null($candidate)){
        if(Auth::user()->id == 88387 || Auth::user()->id==87567 ||  Auth::user()->id==99540 || Auth::user()->id==87569 || Auth::user()->id==87568){

         
        //  return back();
        //return $request->name;
                       //$verhoeff =  new \App\Verhoeff('1');
       //return strval($verhoeff->validate('679008514476')) ;
       //return $verhoeff;
       /*$ap = Masterlist::where('id',$request->approvedprogramme_id)->first();
       $academicsession = $ap->academicyear->accademicsession;
       $minage = $ap->programme->programmegroup->minage;
       $mindate = strtotime($academicsession .' -'.$minage.' year');
       $mindate = date('Y-m-d', $mindate); */

        //$rootpath = Approvedprogramme::user()->database_name;
        $rules = [
            'name' => 'required|max:99',
            'gender_id' => 'required|numeric|min:1',
            'community_id' => 'required|numeric|min:1',
           // 'disability_id' => 'required|numeric|min:1',
            'fathername' => 'required|max:99',
            'mothername' => 'required|max:99',
            'dob' => 'required|date',
            'address' => 'required|min:8',
            'paddress' => 'required|min:8',
            'board_1' => 'required|min:2',
            'yop_1' => 'required',
            'tmarks_1' => 'required|numeric|min:10|max:9999',
            'omarks_1' => 'required|numeric|min:0|max:9999',
            'percentage_1' => 'required|numeric|min:0|max:100',
            'subjects_1' => 'required|min:10',
            'aadhar' => 'required|min:12',

        ]; 
        $request->pincode = trim($request->pincode);
        $request->pincode = str_replace(' ','',$request->pincode);
        $request->contactnumber = trim($request->contactnumber);
        $request->contactnumber = str_replace(' ','',$request->contactnumber);
        $request->aadhar = trim($request->aadhar);
        $request->aadhar = str_replace(' ','',$request->aadhar);
        $request->udid = trim($request->udid);
        $request->udid = str_replace(' ','',$request->udid);
        if($request->nationality_id == 86){
            $rules['pincode'] = 'required|numeric|min:100000|max:999999';
            $rules['ppincode'] = 'required|numeric|min:100000|max:999999';
            $rules['state_id'] = 'required';
            $rules['pstate_id'] = 'required';
            $rules['district_id'] = 'required';
            $rules['pdistrict_id'] = 'required';
        }
        if($request->isdisabled == 1){
            if($candidate==null){
                $rules['udid'] = 'required|udid';
              //  $rules['disabilitytype_id'] = 'required';
               // $rules['disabilityper'] = 'required';
            }
        }
        $plustwo = Approvedprogramme::where('id',$request->approvedprogramme_id)->first()->programme->programmegroup->twelveth;
        if($plustwo ==1){
            $rules['board_2'] = 'required|min:2';
            $rules['yop_2'] = 'required';
            $rules['tmarks_2'] = 'required|numeric|min:10|max:9999';
            $rules['omarks_2'] = 'required|numeric|min:0|max:9999';
            $rules['percentage_2'] = 'required|numeric|min:0|max:100';
            $rules['subjects_2'] = 'required|min:10';
            
        }
        if($request->board_3 !=''){
            $rules['board_3'] = 'required|min:2';
            $rules['yop_3'] = 'required';
            $rules['tmarks_3'] = 'required|numeric|min:10|max:9999';
            $rules['omarks_3'] = 'required|numeric|min:0|max:9999';
            $rules['percentage_3'] = 'required|numeric|min:0|max:100';
            $rules['subjects_3'] = 'required|min:10';
        }
        
        $messages = [
            'gender_id.min' => 'Gender is required',
            'gender_id.required' => 'Gender is required',
            'disabilityper.required' => 'Disability percentage is required',
            'disabilitytype_id.required' => 'Disability type is required',
            'coummunity_id.required' => 'Category is required',
            'state_id.required' => 'State is required in Correspondence Address',
            'pstate_id.required' => 'State is required in Permanent Address',
            'district_id.required' => 'District is required in Correspondence Address',
            'pdistrict_id.required' => 'District is required in Permanent Address',
            'name.required' => 'Name is required',
            'address.required' => 'Address is required in Correspondence Address',
            'address.min' => 'Address is too short in Correspondence Address',
            'pddress.min' => 'Address is too short in Permanent Address',
            'paddress.required' => 'Address is required  in Permanent Address',
            'community_id.required' => ' Category is required',
            'disability_id.min' => 'Disability is required',
            'salutation_id.required' => 'S/o D/o W/o required for Father/Husband name',
            'pincode.min'=> 'Please enter valid PIN code in Correspondence Address            ',
            'pincode.required'=> 'Please enter valid PIN code in Correspondence Address            ',
            'pincode.max'=> 'Please enter valid PIN code in Correspondence Address            ',
            'ppincode.min'=> 'Please enter valid PIN code in Permanent Address            ',
            'ppincode.required'=> 'Please enter valid PIN code in Permanent Address            ',
            'ppincode.max'=> 'Please enter valid PIN code in Permanent Address            ',
            'board_1.required' => 'Please enter 10th board name',
            'board_1.min' => 'Please check 10th board name',
            'yop_1.required' => 'Please enter 10th passing year',
            'yop_1.min' => 'Please check 10th passing year',
            'yop_1.max' => 'Please check 10th passing year',
            'tmarks_1.required' => 'Please enter 10th total mark',
            'tmarks_1.min' => 'Please check 10th total mark',
            'tmarks_1.max' => 'Please check 10th total mark',
            'omarks_1.required' => 'Please enter 10th obtained mark',
            'omarks_1.min' => 'Please check 10th obtained mark',
            'omarks_1.max' => 'Please check 10th obtained mark',
            'subjects_1.required' => 'Please enter 10th subjects',
            'percentage_1.required' => 'Please enter 10th Marks',
            'percentage_1.min' => 'Please check 10th Marks',
            'percentage_1.max' => 'Please check 10th Marks',
            'subjects_1.min' => 'Please check 10th subjects, too short',
            'board_2.required' => 'Please enter 12th board name',
            'board_2.min' => 'Please check 12th board name',
            'yop_2.required' => 'Please enter 12th passing year',
            'yop_2.min' => 'Please check 12th passing year',
            'yop_2.max' => 'Please check 12th passing year',
            'tmarks_2.required' => 'Please enter 12th total mark',
            'tmarks_2.min' => 'Please check 12th total mark',
            'tmarks_2.max' => 'Please check 12th total mark',
            'omarks_2.required' => 'Please enter 12th obtained mark',
            'omarks_2.min' => 'Please check 12th obtained mark',
            'omarks_2.max' => 'Please check 12th obtained mark',
            'percentage_2.required' => 'Please enter 12th Marks',
            'percentage_2.min' => 'Please check 12th Marks',
            'percentage_2.max' => 'Please check 12th Marks',
            'subjects_2.required' => 'Please enter 12th subjects',
            'subjects_2.min' => 'Please check 12th subjects, too short',
            'board_3.min' => 'Please check additionalboard name',
            'yop_3.required' => 'Please enter additionalpassing year',
            'yop_3.min' => 'Please check additionalpassing year',
            'yop_3.max' => 'Please check additionalpassing year',
            'tmarks_3.required' => 'Please enter additionaltotal mark',
            'tmarks_3.min' => 'Please check additionaltotal mark',
            'tmarks_3.max' => 'Please check additionaltotal mark',
            'omarks_3.required' => 'Please enter additional obtained mark',
            'omarks_3.min' => 'Please check additional obtained mark',
            'omarks_3.max' => 'Please check additional obtained obtained mark',
            'percentage_3.required' => 'Please enter additional Marks',
            'percentage_3.min' => 'Please check additional Marks',
            'percentage_3.max' => 'Please check additional Marks',
            'subjects_3.required' => 'Please enter additional subjects',
            'subjects_3.min' => 'Please check additional subjects, too short',
          

            'doc_percentage_exception.required' => 'Supporting document is requried if percentage is less. Please check the box below percengtage and attache the document  / File size should be less than 2 MB',
            'doc_dob.required' => '10th/12th Certificate is required. File size should be less than 1 MB',
            'doc_tenth.required' => '10th Marksheet  required / File size should be less than 1 MB',
            'doc_twelveth.required' => '12th Marksheet  required / File size should be less than 1 MB',
            'doc_community.required' => 'Community Certificate is required / File size should be less than 1 MB',
            'doc_disability.required' => 'Disability Certificate is required / File size should be less than 2 MB',
        //    'photo.required' => 'Photo is required / File size should be less than 1 MB',
            'comment.required' => 'Reason to edit is required',
         //   'photoupload.required' => "Photo not uploaded, please upload again.",
            'dobupload.required' => "DOB certificate not uploaded, please upload again.",
            'markupload.required' => "Marks proof not uploaded, please upload again.",
            'dupload.required' => "Disability Certificate not uploaded, please upload again.",
            'peupload.required' => "Percentage exception document not uploaded, please upload again.",
            'cupload.required' => "Community Certificate not uploaded, please upload again.",
            'rciupload.required' => "RCI Certificate is required",
            'contactnumber.numeric' => "Please enter valid mobile number",
            'contactnumber.min' => "Please enter valid mobile number",
            'contactnumber.max' => "Please enter valid mobile number",
            'udid.udid' => "Invalid UDID/UDID Enrolment Number",
            'contactnumber.unique' => "Mobile number already exists",
        ];

        //$this->validate($request, $rules,$messages);
        
        if($candidate==null){
            
        //    $rules['photo'] = 'required';
            $rules['doc_application'] = 'required';
            
            /*if($request->programmegroup_id != '3'){
                $rules['doc_dob'] = 'required';
                $rules['doc_mark'] = 'required';
            }else{
                $rules['doc_rci'] = 'required';
            }
            $rules['doc_dob'] = 'required';
            $rules['doc_mark'] = 'required';
            */
            $rules['doc_tenth'] = 'required';
            if($plustwo ==1){
                $rules['doc_twelveth'] = 'required';

            }
            $rules['email'] = 'required|unique:candidates';
            $rules['contactnumber'] = 'required|numeric|min:6000000001:max:9999999999|unique:candidates';
        }else{
            
            if($candidate->email!=$request->email){
                $rules['email'] = 'required|unique:candidates';
            }
            $rules['comment'] = 'required';
        }}else{
                return 'Closed';
    
            }
        }

      /*  if($request->has('pex')){
            if($request->programmegroup_id != '3'){
                if($candidate==null){
                    $rules['percentage'] = 'required|numeric|min:20|max:100';

                    $rules['doc_percentage_exception'] = 'required';
                }
                else{
                    if($candidate->doc_percentage_exception==null){
                        $rules['doc_percentage_exception'] = 'required';
                    }
                }
            }
        }
        else{
            if($request->programmegroup_id != '3'){
                if($candidate==null){
                    $rules['percentage'] = 'required|numeric|min:50|max:100';
                }
            }
        } 
        if($request->programmegroup_id == '3'){
            $rules['crr'] = 'required';
            $rules['date_of_reg'] = 'required';
        }
        
        if($request->community_id > 1){
            //$rules['percentage'] = 'required|numeric|min:45|max:100';
            if($candidate==null){
                $rules['doc_community'] = 'required';
            }
        }
        
        if($request->disability_id > 1){
            if($candidate==null){
                $rules['doc_disability'] = 'required';
            }
        }*/

            if($request->community_id > 1){
            //$rules['percentage'] = 'required|numeric|min:45|max:100';
            if($candidate==null){
                $rules['doc_community'] = 'required';
            }
        }

        if($request->has('photo') ){
            if(!file_exists(public_path().'/files/temp/'.$request->photo)){
          //      $rules['photoupload'] = 'required';
            }
        }
       /* if($request->has('doc_dob')){
            if(!file_exists(public_path().'/files/temp/'.$request->doc_dob)){
                $rules['dobupload'] = 'required';
            }
        } */
        if($request->has('doc_tenth') ){
            if(!file_exists(public_path().'/files/temp/'.$request->doc_tenth)){
                $rules['doc_tenth'] = 'required';
            }
        }
        if($request->has('doc_twelveth') ){
            if(!file_exists(public_path().'/files/temp/'.$request->doc_twelveth)){
                $rules['doc_twelveth'] = 'required';
            }
        }
        if($request->has('doc_application')){
            if(!file_exists(public_path().'/files/temp/'.$request->doc_twelveth)){
                $rules['doc_application'] = 'required';
            }
        }

         if($request->has('doc_community')){
            if(!file_exists(public_path().'/files/temp/'.$request->doc_community)){
                $rules['cupload'] = 'required';
            }
        }
        
        /*
        if($request->has('doc_disability')){
            if(!file_exists(public_path().'/files/temp/'.$request->doc_disability)){
                $rules['dupload'] = 'required';
            }
        } 
        if($request->has('doc_community')){
            if(!file_exists(public_path().'/files/temp/'.$request->doc_community)){
                $rules['cupload'] = 'required';
            }
        }
        
        if($request->has('doc_percentage_exception')){
            if(!file_exists(public_path().'/files/temp/'.$request->doc_percentage_exception)){
                $rules['peupload'] = 'required';
            }
        }
        if($request->has('doc_rci')){
            if(!file_exists(public_path().'/files/temp/'.$request->doc_dob)){
                $rules['rciupload'] = 'required';
            }
        } */
       /* $messages = [
            'gender_id.min' => 'Gender field required',
            'community_id.min' => 'Community Category field required',
            'disability_id.min' => 'Disability field required',
            'salutation_id.required' => 'S/o D/o W/o required for Father/Husband name',
            'city_id.min' => 'City field required',
            'pincode.min'=> 'Please enter valid PIN code',
            'pincode.max'=> 'Please enter valid PIN code',
            'doc_percentage_exception.required' => 'Supporting document is requried if percentage is less. Please check the box below percengtage and attache the document  / File size should be less than 2 MB',
            'doc_dob.required' => '10th/12th Certificate is required. File size should be less than 2 MB',
            'doc_mark.required' => 'Marksheet  required / File size should be less than 2 MB',
            'doc_community.required' => 'Community Certificate is required / File size should be less than 2 MB',
            'doc_disability.required' => 'Disability Certificate is required / File size should be less than 2 MB',
            'photo.required' => 'Photo is required / File size should be less than 2 MB',
            'comment.required' => 'Reason to edit is required',
            'photoupload.required' => "Photo not uploaded, please upload again.",
            'dobupload.required' => "DOB certificate not uploaded, please upload again.",
            'markupload.required' => "Marks proof not uploaded, please upload again.",
            'dupload.required' => "Disability Certificate not uploaded, please upload again.",
            'peupload.required' => "Percentage exception document not uploaded, please upload again.",
            'cupload.required' => "Community Certificate not uploaded, please upload again.",
            'rciupload.required' => "RCI Certificate is required",
            'contactnumber.numeric' => "Please enter valid mobile number",
            'contactnumber.min' => "Please enter valid mobile number",
            'contactnumber.max' => "Please enter valid mobile number",
            'udid.udid' => "Invalid UDID/UDID Enrolment Number",
            
        ]; */

        $this->validate($request, $rules,$messages);
        $request->name = trim($request->name);
        $request->name = str_replace('   ',' ',$request->name);
        $request->name = str_replace('  ',' ',$request->name);
        $request->name = strtolower($request->name);
        $request->name = ucwords($request->name);

        $request->fathername = trim($request->fathername);
        $request->fathername = str_replace('   ',' ',$request->fathername);
        $request->fathername = str_replace('  ',' ',$request->fathername);
        $request->fathername = strtolower($request->fathername);
        $request->fathername = ucwords($request->fathername);

        if($candidate==null){
            $candidate = Candidate::create($request->all());
            if($request->has('edugrade_1')){
                Education::create([
                        'candidate_id' => $candidate->id,
                        'board' => $request->board_1,
                        'yop' => $request->yop_1,
                        'tmarks' => $request->tmarks_1,
                        'omarks' => $request->omarks_1,
                        'percentage' => $request->percentage_1,
                        'subjects' => $request->subjects_1,
                        'edugrade' => $request->edugrade_1,
                ]);
            }
            if($request->has('edugrade_2')){
                Education::create([
                        'candidate_id' => $candidate->id,
                        'board' => $request->board_2,
                        'yop' => $request->yop_2,
                        'tmarks' => $request->tmarks_2,
                        'omarks' => $request->omarks_2,
                        'percentage' => $request->percentage_2,
                        'subjects' => $request->subjects_2,
                        'edugrade' => $request->edugrade_2,
                ]);
            }
            if($request->has('edugrade_3')||$request->has('board_3')){
                Education::create([
                        'candidate_id' => $candidate->id,
                        'board' => $request->board_3,
                        'yop' => $request->yop_3,
                        'tmarks' => $request->tmarks_3,
                        'omarks' => $request->omarks_3,
                        'percentage' => $request->percentage_3,
                        'subjects' => $request->subjects_3,
                        'edugrade' => $request->edugrade_3,
                ]);
            }

        }else{
            // $candidate->subdistrict_id = 0;
            // $candidate->village_id = 0;
            // $candidate->psubdistrict_id = 0;
            // $candidate->pvillage_id =0;
            // $candidate->save();

            $candidatedatahistory = new CandidateDataHistory();
            $candidatedatahistory->candidate_id = $candidate->id;
            $candidatedatahistory->user_id = Auth::user()->id;
            $candidatedatahistory->enrolmentno = $candidate->enrolmentno;
            $candidatedatahistory->name = $candidate->name;
            $candidatedatahistory->fathername = $candidate->fathername;
            $candidatedatahistory->mothername = $candidate->mothername;
            $candidatedatahistory->gender_id = $candidate->gender_id;
            $candidatedatahistory->udid = $candidate->udid;
            $candidatedatahistory->ews = $candidate->ews;
            $candidatedatahistory->dob = $candidate->dob;
            $candidatedatahistory->address = $candidate->address;
            $candidatedatahistory->pincode = $candidate->pincode;
            $candidatedatahistory->contactnumber = $candidate->contactnumber;
            $candidatedatahistory->email = $candidate->email;
            $candidatedatahistory->photo = $candidate->photo;
            $candidatedatahistory->community_id = $candidate->community_id;
            $candidatedatahistory->disability_id = $candidate->disability_id;
            $candidatedatahistory->disability_name = $candidate->disability_name;
            $candidatedatahistory->city_id = $candidate->city_id;
            $candidatedatahistory->status_id = $candidate->status_id;
            $candidatedatahistory->coursecompleted_status = $candidate->coursecompleted_status;
            $candidatedatahistory->aadhar = $candidate->aadhar;
            $candidatedatahistory->doc_tenth = $candidate->doc_tenth;
            $candidatedatahistory->doc_twelveth = $candidate->doc_twelveth;
            $candidatedatahistory->doc_application = $candidate->doc_application;
            $candidatedatahistory->doc_community = $candidate->doc_community;

            $educationstring = '';
            foreach($candidate->educations as $etable){
                $educationstring .= $etable->board . ',' . $etable->yop . ',' . $etable->tmarks . ',' . $etable->omarks . ',' . $etable->percentage . ',' . $etable->subjects . ',' . $etable->edugrade . '::';
            }
            $candidatedatahistory->education= $educationstring;
            $candidatedatahistory->save();
            
            // $candidate->update($request->except('photo','doc_tenth','doc_twelveth','doc_community','doc_application'));
            if($candidate->contactnumber != $request->contactnumber){
                $candidate->update([
                    "user_id" => null
                ]);
            }
            $candidate->update($request->except('photo','doc_tenth','doc_application','doc_twelveth','doc_community'));
            $comment = ' updated enrolment data, status set to verification pending.  Note: '. $request->comment ;
            if($request->has('edugrade_1')){
                $edu = \App\Education::where('edugrade','10th')->where('candidate_id',$candidate->id)->first();
                if(!is_null($edu)){
                $edu->update([
                        'board' => $request->board_1,
                        'yop' => $request->yop_1,
                        'tmarks' => $request->tmarks_1,
                        'omarks' => $request->omarks_1,
                        'percentage' => $request->percentage_1,
                        'subjects' => $request->subjects_1,
                        'edugrade' => $request->edugrade_1,
                ]);
                }else{
                    Education::create([
                        'candidate_id' => $candidate->id,
                        'board' => $request->board_1,
                        'yop' => $request->yop_1,
                        'tmarks' => $request->tmarks_1,
                        'omarks' => $request->omarks_1,
                        'percentage' => $request->percentage_1,
                        'subjects' => $request->subjects_1,
                        'edugrade' => $request->edugrade_1,
                ]);
                }
            }
            if($request->has('edugrade_2')){
            $edu = \App\Education::where('edugrade','12th')->where('candidate_id',$candidate->id)->first();
                if(!is_null($edu)){
                    $edu->update([
                        'board' => $request->board_2,
                        'yop' => $request->yop_2,
                        'tmarks' => $request->tmarks_2,
                        'omarks' => $request->omarks_2,
                        'percentage' => $request->percentage_2,
                        'subjects' => $request->subjects_2,
                        'edugrade' => $request->edugrade_2,
                    ]);
                }else{
                    Education::create([
                        'candidate_id' => $candidate->id,
                        'board' => $request->board_2,
                        'yop' => $request->yop_2,
                        'tmarks' => $request->tmarks_2,
                        'omarks' => $request->omarks_2,
                        'percentage' => $request->percentage_2,
                        'subjects' => $request->subjects_2,
                        'edugrade' => $request->edugrade_2,
                ]);
                }
            }
            if($request->has('edugrade_3')||$request->has('board_3')){
                $edu = \App\Education::whereNotIn('edugrade',['10th','12th'])->where('candidate_id',$candidate->id)->first();
                if($edu){
                    $edu->update([
                            'board' => $request->board_3,
                            'yop' => $request->yop_3,
                            'tmarks' => $request->tmarks_3,
                            'omarks' => $request->omarks_3,
                            'percentage' => $request->percentage_3,
                            'subjects' => $request->subjects_3,
                            'edugrade' => $request->edugrade_3,
                    ]);
                }else{
                    Education::create([
                        'candidate_id' => $candidate->id,
                        'board' => $request->board_3,
                        'yop' => $request->yop_3,
                        'tmarks' => $request->tmarks_3,
                        'omarks' => $request->omarks_3,
                        'percentage' => $request->percentage_3,
                        'subjects' => $request->subjects_3,
                        'edugrade' => $request->edugrade_3,
                ]);
                }
            }/*
            if($request->has('edugrade_1')){
                $edu = \App\Education::where('edugrade','10th')->where('candidate_id',$candidate->id)->first();
                $edu->update([
                        'board' => $request->board_1,
                        'yop' => $request->yop_1,
                        'tmarks' => $request->tmarks_1,
                        'omarks' => $request->omarks_1,
                        'percentage' => $request->percentage_1,
                        'subjects' => $request->subjects_1,
                        'edugrade' => $request->edugrade_1,
                ]);
            }
            if($request->has('edugrade_2')){
                $edu = \App\Education::where('edugrade','12th')->where('candidate_id',$candidate->id)->first();
                $edu->update([
                        'board' => $request->board_2,
                        'yop' => $request->yop_2,
                        'tmarks' => $request->tmarks_2,
                        'omarks' => $request->omarks_2,
                        'percentage' => $request->percentage_2,
                        'subjects' => $request->subjects_2,
                        'edugrade' => $request->edugrade_2,
                ]);
            }
            if($request->has('edugrade_3')||$request->has('board_3')){
                $edu = \App\Education::whereNotIn('edugrade',['10th','12th'])->where('candidate_id',$candidate->id)->first();
                $edu->update([
                        'board' => $request->board_3,
                        'yop' => $request->yop_3,
                        'tmarks' => $request->tmarks_3,
                        'omarks' => $request->omarks_3,
                        'percentage' => $request->percentage_3,
                        'subjects' => $request->subjects_3,
                        'edugrade' => $request->edugrade_3,
                ]);
            } */
            $candidate->candidateapprovals()->create(['user_id'=>Auth::user()->id,'comment'=>$comment]);
        }

        $candidate->update([
            "status_id" => 6
        ]);
        /** Updating Approvedprogramme  **/
        $approvedprogramme = Approvedprogramme::find($candidate->approvedprogramme->id);

        $candidateApprovalStatuses = Candidate::where('approvedprogramme_id', $approvedprogramme->id)->get(['enrolmentno', 'status_id']);
        $enrolmentCount = Candidate::where('approvedprogramme_id', $approvedprogramme->id)->whereNotNull('enrolmentno')->count();;

        $approvedprogramme->update([
            "registered_count" => $candidateApprovalStatuses->count(),
            "enrolment_count" => $enrolmentCount,
            "verificationpending_count" => $candidateApprovalStatuses->where('status_id', 6)->count(),
            "approved_count" => $candidateApprovalStatuses->where('status_id', 2)->count(),
            "pending_count" => $candidateApprovalStatuses->where('status_id', 1)->count(),
            "rejected_count" => $candidateApprovalStatuses->where('status_id', 3)->count(),
        ]);

        $filestart = $request->approvedprogramme_id . '_' . $candidate->id ;
        if($request->has('photo')){
            if(!is_null($candidate->photo) || $candidate->photo != '') {
                if (file_exists(public_path().'/files/enrolment/photos/'.$candidate->photo)) {
                    unlink(public_path().'/files/enrolment/photos/'.$candidate->photo);
                }
                if (file_exists(public_path().'/files/enrolment/photos/cropped/'.$candidate->photo)) {
                    unlink(public_path().'/files/enrolment/photos/cropped/'.$candidate->photo);
                }
            }
            if (file_exists(public_path().'/files/temp/'.$request->photo)) {
                $file = public_path().'/files/temp/'.$request->photo;
            }
            if (file_exists(public_path().'/files/temp/cropped/'.$request->photo)) {
                $file = public_path().'/files/temp/cropped/'.$request->photo;
            }

            $ex = explode('.', $file);
            $extn = end($ex);
            $filename = $filestart. "." . $extn ;
            $destination = public_path().'/files/enrolment/photos/cropped/'.$filename;
            File::move($file,$destination);
            $candidate->update(['photo'=> 'cropped/'.$filename]);
            $candidate->photo = 'cropped/'.$filename;
            $candidate->save();

        }
       /*

        if($request->has('doc_dob')){
            if(!is_null($candidate->doc_dob) || $candidate->doc_dob != '') {
                if (file_exists(public_path().'/files/enrolment/dateofbirth/'.$candidate->doc_dob)) {
                    unlink(public_path().'/files/enrolment/dateofbirth/'.$candidate->doc_dob);
                }
            }

            $file = public_path().'/files/temp/'. $request->doc_dob;
            $ex = explode('.', $file);
            $extn = end($ex);
            $filename = $filestart. "." . $extn ;
            $destination = public_path().'/files/enrolment/dateofbirth/'.$filename;
            File::move($file,$destination);
            $candidate->update(['doc_dob'=> $filename]);
        }
        if($request->has('doc_rci')){
            if(!is_null($candidate->doc_rci) || $candidate->doc_rci != '') {
                if (file_exists(public_path().'/files/enrolment/crr/'.$candidate->doc_rci)) {
                    unlink(public_path().'/files/enrolment/crr/'.$candidate->doc_rci);
                }
            }

            $file = public_path().'/files/temp/'. $request->doc_rci;
            $ex = explode('.', $file);
            $extn = end($ex);
            $filename = $filestart. "." . $extn ;
            $destination = public_path().'/files/enrolment/crr/'.$filename;
            File::move($file,$destination);
            $candidate->update(['doc_rci'=> $filename]);
        }
        */
        if($request->has('doc_tenth')){
            if(!is_null($candidate->doc_tenth) || $candidate->doc_tenth != '') {
                // if (file_exists(public_path().'/files/enrolment/marksheets/'.$candidate->doc_tenth)) {
                //     //unlink(public_path().'/files/enrolment/marksheets/'.$candidate->doc_tenth);
                // }
            }

            $file = public_path().'/files/temp/'. $request->doc_tenth;
            $ex = explode('.', $file);
            $extn = end($ex);
            $filename = $filestart. "." . $extn ;
            $destination = public_path().'/files/enrolment/marksheets/tenth/'.$filename;
            File::move($file,$destination);
            //$candidate->update(['doc_tenth'=> $filename]);
            $candidate->doc_tenth = $filename;
            $candidate->save();
        }
        
        if($request->has('doc_twelveth')){
            if(!is_null($candidate->doc_twelveth) || $candidate->doc_twelveth != '') {
                // if (file_exists(public_path().'/files/enrolment/marksheets/'.$candidate->doc_twelveth)) {
                //     unlink(public_path().'/files/enrolment/marksheets/'.$candidate->doc_twelveth);
                // }
            }

            $file = public_path().'/files/temp/'. $request->doc_twelveth;
            $ex = explode('.', $file);
            $extn = end($ex);
            $filename = $filestart. "." . $extn ;
            $destination = public_path().'/files/enrolment/marksheets/twelveth/'.$filename;
            File::move($file,$destination);
            //$candidate->update(['doc_twelveth'=> $filename]);
            $candidate->doc_twelveth = $filename;
            $candidate->save();
        }
        if($request->has('doc_application')){
            if(!is_null($candidate->doc_application) || $candidate->doc_application != '') {
                // if (file_exists(public_path().'/files/enrolment/'.$candidate->doc_application)) {
                //     unlink(public_path().'/files/enrolment/'.$candidate->doc_application);
                // }
            }

            $file = public_path().'/files/temp/'. $request->doc_application;
            $ex = explode('.', $file);
            $extn = end($ex);
            $filename = $filestart. "." . $extn ;
            $destination = public_path().'/files/enrolment/applications/'.$filename;
            File::move($file,$destination);
           // $candidate->update(['doc_application'=> $filename]);
            $candidate->doc_application = $filename;
            $candidate->save();
        }
        /*
        if($request->has('doc_disability')){
            if($request->disability_id > 1){

                if(!$candidate->doc_disability == null) {
                    if (file_exists(public_path().'/files/enrolment/d/'.$candidate->doc_disability)) {
                        unlink(public_path().'/files/enrolment/d/'.$candidate->doc_disability);
                    }
                }

                $file = public_path().'/files/temp/'. $request->doc_disability;
                $ex = explode('.', $file);
                $extn = end($ex);
                $filename = $filestart. "." . $extn ;
                $destination = public_path().'/files/enrolment/d/'.$filename;
                File::move($file,$destination);
                $candidate->update(['doc_disability'=> $filename]);

            }else{
                $candidate->update(['doc_disability'=>NULL]);
            }
        } */
        if($request->has('doc_community')){
            if(!is_null($request->doc_community) ) {
                    // if (file_exists(public_path().'/files/enrolment/c/'.$candidate->doc_community)) {
                    //     unlink(public_path().'/files/enrolment/c/'.$candidate->doc_community);
                    // }

                $file = public_path().'/files/temp/'. $request->doc_community;
                $ex = explode('.', $file);
                $extn = end($ex);
                $filename = $filestart. "." . $extn ;
                $destination = public_path().'/files/enrolment/c/'.$filename;
                File::move($file,$destination);
                // $candidate->update(['doc_community'=> $filename]);
                $candidate->doc_community = $filename;
                $candidate->save();
            }else{
                $candidate->update(['doc_community'=>NULL]);
                $candidate->doc_community = null;
                $candidate->save();
            }
        }
        /*
        if($request->has('pex')){
            if($request->has('doc_percentage_exception')){
                if(!$candidate->doc_percentage_exception == null) {
                    if (file_exists(public_path().'/files/enrolment/p/'.$candidate->doc_percentage_exception)) {
                        unlink(public_path().'/files/enrolment/p/'.$candidate->doc_percentage_exception);
                    }
                }

                if(!is_null($candidate->doc_percentage_exception) || $candidate->doc_percentage_exception != '') {
                    if (file_exists(public_path().'/files/enrolment/p/'.$candidate->doc_percentage_exception)) {
                        unlink(public_path().'/files/enrolment/p/'.$candidate->doc_percentage_exception);
                    }
                }

                $file = public_path().'/files/temp/'. $request->doc_percentage_exception;
                $ex = explode('.', $file);
                $extn = end($ex);
                $filename = $filestart. "." . $extn ;
                $destination = public_path().'/files/enrolment/p/'.$filename;
                File::move($file,$destination);
                $candidate->update(['doc_percentage_exception'=> $filename]);
            }
        }else{
            $candidate->update(['doc_percentage_exception'=>NULL]);
        }
        */
        for($i=0;$i<5;$i++){
            $chkf = 'filename_'.$i;
            if($request->has($chkf)){

                $fn = 'filename_'.$i;
                $file = public_path().'/files/temp/'. $request->$fn;
                $ex = explode('.', $file);
                $extn = end($ex);
                $filename = $filestart.'_'. $i . "." . $extn ;
                $destination = public_path().'/files/enrolment/additional/'.$filename;
                File::copy($file,$destination);
                //$candidate->update(['doc_percentage_exception'=> $filename]);
                $fd = 'filedescription_'.$i;
                $candidate->candidatefiles()->create(['filename'=>$filename,'description'=>$request->$fd]);
            }
        }

        Session::put('messages','Enrolment data updated');
        return redirect('/nber/candidates/'.$request->approvedprogramme_id);
    }

    public function storedraft(Request $request){
        return back();
        return $this->storeorupdateDraft($request);
    }


    public function updatedraft($id, Request $request){
        return back();
        $candidate = Candidate::find($id);
        return $this->storeorupdateDraft($request,$candidate);
    }

    private function storeorupdateDraft($request, $candidate = null){
        return back();
        if($request->email == ''){
            $request->merge(['email' => 'TEMP' . str_random(8).'@example.com']);
        }
        if(!$request->has('email')){
            $request->merge(['email' => 'TEMP' . str_random(8).'@example.com']);
        }
        $rules = [
        'name' => 'required|max:99',
        'gender_id' => 'required|numeric|min:1',
        'community_id' => 'required|numeric|min:1',
        // 'disability_id' => 'required|numeric|min:1',
        'fathername' => 'required|max:99',
        'mothername' => 'required|max:99',
        'enrolmentno' => 'required',
        'email'=> 'unique:candidates',
        ]; 
        
        
        $request->pincode = trim($request->pincode);
        $request->pincode = str_replace(' ','',$request->pincode);
        $request->contactnumber = trim($request->contactnumber);
        $request->contactnumber = str_replace(' ','',$request->contactnumber);
        $request->aadhar = trim($request->aadhar);
        $request->aadhar = str_replace(' ','',$request->aadhar);
        $request->udid = trim($request->udid);
        $request->udid = str_replace(' ','',$request->udid);
        $messages = [
        'gender_id.min' => 'Gender is required',
        'gender_id.required' => 'Gender is required',
        'disabilityper.required' => 'Disability percentage is required',
        'disabilitytype_id.required' => 'Disability type is required',
        'coummunity_id.required' => 'Category is required',
        'state_id.required' => 'State is required in Correspondence Address',
        'pstate_id.required' => 'State is required in Permanent Address',
        'district_id.required' => 'District is required in Correspondence Address',
        'pdistrict_id.required' => 'District is required in Permanent Address',
        'name.required' => 'Name is required',
        'address.required' => 'Address is required in Correspondence Address',
        'address.min' => 'Address is too short in Correspondence Address',
        'pddress.min' => 'Address is too short in Permanent Address',
        'paddress.required' => 'Address is required  in Permanent Address',
        'community_id.required' => ' Category is required',
        'disability_id.min' => 'Disability is required',
        'salutation_id.required' => 'S/o D/o W/o required for Father/Husband name',
        'pincode.min'=> 'Please enter valid PIN code in Correspondence Address            ',
        'pincode.required'=> 'Please enter valid PIN code in Correspondence Address            ',
        'pincode.max'=> 'Please enter valid PIN code in Correspondence Address            ',
        'ppincode.min'=> 'Please enter valid PIN code in Permanent Address            ',
        'ppincode.required'=> 'Please enter valid PIN code in Permanent Address            ',
        'ppincode.max'=> 'Please enter valid PIN code in Permanent Address            ',
        'board_1.required' => 'Please enter 10th board name',
        'board_1.min' => 'Please check 10th board name',
        'yop_1.required' => 'Please enter 10th passing year',
        'yop_1.min' => 'Please check 10th passing year',
        'yop_1.max' => 'Please check 10th passing year',
        'tmarks_1.required' => 'Please enter 10th total mark',
        'tmarks_1.min' => 'Please check 10th total mark',
        'tmarks_1.max' => 'Please check 10th total mark',
        'omarks_1.required' => 'Please enter 10th obtained mark',
        'omarks_1.min' => 'Please check 10th obtained mark',
        'omarks_1.max' => 'Please check 10th obtained mark',
        'subjects_1.required' => 'Please enter 10th subjects',
        'percentage_1.required' => 'Please enter 10th Marks',
        'percentage_1.min' => 'Please check 10th Marks',
        'percentage_1.max' => 'Please check 10th Marks',
        'subjects_1.min' => 'Please check 10th subjects, too short',
        'board_2.required' => 'Please enter 12th board name',
        'board_2.min' => 'Please check 12th board name',
        'yop_2.required' => 'Please enter 12th passing year',
        'yop_2.min' => 'Please check 12th passing year',
        'yop_2.max' => 'Please check 12th passing year',
        'tmarks_2.required' => 'Please enter 12th total mark',
        'tmarks_2.min' => 'Please check 12th total mark',
        'tmarks_2.max' => 'Please check 12th total mark',
        'omarks_2.required' => 'Please enter 12th obtained mark',
        'omarks_2.min' => 'Please check 12th obtained mark',
        'omarks_2.max' => 'Please check 12th obtained mark',
        'percentage_2.required' => 'Please enter 12th Marks',
        'percentage_2.min' => 'Please check 12th Marks',
        'percentage_2.max' => 'Please check 12th Marks',
        'subjects_2.required' => 'Please enter 12th subjects',
        'subjects_2.min' => 'Please check 12th subjects, too short',
        'board_3.min' => 'Please check additionalboard name',
        'yop_3.required' => 'Please enter additionalpassing year',
        'yop_3.min' => 'Please check additionalpassing year',
        'yop_3.max' => 'Please check additionalpassing year',
        'tmarks_3.required' => 'Please enter additionaltotal mark',
        'tmarks_3.min' => 'Please check additionaltotal mark',
        'tmarks_3.max' => 'Please check additionaltotal mark',
        'omarks_3.required' => 'Please enter additional obtained mark',
        'omarks_3.min' => 'Please check additional obtained mark',
        'omarks_3.max' => 'Please check additional obtained obtained mark',
        'percentage_3.required' => 'Please enter additional Marks',
        'percentage_3.min' => 'Please check additional Marks',
        'percentage_3.max' => 'Please check additional Marks',
        'subjects_3.required' => 'Please enter additional subjects',
        'subjects_3.min' => 'Please check additional subjects, too short',


        'doc_percentage_exception.required' => 'Supporting document is requried if percentage is less. Please check the box below percengtage and attache the document  / File size should be less than 2 MB',
        'doc_dob.required' => '10th/12th Certificate is required. File size should be less than 1 MB',
        'doc_tenth.required' => '10th Marksheet  required / File size should be less than 1 MB',
        'doc_twelveth.required' => '12th Marksheet  required / File size should be less than 1 MB',
        'doc_community.required' => 'Community Certificate is required / File size should be less than 1 MB',
        'doc_disability.required' => 'Disability Certificate is required / File size should be less than 2 MB',
    //    'photo.required' => 'Photo is required / File size should be less than 1 MB',
        'comment.required' => 'Reason to edit is required',
    //    'photoupload.required' => "Photo not uploaded, please upload again.",
        'dobupload.required' => "DOB certificate not uploaded, please upload again.",
        'markupload.required' => "Marks proof not uploaded, please upload again.",
        'dupload.required' => "Disability Certificate not uploaded, please upload again.",
        'peupload.required' => "Percentage exception document not uploaded, please upload again.",
        'cupload.required' => "Community Certificate not uploaded, please upload again.",
        'rciupload.required' => "RCI Certificate is required",
        'contactnumber.numeric' => "Please enter valid mobile number",
        'contactnumber.min' => "Please enter valid mobile number",
        'contactnumber.max' => "Please enter valid mobile number",
        'udid.udid' => "Invalid UDID/UDID Enrolment Number",
        'contactnumber.unique' => "Mobile number already exists",
        ];

        if($candidate==null){
           // $rules['photo'] = 'required';
        }
        if($request->has('photo') ){
            if(!file_exists(public_path().'/files/temp/'.$request->photo)){
            //    $rules['photoupload'] = 'required';
            }
        }
        if($request->has('doc_tenth') ){
            if(!file_exists(public_path().'/files/temp/'.$request->doc_tenth)){
               $rules['doc_tenth'] = 'required';
            }
        }
        if($request->has('doc_twelveth') ){
            if(!file_exists(public_path().'/files/temp/'.$request->doc_twelveth)){
                $rules['doc_twelveth'] = 'required';
            }
        }
        if($request->has('doc_application')){
            if(!file_exists(public_path().'/files/temp/'.$request->doc_twelveth)){
                $rules['doc_application'] = 'required';
            }
        }
        $this->validate($request, $rules,$messages);
        $request->name = trim($request->name);
        $request->name = str_replace('   ',' ',$request->name);
        $request->name = str_replace('  ',' ',$request->name);
        $request->name = strtolower($request->name);
        $request->name = ucwords($request->name);

        $request->fathername = trim($request->fathername);
        $request->fathername = str_replace('   ',' ',$request->fathername);
        $request->fathername = str_replace('  ',' ',$request->fathername);
        $request->fathername = strtolower($request->fathername);
        $request->fathername = ucwords($request->fathername);

        if($candidate==null){
            $candidate = Candidate::create($request->all());
            if($request->has('edugrade_1')){
                Education::create([
                        'candidate_id' => $candidate->id,
                        'board' => $request->board_1,
                        'yop' => $request->yop_1,
                        'tmarks' => $request->tmarks_1,
                        'omarks' => $request->omarks_1,
                        'percentage' => $request->percentage_1,
                        'subjects' => $request->subjects_1,
                        'edugrade' => $request->edugrade_1,
                ]);
            }
            if($request->has('edugrade_2')){
                Education::create([
                        'candidate_id' => $candidate->id,
                        'board' => $request->board_2,
                        'yop' => $request->yop_2,
                        'tmarks' => $request->tmarks_2,
                        'omarks' => $request->omarks_2,
                        'percentage' => $request->percentage_2,
                        'subjects' => $request->subjects_2,
                        'edugrade' => $request->edugrade_2,
                ]);
            }
            if($request->has('edugrade_3')||$request->has('board_3')){
                Education::create([
                        'candidate_id' => $candidate->id,
                        'board' => $request->board_3,
                        'yop' => $request->yop_3,
                        'tmarks' => $request->tmarks_3,
                        'omarks' => $request->omarks_3,
                        'percentage' => $request->percentage_3,
                        'subjects' => $request->subjects_3,
                        'edugrade' => $request->edugrade_3,
                ]);
            }
        }else{
            $candidate->subdistrict_id = 0;
            $candidate->village_id = 0;
            $candidate->psubdistrict_id = 0;
            $candidate->pvillage_id =0;
            $candidate->save();
            $candidate->update($request->except('photo','doc_tenth','doc_twelveth','doc_community','doc_application'));
            $comment = ' updated enrolment data, status set to verification pending.  Note: '. $request->comment ;
            if($request->has('edugrade_1')){
                $edu = \App\Education::where('edugrade','10th')->where('candidate_id',$candidate->id)->first();
                if(!is_null($edu)){
                $edu->update([
                        'board' => $request->board_1,
                        'yop' => $request->yop_1,
                        'tmarks' => $request->tmarks_1,
                        'omarks' => $request->omarks_1,
                        'percentage' => $request->percentage_1,
                        'subjects' => $request->subjects_1,
                        'edugrade' => $request->edugrade_1,
                ]);
                }else{
                    Education::create([
                        'candidate_id' => $candidate->id,
                        'board' => $request->board_1,
                        'yop' => $request->yop_1,
                        'tmarks' => $request->tmarks_1,
                        'omarks' => $request->omarks_1,
                        'percentage' => $request->percentage_1,
                        'subjects' => $request->subjects_1,
                        'edugrade' => $request->edugrade_1,
                ]);
                }
            }
            if($request->has('edugrade_2')){
            $edu = \App\Education::where('edugrade','12th')->where('candidate_id',$candidate->id)->first();
                if(!is_null($edu)){
                    $edu->update([
                        'board' => $request->board_2,
                        'yop' => $request->yop_2,
                        'tmarks' => $request->tmarks_2,
                        'omarks' => $request->omarks_2,
                        'percentage' => $request->percentage_2,
                        'subjects' => $request->subjects_2,
                        'edugrade' => $request->edugrade_2,
                    ]);
                }else{
                    Education::create([
                        'candidate_id' => $candidate->id,
                        'board' => $request->board_2,
                        'yop' => $request->yop_2,
                        'tmarks' => $request->tmarks_2,
                        'omarks' => $request->omarks_2,
                        'percentage' => $request->percentage_2,
                        'subjects' => $request->subjects_2,
                        'edugrade' => $request->edugrade_2,
                ]);
                }
            }
            if($request->has('edugrade_3')||$request->has('board_3')){
                $edu = \App\Education::whereNotIn('edugrade',['10th','12th'])->where('candidate_id',$candidate->id)->first();
                if($edu){
                    $edu->update([
                            'board' => $request->board_3,
                            'yop' => $request->yop_3,
                            'tmarks' => $request->tmarks_3,
                            'omarks' => $request->omarks_3,
                            'percentage' => $request->percentage_3,
                            'subjects' => $request->subjects_3,
                            'edugrade' => $request->edugrade_3,
                    ]);
                }else{
                    Education::create([
                        'candidate_id' => $candidate->id,
                        'board' => $request->board_3,
                        'yop' => $request->yop_3,
                        'tmarks' => $request->tmarks_3,
                        'omarks' => $request->omarks_3,
                        'percentage' => $request->percentage_3,
                        'subjects' => $request->subjects_3,
                        'edugrade' => $request->edugrade_3,
                ]);
                }
            }
            $candidate->candidateapprovals()->create(['user_id'=>Auth::user()->id,'comment'=>$comment]);
        }
        $candidate->update([
            "status_id" => 6
        ]);
        $approvedprogramme = Approvedprogramme::find($candidate->approvedprogramme->id);

        $candidateApprovalStatuses = Candidate::where('approvedprogramme_id', $approvedprogramme->id)->get(['enrolmentno', 'status_id']);
        $enrolmentCount = Candidate::where('approvedprogramme_id', $approvedprogramme->id)->whereNotNull('enrolmentno')->count();;

        $approvedprogramme->update([
        "registered_count" => $candidateApprovalStatuses->count(),
        "enrolment_count" => $enrolmentCount,
        "verificationpending_count" => $candidateApprovalStatuses->where('status_id', 6)->count(),
        "approved_count" => $candidateApprovalStatuses->where('status_id', 2)->count(),
        "pending_count" => $candidateApprovalStatuses->where('status_id', 1)->count(),
        "rejected_count" => $candidateApprovalStatuses->where('status_id', 3)->count(),
        ]);

        $filestart = $request->approvedprogramme_id . '_' . $candidate->id ;
        if($request->has('photo')){
            if(!is_null($candidate->photo) || $candidate->photo != '') {
            if (file_exists(public_path().'/files/enrolment/photos/'.$candidate->photo)) {
                unlink(public_path().'/files/enrolment/photos/'.$candidate->photo);
            }
            if (file_exists(public_path().'/files/enrolment/photos/cropped/'.$candidate->photo)) {
                unlink(public_path().'/files/enrolment/photos/cropped/'.$candidate->photo);
            }
            }
            if (file_exists(public_path().'/files/temp/'.$request->photo)) {
            $file = public_path().'/files/temp/'.$request->photo;
            }
            if (file_exists(public_path().'/files/temp/cropped/'.$request->photo)) {
            $file = public_path().'/files/temp/cropped/'.$request->photo;
            }

            $ex = explode('.', $file);
            $extn = end($ex);
            $filename = $filestart. "." . $extn ;
            $destination = public_path().'/files/enrolment/photos/cropped/'.$filename;
            File::move($file,$destination);
            $candidate->update(['photo'=> 'cropped/'.$filename]);

        }

        if($request->has('doc_tenth')){
        if(!is_null($candidate->doc_tenth) || $candidate->doc_tenth != '') {
        if (file_exists(public_path().'/files/enrolment/marksheets/tenth/'.$candidate->doc_tenth)) {
            unlink(public_path().'/files/enrolment/marksheets/tenth/'.$candidate->doc_tenth);
        }
        }

        $file = public_path().'/files/temp/'. $request->doc_tenth;
        $ex = explode('.', $file);
        $extn = end($ex);
        $filename = $filestart. "." . $extn ;
        $destination = public_path().'/files/enrolment/marksheets/tenth/'.$filename;
        File::move($file,$destination);
        $candidate->update(['doc_tenth'=> $filename]);
        }

        if($request->has('doc_twelveth')){
        if(!is_null($candidate->doc_twelveth) || $candidate->doc_twelveth != '') {
        if (file_exists(public_path().'/files/enrolment/marksheets/twelveth/'.$candidate->doc_twelveth)) {
            unlink(public_path().'/files/enrolment/marksheets/twelveth/'.$candidate->doc_twelveth);
        }
        }

        $file = public_path().'/files/temp/'. $request->doc_twelveth;
        $ex = explode('.', $file);
        $extn = end($ex);
        $filename = $filestart. "." . $extn ;
        $destination = public_path().'/files/enrolment/marksheets/twelveth/'.$filename;
        File::move($file,$destination);
        $candidate->update(['doc_twelveth'=> $filename]);
        }
        if($request->has('doc_application')){
        if(!is_null($candidate->doc_application) || $candidate->doc_application != '') {
        if (file_exists(public_path().'/files/enrolment/'.$candidate->doc_application)) {
            unlink(public_path().'/files/enrolment/'.$candidate->doc_application);
        }
        }

        $file = public_path().'/files/temp/'. $request->doc_application;
        $ex = explode('.', $file);
        $extn = end($ex);
        $filename = $filestart. "." . $extn ;
        $destination = public_path().'/files/enrolment/applications/'.$filename;
        File::move($file,$destination);
        $candidate->update(['doc_application'=> $filename]);
        }
        if($request->has('doc_community')){
        if(!$candidate->doc_community == null) {
            if (file_exists(public_path().'/files/enrolment/c/'.$candidate->doc_community)) {
                unlink(public_path().'/files/enrolment/c/'.$candidate->doc_community);
            }

        $file = public_path().'/files/temp/'. $request->doc_community;
        $ex = explode('.', $file);
        $extn = end($ex);
        $filename = $filestart. "." . $extn ;
        $destination = public_path().'/files/enrolment/c/'.$filename;
        File::move($file,$destination);
        $candidate->update(['doc_community'=> $filename]);
        }else{
        $candidate->update(['doc_community'=>NULL]);
        }
        }
        for($i=0;$i<5;$i++){
            $chkf = 'filename_'.$i;
            if($request->has($chkf)){

            $fn = 'filename_'.$i;
            $file = public_path().'/files/temp/'. $request->$fn;
            $ex = explode('.', $file);
            $extn = end($ex);
            $filename = $filestart.'_'. $i . "." . $extn ;
            $destination = public_path().'/files/enrolment/additional/'.$filename;
            File::copy($file,$destination);
            //$candidate->update(['doc_percentage_exception'=> $filename]);
            $fd = 'filedescription_'.$i;
            $candidate->candidatefiles()->create(['filename'=>$filename,'description'=>$request->$fd]);
            }
        }

        Session::put('messages','Enrolment data updated');
        return redirect('/nber/candidates/'.$request->approvedprogramme_id);
    }
    public function show($id){




        $candidate = Candidate::find($id);
        $current_exam = Exam::find(24);
        $terms = [];


$user = Auth::user();
if ($user && $user->id != 88387) {
    $nberStaff = \App\Nberstaff::where('user_id', $user->id)->first();
    if ($candidate->approvedprogramme->programme->nber_id != $nberStaff->nber_id) {
        Session::put('messages', 'Contact NBER: ' . $nberStaff->name_code);
        return back();
    }
}
    
      /*  if($candidate->approvedprogramme->academicyear_id == $current_exam->academicyear_id){
            $termsubjects = \App\Subject::where('syear',1)->where('programme_id',$candidate->approvedprogramme->programme_id)->get();
            $backlogsubjects = null;
        }else{
            if($candidate->approvedprogramme->academicyear_id == ($current_exam->academicyear_id - 1)){
                $termsubjects = \App\Subject::where('syear',2)->where('programme_id',$candidate->approvedprogramme->programme_id)->get();
                $backlogsubject_ids = DB::select("select subject_id from marks
                where candidate_id = " . $candidate->id . " 
                group by `subject_id`
                having sum(result_id) =0");
                $backlogsubjects = \App\Subject::whereIn('id',array_pluck($backlogsubject_ids,'subject_id'))->get();
            }else{
                $termsubjects = null;
                $backlogsubject_ids =DB::select("select subject_id from marks
                where candidate_id = " . $candidate->id . "
                group by `subject_id`
                having sum(result_id) =0");
                $backlogsubjects = \App\Subject::whereIn('id',array_pluck($backlogsubject_ids,'subject_id'))->get();
            }
        } */

        
        $exams = \App\Exam::where('id','<',27)->orderBy('id','desc')->get();
        $marks = DB::select("
            select  
                m.id,
                e.name, 
                s.scode, 
                s.sname, 
                case m.internalattendance_id when 1 then '1' when 2 then '2' else 'NA' end as internal_attendance, 
                case m.externalattendance_id when 1 then '1' when 2 then '2' else 'NA' end as external_attendance, 
                internal_mark,
                external_mark,
                s.imin_marks,
                s.imax_marks,
                s.emin_marks,
                s.emax_marks,
                case m.result_id when 1 then 'Pass' when 0 then 'Fail' else 'NA' end as result,
                s.syear as term,
                st.type,
                m.exam_id,
                s.subjecttype_id,
                grace,
                m.ra_id,
                m.re_mark,
                m.applicant_id,
                m.candidate_id,
                c.approvedprogramme_id
            from 
            (
            select grace, na.id, candidate_id, newapplicant_id as applicant_id, 25 as exam_id, subject_id, internalattendance_id, externalattendance_id, internal_mark,  result_id, external_mark, 0 as ra_id, reevaluated_marks as re_mark from newapplications na
            where candidate_id = " . $id ." 
            union
            select grace, a.id, candidate_id, supplimentaryapplicant_id as applicant_id, 24 as exam_id, subject_id, 1 as internalattendance_id, externalattendance_id, internal_mark,  result_id, external_mark, 0 as ra_id, 0 as re_mark from supplimentaryapplications a
            where candidate_id = " . $id ." 
            union
            select grace, ca.id, ca.candidate_id, ca.currentapplicant_id as applicant_id, ca.exam_id, ca.subject_id, internalattendance_id, externalattendance_id, internal_mark, if(ra.id>1, ca.reevaluation_result_id, ca.reevaluation_result_id) as result_id, if(ra.id>1, if(ra.reevaluated_marks > external_mark, ra.reevaluated_marks , external_mark),  external_mark) as external_mark, ra.id as ra_id, reevaluation_mark as re_mark 
            from currentapplications ca
            left join reevaluationapplicationsubjects ra on ra.subject_id = ca.subject_id and  ra.candidate_id = ca.candidate_id and ra.exam_id = 22  and ra.active_status != 1
            where ca.candidate_id = " . $id ." 
            union 
            select grace, id, candidate_id, applicant_id, exam_id, subject_id, internalattendance_id, externalattendance_id, internal_mark,  result_id, external_mark, 0 as ra_id,0 as re_mark from applications sa
            where candidate_id = " . $id ."
            union
            select
            
                IF((IFNULL(mark_ex_re, 0) + IFNULL(grace_re, 0)) >= (IFNULL(mark_ex, 0) + IFNULL(grace, 0)), IFNULL(grace_re, 0),IFNULL(grace, 0)) AS grace,
                id,
                candidate_id,
                applicant_id,
                exam_id,
                subject_id,
                attendance_in as internalattendance_id,
                attendance_ex as externalattendance_id,
                mark_in as internal_mark,
                if((IFNULL(mark_ex_re, 0) + IFNULL(grace_re, 0)) > (IFNULL(mark_ex, 0) + IFNULL(grace, 0)), result_id_re, result_id) as result_id,
                mark_ex as external_mark,
                0 as ra_id,
                mark_ex_re as mark_ex_re
            from
                allapplications 
            where candidate_id = " . $id ." 
            ) as m
            left join subjects s on s.id = m.subject_id
            left join candidates c on c.id = m.candidate_id
            left join subjecttypes st on st.id = s.subjecttype_id
            left join exams e on e.id = m.exam_id
            order by e.id desc, s.syear, s.subjecttype_id, s.sortorder
        ");
        $subjects = \App\Subject::where('programme_id',$candidate->approvedprogramme->programme_id)->get();

        $supplimentaryapplicant = \App\Supplimentaryapplicant::where('candidate_id',$candidate->id)->first();

        $reeval_exam = Exam::where('reevaluation_status',1)->first();
        $reevaluationapplicaiton = \App\Reevaluationapplication::where('candidate_id',$candidate->id)->where('exam_id',$reeval_exam->id)->first();

        $attendace = \App\Attendance::where('candidate_id',$candidate->id)->get();
        $exam_center = null;
        $fy_count = 0;
        $sy_count = 0;
        if(!is_null($supplimentaryapplicant)){
        $this->applicantService->assignmodel(24);
        $this->applicantService->getApplicant($supplimentaryapplicant->id);
        //$exam_center = $this->applicantService->getExamcenter(($candidate->approvedprogramme->institute));
        
        //if($c->Approvedprogramme->institute->id == Nber::where('user_id',Auth::user()->id)->first()->id){
            $fy_count = $this->applicantService->getNumberOfPapers(1);
        $sy_count = $this->applicantService->getNumberOfPapers(2);
    }
        return view('nber.candidates.view_details',compact('fy_count','sy_count','exams','attendace','supplimentaryapplicant','reevaluationapplicaiton','candidate','current_exam','marks','subjects'));
        //}else{
         //   return back();
        //}
    }

public function track_payment(Request $r){
 $exam_payment = [];
 $revalution_payment = [];

     $institutes = Institute::orderBy('name')->get();

        if($r->has('enrollment')){
            
     $enrollment = $r->input('enrollment');




$exam_payment = DB::table('candidates')
    ->join('viewapplicants', 'candidates.id', '=', 'viewapplicants.candidate_id')
    ->join('orders', 'viewapplicants.order_id', '=', 'orders.id')
    ->select(
        'orders.*',
        'candidates.enrolmentno',
        'candidates.name',
        'candidates.fathername'
    )->where('candidates.enrolmentno', $enrollment)
    ->get();

    $revalution_payment = DB::table('candidates')
    ->join('reevaluationapplications', 'candidates.id', '=', 'reevaluationapplications.candidate_id')
    ->join('orders', 'reevaluationapplications.order_id', '=', 'orders.id')
    ->select(
        'orders.*',
        'candidates.enrolmentno',
        'candidates.name',
        'candidates.fathername'
    )->where('candidates.enrolmentno', $enrollment)
    ->get();





    $instituteId = $r->input('institute');

          
        }
        return view('nber.payment',compact('exam_payment','institutes','revalution_payment'));

 

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
