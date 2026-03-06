<?php

namespace App\Http\Controllers\Institute;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Approvedprogramme;
use Validator;
use App\Http\Controllers\Controller;
use Auth;
use App\Candidate;
use App\City;
use App\Community;
use App\Disability;
use App\Gender;
use App\Salutation;
use App\Institute;
use App\State;
use App\Lgstate;
use App\District;
use App\Subdistrict;
use App\Village;
use App\Nationality;
use App\Masterlist;
use App\User;
use App\CandidateDataHistory;
use Session;
use File;
use Input;
use App\Configuration;
//use App\Disabilitytype;
use App\Education;

class CandidateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }
    public function updateverificationstatus(Request $r){
        return 'Closed';

        $candidate = Candidate::find($r->candidateId);
        if($r->update == 'mobile'){
            $candidate->mobile_otp_verified_on = date('Y-m-d');
        }else{
            $candidate->email_otp_verified_on = date('Y-m-d');
        }
        $candidate->save(); 
        $data = "Updated";
        return response()->json($data);
    }
    public function index($id){
        
        $ap = Approvedprogramme::find($id);
        if($ap && $ap->institute_id == \App\Institute::where('user_id',Auth::user()->id)->first()->id){
            $enable = 1;
           /* if($ap->academicyear->current==1 or ($ap->programme->nber_id = 3 && ($ap->academicyear_id < 11 or $ap->academicyear_id == 10))){
                if($ap->programme->recognised_by == "NT") { 
                    $enable = 1;
                }else{
                    $enrolment = Configuration::where('attribute','enrolment')->first()->value;
                    if($enrolment == 1){
                        $enable = 1;
                    }else{
                        $incidentalstatus = \App\Http\Controllers\Institute\IncidentalchargeController::checkIncidentalChargesPaid($ap->id);
                        if($incidentalstatus == "APPROVED") { $enable = 1; }
                    }
                }
                $enable = 1;*/
                if($enable == 1 && $ap->institute->user_id==Auth::user()->id){
                    $candidates = Candidate::where('approvedprogramme_id',$ap->id)->get();
                    return view('institute.candidates.index',compact('candidates','ap'));

                }else{
                    return redirect('/');
                }
          //  }
        }else{
            return redirect('/');
        }
    }

    public function studentlogin($id){
        $ap = Approvedprogramme::find($id);
        if($ap){
            if($ap->institute->user_id==Auth::user()->id){
                $candidates = Candidate::where('approvedprogramme_id',$ap->id)->get();
                return view('institute.candidates.studentlogin',compact('candidates','ap'));
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function create($id){
        return 'Closed';
        $ap = Approvedprogramme::find($id);
       // if($ap->programme_id == 43 || $ap->programme_id == 20){
            return $this->createoredit($id);
        /*}else{
         return 'Closed';
        }*/

        
    }
    public function edit($id){
        //return 'Closed';

        return $this->niepvdedit($id);
        //$candidate = Candidate::find($id);
        //return $this->createoredit($candidate->approvedprogramme_id,$candidate);
    }

    public function delete($id){
    //    return 'Closed';

        $candidate = Candidate::find($id);
        $candidate->delete();
        Session::put('messages','Enrolment data deleted');
        return back();
    }

    public function niepvdedit($id){
        
        $candidate = Candidate::find($id);
        $apid = $candidate->approvedprogramme_id;
        $ap = Approvedprogramme::find($apid);
        if($ap && $ap->academicyear_id == 12){
      //  if($candidate->status_id == 1 || $candidate->status_id ==7 || $candidate->status_id ==8 || $candidate->incomplete_data == 1){
            if($ap->institute->user_id==Auth::user()->id){
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
                    return view('institute.candidates.edit_niepvd',compact('mindate','nationalities','yesno','apid','states','candidate','salutations','cities','genders','communities','institute','programme'));
                }
            }           
        }
        //}
        return redirect('/');
    }

    private function createoredit($apid,$candidate=null){
        //return 'Closed';
        
        $ap = Approvedprogramme::find($apid);
       // if($ap && $ap->programme_id == 43 ||$ap->programme_id == 20){
            if($ap->institute->user_id==Auth::user()->id){
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
                 /*   if($ap->programme->nber_id == 2){
                        return view('institute.candidates.editbomb',compact('mindate','nationalities','yesno','apid','states','candidate','salutations','cities','genders','communities','institute','programme'));

                    }*/
                    return view('institute.candidates.edit',compact('mindate','nationalities','yesno','apid','states','candidate','salutations','cities','genders','communities','institute','programme'));
                }else{
                    if($ap->maxintake > $ap->candidates()->count()){
                        return view('institute.candidates.create',compact('mindate','nationalities','yesno','apid','states', 'salutations','cities','genders','communities','institute','programme'));
                    }
                }
            }
        //}
        return redirect('/');
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

   
    public function store(Request $request){
        $ap = Approvedprogramme::find($request->approvedprogramme_id);
       // if($ap->programme_id == 43 || $ap->programme_id == 20){
            return $this->storeorupdate($request);
        /*}else{
         return 'Closed';
        }*/
    }
    public function update($id,Request $request){
        $ap = Approvedprogramme::find($request->approvedprogramme_id);
      //  if($ap->programme_id == 43 || $ap->programme_id == 20){
            $candidate = Candidate::find($id);
            return $this->storeorupdate($request,$candidate);
/*        }else{
         return 'Closed';
        } */

        
    }
    public function updatemobile(Request $request){
        return 'Closed';

        $rules = [
            'contactnumber' => 'required|numeric|min:6000000001:max:9999999999|unique:candidates'
        ];
        $messages = [
            'contactnumber' => 'Please enter valid mobile number',
        ];
        $this->validate($request, $rules,$messages);
        $candidate = Candidate::find($request->id);
      //  if($candidate->is_mobile_number_verified != 'Yes' || $candidate->duplicate_mobile == 1){
            $candidate->contactnumber = $request->contactnumber;
            $candidate->is_mobile_number_verified  = 'No';
            $candidate->is_mobile_edited = 1;
            $candidate->save();
            if($candidate->user_id > 0){
                $user = User::find($candidate->user_id);
                $user->username = $request->contactnumber;
                $user->save();
            }
            return response()->json('success');
    //    }else{
      //      return response()->json('Already verified.');
       // }
    }
    private function storeorupdate($request, $candidate = null){
        //return 'Closed';

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
            'fathername' => 'required|alpha_spaces|max:99',
            'mothername' => 'required|alpha_spaces|max:99',
            'dob' => 'required|date',
            'address' => 'required|min:8',
            'paddress' => 'required|min:8',
            'board_1' => 'required|min:2',
            'yop_1' => 'required',
            'tmarks_1' => 'required|numeric|min:10|max:9999',
            'omarks_1' => 'required|numeric|min:0|max:9999',
            'percentage_1' => 'required|numeric|min:0|max:100',
            'subjects_1' => 'required|min:10',
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
            $rules['state_id'] = 'required|numeric|min:1';
            $rules['pstate_id'] = 'required|numeric|min:1';
            $rules['district_id'] = 'required|numeric|min:1';
            $rules['pdistrict_id'] = 'required|numeric|min:1';
            $rules['aadhar'] = 'required|min:12';
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
            'state_id.min' => 'State is required in Correspondence Address',
            'pstate_id.required' => 'State is required in Permanent Address',
            'pstate_id.min' => 'State is required in Permanent Address',
            'district_id.required' => 'District is required in Correspondence Address',
            'district_id.min' => 'District is required in Correspondence Address',
            'pdistrict_id.required' => 'District is required in Permanent Address',
            'pdistrict_id.min' => 'District is required in Permanent Address',
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
            'photo.required' => 'Photo is required / File size should be less than 1 MB',
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
            'contactnumber.unique' => "Mobile number already exists",
            'doc_application.required' => "Scanned copy of the application is required.",
        ];

        //$this->validate($request, $rules,$messages);
        
        if($candidate==null){
            $rules['name'] = 'required|alpha_spaces|max:99';
            $rules['photo'] = 'required';
            $rules['signature'] = 'required';
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
            $rules['email'] = 'required|regex:/(.+)@(.+)\.(.+)/i|unique:candidates';
            $rules['contactnumber'] = 'required|numeric|min:6000000001:max:9999999999|unique:candidates';
        }else{
            if($candidate->photo == '' || $candidate->photo == null){
              $rules['photo'] = 'required';
            }
            if($candidate->doc_application == '' || $candidate->doc_application == null){
                $rules['doc_application'] = 'required';
            }
            if($candidate->doc_tenth == '' || $candidate->doc_tenth == null){
                $rules['doc_tenth'] = 'required';
            }
            if($plustwo ==1  && ($candidate->doc_twelveth == '' || $candidate->doc_twelveth == null)){
                $rules['doc_twelveth'] = 'required';
            }
            if($candidate->email!=$request->email){
                $rules['email'] = 'required|regex:/(.+)@(.+)\.(.+)/i|unique:candidates';
            }
            if($request->community_id > 1 && ($candidate->doc_community == '' || $candidate->doc_community == null)){
                //$rules['percentage'] = 'required|numeric|min:45|max:100';
                $rules['doc_community'] = 'required';
            }
            /*if($request->community_id > 1){
                //$rules['percentage'] = 'required|numeric|min:45|max:100';
                if($candidate==null){
                    $rules['doc_community'] = 'required';
                }
            } */
            $rules['contactnumber'] = 'required|numeric|min:6000000001:max:9999999999';
            $rules['comment'] = 'required';
            if($request->isdisabled == 1){
                if($candidate->udid == '' || $candidate->udid == null){
                    $rules['udid'] = 'required|udid';
                  //  $rules['disabilitytype_id'] = 'required';
                   // $rules['disabilityper'] = 'required';
                }
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

        if($request->has('photo') ){
            if(!file_exists(public_path().'/files/temp/'.$request->photo)){
                $rules['photoupload'] = 'required';
            }
        }

        if($request->has('signature') ){
            if(!file_exists(public_path().'/files/temp/'.$request->signature)){
                $rules['signature'] = 'required';
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
            //$candidatedatahistory->percentage = $candidate->percentage;
            $candidatedatahistory->ews = $candidate->ews;
            $candidatedatahistory->dob = $candidate->dob;
            $candidatedatahistory->address = $candidate->address;
            $candidatedatahistory->pincode = $candidate->pincode;
            $candidatedatahistory->contactnumber = $candidate->contactnumber;
            $candidatedatahistory->email = $candidate->email;
            $candidatedatahistory->photo = $candidate->photo;
            // $candidatedatahistory->doc_mark = $candidate->doc_mark;
            // $candidatedatahistory->doc_dob = $candidate->doc_dob;
            // $candidatedatahistory->doc_disability = $candidate->doc_disability;

            // $candidatedatahistory->doc_community = $candidate->doc_community;
            // $candidatedatahistory->doc_percentage_exception = $candidate->doc_percentage_exception;
            $candidatedatahistory->community_id = $candidate->community_id;
            $candidatedatahistory->disability_id = $candidate->disability_id;
            $candidatedatahistory->disability_name = $candidate->disability_name;
            $candidatedatahistory->city_id = $candidate->city_id;
            $candidatedatahistory->status_id = $candidate->status_id;
            //$candidatedatahistory->course_percentage = $candidate->course_percentage;
            //$candidatedatahistory->class = $candidate->class;
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
            $candidate->update($request->except('photo','signature','doc_tenth','doc_application','doc_twelveth','doc_community'));
             $comment = ' updated enrolment data, status set to verification pending.  Note: '. $request->comment ;
            if($request->has('edugrade_1')){
                if($edu = \App\Education::where('edugrade','10th')->where('candidate_id',$candidate->id)->count() > 0){
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
                if(\App\Education::where('edugrade','12th')->where('candidate_id',$candidate->id)->count() > 0){
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
                    if( \App\Education::whereNotIn('edugrade',['10th','12th'])->where('candidate_id',$candidate->id)->count()>0){
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
            "status_id" => 6,
            "incomplete_2024_data" => 0
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
                /*if (file_exists(public_path().'/files/enrolment/photos/'.$candidate->photo)) {
                    unlink(public_path().'/files/enrolment/photos/'.$candidate->photo);
                }
                if (file_exists(public_path().'/files/enrolment/photos/cropped/'.$candidate->photo)) {
                    unlink(public_path().'/files/enrolment/photos/cropped/'.$candidate->photo);
                } */
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

        if($request->has('signature')){
            if(!is_null($candidate->signature) || $candidate->signature != '') {
                /*if (file_exists(public_path().'/files/enrolment/photos/'.$candidate->photo)) {
                    unlink(public_path().'/files/enrolment/photos/'.$candidate->photo);
                }
                if (file_exists(public_path().'/files/enrolment/photos/cropped/'.$candidate->photo)) {
                    unlink(public_path().'/files/enrolment/photos/cropped/'.$candidate->photo);
                } */
            }
            if (file_exists(public_path().'/files/temp/'.$request->signature)) {
                $file = public_path().'/files/temp/'.$request->signature;
            }
            if (file_exists(public_path().'/files/temp/cropped/'.$request->signature)) {
                $file = public_path().'/files/temp/cropped/'.$request->signature;
            }

            $ex = explode('.', $file);
            $extn = end($ex);
            $filename = $filestart. "." . $extn ;
            $destination = public_path().'/files/enrolment/signature/cropped/'.$filename;
            File::move($file,$destination);
            $candidate->update(['signature'=> 'cropped/'.$filename]);

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
                //    unlink(public_path().'/files/enrolment/marksheets/'.$candidate->doc_tenth);
               // }
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
             //   if (file_exists(public_path().'/files/enrolment/marksheets/'.$candidate->doc_twelveth)) {
              //      unlink(public_path().'/files/enrolment/marksheets/'.$candidate->doc_twelveth);
              //  }
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
              //  if (file_exists(public_path().'/files/enrolment/'.$candidate->doc_application)) {
               //     unlink(public_path().'/files/enrolment/'.$candidate->doc_application);
               // }
            }

            $file = public_path().'/files/temp/'. $request->doc_application;
            $ex = explode('.', $file);
            $extn = end($ex);
            $filename = $filestart. "." . $extn ;
            $destination = public_path().'/files/enrolment/applications/'.$filename;
            File::move($file,$destination);
            $candidate->update(['doc_application'=> $filename]);
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
                if(!$candidate->doc_community == null) {
               //     if (file_exists(public_path().'/files/enrolment/c/'.$candidate->doc_community)) {
                 //       unlink(public_path().'/files/enrolment/c/'.$candidate->doc_community);
                   //}
               }

                $file = public_path().'/files/temp/'. $request->doc_community;
                $ex = explode('.', $file);
                $extn = end($ex);
                $filename = $filestart. "." . $extn ;
                $destination = public_path().'/files/enrolment/c/'.$filename;
                File::move($file,$destination);
                $candidate->update(['doc_community'=> $filename]);
            }else{
             //   $candidate->update(['doc_community'=>NULL]);
            }
        //}
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
        return redirect('/programme/'.$request->approvedprogramme_id);
    }

    public function show($id){
        $c = Candidate::find($id);
        if($c->Approvedprogramme->institute->id == Institute::where('user_id',Auth::user()->id)->first()->id){
            return view('institute.candidates.view_details',compact('c'));
        }else{
            return back();
        }
    }

    public function search(Request $request){
        $institute_id = Institute::where('user_id',Auth::user()->id)->first()->id;
        $candidates = Candidate::whereHas('approvedprogramme',function($q) use($institute_id){
            $q->where('institute_id',$institute_id);
        })->where('enrolmentno','like','%'.$request->key.'%');//->where('name','like','%'.$request->key.'%');

        if($candidates->count()==0){
            $candidates = Candidate::whereHas('approvedprogramme',function($q) use($institute_id){
                $q->where('institute_id',$institute_id);
            })->where('name','like','%'.$request->key.'%');//->where('name','like','%'.$request->key.'%');
        }
        $ccount = $candidates->count();

        if( $ccount == 1 && strtolower($candidates->first()->enrolmentno) == strtolower($request->key)){
            return redirect('/student/'.$candidates->first()->id);
        }

        $candidates = $candidates->paginate(20);
        $text = 'Search Result';
        $key = $request->key;
        return view('institute.search.index',compact('candidates','key'));
        //	return view('nber.institutes.index',compact('institutes'));
    }
}

