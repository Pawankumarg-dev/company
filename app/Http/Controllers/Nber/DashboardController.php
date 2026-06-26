<?php

namespace App\Http\Controllers\Nber;

use App\Nberstaff;
use App\Title;
use App\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Notice;
use App\Http\Requests;
use App\Programme;
use App\Configuration;

use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\DB;
use App\Malpractice;
use App\Services\Common\HelperService;

class DashboardController extends Controller
{
   private $nber_id;
    private $exam_id;

    public function __construct(HelperService $help)
    {
       $this->middleware(['role:nber']);
       $this->helperService = $help;
       $this->nber_id = $this->helperService->getNberID();
       $this->exam_id = Session::get('exam_id');
    }
    public function index(){
        $nber_id = Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;

        $verification = DB::select("select 
            i.rci_code as username, 
            
            i.name as institute, 
            p.abbreviation as programme, 
            ap.maxintake as maxintake,  count(c.id) as applications_received, sum(if(c.status_id=6,1,0)) as not_verified,  sum(if(c.status_id=2,1,0)) as verified, sum(if(c.status_id=1,1,0)) as rejected,sum(if(c.status_id=9,1,0)) as discontinued   from approvedprogrammes ap
        left join institutes i  on i.id = ap.institute_id
        left join programmes p on p.id = ap.programme_id
        left join nbers n on n.id = p.nber_id
        left join users u on u.id = i.user_id
        left outer join candidates c on c.approvedprogramme_id = ap.id
        where  p.nber_id = ".$nber_id."  and ap.institute_id != 1004 and ap.academicyear_id = ".Session::get('academicyear_id')."  and ap.deleted_at is null and c.deleted_at is null group by ap.id order  by u.username");
        //return $verification;
        return view('nber.dashboard.dashboard',compact('verification'));
    }
    public function changeayid($id){
        Session::put('academicyear_id',$id);
        return back();
    }
    public function showDashboard() {

    }
    public function settings(){
        $niname = Configuration::find(1);
        $logo = Configuration::find(2);
        $enrolment = Configuration::find(3);
        $offline = Configuration::where('attribute','offline')->first();
        $online = Configuration::where('attribute','online')->first();
        $ccavenue_working_key = Configuration::where('attribute','ccavenue_working_key')->first();
        $ccavenue_access_code = Configuration::where('attribute','ccavenue_access_code')->first();
        $ccavenue_merchant_id = Configuration::where('attribute','ccavenue_merchant_id')->first();

        $accountname = Configuration::where('attribute','accountname')->first();
        $bankname = Configuration::where('attribute','bankname')->first();
        $bankaddress = Configuration::where('attribute','bankaddress')->first();
        $accountnumber = Configuration::where('attribute','accountnumber')->first();
        $typeofaccount = Configuration::where('attribute','typeofaccount')->first();
        $ifsccode = Configuration::where('attribute','ifsccode')->first();
        
        return view('nber.settings.index',compact('niname','logo','enrolment','offline','online','ccavenue_access_code','ccavenue_merchant_id','ccavenue_working_key','accountname','bankname','bankaddress','accountnumber','typeofaccount','ifsccode'));
    }
    public function updatesettings(Request $r){
        $niname = Configuration::find(1);
        $enrolment = Configuration::find(3);

        $offline = Configuration::where('attribute','offline')->first();
        $online = Configuration::where('attribute','online')->first();
        $ccavenue_working_key = Configuration::where('attribute','ccavenue_working_key')->first();
        $ccavenue_access_code = Configuration::where('attribute','ccavenue_access_code')->first();
        $ccavenue_merchant_id = Configuration::where('attribute','ccavenue_merchant_id')->first();
        $accountname = Configuration::where('attribute','accountname')->first();
        $bankname = Configuration::where('attribute','bankname')->first();
        $bankaddress = Configuration::where('attribute','bankaddress')->first();
        $accountnumber = Configuration::where('attribute','accountnumber')->first();
        $typeofaccount = Configuration::where('attribute','typeofaccount')->first();
        $ifsccode = Configuration::where('attribute','ifsccode')->first();
        
        $offline->value = $r->offline;
        $offline->save();
        $online->value = $r->online;
        $online->save();
        $ccavenue_working_key->value =$r->ccavenue_working_key;
        $ccavenue_working_key->save();
        $ccavenue_access_code->value = $r->ccavenue_access_code;
        $ccavenue_access_code->save();
        $ccavenue_merchant_id->value = $r->ccavenue_merchant_id;
        $ccavenue_merchant_id->save();
        $niname->value = $r->niname;        
        $niname->save();
        $enrolment->value = $r->enrolment;
        $enrolment->save();
        $accountname->value = $r->accountname;
        $bankname->value = $r->bankname;
        $bankaddress->value = $r->bankaddress;
        $accountnumber->value = $r->accountnumber;
        $typeofaccount->value = $r->typeofaccount;
        $ifsccode->value = $r->ifsccode;
        $accountname->save();
        $bankname->save();
        $bankaddress->save();
        $accountnumber->save();
        $typeofaccount->save();
        $ifsccode->save();
        return back();
    }

    
    public function index_notice(){
        $notices =Notice::all()->sortByDesc('publish_date')->where('status','1');
        return view('notices.show',compact('notices'));
      }


    public function insert_notice(){
        return view('notices.addnotice');
      }

    public function store_notice(Request $request) 
        {
            // $validator = Validator::make($request->all(), [
            //     'file_title'   => 'required|string|max:255',
            //     'file_name'    => 'required|file|mimes:pdf,doc,docx,txt|max:2048', 
            //     'publish_date' => 'required|date',
            //     'status'       => 'required|in:1,0',
            // ]);

            // if ($validator->fails()) {
            //     return redirect()->back()
            //                     ->withErrors($validator)  
            //                     ->withInput();            
            // }

            if($request->hasFile('file_name')){
                $file = $request->file('file_name');
                $filename =$file->getClientOriginalName();
                $file->move(public_path('files/notice/'), $filename);
            } else {
                $filename = null;
            }

            Notice::create([
                'title'        => $request->file_title,
                'file_name'    => $filename,
                'publish_date' => $request->publish_date,
                'status'       => $request->status,
            ]);

            return redirect()->route('notice_index')->with('success', 'Notice Added Successfully!');
        }


      public function edit_notice($id){
            $notice = Notice::findOrFail($id);
            return view('notices.edite', compact('notice'));
        }

      public function update_notice(Request $request, $id)
        {
            $notice = Notice::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'file_title'   => 'required|string|max:255',
              
                'publish_date' => 'required|date',
                'status'       => 'required|in:1,0',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('file_name')) {
                $file = $request->file('file_name');
                $filename = $file->getClientOriginalName();
                $file->move(public_path('files/notice/'), $filename);

                if ($notice->file_name && file_exists(public_path('files/notice/' . $notice->file_name))) {
                    unlink(public_path('files/notice/' . $notice->file_name));
                }
            } else {
                $filename = $notice->file_name; 
            }

            $notice->update([
                'title'        => $request->file_title,
                'file_name'    => $filename,
                'publish_date' => $request->publish_date,
                'status'       => $request->status,
            ]);

            return redirect()->route('notice_index')->with('success', 'Notice Updated Successfully!');
        }

