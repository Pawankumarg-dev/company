<?php

namespace App\Http\Controllers\Institute;

use App\District;
use App\Externalexamcenter;
use App\Http\Controllers\Controller;
use App\Institute;
use App\Lgstate;
use App\Paymentbank;
use App\Subdistrict;
use App\Village;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\Common\HelperService;

use Session;

class ExamCenterController extends Controller
{
    private $helperService  ;
    public function __construct(HelperService $h)
    {
        $this->helperService = $h;
        $this->middleware(['role:institute']);
    }
    public function index()
    {

        $schools = Externalexamcenter::where('institute_id', $this->helperService->getInstituteID())->where('exam_id',27)->get();
$ss= $this->helperService->getInstituteID();
        if($ss=='1004'){
             $schools = Externalexamcenter::where('exam_id',27)->get();
        }
        return view('institute.examcenters.index', compact('schools'));
    }

    public function create()
    {
        $institute_location = Session::get('institute_location');

        $states = Lgstate::all();
        $districts = District::all();
        $villages = Village::all();
        $subdistricts = Subdistrict::all();
        $banks = Paymentbank::all();
        return view('institute.examcenters.add-center-details', compact('states', 'districts', 'subdistricts', 'villages', 'banks','institute_location'));
    }
    public function store(Request $request)
    {
        $randomString = uniqid(time(), true). $request['institute_id'];
        if ($request->hasFile('consent_form')) {
            $image = $request->file('consent_form');
            $imageName = $randomString . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/institutes/exam-consent-form'), $imageName);
        }
        // $exam_id = \App\Exam::where('scheduled_exam',1)->first()->id;
        $exam_id = 27;

        $examCenter = new Externalexamcenter();
        $examCenter->name = $request['name'];
        $examCenter->institute_id = $request['institute_id'];

        $examCenter->seats_per_room = $request['seats_per_room'];
        $examCenter->setting_capacity = $request['setting_capacity'];
        $examCenter->latitude = $request['latitude'];
        $examCenter->longitude = $request['longitude'];
        $examCenter->lgstate_id = $request['lgstate_id'];
        $examCenter->district = $request['district'];
        $examCenter->subdistrict = $request['subdistrict'];
        $examCenter->village = $request['village'];
        $examCenter->address = $request['address'];
        $examCenter->pincode = $request['pincode'];
        $examCenter->nearest_police_station = $request['nearest_police_station'];
        $examCenter->nearest_post_office = $request['nearest_post_office'];
        $examCenter->principal_name = $request['principal_name'];
        $examCenter->email1 = $request['email1'];
        $examCenter->principal_mobile = $request['principal_mobile'];
        $examCenter->principal_whatsapp = $request['principal_whatsapp'];
        $examCenter->contactperson = $request['contactperson'];
        $examCenter->alternative_designation = $request['alternative_designation'];
        $examCenter->email2 = $request['email2'];
        $examCenter->contactnumber1 = $request['contactnumber1'];
        $examCenter->contactnumber2 = $request['contactnumber2'];
        $examCenter->district_officer_name = $request['district_officer_name'];
        $examCenter->district_officer_mobile = $request['district_officer_mobile'];
        $examCenter->bank_name = $request['bank_name'];
        $examCenter->account_holder_name = $request['account_holder_name'];
        $examCenter->account_number = $request['account_number'];
        $examCenter->branch = $request['branch'];
        $examCenter->ifsc_code = $request['ifsc_code'];
        $examCenter->stay = $request['stay'];
        $examCenter->permission = $request['permission'];
        $examCenter->consent_form = $imageName; // Save file path
        $examCenter->active_status = 1; // Save file path
        $examCenter->exam_id = $exam_id;
        $examCenter->superintendent_declearation =$request['superintendent_declearation'];
        $examCenter->superintendent = $request['superintendent'];
        $examCenter->session_min_capacity = $request['session_min_capacity'];
        $examCenter->classrooms = $request['classrooms'];
        $examCenter->washrooms = $request['washrooms'];
        $examCenter->cctv_facility = $request['cctv_facility'];
        $examCenter->computers = $request['computers'];
        $examCenter->printers =$request['printers'];
        $examCenter->photocopiers = $request['photocopiers'];
        $examCenter->scanners = $request['scanners'];
        $examCenter->support_staff = $request['support_staff'];
        $examCenter->technical_staff =$request['technical_staff'];
        $examCenter->accessibility = json_encode($request->input('accessibility', []));
        $examCenter->drinking_water =$request['drinking_water'];
        $examCenter->security_guards =$request['security_guards'];
        $examCenter->special_permissions_details =$request['special_permissions_details'];
        $examCenter->classroom_count =$request['classroom_count'];
        $examCenter->open_space =$request['open_space'];
        $examCenter->save();
        // superintendent_declearation
        // superintendent
        // session_min_capacity
        // classrooms
        // washrooms
        // cctv_facility
        // computers
        // printers
        // photocopiers
        // scanners
        // support_staff
        // technical_staff
        // accessibility
        // drinking_water
        // security_guards
        // special_permissions_details


        //  $states = Lgstate::where('id',$request['lgstate_id'])->first();
        //  $examCenter->code='EXC'.$states->state_code.$insertedId;
        //  $examCenter->save();

        return redirect('institute/examcenters')->with('message', 'Exam Center details have been save successfully!');

    }
    public function edit($id)
    {
        $villages = Village::all();
        $subdistricts = Subdistrict::all();
        $banks = Paymentbank::all();
        $school = Externalexamcenter::findOrFail($id);
        $states = Lgstate::all();
        $districts = District::all();

        return view('institute.examcenters.edit', compact('school', 'states', 'districts', 'subdistricts', 'villages', 'banks'));
    }

