<?php

namespace App\Http\Controllers\Institute;

use App\Candidate;
use App\Exam;
use App\Institutecertificateincharge;
use App\Instituteinformationupdate;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Institute;
use App\State;
use App\City;
use App\Institutehead;
use App\Coursecoordinator;
use App\Institutefacility;
use Auth;
use Illuminate\Support\Facades\Mail;
use Session;

class CenterinformationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }

    public function index() {
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        $title = 'Institute - Information';

        $institutehead = Institutehead::where('institute_id', $institute->id)->first();
        $institutefacility = Institutefacility::where('institute_id', $institute->id)->first();
        $institutecertificateincharge = Institutecertificateincharge::where('institute_id', $institute->id)->first();

        $states = State::orderBy('state_name')->get();
        $cities = City::orderBy('name')->get();

        return view ('institute.centerinformation.edit', compact('institute', 'states', 'cities', 'title', 'institutehead', 'institutefacility', 'institutecertificateincharge'));

        if($institute->edit_status == '1') {
            if($institute->verify_status == '0') {
                return view ('institute.centerinformation.edit', compact('institute', 'states', 'cities', 'title', 'institutehead', 'institutefacility', 'institutecertificateincharge'));
            }
            else {
                return redirect('/institute/center-information/notifications');
            }
        }
        else {
            return redirect('/institute/dashboard');
        }
    }

    public function checkEmailAddressExist(Request $request) {
        $emailAddressCount = Institute::where('email', $request->emailAddress)->count();

        $responseData = "Not Exist";

        if($emailAddressCount != 0) {
            if($emailAddressCount == 1) {
                $candidateEmailAddressFound = Institute::find($request->instituteId)->where('email', $request->emailAddress)->exists();

                if($candidateEmailAddressFound == null)
                    $responseData = "No Self-Exist";
                else
                    $responseData = "Self-Exist";
            }
            else {
                $responseData = "Exist";
            }
        }

        return response()->json($responseData);
    }

    public function sendEmailAddressVerificationCode(Request $request) {
        $responseData = "";
        try {
            $verificationCode = trim($request->verificationCode);
            $to_name = $request->instituteCode;
            $to_email = trim($request->emailAddress);

            Mail::send('institute.centerinformation.send_email_address_verification_code', ['verificationCode' => $verificationCode, 'instituteCode' => $to_name], function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject($to_name." - Institute's Official Email Address - Verification Code [".date('d-m-Y h:m:s A')."]");
                $message->from('nber.notifications@gmail.com','NIEPMD-NBER, Chennai');
            });

            $responseData = 1;
        }
        catch (\Exception $ex){
            $responseData = $ex->getMessage();
        }

        return response()->json($responseData);
    }

    public function update_information(Request $r) {
        $rules = [
            'address1' => 'required',
            'address2' => 'required',
            'address3' => 'required',
            'postoffice' => 'required',
            'landmark' => 'present',
            'city' => 'required',
            'pincode' => 'required | numeric',
            'contactnumber1' => 'required | numeric',
            'contactnumber2' => 'present | numeric',
            'email' => 'required | email',
            'website' => 'present',
            'faxno' => 'present',
            'headname' => 'required',
            'headdesignation' => 'required',
            'headqualification' => 'required',
            'headrcino' => 'present',
            'heademail' => 'required | email',
            'headcontactnumber1' => 'required | numeric',
            'headcontactnumber2' => 'present | numeric',
            'headfaxno' => 'present | numeric',
            'buildup_area' => 'required | numeric',
            'landarea' => 'required | numeric',
            'city_distance' => 'required | numeric',
            'postoffice_distance' => 'required | numeric',
            'available_rooms' => 'required | numeric',
            'classroom_size' => 'required | numeric',
            'biometric_facility' => 'required',
            'cctv_facility' => 'required'
        ];

        $messages = [
            //address1 field
            'address1.required' => 'Street field is required',

            //address2 field
            'address2.required' => 'Village/Area field is required',

            'address3.required' => 'Taluk field is required',

            //postoffice
            'postoffice.required' => 'Post office field is required',

            //city
            'city.required' => 'City field is required',

            //pincode
            'pincode.required' => 'Pincode field is required',

            //contactnumber1
            'contactnumber1.required' => 'Contact Number field is required',

            //email
            'email.required' => 'Institute Email field is required',

            //headname
            'headname.required' => 'Institute Head\'s Name field is required',

            //headdesignation
            'headdesignation.required' => 'Institute Head\'s Designation field is required',

            //headqualification
            'headqualification.required' => 'Institute Head\'s Qualification field is required',

            //heademail
            'heademail.required' => 'Institute Head\'s Email field is required',

            //headcontactnumber1
            'headcontactnumber1.required' => 'Institute Head\'s Contact Number field is required',

            //buildup_area
            'buildup_area.required' => 'Buildup Area field is required',

            //landarea
            'landarea.required' => 'Landarea field is required',

            //city_distance
            'city_distance.required' => 'City distance field is required',

            //postoffice_distance
            'postoffice_distance.required' => 'Post office distance field is required',

            //available_rooms
            'available_rooms.required' => 'Number of rooms available field is required',

            //classroom_size
            'classroom_size.required' => 'Size of the classroom field is required',

        ];

        $validator = validator($r->all(), $rules, $messages);

        $validator->after(function ($validator) use ($r) {
            if($r->city == '-') {
                $validator->errors()->add('city', 'Please select an option for city and state');
            }
            if($r->biometric_facility == '-') {
                $validator->errors()->add('biometric_facility', 'Please select an option for Biometric Facility');
            }
            if($r->cctv_facility == '-') {
                $validator->errors()->add('cctv_facility', 'Please select an option for CCTV Facility');
            }
        });

        $this->validateWith($validator);

        //return redirect('/institute/centerinformation/update/'.$institute_id.'/'.$r);

        return $this->addoredit($r);
    }

    public function addoredit($r) {
        $institute = Institute::find($r->institute_id);

        $institute->update([
            'address1' => $r->address1,
            'address2' => $r->address2,
            'address3' => $r->address3,
            'postoffice' => $r->postoffice,
            'landmark' => $r->landmark,
            'city_id' => $r->city,
            'pincode' => $r->pincode,
            'contactnumber1' => $r->contactnumber1,
            'contactnumber2' => $r->contactnumber2,
            'email' => $r->email,
            'website' => $r->website,
            'faxno' => $r->faxno
        ]);

        $instituteheads = Institutehead::where('institute_id', $institute->id)->first();

        if(is_null($instituteheads)) {
            Institutehead::create([
                'institute_id' => $institute->id,
                'name' => $r->headname,
                'designation' => $r->headdesignation,
                'qualification' => $r->headqualification,
                'email' => $r->heademail,
                'rci_reg_no' => $r->headrcino,
                'contactnumber1' => $r->headcontactnumber1,
                'contactnumber2' => $r->headcontactnumber2,
                'faxno' => $r->headfaxno
            ]);
        }
        else {
            $instituteheads->update([
                'institute_id' => $institute->id,
                'name' => $r->headname,
                'designation' => $r->headdesignation,
                'qualification' => $r->headqualification,
                'email' => $r->heademail,
                'rci_reg_no' => $r->headrcino,
                'contactnumber1' => $r->headcontactnumber1,
                'contactnumber2' => $r->headcontactnumber2,
                'faxno' => $r->headfaxno
            ]);
        }

        $institutefacility = Institutefacility::where('institute_id', $institute->id)->first();

        if(is_null($institutefacility)) {
            Institutefacility::create([
                'institute_id' => $institute->id,
                'buildup_area' => $r->buildup_area,
                'landarea' => $r->landarea,
                'city_distance' => $r->city_distance,
                'postoffice_distance' => $r->postoffice_distance,
                'available_rooms' => $r->available_rooms,
                'classroom_size' => $r->classroom_size,
                'biometric_facility' => $r->biometric_facility,
                'cctv_facility' => $r->cctv_facility
            ]);
        }
        else {
            $institutefacility->update([
                'institute_id' => $institute->id,
                'buildup_area' => $r->buildup_area,
                'landarea' => $r->landarea,
                'city_distance' => $r->city_distance,
                'postoffice_distance' => $r->postoffice_distance,
                'available_rooms' => $r->available_rooms,
                'classroom_size' => $r->classroom_size,
                'biometric_facility' => $r->biometric_facility,
                'cctv_facility' => $r->cctv_facility
            ]);
        }

        $institute->update(['edit_status' => '1']);

        Session::put('messages','Center Information added / updated successfully');
        return redirect('/institute/dashboard');
    }

    public function getcities(Request $request) {
        $cities = City::where('state_id', $request->state_id)->orderBy('name')->get();

        return response()->json($cities);
    }

    public function getCityList(Request $request) {
        $cities = City::where('state_id', $request->state_id)->orderBy('name')->get();

        return response()->json($cities);
    }

    public function updateInformation(Request $request) {
        $institute = Institute::find($request->institute_id);

        $institute->update([
            'street_address' => $request->street_address,
            'postoffice' => $request->postoffice,
            'landmark' => $request->landmark,
            'city_id' => $request->city_id,
            'pincode' => $request->pincode,
            'contactnumber1' => $request->contactnumber1,
            'contactnumber2' => $request->contactnumber2,
            'email' => $request->email,
            'email2' => $request->email2,
            'website' => $request->website,
            'faxno' => $request->faxno
        ]);

        $instituteheads = Institutehead::where('institute_id', $institute->id)->first();

        if(is_null($instituteheads)) {
            Institutehead::create([
                'institute_id' => $institute->id,
                'name' => $request->headname,
                'designation' => $request->headdesignation,
                'qualification' => $request->headqualification,
                'email' => $request->heademail,
                'rci_reg_no' => $request->headrci_reg_no,
                'contactnumber1' => $request->headcontactnumber1,
                'contactnumber2' => $request->headcontactnumber2,
            ]);
        }
        else {
            $instituteheads->update([
                'institute_id' => $institute->id,
                'name' => $request->headname,
                'designation' => $request->headdesignation,
                'qualification' => $request->headqualification,
                'email' => $request->heademail,
                'rci_reg_no' => $request->headrci_reg_no,
                'contactnumber1' => $request->headcontactnumber1,
                'contactnumber2' => $request->headcontactnumber2,
            ]);
        }

        $institutefacility = Institutefacility::where('institute_id', $institute->id)->first();

        if(is_null($institutefacility)) {
            Institutefacility::create([
                'institute_id' => $institute->id,
                'buildup_area' => $request->buildup_area,
                'landarea' => $request->landarea,
                'city_distance' => $request->city_distance,
                'postoffice_distance' => $request->postoffice_distance,
                'available_rooms' => $request->available_rooms,
                'biometric_facility' => $request->biometric_facility,
                'cctv_facility' => $request->cctv_facility
            ]);
        }
        else {
            $institutefacility->update([
                'institute_id' => $institute->id,
                'buildup_area' => $request->buildup_area,
                'landarea' => $request->landarea,
                'city_distance' => $request->city_distance,
                'postoffice_distance' => $request->postoffice_distance,
                'available_rooms' => $request->available_rooms,
                'biometric_facility' => $request->biometric_facility,
                'cctv_facility' => $request->cctv_facility
            ]);
        }

        $institutecertificateincharge = Institutecertificateincharge::where('institute_id', $institute->id)->first();

        if(is_null($institutecertificateincharge)) {
            Institutecertificateincharge::create([
                'institute_id' => $institute->id,
                'name' => $request->certificateincharge_name,
                'designation' => $request->certificateincharge_designation,
                'contactnumber1' => $request->certificateincharge_contactnumber1,
                'contactnumber2' => $request->certificateincharge_contactnumber2,
                'email' => $request->certificateincharge_email,
            ]);
        }
        else {
            $institutecertificateincharge->update([
                'institute_id' => $institute->id,
                'name' => $request->certificateincharge_name,
                'designation' => $request->certificateincharge_designation,
                'contactnumber1' => $request->certificateincharge_contactnumber1,
                'contactnumber2' => $request->certificateincharge_contactnumber2,
                'email' => $request->certificateincharge_email,
            ]);
        }

        $instituteinformationupdate = Instituteinformationupdate::create([
            'institute_id' => $institute->id,
            'user_id' => $institute->user->id,
            'update_remarks' => $request->update_remarks,
            'active_status' => '1',
        ]);

        $institute->update([
            'edit_status' => '0',
            'verify_status' => '2'
        ]);

        //return redirect('/institute/center-information/notifications');
        return redirect('/institute/dashboard');
    }

    public function showNotifications() {
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        if($institute->edit_status == 1) {
            if($institute->verify_status == 1) {
                $title = 'Institute - Information';

                $institutehead = Institutehead::where('institute_id', $institute->id)->first();
                //$coursecoordinators = Coursecoordinator::where('institute_id', $institute->id)->get();
                $institutefacility = Institutefacility::where('institute_id', $institute->id)->first();
                $institutecertificateincharge = Institutecertificateincharge::where('institute_id', $institute->id)->first();

                $states = State::orderBy('state_name')->get();
                $cities = City::orderBy('name')->get();

                return view ('institute.centerinformation.notifications', compact('institute', 'states', 'cities', 'title', 'institutehead', 'institutefacility', 'institutecertificateincharge'));
            }
        }
        else {
            return redirect('/institute/dashboard');
        }
    }
}
