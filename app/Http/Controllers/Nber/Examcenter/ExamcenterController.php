<?php

namespace App\Http\Controllers\Nber\Examcenter;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Externalexamcenter;
use Illuminate\Support\Facades\Hash;
use App\Services\Common\HelperService;
use Auth;
use DB;
use Session;

class ExamcenterController extends Controller
{


    private $helperService;

    public function __construct(HelperService $helper)
    {
        $this->helperService = $helper;
       $this->middleware(['role:nber']);
    }

    

    public function index(Request $r){
        $examcenters = Externalexamcenter::where('coe',1)->orwhere('exam_id',29)->orderBy('code', 'ASC')->get();
        return view('nber.examcenter.index',
            compact(
                'examcenters'
            )
        );
    }

    public function show($id){
        $examcenter = Externalexamcenter::find($id);
        return view('nber.examcenter.show',compact('examcenter'));
    }

    public function create(){

        $lgstates = \App\Lgstate::all();
        $districts = \App\District::all();
        return view('nber.examcenter.create',compact('lgstates','districts'));
    }

      public function fetchRCI(Request $request)
    {
        $code = $request->inst_code;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://rciregistration.nic.in/rehabcouncil/api/instapprovaldata_byinstcode.jsp',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "{ inst_code: $code }",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/plain'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return response()->json($response);
    }

    public function edit($id){
        $districts = \App\District::all();
        $examcenter = Externalexamcenter::find($id);
        $lgstates = \App\Lgstate::all();
        return view('nber.examcenter.edit',compact('examcenter','lgstates','districts'));
    }

    public function store(Request $r){

  $existingCenter = Externalexamcenter::where('code', $r->code)->first();
    if ($existingCenter) {
        Session::flash('messages', 'Exam Center with this code already exists');
        return redirect()->back();
    }
        $examcenter = Externalexamcenter::create($r->except('username','password'));
        // $user = \App\User::where('username',$r->username)->first();
        // if(is_null($user)){
        //     $user = \App\User::create([
        //         'username' => $r->username,
        //         'password' =>  Hash::make($r->password),
        //         'confirmed' => 0,
        //         'confirmation_code' => '111zzza',
        //         'usertype_id' => 6,
        //         'email' => $r->email1,
        //         'use_password' => null,
        //         'exam_id' => 27
        //     ]);
        // }else{
        //     $user->password =    Hash::make($r->password);
        //     $user->save();         
        // }
        // $examcenter->user_id = $user->id;
        $examcenter->save();
        Session::flash('messages','Created');
        return view('nber.examcenter.show',compact('examcenter'));
    }

    public function update($id,Request $r){
        
        // if(Auth::user()->id == 88387){


        $examcenter = Externalexamcenter::find($id);
        $examcenter->update($r->except('username','password','code'));
        // $user = \App\User::where('username',$r->username)->first();
        // if(!is_null($user)){
        //     $user->password =  Hash::make($r->password);
        //     $user->usertype_id = 6;
        //     $user->email = $r->email1;
        //     $user->save();     
        // }else{
        //     $user = \App\User::create([
        //         'username' => $r->username,
        //         'password' =>  Hash::make($r->password),
        //         'confirmed' => 0,
        //         'confirmation_code' => '111zzza',
        //         'usertype_id' => 6,
        //         'email' => $r->email1,
        //         'use_password' => null
        //     ]);
        // }
        // $examcenter->user_id = $user->id;
        $examcenter->save();
        Session::flash('messages','Updated');
        return redirect('/nber/excenter/') ;
//         }else{
// return "closed";
//         }
        
        
        return view('nber.examcenter.show',compact('examcenter'));
    }



  public function subject_by_candidate(Request $request)
            {
                $exam_id = 28;
                $nber_id = Auth::user()->nberstaffs->first()->nber_id;

                $course = $request->course;
                $state = $request->states;
                // $subject_type = $request->subject_type;

                $query = "
                    SELECT 
                        programmes.abbreviation, 
                        programmes.id as programme_id,
                        subjects.id as subject_id,
                        subjects.sname,
                        subjects.scode,
                        lgstates.id as state_id,
                        lgstates.state_name,
                     subjects.subjecttype_id,
institutes.name,institutes.rci_code,GROUP_CONCAT(DISTINCT languages.language) as language,
 count(DISTINCT candidates.id) AS theory_students

    


                    FROM approvedprogrammes
                    INNER JOIN programmes 
                        ON programmes.id = approvedprogrammes.programme_id
                    INNER JOIN candidates
                        ON candidates.approvedprogramme_id = approvedprogrammes.id
                    INNER JOIN allapplicants
                        ON allapplicants.candidate_id = candidates.id
                    INNER JOIN allapplications 
                        ON allapplications.applicant_id = allapplicants.id 
                         left JOIN languages 
                        ON languages.id = allapplicants.language_id 

                    INNER JOIN subjects
                        ON subjects.id = allapplications.subject_id and subjects.is_external=1
                    inner join institutes on institutes.id=approvedprogrammes.institute_id
                    INNER JOIN lgstates
                    ON lgstates.id = institutes.state_id
                    WHERE allapplications.exam_id = ?
                    AND programmes.nber_id = ?
                ";

                $params = [$exam_id, $nber_id];

                if (!empty($course)) {
                    $query .= " AND programmes.id = ?";
                    $params[] = $course;
                }
                // State Filter
                if (!empty($state)) {
                    $query .= " AND lgstates.id = ?";
                    $params[] = $state;
                }

                  if (!empty($subject_type)) {
                    $query .= " AND subjects.subjecttype_id = ?";
                    $params[] = $subject_type;
                }

                $query .= " GROUP BY institutes.id,subjects.id ORDER BY programmes.abbreviation ASC";

                $nber_details = DB::select($query, $params);

                return view('nber.examcenter.students', compact('nber_details'));
            }
    

}
