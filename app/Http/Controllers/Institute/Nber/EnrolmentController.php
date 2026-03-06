<?php

namespace App\Http\Controllers\Nber;

use App\Academicyear;
use App\Approvedprogramme;
use App\City;
use App\Community;
use App\Disability;
use App\Enrolmentpayment;
use App\Gender;
use App\Institute;
use App\Candidate;
use App\Salutation;
use App\Status;
use Auth;
use Session;
use Image;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet;

class EnrolmentController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index() {
        //$academicyears = Academicyear::orderBy('year', 'desc')->get();
        $academicyear = Academicyear::where('current',1)->first();
        $approvedprogrammes = Approvedprogramme::where('academicyear_id',$academicyear->id);
        return view('nber.enrolments.index', compact('academicyear','approvedprogrammes'));
    }

    public function addAcademicYear() {

    }

    public function showCourseApprovalVerificationDetails($ayId) {
        $academicyear = Academicyear::find($ayId);
        unset($ayId);

        $pendingCount = Approvedprogramme::where('academicyear_id', $academicyear->id)->where('status_id', 1)->count(); //Pending
        $approvedCount = Approvedprogramme::where('academicyear_id', $academicyear->id)->where('status_id', 2)->count(); //Approved
        $rejectedCount = Approvedprogramme::where('academicyear_id', $academicyear->id)->where('status_id', 3)->count(); //Rejected
        $verificationPendingCount = Approvedprogramme::where('academicyear_id', $academicyear->id)->where('status_id', 6)->count(); //Verification Pending

        $totalCount = $pendingCount + $approvedCount + $rejectedCount + $verificationPendingCount;

        return view('nber.enrolments.show_course_approval_verification_details', compact('academicyear', 'pendingCount', 'approvedCount', 'rejectedCount', 'verificationPendingCount', 'totalCount'));
    }

    public function showApprovedprogrammesList($ayId, $statusId) {
        $academicyear = Academicyear::find($ayId);
        unset($ayId);

        if(!is_null($academicyear)) {
            $status = Status::find($statusId);
            unset($statusId);

            if(is_null($status) || $status->id == 5) {
                return redirect('/nber/enrolments');
            }
            else {
                $percentage = Approvedprogramme::where('academicyear_id', $academicyear->id)->count();

                if($status->id == 4) {
                    $approvedprogrammes = Approvedprogramme::where('academicyear_id', $academicyear->id)
                        ->with('institute', 'programme')->get()
                        ->sortBy('programme.abbreviation')->sortBy('institute.code');

                    $status_remarks = 'Total';
                    $percentage = 100;
                }
                else{
                    $approvedprogrammes = Approvedprogramme::where('academicyear_id', $academicyear->id)
                        ->where('status_id', $status->id)->with('institute', 'programme')
                        ->get()
                        ->sortBy('programme.abbreviation')->sortBy('institute.code');

                    $status_remarks = $status->status;

                    $percentage = round(($approvedprogrammes->count() / $percentage)*100);
                }

                $approvedprogrammesCount = $approvedprogrammes->count();
               // return $approvedprogrammes;

                return view('nber.enrolments.show_approvedprogrammes_list', compact('academicyear', 'approvedprogrammes', 'status_remarks', 'approvedprogrammesCount', 'percentage'));
            }
        }
        else {
            return redirect('/nber/enrolments');
        }


        //return view('nber.enrolments.show_approvedprogrammes_list', compact('academicyear', 'approvedprogrammes'));
    }

    public function downloadApprovedprogrammesList($ayId, $statusId) {
        $academicyear = Academicyear::find($ayId);
        unset($ayId);

        $status = Status::find($statusId);
        unset($statusId);
    }

    public function showInstituteList($ayid) {
        $academicyear = Academicyear::find($ayid);

        $approvedprogrammes = Approvedprogramme::select('approvedprogrammes.*')
            ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
            ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->where('approvedprogrammes.academicyear_id', $academicyear->id)->orderBy('institutes.code')->orderBy('programmes.sortorder')
            ->orderBy('programmes.sortorder')
            ->get();

        //$institute_id = $approvedprogrammes->unique('institute_id')->pluck('institute_id')->toArray();

        //$institutes = Institute::whereIn('id', $institute_id)->orderBy('code')->get();

        return view('nber.enrolments.institute_list', compact('academicyear', 'approvedprogrammes', 'institutes'));
    }

    public function showapprovalstatus($ayid) {
        $academicyear = Academicyear::find($ayid);

        $verificationpendingcount = Candidate::whereIn("approvedprogramme_id", Approvedprogramme::where("academicyear_id", $academicyear->id)->where("status_id", 2)->pluck("id")->toArray())
            ->where("status_id", 6)->count("id");
        $pendingcount = Candidate::whereIn("approvedprogramme_id", Approvedprogramme::where("academicyear_id", $academicyear->id)->where("status_id", 2)->pluck("id")->toArray())
            ->where("status_id", 1)->count("id");
        $approvedcount = Candidate::whereIn("approvedprogramme_id", Approvedprogramme::where("academicyear_id", $academicyear->id)->where("status_id", 2)->pluck("id")->toArray())
            ->where("status_id", 2)->count("id");
        $rejectedcount = Candidate::whereIn("approvedprogramme_id", Approvedprogramme::where("academicyear_id", $academicyear->id)->where("status_id", 2)->pluck("id")->toArray())
            ->where("status_id", 3)->count("id");
        $totalcount = Candidate::whereIn("approvedprogramme_id", Approvedprogramme::where("academicyear_id", $academicyear->id)->where("status_id", 2)->pluck("id")->toArray())
            ->count("id");

        return view('nber.enrolments.showapprovalstatus', compact('academicyear', 'verificationpendingcount', 'pendingcount', 'approvedcount', 'rejectedcount', 'totalcount'));
    }

    public function approveCourse($apid) {
        $approvedprogramme = Approvedprogramme::find($apid);

        $approvedprogramme->update([
            'status_id' => '2'
        ]);

        //return redirect('/enrolments/'.$approvedprogramme->academicyear_id.'/institute-list');
        return redirect()->back();
    }

    public function holdCourse($apid) {
        $approvedprogramme = Approvedprogramme::find($apid);

        $approvedprogramme->update([
            'status_id' => '1'
        ]);

        return redirect()->back();

        //return redirect('/enrolments/'.$approvedprogramme->academicyear_id.'/institute-list');
    }

    public function rejectCourse($apid) {
        $approvedprogramme = Approvedprogramme::find($apid);

        $approvedprogramme->update([
            'status_id' => '3'
        ]);

        return redirect()->back();
        //return redirect('/enrolments/'.$approvedprogramme->academicyear_id.'/institute-list');
    }

    public function deleteCourse($apid) {
        $approvedprogramme = Approvedprogramme::find($apid);
    }

    public function viewCandidates(Request $r) {
        $status = '';
        $institute = '';
        $programme = '';
        $i='';

        $candidates = Candidate::where('id','!=','0')->whereHas('approvedprogramme',function($q) use($r) {
            $q->where('id', $r->p);
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
        $candidates = $candidates->orderBy('enrolmentno')->paginate(35);

        return view('nber.enrolments.candidate_list',compact('candidates','status','institute','programme','i', 'ap'));
    }

    public function deletecandidate($candid) {
        $candidate = Candidate::find($candid);

        if($candidate) {
            if(!is_null($candidate->photo) || $candidate->photo != '') {
                if (file_exists(public_path().'/files/enrolment/photos/'.$candidate->photo)) {
                    unlink(public_path().'/files/enrolment/photos/'.$candidate->photo);
                }
                if (file_exists(public_path().'/files/enrolment/photos/cropped/'.$candidate->photo)) {
                    unlink(public_path().'/files/enrolment/photos/cropped/'.$candidate->photo);
                }

                if (file_exists(public_path().'/files/temp/'.$candidate->photo)) {
                    $file = public_path().'/files/temp/'.$candidate->photo;
                }
                if (file_exists(public_path().'/files/temp/cropped/'.$candidate->photo)) {
                    $file = public_path().'/files/temp/cropped/'.$candidate->photo;
                }
            }

            if(!is_null($candidate->doc_dob) || $candidate->doc_dob != '') {
                if (file_exists(public_path().'/files/temp/'.$candidate->doc_dob)) {
                    unlink(public_path().'/files/temp/'.$candidate->doc_dob);
                }

                if (file_exists(public_path().'/files/enrolment/dateofbirth/'.$candidate->doc_dob)) {
                    unlink(public_path().'/files/enrolment/dateofbirth/'.$candidate->doc_dob);
                }
            }

            if(!is_null($candidate->doc_rci) || $candidate->doc_rci != '') {
                if (file_exists(public_path().'/files/temp/'.$candidate->doc_rci)) {
                    unlink(public_path().'/files/temp/'.$candidate->doc_rci);
                }

                if (file_exists(public_path().'/files/enrolment/crr/'.$candidate->doc_rci)) {
                    unlink(public_path().'/files/enrolment/crr/'.$candidate->doc_rci);
                }
            }

            if(!is_null($candidate->doc_mark) || $candidate->doc_mark != '') {
                if (file_exists(public_path().'/files/temp/'.$candidate->doc_mark)) {
                    unlink(public_path().'/files/temp/'.$candidate->doc_mark);
                }

                if (file_exists(public_path().'/files/enrolment/marksheets/'.$candidate->doc_mark)) {
                    unlink(public_path().'/files/enrolment/marksheets/'.$candidate->doc_mark);
                }
            }

            if(!$candidate->doc_disability == null) {
                if (file_exists(public_path().'/files/enrolment/d/'.$candidate->doc_disability)) {
                    unlink(public_path().'/files/enrolment/d/'.$candidate->doc_disability);
                }

                if (file_exists(public_path().'/files/temp/'.$candidate->doc_disability)) {
                    unlink(public_path().'/files/temp/'.$candidate->doc_disability);
                }
            }

            if(!$candidate->doc_community == null) {
                if (file_exists(public_path().'/files/enrolment/c/'.$candidate->doc_community)) {
                    unlink(public_path().'/files/enrolment/c/'.$candidate->doc_community);
                }
                if (file_exists(public_path().'/files/temp/'.$candidate->doc_community)) {
                    unlink(public_path().'/files/temp/'.$candidate->doc_community);
                }
            }

            if(!is_null($candidate->doc_percentage_exception) || $candidate->doc_percentage_exception != '') {
                if (file_exists(public_path().'/files/enrolment/p/'.$candidate->doc_percentage_exception)) {
                    unlink(public_path().'/files/enrolment/p/'.$candidate->doc_percentage_exception);
                }
            }
        }

        $candidate->delete();

        return back();
    }

    public function editformcandidate($candid){
        $candidate = Candidate::find($candid);

        if($candidate) {
            $apid = Approvedprogramme::find($candidate->approvedprogramme_id)->id;

            $cities=City::all();
            $genders=Gender::all();
            $communities = Community::all();
            $programme = $candidate->approvedprogramme->programme;
            $disabilities = Disability::all();
            $salutations = Salutation::all();

            return view('nber.enrolments.editcandidate',compact('apid','candidate','salutations','cities','genders','communities','disabilities','institute','programme'));
        }
    }

    public function update($id,Request $request){
        $candidate = Candidate::find($id);
        return $this->updatecandidatedetails($request,$candidate);
    }
    private function updatecandidatedetails($request, $candidate = null){
        $rules = [
            'name' => 'required',
            'gender_id' => 'required|numeric|min:1',
            'community_id' => 'required|numeric|min:1',
            'disability_id' => 'required|numeric|min:1',
            'salutation_id' => 'required|numeric|min:1',
            'fathername' => 'required',
            'mothername' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'city_id' => 'required|numeric|min:1',
            'pincode' => 'required',
            'contactnumber' => 'required',
        ];
        if($candidate==null){
            $rules['photo'] = 'required';
            if($request->programmegroup_id != '3'){
                $rules['doc_dob'] = 'required';
                $rules['doc_mark'] = 'required';
            }else{
                $rules['doc_rci'] = 'required';
            }
            $rules['email'] = 'required|unique:candidates';
        }else{
            if($candidate->email!=$request->email){
                $rules['email'] = 'required|unique:candidates';
            }
            $rules['comment'] = 'required';
        }

        if($request->has('pex')){
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
        }

        if($request->has('photo')){
            if(!file_exists(public_path().'/files/temp/'.$request->photo)){
                $rules['photoupload'] = 'required';
            }
        }
        if($request->has('doc_dob')){
            if(!file_exists(public_path().'/files/temp/'.$request->doc_dob)){
                $rules['dobupload'] = 'required';
            }
        }
        if($request->has('doc_mark')){
            if(!file_exists(public_path().'/files/temp/'.$request->doc_mark)){
                $rules['markupload'] = 'required';
            }
        }
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
        }
        $messages = [
            'gender_id.min' => 'Gender field required',
            'community_id.min' => 'Community Category field required',
            'disability_id.min' => 'Disability field required',
            'salutation_id.required' => 'S/o D/o W/o required for Father/Husband name',
            'city_id.min' => 'City field required',
            'doc_percentage_exception.required' => 'Supporting document is requried if percentage is less. Please check the box below percengtage and attache the document  / File size should be less than 2 MB',
            'doc_dob.required' => 'Date of birth proof required / File size should be less than 2 MB',
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
        ];

        $this->validate($request, $rules,$messages);

        if($candidate==null){
            $candidate = Candidate::create($request->all());
            $approvedprogramme = Approvedprogramme::find($candidate->approvedprogramme->id);
            $approvedprogramme->update([
                'registered_count' => $approvedprogramme->registered_count + 1,
            ]);
        }else{
            $candidate->update($request->except(['photo','doc_mark','doc_dob','doc_disability','doc_community','doc_percentage_exception','doc_rci']));
            $comment = ' updated enrolment data, status set to pending.  Note: '. $request->comment ;
            $candidate->candidateapprovals()->create(['user_id'=>Auth::user()->id,'comment'=>$comment]);
        }
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

        if($request->has('doc_mark')){
            if(!is_null($candidate->doc_mark) || $candidate->doc_mark != '') {
                if (file_exists(public_path().'/files/enrolment/marksheets/'.$candidate->doc_mark)) {
                    unlink(public_path().'/files/enrolment/marksheets/'.$candidate->doc_mark);
                }
            }

            $file = public_path().'/files/temp/'. $request->doc_mark;
            $ex = explode('.', $file);
            $extn = end($ex);
            $filename = $filestart. "." . $extn ;
            $destination = public_path().'/files/enrolment/marksheets/'.$filename;
            File::move($file,$destination);
            $candidate->update(['doc_mark'=> $filename]);
        }
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
        }
        if($request->has('doc_community')){
            if($request->community_id > 1){
                if(!$candidate->doc_community == null) {
                    if (file_exists(public_path().'/files/enrolment/c/'.$candidate->doc_community)) {
                        unlink(public_path().'/files/enrolment/c/'.$candidate->doc_community);
                    }
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
        return redirect('/enrolments/view/candidates?p='.$request->approvedprogramme_id);
    }

    public function generateenrolmentno($id) {
        $ap = Approvedprogramme::find($id);

        $approvedcandidate_ids = Candidate::where('approvedprogramme_id', $ap->id)->where('status_id', 2)->whereNull('enrolmentno')->pluck('id')->toArray();

        $candidate_ids = Enrolmentpayment::whereIn('candidate_id', $approvedcandidate_ids)->where('status_id', 2)->pluck('candidate_id')->unique()->toArray();
        $candidates = Candidate::whereIn('id', $candidate_ids)->orderBy('name')->get();
        $maxcount = $candidates->count();

        foreach ($candidates as $c) {
            if(is_null($c->enrolmentno) || $c->enrolmentno == '') {
                for($i=1; $i<=$maxcount;$i++) {
                    $enrolmentno = $ap->programme->enrolmentcode . $ap->academicyear->enrolmentcode . str_pad($ap->institute->enrolmentcode,3,'0',STR_PAD_LEFT). str_pad($i,2,'0',STR_PAD_LEFT);

                    if($candidates->where('enrolmentno', $enrolmentno)->count() == 0) {
                        $c->update(['enrolmentno' => $enrolmentno]);
                        $ap->update([
                            'enrolment_count' => $ap->enrolment_count + 1,
                        ]);
                        break;
                    }
                }
            }
        }

        return redirect('/enrolments/enrolmentnumber/showlists/'.$ap->academicyear_id);

        /*
        $ap = Approvedprogramme::find($id);
        $candidates = Candidate::where('approvedprogramme_id', $ap->id)->orderBy('enrolmentno')->get();
        $candidate_count = $candidates->count();

        foreach ($candidates as $c) {
            if($c->status_id == 2) {
                if(is_null($c->enrolmentno) || $c->enrolmentno == '') {
                    for($i=1; $i<=$candidate_count;$i++) {
                        $enrolmentno = $ap->programme->enrolmentcode . $ap->academicyear->enrolmentcode . str_pad($ap->institute->enrolmentcode,3,'0',STR_PAD_LEFT). str_pad($i,2,'0',STR_PAD_LEFT);

                        if($candidates->where('enrolmentno', $enrolmentno)->count() == 0) {
                            $c->update(['enrolmentno' => $enrolmentno]);
                            $ap->update([
                                'enrolment_count' => $ap->enrolment_count + 1,
                            ]);
                            break;
                        }
                    }
                }
            }
        }
        */

        //return redirect('/enrolments/view/candidates?p='.$id);
    }

    public function generateenrolmentno1($id) {
        $ap = Approvedprogramme::find($id);

        $approvedcandidate_ids = Candidate::where('approvedprogramme_id', $ap->id)->where('status_id', 2)->whereNull('enrolmentno')->pluck('id')->toArray();

        foreach ($approvedcandidate_ids as $cid) {
            $candidate = Candidate::find($cid);

            if(!is_null($candidate)) {
                if(is_null($candidate->enrolmentno) || trim($candidate->enrolmentno) == "") {
                    for($i=1; $i<=35;$i++) {
                        $enrolmentno = $candidate->approvedprogramme->programme->enrolmentcode.$candidate->approvedprogramme->academicyear->enrolmentcode . str_pad($candidate->approvedprogramme->institute->enrolmentcode,3,'0',STR_PAD_LEFT). str_pad($i,2,'0',STR_PAD_LEFT);

                        if(Candidate::where('enrolmentno', $enrolmentno)->count() == 0) {
                            $candidate->update(['enrolmentno' => $enrolmentno]);

                            $candidateApprovalStatuses = Candidate::where('approvedprogramme_id', $candidate->approvedprogramme_id)->get(['enrolmentno', 'status_id']);
                            $enrolmentCount = Candidate::where('approvedprogramme_id', $candidate->approvedprogramme_id)->whereNotNull('enrolmentno')->count();

                            $candidate->approvedprogramme->update([
                                "registered_count" => $candidateApprovalStatuses->count(),
                                'enrolment_count' => $enrolmentCount,
                                "verificationpending_count" => $candidateApprovalStatuses->where('status_id', 6)->count(),
                                "approved_count" => $candidateApprovalStatuses->where('status_id', 2)->count(),
                                "pending_count" => $candidateApprovalStatuses->where('status_id', 1)->count(),
                                "rejected_count" => $candidateApprovalStatuses->where('status_id', 3)->count(),
                            ]);
                            break;
                        }
                    }
                }
            }
        }

        /*
        $ap = Approvedprogramme::find($id);
        $candidates = Candidate::where('approvedprogramme_id', $ap->id)->orderBy('enrolmentno')->get();
        $candidate_count = $candidates->count();

        foreach ($candidates as $c) {
            if($c->status_id == 2) {
                if(is_null($c->enrolmentno) || $c->enrolmentno == '') {
                    for($i=1; $i<=$candidate_count;$i++) {
                        $enrolmentno = $ap->programme->enrolmentcode . $ap->academicyear->enrolmentcode . str_pad($ap->institute->enrolmentcode,3,'0',STR_PAD_LEFT). str_pad($i,2,'0',STR_PAD_LEFT);

                        if($candidates->where('enrolmentno', $enrolmentno)->count() == 0) {
                            $c->update(['enrolmentno' => $enrolmentno]);
                            $ap->update([
                                'enrolment_count' => $ap->enrolment_count + 1,
                            ]);
                            break;
                        }
                    }
                }
            }
        }
        */

        return redirect('/enrolments/view/candidates?p='.$id);
    }

    public function showlistsforenrolmentnumber($ayid) {
        $academicyear = Academicyear::find($ayid);

        $approvedprogrammes = Approvedprogramme::with('institute')
            ->whereHas('programme', function($query) {
                $query->where('recognised_by', 'rci');
            })
            ->where('academicyear_id', $academicyear->id)
            ->where('status_id', 2)->get()->sortBy('institute.code');

        return view('nber.enrolments.showlistsforenrolmentnumber', compact('academicyear', 'approvedprogrammes'));
    }

    public static function calculateregisteredcount($ayid) {
        $count = Candidate::whereHas('approvedprogramme', function ($query) use($ayid) {
            return $query->where('academicyear_id', $ayid)->where('status_id', 2);
        })->count();

        return $count;
    }

    public function downloadEnrolmentVerificationDetails($ayid) {
        $academicyear = Academicyear::find($ayid);

        if($academicyear) {
            $approvedprogrammes = Approvedprogramme::with('institute')
                ->whereHas('programme', function($query) {
                    $query->where('recognised_by', 'rci');
                })
                ->where('academicyear_id', $academicyear->id)
                ->where('status_id', 2)->get()->sortBy('institute.code');

            if($approvedprogrammes) {
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                $styleArray = [
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    ]
                ];

                $sheet->setCellValue('A1', 'S.No');
                $sheet->setCellValue('B1', 'Institute Code');
                $sheet->setCellValue('C1', 'Institute Name');
                $sheet->setCellValue('D1', 'Programme');
                $sheet->setCellValue('E1', 'Registered Count');
                $sheet->setCellValue('F1', 'Verification Pending Count');
                $sheet->setCellValue('G1', 'Approved Count');
                $sheet->setCellValue('H1', 'Pending Count');
                $sheet->setCellValue('I1', 'Rejected Count');
                $sheet->setCellValue('J1', 'Enrolment Given Count');
                $sheet->setCellValue('K1', 'Enrolment Not Given Count');

                //setting Text Wrap for Columns
                $sheet->getStyle('A1:K1')->getAlignment()->setWrapText(true);

                //Setting Column Width
                $sheet->getColumnDimension('A')->setWidth(5, 'pt');
                $sheet->getColumnDimension('B')->setWidth(7, 'pt');
                $sheet->getColumnDimension('C')->setWidth(40, 'pt');
                $sheet->getColumnDimension('D')->setWidth(15, 'pt');

                //Applying styles
                $sheet->getStyle('A1:K1')->applyFromArray($styleArray);
                $sheet->getStyle('A1:K1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('A1:K1')->getFont()->setBold(true);

                $sheet->getStyle('A1:K1')->getFont()->setName('Bookman Old Style');
                $sheet->getStyle('A1:K1')->getFont()->setSize(8);

                $rowCount = 2;
                $sno = 1;
                $grandRegisteredCount = 0;
                $grandVerificationPendingCount = 0;
                $grandApprovedCount = 0;
                $grandPendingCount = 0;
                $grandRejectedCount = 0;
                $grandEnrolmentCount = 0;
                $grandDifferenceCount = 0;
                foreach ($approvedprogrammes as $approvedprogramme) {
                    $registeredCount = $approvedprogramme->registered_count;
                    $verificationPendingCount = $approvedprogramme->verificationpending_count;
                    $approvedCount = $approvedprogramme->approved_count;
                    $pendingCount = $approvedprogramme->pending_count;
                    $rejectedCount = $approvedprogramme->rejected_count;
                    $enrolmentCount = $approvedprogramme->enrolment_count;
                    $differenceCount = (int) $approvedCount - (int) $enrolmentCount;

                    $grandRegisteredCount += (int) $registeredCount;
                    $grandVerificationPendingCount += (int) $verificationPendingCount;
                    $grandApprovedCount += (int) $approvedCount;
                    $grandPendingCount += (int) $pendingCount;
                    $grandRejectedCount += (int) $rejectedCount;
                    $grandEnrolmentCount += (int) $enrolmentCount;
                    $grandDifferenceCount += (int) $differenceCount;

                    $sheet->setCellValue('A'.$rowCount, $sno);
                    $sheet->setCellValue('B'.$rowCount, $approvedprogramme->institute->code);
                    $sheet->setCellValue('C'.$rowCount, $approvedprogramme->institute->name);
                    $sheet->setCellValue('D'.$rowCount, $approvedprogramme->programme->course_name);
                    $sheet->setCellValue('E'.$rowCount, $registeredCount);
                    $sheet->setCellValue('F'.$rowCount, $verificationPendingCount);
                    $sheet->setCellValue('G'.$rowCount, $approvedCount);
                    $sheet->setCellValue('H'.$rowCount, $pendingCount);
                    $sheet->setCellValue('I'.$rowCount, $rejectedCount);
                    $sheet->setCellValue('J'.$rowCount, $enrolmentCount);
                    $sheet->setCellValue('K'.$rowCount, $differenceCount);

                    //Setting Text Wrap for Cells
                    $sheet->getStyle('C'.$rowCount)->getAlignment()->setWrapText(true);

                    //Applying Styles
                    $sheet->getStyle('A'.$rowCount.':K'.$rowCount)->applyFromArray($styleArray);
                    $sheet->getStyle('A'.$rowCount.':K'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                    $sheet->getStyle('A'.$rowCount.':K'.$rowCount)->getFont()->setName('Bookman Old Style');
                    $sheet->getStyle('A'.$rowCount.':K'.$rowCount)->getFont()->setSize(8);

                    $sheet->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('E'.$rowCount.':K'.$rowCount)->getAlignment()->setHorizontal('center');

                    $rowCount++;
                    $sno++;

                    unset($approvedprogramme);
                }

                $sheet->getPageMargins()->setLeft(0.5);

                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

                $headingName =  $academicyear->year." Batch - Candidate Enrolment Verification Details";

                $sheet->getHeaderFooter()->setOddHeader('&C&H&B&"Bookman Old Style-" '.$headingName);
                $sheet->getHeaderFooter()->setOddFooter('&C&H&B&"Bookman Old Style-" Page &P of &N');

                $filename = $headingName.".xlsx";
                ob_end_clean();
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="'.$filename.'"');
                header('Cache-Control: max-age=0');

                $writer = PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
            }
        }
    }

    public function cropimage(Request $request){
        echo '<script>console.log("hi")</script>';
    }

    public function candidateDataVerificationStatus($ayId) {
        $academicyear = Academicyear::find($ayId);

        if(!is_null($academicyear)) {
            $totalCount = Candidate::with('approvedprogramme')
                ->whereHas('approvedprogramme', function ($query) use($ayId){
                    $query->where('status_id', 2)->where('academicyear_id', $ayId)
                    ->whereHas('programme', function ($query){
                        $query->where('recognised_by', 'rci')->where('active_status', '!=', 3);
                    });
                })->get(['status_id']);

            $verificationPendingCount = $totalCount->where('status_id', 6)->count();
            $pendingCount = $totalCount->where('status_id', 1)->count();
            $approvedCount = $totalCount->where('status_id', 2)->count();
            $rejectedCount = $totalCount->where('status_id', 3)->count();
            $totalCount = $totalCount->count();

            return view('nber.enrolments.candidatedata.show_verification_status', compact('academicyear', 'totalCount', 'verificationPendingCount', 'pendingCount', 'approvedCount', 'rejectedCount'));
        }
        else {
            return redirect('/nber/enrolments');
        }
    }

    public function candidateDataVerificationApprovedprogrammeLists($ayId, $statusId) {
        $academicyear = Academicyear::find($ayId);

        if(!is_null($academicyear)) {
            if(is_null(Status::find($statusId)) || in_array($statusId, [5])) {
                unset($statusId);

                return redirect('/nber/enrolments');
            }
            else {
                $collections = Approvedprogramme::select('approvedprogrammes.id as id', 'institutes.name as instituteName', 'institutes.code as instituteCode', 'programmes.abbreviation as courseCode', 'candidates.status_id as statusId')
                    ->join('candidates', 'candidates.approvedprogramme_id', '=', 'approvedprogrammes.id')
                    ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
                    ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
                    ->where('approvedprogrammes.academicyear_id', $ayId)
                    ->where('approvedprogrammes.status_id', 2)
                    ->where('programmes.recognised_by', 'rci')
                    ->where('programmes.active_status', '!=', 3)
                    ->orderBy('institutes.code')
                    ->orderBy('programmes.sortorder')
                    ->get();

                $view_url = "enrolments/view/candidates?";

                $approvedprogrammes = ($statusId != 4 ? $collections->where('statusId', (int) $statusId)->unique(['id']) : $collections->unique(['id']));
                $approvedprogrammesCount = $approvedprogrammes->count();
                $status_remarks = ($statusId != 4 ? Status::find($statusId)->status : "Full");
                $view_url = ($statusId != 4 ? $view_url."s=$statusId&p=" : $view_url."p=");
                $status_class = Status::find($statusId)->class;

                return view('nber.enrolments.candidatedata.approvedprogramme_list', compact('academicyear','approvedprogrammes', 'status_remarks', 'status_class', 'approvedprogrammesCount', 'view_url'));
            }
        }
        else {
            return redirect('/nber/enrolments');
        }
    }
}
