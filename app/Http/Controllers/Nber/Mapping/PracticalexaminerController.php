<?php

namespace App\Http\Controllers\Nber\Mapping;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\Mapping\PracticalExaminerMapping;
use App\Services\Common\Downloadable;
use PDF;
use Auth;
use App\Services\DBService;
use Session;
use DB;
use Illuminate\Support\Facades\Hash;


class PracticalexaminerController extends Controller
{
    private $helperService;
    private $page;
  private $nber_id;
  private $exam_id;
    public function __construct(HelperService $help)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $help;
        $type = app()->request->has('type') ? app()->request->type : 'all';
        $this->page =  (new PracticalExaminerMapping($type));
            $this->helperService = new HelperService();
            $this->exam_id = 28;

                    $this->nber_id = $this->helperService->getNberID();

    }
    public function index(Request $r){
      set_time_limit(300);
      ini_set('memory_limit','-1');
      ini_set('max_execution_time',300);
      $results = $this->page->getPracticalExaminers();
      $title = $this->page->getTitle();
      $type = $this->page->getType();
      $faculties = $this->page->getListofFaculties();
      //return $faculties;
      return (new Downloadable('nber/mapping','practicalexaminers',compact(
        'results',
        'title',
        'type',
        'faculties'
      ),$title))->load();
    }

    public function store(Request $r){
      //$programme_ids =  \App\Subject::whereIn('id',$r->subjects)->pluck('programme_id')->unique();
      // Session::put('messages','Closed');
      // return back();
      // $existing =  \App\Practicalexam::where('institute_id',$r->institute_id)->where('faculty_id',$r->faculty_id)->where('exam_id',27)->get();
      // if($existing->count() > 0 ){
      //   foreach($existing as $ex){
      //     $ex->start_date = $r->start_date;
      //     $ex->end_date = $r->end_date;
      //     $ex->save();
      //     if(!is_null($ex->start_date)){
      //       Session::put('messages','Already emailed the password to the examiner. Updated the dates');
      //       return back();
      //     }
      //   }
      // }
      // foreach($existing as $ex){
      //   DB::table('practicalexam_subject')->where('practicalexam_id', $ex->id)->delete();
      //   $ex->delete();
      // }
      if($r->has('subjects')){
        foreach($r->subjects as $s){
          $subject = \App\Subject::find($s);
          $pe = \App\Practicalexam::where('institute_id',$r->institute_id)->where('faculty_id',$r->faculty_id)->where('exam_id',28)->where('programme_id',$subject->programme_id)->first();
          $progamme = \App\Programme::find($subject->programme_id);
          if(is_null($pe)){
            $pe = \App\Practicalexam::create([
              'institute_id' => $r->institute_id,
              'faculty_id' => $r->faculty_id,
              'exam_id' => $this->exam_id,
              'programme_id' => $subject->programme_id,
              'course_id' => $progamme->course_id,
              'start_date' => $r->start_date,
              'end_date' => $r->end_date
            ]);
          }else{
              $pe->start_date = $r->start_date;
              $pe->end_date = $r->end_date;
              $pe->save();
          }
          $pe->subjects()->attach($s);
        }
        Session::put('messages','Updated');
      }else{
        Session::put('messages','Removed');
      }
      return back();
    }


    public function institute_course(){

        $examname = \App\Exam::find($this->exam_id)->name;

        $eid = $this->exam_id; // exam ID
$nid = $this->nber_id;  // nber_id

$institutes = DB::table('approvedprogrammes as ap')
    ->join('candidates', 'candidates.approvedprogramme_id', '=', 'ap.id')
    ->join('allapplicants', function($join) use ($eid) {
        $join->on('allapplicants.candidate_id', '=', 'candidates.id')
             ->where('allapplicants.exam_id', '=', $eid);
    })
    ->join('allapplications', 'allapplications.applicant_id', '=', 'allapplicants.id')
    ->join('subjects', function($join) {
        $join->on('subjects.id', '=', 'allapplications.subject_id')
             ->where('subjects.subjecttype_id', '=', 2)
             ->where('subjects.is_external', '=', 1);
    })
    ->join('programmes as p', 'p.id', '=', 'ap.programme_id')
    ->join('institutes as i', 'i.id', '=', 'ap.institute_id')
    ->select(
        'i.id as institute_id',
        'i.rci_code',
        'i.name',
         DB::raw("count(allapplications.candidate_id) as total_candidate"),

    DB::raw("
        COUNT(
            CASE 
                WHEN allapplications.mark_ex >= 0 
                     OR allapplications.attendance_ex IN (1,2)
                THEN allapplications.candidate_id 
            END
        ) as marks_entered
    "),
DB::raw("GROUP_CONCAT(DISTINCT CONCAT(p.id, ':', p.abbreviation) SEPARATOR ',') as programmes")
    )
    ->where('p.nber_id', '=', $nid)
    ->groupBy('ap.institute_id')
    ->orderBy('i.rci_code')
    ->get();

return view('nber.mapping.practical-inst-list',compact('institutes','examname'));

    }

 public function practicalexammappingadd(Request $request)
    {
        $eid = $this->exam_id; // exam ID
        $exam= \App\Exam::find($this->exam_id);


$nid = $this->nber_id;  // nber_id
        $pid = $request->input('pid'); // optional filter by programme
        $institute_id = $request->input('institute_id'); // optional filter by institute

        $institutes = DB::table('approvedprogrammes as ap')
            ->join('candidates', 'candidates.approvedprogramme_id', '=', 'ap.id')
            ->join('allapplicants', function($join) use ($eid) {
                $join->on('allapplicants.candidate_id', '=', 'candidates.id')
                     ->where('allapplicants.exam_id', '=', $eid);
            })
            ->join('allapplications', 'allapplications.applicant_id', '=', 'allapplicants.id')
            ->join('subjects', function($join) {
                $join->on('subjects.id', '=', 'allapplications.subject_id')
                     ->where('subjects.subjecttype_id', '=', 2)
                     ->where('subjects.is_external', '=', 1);
            })
            ->join('programmes as p', 'p.id', '=', 'ap.programme_id')
            ->join('institutes as i', 'i.id', '=', 'ap.institute_id')
            ->select(
                'i.id as institute_id',
                'i.rci_code',
                'i.name',
        DB::raw('count(distinct allapplicants.candidate_id) as total_candidates'),
                DB::raw("GROUP_CONCAT(DISTINCT CONCAT(p.id, ':', p.abbreviation) SEPARATOR ',') as programmes"),
                DB::raw('GROUP_CONCAT(DISTINCT IF(subjects.syear = 1, CONCAT(subjects.id, ":", subjects.scode), NULL)) as year_1_subjects'),
                DB::raw('GROUP_CONCAT(DISTINCT IF(subjects.syear = 2, CONCAT(subjects.id, ":", subjects.scode), NULL)) as year_2_subjects')
            )
            ->where('p.nber_id', '=', $nid)
            ->where('p.id', $pid)
            ->where('i.id', $institute_id)
            ->groupBy('ap.institute_id')
            ->orderBy('i.rci_code')
            ->get();
 $faculties = $this->page->getListofFaculties();

  
    $min_date = '2026-03-30';
    $max_date = '2026-04-06'; // last day of current month



 $mapped = DB::table('practicalexams')
    ->leftjoin('practicalexam_subject', 'practicalexams.id', '=', 'practicalexam_subject.practicalexam_id')
    ->leftjoin('subjects', 'subjects.id', '=', 'practicalexam_subject.subject_id')
    ->join('faculties', 'practicalexams.faculty_id', '=', 'faculties.id')
    ->where('practicalexams.exam_id', $eid) // ✅ FIXED
    ->where('practicalexams.institute_id', $institute_id) // ✅ FIXED
    ->where('practicalexams.programme_id', $pid) // ✅ FIXED
    ->whereNull('practicalexams.deleted_at') 
    ->select(
        'faculties.id as faculty_id',
        'faculties.name',
        'faculties.mobileno',
        'faculties.email',
        'faculties.crr_no',
        'practicalexams.start_date',
        'practicalexams.end_date',
        'practicalexams.id as del_id',
        DB::raw('GROUP_CONCAT(subjects.scode SEPARATOR ", ") as scode'),
        DB::raw('GROUP_CONCAT(subjects.sname SEPARATOR ", ") as sname'),
        DB::raw('GROUP_CONCAT(distinct(subjects.id)) as subject_id')
    )
    ->groupBy('faculties.id')
    ->get();

    //dd($faculties);
        return view('nber.mapping.practical-course-subject', compact('institutes','faculties','min_date','max_date','mapped'));
    }


 public function practicalexammappingmail(Request $request){

//  $practicalexaminers = \App\Practicalexam::where('exam_id',28)
//     ->pluck('faculty_id')
//     ->unique();

// foreach ($practicalexaminers as $pe) {

//     $faculty = \App\Faculty::find($pe);


$faculty = \App\Faculty::find($request->id);


    if ($faculty) {

        $characters = '123456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $password = substr(str_shuffle($characters), 0, 10);
        $user = \App\User::where('username', $faculty->crr_no)->first();
        if (is_null($faculty->user_id) && is_null($user)) {
            $user = \App\User::create([
                'username' => $faculty->crr_no,
                'password' => Hash::make($password),
                'confirmed' => 0,
                'confirmation_code' => '123',
                'usertype_id' => 14,
                'email' => $faculty->email
            ]);
                $faculty->user_id = $user->id;
                $faculty->save();

        }
        if ($user && $user->usertype_id == 14) {
            if(is_null($faculty->password)){
            $user->password = Hash::make($password);
            $user->save();
            $faculty->emailed = 0;
            $faculty->password = $password;
            }
            $faculty->user_id = $user->id;
            $faculty->save();
            // echo "Saved " . $faculty->crr_no . "<br>";
        }


    }



$paractical = 'SELECT
	institutes.rci_code as exam_center, 
	courses.`name`,
    practicalexams.start_date, 
	practicalexams.end_date,
    f.`name` as faculty_name,
    	f.`address`,
		f.email,
		f.crr_no as username,
		f.password as password
FROM
	practicalexams
    INNER JOIN
		faculties f 
	ON
		f.id = practicalexams.faculty_id
	INNER JOIN
		institutes
	ON 
		practicalexams.institute_id = institutes.id
	INNER JOIN
		courses
	ON 
		practicalexams.course_id = courses.id 
	WHERE 
		practicalexams.start_date is not null and practicalexams.exam_id='.$this->exam_id.'
		and  f.id= ' . $request->id;

		$paractical =  (new DBService)->fetch($paractical);
		
		$nber = \App\Nber::where('id', $this->nber_id)->first();

		$to  = $paractical->first()->email;
		$logo =  asset('images/') . "/" . $nber->logo;

		$nbername = $nber->name . " ( " . $nber->short_name_code . " )";
		$nber_email = $nber->email;
		$address = $nber->address;
		$faculty_name  = $paractical->first()->faculty_name;
		$faculty_address = $paractical->first()->address;
		$date = \Carbon\Carbon::now()->format('d/m/Y');
		$practical_exam_contact_1 = $nber->practical_exam_contact_1;
		$practical_exam_contact_2 = $nber->practical_exam_contact_2;
		$practical_exam_contact_3 = $nber->practical_exam_contact_3;
		$username = $paractical->first()->username;
		$password = $paractical->first()->password;
		$table = "";

		foreach ($paractical as $exam) {
			$d = "";
			if (!empty($exam->start_date) && $exam->start_date > '2025-00-00') {
				$d .= " From " . \Carbon\Carbon::parse($exam->start_date)->format('d/m/Y');
			}
			if (!empty($exam->end_date && $exam->end_date > '2025-00-00')) {
				$d .= " To " . \Carbon\Carbon::parse($exam->end_date)->format('d/m/Y');
			}

			$table .= "<tr><td>" . $exam->exam_center . "</td><td>" .  $exam->name . "</td><td>" . $d . "</td></tr>";
		}
		$url = "https://rciregistration.nic.in/rehabcouncil/api/exam_email_send_nber_1.jsp?to=".urlencode($to)."&logo=".urlencode($logo)."&nbername=".urlencode($nbername)."&nber_email=".urlencode($nber_email)."&address=".urlencode($address)."&nber_email=".urlencode($nber_email)."&faculty_name=".urlencode($faculty_name)."&date=".urlencode($date)."&faculty_address=".urlencode($faculty_address)."&practical_exam_contact_1=".urlencode($practical_exam_contact_1)."&practical_exam_contact_2=".urlencode($practical_exam_contact_2)."&practical_exam_contact_3=".urlencode($practical_exam_contact_3)."&table=".urlencode($table)."&username=".urlencode($username)."&password=".urlencode($password);
		$is_ok = $this->http_response($url);

// }
        return response()->json(['status' => 'success', 'message' => 'mail sent']);

 }




    // Save mapping
  public function savePracticalMapping(Request $r)
{
    return response()->json(['message' => 'Closed, Exam date is over']);

//     $data = $r->json()->all(); // Get JSON data from AJAX
//     $facultyId = $data['faculty_id'] ?? null;
//     $startDate = $data['start_date'] ?? null;
//     $endDate = $data['end_date'] ?? null;
               
//     $subjectsYear1 = $data['subjects_year1'] ?? [];
//     $subjectsYear2 = $data['subjects_year2'] ?? [];

//     // Function to save subjects per institute and year
//     $saveSubjects = function($subjectsArray, $year) use ($facultyId, $startDate, $endDate) {
   

//         foreach ($subjectsArray as $instituteId => $subjectIds) {
//             foreach ($subjectIds as $subjectId) {
//                 $subject = \App\Subject::find($subjectId);
//                 if (!$subject) continue;
// $eid = $this->exam_id;

//                 $pe = \App\Practicalexam::where('institute_id', $instituteId)
//                         ->where('faculty_id', $facultyId)
//                         ->where('exam_id',$eid)
//                         ->where('programme_id', $subject->programme_id)
//                         ->first();

//                 $programme = \App\Programme::find($subject->programme_id);

//                 if (is_null($pe)) {
//                     $pe = \App\Practicalexam::create([
//                         'institute_id' => $instituteId,
//                         'faculty_id' => $facultyId,
//                         'exam_id' => $eid,
//                         'programme_id' => $subject->programme_id,
//                         'course_id' => $programme->course_id,
//                         'start_date' => $startDate,
//                         'end_date' => $endDate,
//                     ]);
//                 } else {
//                     $pe->start_date = $startDate;
//                     $pe->end_date = $endDate;
//                     $pe->save();
//                 }
                

//                     $pe->subjects()->attach($subjectId);
                
//             }
//         }
//     };

//     // Save 1st year subjects
//     $saveSubjects($subjectsYear1, 1);

//     // Save 2nd year subjects
//     $saveSubjects($subjectsYear2, 2);

//     return response()->json(['message' => 'Practical mapping saved successfully!']);
}


public function PracticalMappingRemove(Request $request)
    {
        $item = \App\Practicalexam::find($request->id);
        if (!$item) {
            return response()->json(['status' => 'error', 'message' => 'Item not found'], 404);
        }
        $item->reason = $request->reason;
        $item->save();
        $item->delete();
        $item = \App\PracticalexamSubject::where('practicalexam_id', $request->id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Item removed successfully']);
    }

    public function http_response($url, $status = null, $wait = 3)

{
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


    public function practicalverify_list()
    {

$examId =28;

$data = DB::table('practicalexams')
    ->select(
        'institutes.name as institute_name',
        'institutes.rci_code',
        DB::raw('GROUP_CONCAT(DISTINCT subjects.scode) as subjects'),
        'awardlisttemplates.exam_date',
        'awardlisttemplates.marksheet',
        'programmes.abbreviation',
        'faculties.crr_no',
        'faculties.id as faculty_id',
        'faculties.name as faculty_name',
        'faculties.mobileno',
        'faculties.email',
        'awardlisttemplates.id',
        'awardlisttemplates.verified'

    )
    ->join('faculties', 'faculties.id', '=', 'practicalexams.faculty_id')
    ->join('awardlisttemplates', function($join) {
        $join->on('practicalexams.id', '=', 'awardlisttemplates.practicalexam_id')
             ->on('practicalexams.practicalexaminer_id', '=', 'awardlisttemplates.practicalexaminer_id');
    })
    ->join('institutes', 'practicalexams.institute_id', '=', 'institutes.id')
    ->join('approvedprogrammes', 'awardlisttemplates.approvedprogramme_id', '=', 'approvedprogrammes.id')
    ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
    ->join('candidates', 'approvedprogrammes.id', '=', 'candidates.approvedprogramme_id')
    ->join('allapplications', 'candidates.id', '=', 'allapplications.candidate_id')
    ->join('awardlisttemplate_subject', 'awardlisttemplates.id', '=', 'awardlisttemplate_subject.awardlisttemplate_id')
    ->join('subjects', function($join) {
        $join->on('awardlisttemplate_subject.subject_id', '=', 'subjects.id')
             ->on('allapplications.subject_id', '=', 'subjects.id');
    })
    ->where('practicalexams.exam_id', $examId)
    ->where('programmes.nber_id', $this->nber_id)
    ->groupBy('awardlisttemplates.id')
    ->get();
   // dd($data);
    return view('nber.verify.practicalexam-list',compact('data'));
    }
        
   public function practicalverify_details($id)
    {
        
    // $examId = $this->exam_id; 
    $examId =28;
    $data = DB::table('awardlisttemplates')
        ->join('awardlisttemplate_subject', 'awardlisttemplates.id', '=', 'awardlisttemplate_subject.awardlisttemplate_id')
        ->join('candidates', 'awardlisttemplates.approvedprogramme_id', '=', 'candidates.approvedprogramme_id')
        ->join('allapplications', 'candidates.id', '=', 'allapplications.candidate_id')
        ->join('subjects', function ($join) {
            $join->on('awardlisttemplate_subject.subject_id', '=', 'subjects.id')
                ->on('allapplications.subject_id', '=', 'subjects.id');
        })
        ->where('awardlisttemplates.id', $id)
        ->where('allapplications.exam_id', $examId)
        ->select(
            DB::raw("GROUP_CONCAT(CONCAT(subjects.id, ':', allapplications.mark_ex) ORDER BY subjects.id SEPARATOR ',') as subject_marks"),
            DB::raw("GROUP_CONCAT(DISTINCT subjects.id) as subjects"),
            'allapplications.attendance_ex',
            'awardlisttemplates.marksheet',
            'candidates.enrolmentno',
            'candidates.name as candidate_name',
            'awardlisttemplates.id',
            'awardlisttemplates.verified'

        )
        ->groupBy('allapplications.candidate_id', 'allapplications.attendance_ex')
        ->get();


    $subjectIds = explode(',', $data[0]->subjects);

    $subjects = \App\Subject::whereIn('id', $subjectIds)->get();

        return view('nber.verify.practicalexam-details', compact('data', 'subjects'));
    }
 public function verify($id)
    {
        $mark = \App\Awardlisttemplate::findOrFail($id);
        $mark->verified = 1;
        $mark->save();
        return redirect()->back()->with('success', 'Student marks verified successfully!');
    }

 public function notverify($id)
    {
        $mark = \App\Awardlisttemplate::findOrFail($id);
        $mark->verified = 2;
        $mark->save();
        return redirect()->back()->with('success', 'Student marks not verified!');
    }


}