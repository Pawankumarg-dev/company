<?php

namespace App\Http\Controllers\Nber;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Session;
use App\Evaluator;
use Illuminate\Support\Facades\Auth;
use App\Institute;
use App\Lgstate;
use App\District;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\User;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class EvalutorController extends Controller
{
    private $exam_id;

    public function __construct()
    {
        $this->middleware(['role:nber']);
        $this->exam_id = Session::get('exam_id');
    }

    public function processqp(){
        //  //$courses = \App\Course::all();
        
        // $job = (new \App\Jobs\Encryptwatermarked(27,75))->onQueue('encrypt75');
        // $this->dispatch($job);
        // // return "Job Created";
        // $job = (new \App\Jobs\Extractallqp(27,0))->onQueue('extract');
        // $this->dispatch($job);
        $job = (new \App\Jobs\Processqpgenpwd(27,89))->onQueue('genpwd89');
        $this->dispatch($job);
        // $job = (new \App\Jobs\Processqpgenpwd(27,86))->onQueue('genpwd86');
        // $this->dispatch($job);
        // $job = (new \App\Jobs\Processqpgenpwd(27,87))->onQueue('genpwd87');
        // $this->dispatch($job);
        // $job = (new \App\Jobs\Processqpgenpwd(27,88))->onQueue('genpwd88');
        // $this->dispatch($job);
        return "Job Created";
        $job = (new \App\Jobs\CheckCRRNo())->onQueue('crr');
        $this->dispatch($job);
        return "Job Created";
        $job = (new \App\Jobs\Extractallqp(27,0))->onQueue('cccg');
        $this->dispatch($job);
        return "Job Created";
        // $job = (new \App\Jobs\Extractallqp(27,84))->onQueue('extract');
        // // $this->dispatch($job);
        // $job = (new \App\Jobs\Processqpgenpwd(27,81))->onQueue('genpwd81');
        // $this->dispatch($job);
        // $job = (new \App\Jobs\Processqpgenpwd(27,82))->onQueue('genpwd82');
        // $this->dispatch($job);
        // $job = (new \App\Jobs\Processqpgenpwd(27,83))->onQueue('genpwd83');
        // $this->dispatch($job);
        // $job = (new \App\Jobs\Processqpgenpwd(27,84))->onQueue('genpwd84');
        // $this->dispatch($job);
        // return "Job Created";

  
         return "Job Created";

         $job = (new \App\Jobs\Generatewatermark(27,77))->onQueue('watermark77');
          $this->dispatch($job);
          $job = (new \App\Jobs\Generatewatermark(27,78))->onQueue('watermark78');
          $this->dispatch($job);
          $job = (new \App\Jobs\Generatewatermark(27,79))->onQueue('watermark79');
          $this->dispatch($job);
          $job = (new \App\Jobs\Generatewatermark(27,80))->onQueue('watermark80');
          $this->dispatch($job);
          
        return "Job Created";

            // $job = (new \App\Jobs\Encrypting(27,69))->onQueue('day269');

            // $this->dispatch($job);


            // $job = (new \App\Jobs\Encrypting(27,71))->onQueue('day271');

            // $this->dispatch($job);


        //  $job = (new \App\Jobs\Processqp(27,67))->onQueue('morningsessionday67');

        //  $this->dispatch($job);

        //  $job = (new \App\Jobs\Processqp(27,68))->onQueue('morningsessionday68');

        //  $this->dispatch($job);

         return "Job Created";
         $job =  (new \App\Jobs\GenerateECPassword())->onQueue('resendemail'); 
             $this->dispatch($job);

        // $job =  (new \App\Jobs\GenerateECPassword())->onQueue('resendpwd'); 
        //      $this->dispatch($job);
        // $job =  (new \App\Jobs\Extractallqp(27,23))->onQueue('step23'); 
        // $this->dispatch($job);
        // $job =  (new \App\Jobs\Extractallqp(27,7))->onQueue('step23'); 
        // $this->dispatch($job);
             
        // $job =  (new \App\Jobs\Processqpdemo(27,0))->onQueue('demoprocess'); 
        // $this->dispatch($job);
         return "Job Created";
        // $job = (new \App\Jobs\ExtractQPOMRCode(27,34112))->onQueue('dvrb2');
         
        //  //$job = (new \App\Jobs\ExtractQPNBER(27,4))->onQueue('niepid');
        //  $this->dispatch($job);
        //  return "Job Created";
        // // $courses = \App\Course::all();
        // foreach($courses as $c){
        //     $job = (new \App\Jobs\Extractallqp(27,$c->id))->onQueue('checkpwd');
        //     $this->dispatch($job);
        // }
        return "Job Created";
    }

   public function send_csemail(){
  
         $job =  (new \App\Jobs\GenerateEVCPassword())->onQueue('resetpwd'); 
             $this->dispatch($job);

        //  $job =  (new \App\Jobs\GenerateECPassword())->onQueue('resendpwd'); 
        //       $this->dispatch($job);
        return "Job Created";
    }






    public function index(){
        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
        $evaluator = Evaluator::where('exam_id',$this->exam_id)->where('nber_id',$nber_id)->get();
        return view('nber.evalutor.index',compact('evaluator'));
    }

    public function create(){
        $states = Lgstate::get();
        $institutes  = Institute::get();
        $districts = \App\District::all();
        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
        return view('nber.evalutor.create',compact('states','institutes','nber_id','districts'));
    }
    public function store(Request $request)
    {
        $evaluator = new Evaluator();
        $evaluator->name = $request->name;
        $evaluator->crr_no = $request->crr_no;
        $evaluator->designation = $request->designation;
        $evaluator->institute_id = $request->institute_id;
        $evaluator->email = $request->email;
        $evaluator->mobile = $request->mobile;
        $evaluator->lgstate_id = $request->lgstate_id;
        $evaluator->district = $request->district;
        $evaluator->exam_id = $this->exam_id;
        $evaluator->nber_id = $request->nber_id;
        
        $evaluator->save();

        Session::flash('messages','Evaluator added successfully');

        return redirect('nber/evaluators')->with('success', 'Evaluator added successfully!');


  
    }
    public function show($id)
{
    $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
    $evaluator = Evaluator::findOrFail($id);
    $institutes = Institute::all(); 
    $states = Lgstate::all();  
    $districts = District::get();  

    return view('nber.evalutor.edit', compact('evaluator', 'institutes', 'states', 'districts','nber_id'));
}

public function update(Request $request)
{
    $id=$request->id;
    $evaluator = Evaluator::findOrFail($id);
    $evaluator->name = $request->name;
    $evaluator->crr_no = $request->crr_no;
    $evaluator->designation = $request->designation;
    $evaluator->institute_id = $request->institute_id;
    $evaluator->email = $request->email;
    $evaluator->mobile = $request->mobile;
    $evaluator->lgstate_id = $request->lgstate_id;
    $evaluator->district = $request->district;
    $evaluator->save();
    Session::flash('messages','Evaluator detail updated successfully!');

    return redirect('nber/evaluators')->with('success', 'Evaluator detail updated successfully!');
}
public function evaluators_verify(Request $request){
    $evaluator = Evaluator::findOrFail($request->item_id);
 
    $evaluator->is_verified = 1;
    $evaluator->save();
    return response()->json(['message' => 'Verification successfully done']);
}
public function sendPassword(Request $request)
{
    

    $evaluator = Evaluator::find($request->item_id);
    $password='EV'.str_random(3).'@'.$request->item_id;

    if ($evaluator) {
        if (empty($evaluator->user_id)) {
            $user = new User();
            $user->username = $evaluator->email;
            $user->email = $evaluator->email;
            $user->usertype_id = 13; 
            $user->password = Hash::make($password);  
            $user->save();
            $evaluator->user_id = $user->id;
            $evaluator->save();
            $url = "https://rciregistration.nic.in/rehabcouncil/api/exam_email_send_nber.jsp?email=" . urlencode($evaluator->email) . "&name=Evalutor&password=" . urlencode($password) . "&user_id=" . urlencode($evaluator->email);
            $is_ok = $this->http_response($url);
            return response()->json(['message' => $url]);
        } else {

            $user = User::find($evaluator->user_id);
            if ($user) {
                $user->password =Hash::make($password);  
                $user->save();
                $url = "https://rciregistration.nic.in/rehabcouncil/api/exam_email_send_nber.jsp?email=" . urlencode($evaluator->email) . "&name=Evalutor&password=" . urlencode($password) . "&user_id=" . urlencode($evaluator->email);
                // $url = "https://rciregistration.nic.in/rehabcouncil/api/email_send_nber.jsp?email=".$evaluator->email."&name=".$evaluator->name."&password=".$password."&type=institute";
                $is_ok = $this->http_response($url);
                return response()->json(['message' => $url]);
            } else {
                return response()->json(['message' => 'User associated with this evaluator not found.'], 404);
            }
        }
    }
    return response()->json(['message' => 'Evaluator not found.'], 404);
}

public function http_response($url, $status = null, $wait = 3)

    {
    
         
    
    
    
            // we fork the process so we don't have to wait for a timeout
    
    
                // we are the parent
    
                $ch = curl_init();
    
                curl_setopt($ch, CURLOPT_URL, $url);
    
                curl_setopt($ch, CURLOPT_HEADER, TRUE);
    
                curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
    
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    
                $head = curl_exec($ch);
    
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
                curl_close($ch);

                return $httpCode;
        }



public function course(){


        $exam_id = Session::get('exam_id');
        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;
        $programmes = \App\Programme::where('nber_id',$nber_id)->where('active_status',1)->get();
        $year =Session::get('academicyear_id');
        $evaluationcenters = \App\Evaluationcenter::where('exam_id',$exam_id)->get();



        return view('nber.evaluations.programmes', compact('programmes','year','evaluationcenters'));

}


public function verify_external(Request $request){
        $nber_id = \App\Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;

        $subject = \App\Subject::find($request->subject_id);



//  if ($nber_id == 65) {

//             $applications =  \App\Allexamstudent::where('externalexamcenter_id',$request->externalexamcenter_id)->where('exam_id',27)->where('subject_id',$request->subject_id)->where('attendance',1)->orderBy('language_id')->get();

// } else {
        $applications =  \App\Allexamstudent::where('externalexamcenter_id',$request->externalexamcenter_id)->where('exam_id',27)->where('subject_id',$request->subject_id)->where('attendance',1)->orderBy('language_id','candidate_id')->get();

// }


        return view('nber.evaluations.markentry',compact('applications','subject'));



}


public function verify_marks(Request $r){
     $externalexamcenter_id = $r->externalexamcenter_id;
        $subject_id = $r->subject_id;
        $applications =  \App\Allexamstudent::where('externalexamcenter_id', $externalexamcenter_id)
    ->where('exam_id', 27)
    ->where('subject_id', $subject_id)
    ->where('attendance', 1)
    ->update(['verified' => 1]);
        // foreach($applications as $application){     
        //     $application->verified = 1;
        //     $application->save();
        // }
                        Session::put('messages','Verified marks updated successfully.');

return redirect()->route('marks-verification-course');

}


public function update_marks(Request $request)
{
  





    $nber_id = \App\Nberstaff::where('user_id', Auth::id())->value('nber_id');
        $access = Session::get('admin');

     if($access==2){
                        $data = \App\Changemarrequest::where('nber_id','=',$nber_id)->where('status',1)->get();
                        return view('nber.update-mark',compact('data'));
                    }
    $query = \App\Changemarrequest::where('nber_id', $nber_id);

    // Status filter
    if ($request->has('status') && $request->status !== '') {
        $query->where('status', $request->status);
    }

    // Edit type filter
    if ($request->has('edit') && $request->edit !== '') {
        $query->where('edit', $request->edit);
    }

    // Internal / External filter
    if ($request->has('inex') && $request->inex !== '') {
        $query->where('inex', $request->inex);
    }

    $data = $query->orderBy('status')->get();

    return view('nber.update-mark-request', compact('data'));
}


}
