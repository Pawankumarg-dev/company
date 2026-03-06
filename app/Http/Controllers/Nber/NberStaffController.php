<?php

namespace App\Http\Controllers\Nber;

use App\Nbersmsupdate;
use App\Nberstaff;
use App\User;
use Illuminate\Http\Request;
use App\Title;
use App\Gender;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;

use App\Technicalissue;

class NberStaffController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }
    public function issues(Request $r){
        if($r->has('showall')){
            $collections = Technicalissue::paginate(100);

        }else{
            $collections = Technicalissue::where('status_id',0)->paginate(100);
        }
        $link  = 'technicalissues';
        $text = "Technical Issues";
        return view('nber/technicalissues/index',compact('collections','link','text'));
    }

    public function createissue(Request $request){
    	$issue = Technicalissue::create($request->all());
        if($request->solution != ''){
            $issue->solved_at = \Carbon\Carbon::now();
            $issue->save();
        }
        Session::put('messages','Created');
    	return back();
    }
    public function updateissue(Request $request){
    	$issue = Technicalissue::find($request->id);
    	$issue->update($request->except('id'));
        if($request->solution != ''){
            $issue->solved_at = \Carbon\Carbon::now();
            $issue->save();
        }
    	Session::put('messages','Updated');
    	return  back();

    }
    public function changenber($nid){
        if((Auth::user()->id == 88387 || Auth::user()->id == 239776) && $nid > 0 && $nid < 6){
            $nberstaff = Nberstaff::where('user_id',Auth()->user()->id)->first();
            $nberstaff->nber_id = $nid;
            $nberstaff->save();
            //Session::put('messages','Changed')
            return back();
        }
    }
    public function create(Request $request){

        if(Nberstaff::where('user_id',Auth()->user()->id)->first()->admin == 1){
            $rules = [
                'username' => 'required|unique:users',
                'name' => 'required',
                'email_address' => 'required|email',
                'title_id' => 'required',
                'designation' => 'required',
                'gender_id' => 'required',
                'mobile_number' => 'required',
                'password' => 'required'
            ];
            $messages = [
                'username.required' => 'The Login ID is required',
                'username.unique' => 'The Login ID is already taken',
                'email.required' => 'The Email address field is required',
                'title_id.required' => 'The Title is required',
                'gender_id.required' => 'The Gender is required',
                
            ];
            $this->validate($request, $rules,$messages);

         
            $rules = [
                'username' => 'required|unique:users',
            ];
            $messages = [
                'username.unique' => 'The Login ID is already taken',
            ];

            $this->validate($request, $rules,$messages);

           // $mysqluser = User::create(['username'=>$request->username,'password'=>bcrypt($request->password),'email'=>$request->email_address,'usertype_id'=>'1','confirmation_code'=>'']);
            $user = User::create(['username'=>$request->username,'password'=>bcrypt($request->password),'email'=>$request->email_address,'usertype_id'=>'1','confirmation_code'=>'']);
            $nber_id = Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
    
            Nberstaff::create([
                'user_id'=>$user->id,
                'name'=>$request->name,
                'email_address'=>$request->email_address,
                'title_id'=>$request->title_id,
                'designation'=>$request->designation,
                'gender_id'=>$request->gender_id,
                'mobile_number'=>$request->mobile_number,
                'active_status'=>1,
                'admin' => $request->admin,
                'nber_id' => $nber_id,
            ]);
            $request->session()->flash('status', 'Account created!');
            return back();
        }else{
            return back();
        }
    }

    public function update(Request $request){

        if(Nberstaff::where('user_id',Auth()->user()->id)->first()->admin == 1){

            $nberstaff  = Nberstaff::find($request->id);
            //$username = User::find($nberstaff->user_id)->username;
            /*if($request->username != $username ){

                $rules = [
                    'username' => 'required|unique:users',
                ];
                $messages = [
                    'username.required' => 'The Login ID is required',
                    'username.unique' => 'The Login ID is already taken',
                ];
                $this->validate($request, $rules,$messages);
            }*/
            $rules = [
                'name' => 'required',
                'email_address' => 'required|email',
                'title_id' => 'required',
                'designation' => 'required',
                'gender_id' => 'required',
                'mobile_number' => 'required',
            ];
            $messages = [
                'email.required' => 'The Email address field is required',
                'title_id.required' => 'The Title is required',
                'gender_id.required' => 'The Gender is required',
            ];
            $this->validate($request, $rules,$messages);


            //$database = \Auth::user()->database_name;
            //\Illuminate\Support\Facades\DB::setDefaultConnection('mysql');
            //if($request->username != $username ){
            //    $rules = [
            //        'username' => 'required|unique:users',
            //    ];
            //    $messages = [
            //        'username.unique' => 'The Login ID is already taken',
            //    ];
            //    $this->validate($request, $rules,$messages);
            //}


            //$mysqluser = User::find($nberstaff->user_id);

            //$mysqluser->username = $request->username;
            //$mysqluser->save();

            //\Illuminate\Support\Facades\DB::setDefaultConnection($database);
            //$user = User::find($nberstaff->user_id);
            //$user->username = $request->username;
            //$user->save();
    
            $nberstaff->name = $request->name;
            $nberstaff->email_address = $request->email_address;
            $nberstaff->title_id = $request->title_id;
            $nberstaff->designation = $request->designation;
            $nberstaff->gender_id = $request->gender_id;
            $nberstaff->mobile_number = $request->mobile_number;
            $nberstaff->admin = $request->admin;
            $nberstaff->save();
            $request->session()->flash('status', 'Updated');
            return back();
        }else{
            return back();
        }
    }
    public function changepassword(Request $request){
        if(Nberstaff::where('user_id',Auth()->user()->id)->first()->admin == 1){
            $rules = [
                'password' => 'required|min:8',
            ];
            $messages = [
            ];
            $this->validate($request, $rules,$messages);
            $user = User::find(Nberstaff::find($request->id)->user_id);
            $user->password = bcrypt($request->password);
            $user->save();
          //  $database = \Auth::user()->database_name;
           // \Illuminate\Support\Facades\DB::setDefaultConnection('mysql');
           // $mysqluser = User::find($user->id);
           // $mysqluser->password = bcrypt($request->password);
           // $mysqluser->save();
           // \Illuminate\Support\Facades\DB::setDefaultConnection($database);
            $request->session()->flash('status', 'Updated');
            return back();
        }else{
            return back();
        }
    }
    public function index(){
        return '';
        if(Nberstaff::where('user_id',Auth()->user()->id)->first()->admin == 1){
            $nber_id = Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
            $collections = Nberstaff::where('nber_id',$nber_id)->paginate(10);
            $link = 'staffs';
            $text = 'NBER Staffs';
            $titles = Title::all();
            $genders = Gender::all();
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
            return view('nber.staffdetails.list',compact('collections','link','text','titles','genders','yesno'));
        }else{
            return redirect('/nber/dashboard');
        }
    }
    public function newstaff(Request $request){
        $titles = Title::get();
        return view('nber.staffdetails.create_new_staff_details',compact('titles'));
    }
    public function createStaff(Request $request) {
        $nberstaff = Nberstaff::firstOrCreate([
            "user_id" => Auth::user()->id,
            "title_id" => $request->title_id,
            "name" => trim(strtoupper($request->name)),
            "designation" => trim($request->designation),
            "gender_id" => $request->gender_id,
            "dob" => date("Y-m-d", strtotime($request->dob)),
            "mobile_number" => trim($request->mobile_number),
            "email_address" => trim($request->email_address),
            "active_status" => 1
        ]);

        if(!is_null($nberstaff)) {
            $nberstaff->user->update([
                "password" => bcrypt($request->password),
                "confirmation_code" => $request->password,
            ]);
        }

        return redirect('/nber/dashboard');
    }

    public function sendMobileNumberVerificationCode(Request $request) {
        $api_key = '25FA4F48782DFA';
        $contacts = trim($request->mobileNumber);
        $from = 'CHNBER';
        $template_id = '1207165062739786623';
        $verificationCode = trim($request->verificationCode);
        $sms_text = urlencode('Dear Official, '.$verificationCode.' is the mobile verification code. Regards, NIEPMD-NBER, Chennai.');

        $api_url = "http://sms.godaddysms.com/app/smsapi/index.php?key=" . $api_key . "&campaign=0&routeid=13&type=text&contacts=" . $contacts . "&senderid=" . $from . "&msg=" . $sms_text . "&template_id=" . $template_id;

        $responseData = file_get_contents($api_url);

        Nbersmsupdate::firstOrCreate([
            "user_id" => Auth::user()->id,
            "type" => "Staff Profile",
            "mobile_number" => trim($request->mobileNumber),
            "otp" => trim($request->verificationCode),
            "sms" => urldecode($sms_text),
            "remarks" => "added NBER staff details"
        ]);

        return response()->json($responseData);
    }
}