    public function malpractice_add(){
                        $exams = \App\Exam::all();


            return view('nber.malpractice.malpractice_add',compact('exams'));
        }

        public function malpractice_store(Request $request)
        {

            $candidate = \App\Candidate::where('enrolmentno', $request->candidate_enrolment)->first();

            if(!$candidate)
                {
                    return response()->json([
                        'status' => false,
                        'errors' => [
                            'candidate_enrolment' => 'Please fill correct enrolment number'
                        ]
                    ]);
                }

            $fileName = '';
            if($request->hasFile('malpractice_report'))
                {
                    $file = $request->file('malpractice_report');

                    $fileName = time().'_'.$file->getClientOriginalName();

                    $destinationPath = public_path('/files/malpractice');

                    $file->move($destinationPath, $fileName);
                }

            Malpractice::create([
                'title' => $request->title,
                'description' => $request->description,
                'exam_id' => $request->exam_id,
                'candidate_id' => $candidate->id,
                'malpractice_report' => $fileName,
                'clo' => $request->clo,
                'active' =>1
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Malpractice Added Successfully'
            ]);
        }

        public function malpractice_show(){
                    $nber_id = Nberstaff::where('user_id',Auth::user()->id)->first()->nber_id;

           $malpractices = DB::table('malpractices')
            ->join('candidates', 'malpractices.candidate_id', '=', 'candidates.id')
           ->join ('approvedprogrammes','approvedprogrammes.id','=','candidates.approvedprogramme_id')
           ->join('programmes','programmes.id','=','approvedprogrammes.programme_id')
                      ->join('exams','exams.id','=','malpractices.exam_id')

            ->select(
                'malpractices.id',
                'candidates.name',
                'candidates.enrolmentno',
                'malpractices.exam_id',
                'malpractices.description',
                'malpractices.title',
                                'malpractices.clo',

                'malpractices.malpractice_report',
                'malpractices.malpractice_committee_decision',
                'malpractices.candidate_id',
                'malpractices.active',
                'programmes.nber_id',
                'programmes.abbreviation',
                'programmes.code',
                'programmes.name as programmename',
                'exams.name as exam_name'
            )
//    ->where('malpractices.exam_id', $this->exam_id)
            ->where('programmes.nber_id', $this->nber_id)
                        ->get(); 
            return view('nber.malpractice.malpractice_view', compact('malpractices'));
        }


