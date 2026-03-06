<?php

namespace App\Http\Controllers\Institute;

use App\Programme;
use App\Programmeapprovalfile;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Institute;
use App\Approvedprogramme;
use App\Academicyear;
use Auth;
use App\Configuration;
use Session;

class EnrolmentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }

    public function index() {
        $allowenrolment = Configuration::where('attribute','enrolment')->first()->value;
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('academicyear_id',Session::get('academicyear_id'))->get();
        foreach($approvedprogrammes as $ap){
            $declaration = \App\Admissiondeclaration::where('approvedprogramme_id',$ap->id)->first();
            if(is_null($declaration)){
                $count = \App\Candidate::where('approvedprogramme_id',$ap->id)->where('deleted_at',null)->count();
                $declaration = \App\Admissiondeclaration::create([
                    'institute_id' => $institute->id,
                    'no_of_candidates' => $count,
                    'academicyear_id' => 12,
                    'otp' =>  rand(100000, 999999),
                    'approvedprogramme_id' => $ap->id
                ]);   
            }
        }
        return view('institute.enrolment.index', compact('approvedprogrammes','allowenrolment'));
    }

    public function newEnrolment() {
        $programmes = Programme::all();
        $institute = Institute::where('user_id',Auth::user()->id)->first();
        $academicyears = Academicyear::orderBy('year', 'desc')->get();
        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $currentyear = Academicyear::where('current', '1')->first();
        //$programmeapprovedfiles =

        $ap = Approvedprogramme::where('institute_id', $institute->id)->where('academicyear_id', $currentyear->id)->get();
        

        
        if($ap->count() == '0') {
            $programmelist = Programme::where('active_status', '1')->get();
        }
        else {
            $ap_ids = $ap->pluck('programme_id')->toArray();
            $programmelist = Programme::where('active_status', '1')->whereNotIn('id', $ap_ids)->get();
        }
        return view('institute.enrolment.new', compact('programmes', 'institute', 'academicyears', 'approvedprogrammes', 'programmelist', 'currentyear'));

    }

    public function checkCourse(Request $r) {
        $rules = [
            'filename' => 'required | max:1024',
            'maxintake' => 'required | numeric | min:1 | max:35'
        ];

        $messages = [
            //filename
            "filename.required" > "Please upload the scanned copy of the Approval Letter",
            "filename.max" => "The uploaded file should be less than 1 MB",

            //maxintake
            'maxintake.required' => 'Please enter the maximum intake capacity of students',
            'maxintake.min' => 'The maximum intake capacity of the students can not be less than 1',
            'maxintake.max' => 'The maximum intake capacity of the students can not exceed 35',
        ];

        $validator = validator($r->all(), $rules, $messages);

        $validator->after(function ($validator) use($r) {
            if($r->programme_id === "0") {
                $validator->errors()->add('programme_id', "Please select a programme from the option");
            }

            if($r->hasFile('filename')) {
                $file = $r->file('filename');
                if($file->getClientOriginalExtension() != 'jpg' && $file->getClientOriginalExtension() != 'pdf') {
                    $validator->errors()->add('filename', "The uploaded file should in .jpg or .pdf format only");
                }
            }
        });

        $this->validateWith($validator);

        $institute = Institute::find($r->institute_id);

        $approvedprogramme = Approvedprogramme::create([
            'institute_id' => $r->institute_id,
            'programme_id' => $r->programme_id,
            'academicyear_id' => $r->academicyear_id,
            'maxintake' => $r->maxintake,
            'status_id' => $r->status_id
        ]);

        $file = $r->file('filename');
        $filename = 'rci_letter_'.$institute->code.'_'.$approvedprogramme->id.'.'.$file->getClientOriginalExtension();

        $file->move(public_path()."/files/rciapproval/", $filename);

        Programmeapprovalfile::create([
            'approvedprogramme_id' => $approvedprogramme->id,
            'filename' => $filename
        ]);

        return redirect('/enrolment');
    }

    public static function checkIncidentalChargesPayment($apid) {
        $approvedprogramme = Approvedprogramme::find($apid);


    }

    public function addFileCheck(Request $r) {
        $rules = [
            'filename' => 'required | max:1024',
            'maxintake' => 'required | numeric | min:1 | max:35'
        ];

        $messages = [
            //filename
            "filename.required" => "Please upload the scanned copy of the Approval Letter",
            "filename.max" => "The uploaded file should be less than 1 MB",

            //maxintake
            'maxintake.required' => 'Please enter the maximum intake capacity of students',
            'maxintake.min' => 'The maximum intake capacity of the students can not be less than 1',
            'maxintake.max' => 'The maximum intake capacity of the students can not exceed 35',
        ];

        $validator = validator($r->all(), $rules, $messages);

        $validator->after(function ($validator) use($r) {
            if($r->hasFile('filename')) {
                $file = $r->file('filename');
                if($file->getClientOriginalExtension() != 'jpg' && $file->getClientOriginalExtension() != 'pdf') {
                    $validator->errors()->add('filename', "The uploaded file should in .jpg or .pdf format only");
                }
            }
        });

        $this->validateWith($validator);

        return $this->create($r);
    }

    public function create(Request $r) {
        $approvedprogramme = Approvedprogramme::find($r->approvedprogramme_id);

        $approvedprogramme->update([
            'maxintake' => $r->maxintake,
            'status_id' => $r->status_id
        ]);

        $file = $r->file('filename');
        $filename = 'rci_letter_'.$approvedprogramme->institute->code.'_'.$approvedprogramme->id.'.'.$file->getClientOriginalExtension();

        $file->move(public_path()."/files/rciapproval/", $filename);

        Programmeapprovalfile::create([
            'approvedprogramme_id' => $approvedprogramme->id,
            'filename' => $filename
        ]);

        return redirect('/enrolment');
    }

    public function addFile($apid) {
        $approvedprogramme = Approvedprogramme::find($apid);

        return view('institute.enrolment.add', compact('approvedprogramme'));
    }

    public function editFile($apid) {
        $approvedprogramme = Approvedprogramme::find($apid);

        return view('institute.enrolment.edit', compact('approvedprogramme'));
    }

    public function editFileCheck(Request $r) {
        $rules = [
            'filename' => 'required | max:1024',
            'maxintake' => 'required | numeric | min:1 | max:35'
        ];

        $messages = [
            //filename
            "filename.required" => "Please upload the scanned copy of the Approval Letter",
            "filename.max" => "The uploaded file should be less than 1 MB",

            //maxintake
            'maxintake.required' => 'Please enter the maximum intake capacity of students',
            'maxintake.min' => 'The maximum intake capacity of the students can not be less than 1',
            'maxintake.max' => 'The maximum intake capacity of the students can not exceed 35',
        ];

        $validator = validator($r->all(), $rules, $messages);

        $validator->after(function ($validator) use($r) {
            if($r->hasFile('filename')) {
                $file = $r->file('filename');
                if($file->getClientOriginalExtension() != 'jpg' && $file->getClientOriginalExtension() != 'pdf') {
                    $validator->errors()->add('filename', "The uploaded file should in .jpg or .pdf format only");
                }
            }
        });

        $this->validateWith($validator);

        return $this->update($r);
    }

    public function update(Request $r) {
        $approvedprogramme = Approvedprogramme::find($r->approvedprogramme_id);

        $approvedprogramme->update([
            'maxintake' => $r->maxintake,
        ]);

        $programmeapprovalfile = Programmeapprovalfile::where('approvedprogramme_id', $approvedprogramme->id)->first();
        $destination = public_path()."/files/rciapproval/";
        if(file_exists($destination.$programmeapprovalfile->filename)) {
            unlink($destination.$programmeapprovalfile->filename);
        }

        $file = $r->file('filename');
        $filename = 'rci_letter_'.$approvedprogramme->institute->code.'_'.$approvedprogramme->id.'.'.$file->getClientOriginalExtension();

        $file->move($destination, $filename);

        $programmeapprovalfile->update([
            'filename' => $filename,
        ]);

        $approvedprogramme->update([
            'status_id' => 6
        ]);

        return redirect('/enrolment');
    }

    public function makeenrolmentpayment() {

    }
}