    public function update(Request $request)
    {

        $id = $request['id'];
        $examCenter = Externalexamcenter::findOrFail($id);
        if ($request->hasFile('consent_form')) {
            $randomString = uniqid(time(), true). $id;
            $image = $request->file('consent_form');
            $imageName = $randomString . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/institutes/exam-consent-form'), $imageName);
            // $name = 'public/' . time() . str_random(5) . '.' . $file->getClientOriginalExtension();
            $examCenter->consent_form = $imageName; // Save file path
        }
        $examCenter->name = $request['name'];
        $examCenter->seats_per_room = $request['seats_per_room'];
        $examCenter->setting_capacity = $request['setting_capacity'];
        $examCenter->latitude = $request['latitude'];
        $examCenter->longitude = $request['longitude'];
        $examCenter->lgstate_id = $request['lgstate_id'];
        $examCenter->district = $request['district'];
        $examCenter->subdistrict = $request['subdistrict'];
        $examCenter->village = $request['village'];
        $examCenter->address = $request['address'];
        $examCenter->pincode = $request['pincode'];
        $examCenter->nearest_police_station = $request['nearest_police_station'];
        $examCenter->nearest_post_office = $request['nearest_post_office'];
        $examCenter->principal_name = $request['principal_name'];
        $examCenter->email1 = $request['email1'];
        $examCenter->principal_mobile = $request['principal_mobile'];
        $examCenter->principal_whatsapp = $request['principal_whatsapp'];
        $examCenter->contactperson = $request['contactperson'];
        $examCenter->alternative_designation = $request['alternative_designation'];
        $examCenter->email2 = $request['email2'];
        $examCenter->contactnumber1 = $request['contactnumber1'];
        $examCenter->contactnumber2 = $request['contactnumber2'];
        $examCenter->district_officer_name = $request['district_officer_name'];
        $examCenter->district_officer_mobile = $request['district_officer_mobile'];
        $examCenter->bank_name = $request['bank_name'];
        $examCenter->account_holder_name = $request['account_holder_name'];
        $examCenter->account_number = $request['account_number'];
        $examCenter->branch = $request['branch'];
        $examCenter->ifsc_code = $request['ifsc_code'];
        $examCenter->stay = $request['stay'];
        $examCenter->permission = $request['permission'];
        $examCenter->superintendent_declearation =$request['superintendent_declearation'];
        $examCenter->superintendent = $request['superintendent'];
        $examCenter->session_min_capacity = $request['session_min_capacity'];
        $examCenter->classrooms = $request['classrooms'];
        $examCenter->washrooms = $request['washrooms'];
        $examCenter->cctv_facility = $request['cctv_facility'];
        $examCenter->computers = $request['computers'];
        $examCenter->printers =$request['printers'];
        $examCenter->photocopiers = $request['photocopiers'];
        $examCenter->scanners = $request['scanners'];
        $examCenter->support_staff = $request['support_staff'];
        $examCenter->technical_staff =$request['technical_staff'];
        $examCenter->accessibility = json_encode($request->input('accessibility', []));
        $examCenter->drinking_water =$request['drinking_water'];
        $examCenter->security_guards =$request['security_guards'];
        $examCenter->special_permissions_details =$request['special_permissions_details'];
        $examCenter->classroom_count =$request['classroom_count'];
        $examCenter->open_space =$request['open_space'];

        $examCenter->save();

        return redirect('institute/examcenters')->with('message', 'Examcenters updated successfully!');

    }

    // public function destroy($id)
    // {
    //     $school = ExamCenterName::findOrFail($id);
    //     $school->delete();

    //     return redirect()->route('examcenters.index')->with('success', 'School deleted successfully');
    // }
}