        public function reportToday(Request $request){


                $nber_id = $this->nber_id;
                    if(Auth::user()->id == 88387 || Auth::user()->id == 239776){

                    $where = "
            practicalexams.exam_id = 29
            AND practicalexams.deleted_at IS NULL";

               if ($request->get('nber')) {
            $where .= " AND programmes.nber_id = ".(int)$request->get('nber');
        }
                    }
                    else{
    $where = "
            practicalexams.exam_id = 29
            AND practicalexams.deleted_at IS NULL
            AND programmes.nber_id = '".$nber_id."'

        ";

                    }

    

        if ($request->get('institute')) {
            $where .= " AND practicalexams.institute_id = ".(int)$request->get('institute');
        }

        if ($request->get('faculty')) {
            $where .= " AND practicalexams.faculty_id = ".(int)$request->get('faculty');
        }

          /* ✅ GEO FILTER */
            if ($request->get('geotagged') == "1") {
                $where .= " AND geotaggedphotos.file IS NOT NULL ";
            }

            if ($request->get('geotagged') == "0") {
                $where .= " AND geotaggedphotos.file IS NULL ";
            }

            /* ✅ MARKSHEET FILTER */
            if ($request->get('marksheets') == "1") {
                $where .= " AND awardlisttemplates.marksheet IS NOT NULL ";
            }

            if ($request->get('marksheets') == "0") {
                $where .= " AND awardlisttemplates.marksheet IS NULL ";
            }
 if ($request->get('date')) {
    $date = $request->get('date'); 
        $where .= " AND practicalexams.start_date = '$date'";           
}



                $nber_id = $this->nber_id;
                    $data = DB::select("SELECT
                nbers.name_code,
                practicalexams.slot,
                institutes.name as tti_name,
                institutes.rci_code,
                institutes.coordinate,
                   practicalexams.institute_id,
                practicalexams.faculty_id,


                CONCAT_WS(', ', contactnumber1, contactnumber2) as contact_number,
                practicalexams.start_date,
                practicalexams.end_date,
                                faculties.name AS faculty_name,
                programmes.nber_id,
                faculties.crr_no,
                faculties.mobileno as examiner_number,
                faculties.name as examiner_name,
                GROUP_CONCAT(DISTINCT(subjects.scode)) as scode,
                GROUP_CONCAT(DISTINCT(awardlisttemplates.marksheet)) as marksheet,
                awardlisttemplates.longitude_latitude as longitude_latitude,
                GROUP_CONCAT(DISTINCT(geotaggedphotos.file)) as file_data,
                GROUP_CONCAT(DISTINCT(geotaggedphotos.comment)) as comments,
                max(login_attempts.created_at) as last_log

                FROM
                    practicalexams
                    INNER JOIN
                    practicalexam_subject
                    ON 
                        practicalexam_subject.practicalexam_id = practicalexams.id
                        INNER JOIN faculties on faculties.id=practicalexams.faculty_id
                    INNER JOIN
                    institutes
                    ON 
                        practicalexams.institute_id = institutes.id
                    INNER JOIN
                    programmes
                    ON 
                        practicalexams.programme_id = programmes.id
                    INNER JOIN
                    nbers
                    ON 
                        programmes.nber_id = nbers.id
                INNER JOIN subjects on practicalexam_subject.subject_id=subjects.id
                left JOIN awardlisttemplates on awardlisttemplates.practicalexam_id=practicalexams.id
                left JOIN geotaggedphotos on geotaggedphotos.practicalexam_id=practicalexams.id
                left join login_attempts on login_attempts.user_name=faculties.crr_no
                WHERE
                    $where
                    
                     GROUP BY practicalexams.id");

                    



                //dd($data);
                return view('nber.malpractice.practical_exam_report_today', compact('data'));
            }

            public function theory_paper(Request $request)
                {
                //    dd($request->examday);
                    $query = "
                        SELECT
                           es.id as examsechdule_id,
                            es.description,
                            es.examdate,
                            ec.name,
                            ec.id as exam_center_ids ,
                            ec.code,
                            ap.institute_id,
                            institutes.name AS tti_name,
                            CONCAT_WS(',', ec.contactnumber1, ec.contactnumber2) AS contact_number,
                            GROUP_CONCAT(DISTINCT institutes.rci_code ORDER BY institutes.rci_code) AS rci_code,
                            GROUP_CONCAT(DISTINCT s.scode ORDER BY s.scode) AS subjects,
                             GROUP_CONCAT(DISTINCT ap.filename ORDER BY ap.filename) AS attendance,
                            GROUP_CONCAT(DISTINCT qh.session_id ORDER BY qh.session_id) AS downloaded_sessions,
                            GROUP_CONCAT(DISTINCT qh.agent ORDER BY qh.agent) AS agents,
                            GROUP_CONCAT(DISTINCT l.language ORDER BY l.language) AS languages,
                            COUNT(DISTINCT qh.id) AS download_count
                        FROM examcenters x
                        INNER JOIN externalexamcenters ec
                            ON x.externalexamcenter_id = ec.id
                        INNER JOIN allexampapers ap
                            ON ap.externalexamcenter_id = ec.id
                            AND ap.exam_id = 28
                        INNER JOIN subjects s
                            ON s.id = ap.subject_id
                        INNER JOIN examschedules es
                            ON es.id = ap.examschedule_id
                        LEFT JOIN questionpaperdownloadhistories qh
                            ON ap.examtimetable_id = qh.examtimetable_id
                            AND qh.externalexamcenter_id = ec.id
                        LEFT JOIN languages l
                            ON l.id = qh.language_id
                        INNER JOIN programmes
                            ON s.programme_id = programmes.id
                        INNER JOIN institutes
                            ON institutes.id = ap.institute_id
                        WHERE x.exam_id = 28
                        AND x.nber_id != 8
                       " ;
                 if ($request->has('examday') && $request->examday != '') {

                        $examDays = array_map('intval', explode(',', $request->examday));

                        $query .= " AND es.id IN (" . implode(',', $examDays) . ")";
                    }

                   
                    if ($request->has('examcenter') && $request->examcenter !== '') {
                        $query .= " AND ec.id = ".(int)$request->examcenter;
                    }

                    $query .= "
                        GROUP BY es.id, es.description, ec.id, ec.name, ec.code
                    ";

                     if ($request->has('downloads') && $request->downloads !== '') {
                        if ($request->downloads == '1') {
                           $query .= " HAVING COUNT(DISTINCT qh.id) > 0 ";
                        }

                        if ($request->downloads == '0') {
                             $query .= " HAVING COUNT(DISTINCT qh.id) = 0 ";
                        }
                    }

                    $theory_papers = DB::select($query);
                   // dd( $theory_papers);
                    return view('nber.theory_paper', compact('theory_papers'));
                }


               public function device(Request $request)
                {
                    $query = "
                        SELECT
                            id, access, mac_address, local_ip, public_ip,
                            country, city, latitude, longitude,
                            hostname, username, machine_id, uuid,
                            remote_address, board_serial, os,
                            created_at, updated_at
                        FROM devices
                    ";

                    $params = [];

                    if ($request->has('examcenter') && $request->examcenter != '') {
                        $query .= " WHERE username = ?";
                        $params[] = $request->examcenter;
                    }

                    $query .= " ORDER BY username";

                    $devices = DB::select($query, $params);

                    return view('nber.device', compact('devices'));
                }


}


