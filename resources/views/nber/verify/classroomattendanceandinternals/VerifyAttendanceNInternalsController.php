<?php

namespace App\Http\Controllers\Nber\Verify;

use App\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\Exam\VerifyAttendanceNInternalsService;
use App\Services\Common\Downloadable;
use Illuminate\Support\Facades\DB;
use Session;
use App\Notice;
use Validator;
use Redirect; 
use App\Services\Exam\ApplicantService; 
use Auth;
use App\Programme;
use App\Institute;


class VerifyAttendanceNInternalsController extends Controller
{
    private $exam_id;
    protected $ApplicantService;

    public function __construct(ApplicantService $applicant)
      {
          $this->ApplicantService = $applicant;
          $this->ApplicantService->assignmodel($this->exam_id);
          $this->exam_id = Session::get('exam_id');
      }
    // private $helperService;
    // private $forms;
    // private $type;
    // public function __construct(HelperService $help)
    // {
    //    $this->middleware(['role:nber']);
    //    $this->helperService = $help;
    //    $this->type = app()->request->has('type') ? app()->request->type : 'all';
    //   $this->forms =  (new VerifyAttendanceNInternalsService($this->helperService->getNberORRCIID(),$this->type));
    // }
    // public function index(Request $r){
     
    //   $results = $this->forms->getInstitutes();
    //   $title = $this->forms->getTitle();
    //   $type = $this->forms->getType($r);
    //   return (new Downloadable('nber/verify','classroomattendanceandinternals',compact(
    //     'results',
    //     'title',
    //     'type'
    //   ),$title))->load();
    // }
    // public function show($id){
    //   $attendances = $this->forms->getAttendances($id);
      
    //   $internals = array(
    //     'theory' => array(
    //         'term1' => array(
    //             'subjects' =>  $this->forms->getSubjects($id,1,1),
    //             'marks' =>  $this->forms->getInternalMarks($id,1,1)
    //         ),
    //         'term2' => array(
    //             'subjects' =>  $this->forms->getSubjects($id,1,2),
    //             'marks' =>  $this->forms->getInternalMarks($id,1,2)
    //         )
    //     ),
    //     'practical' => [
    //         'term1' => [
    //             'subjects' =>  $this->forms->getSubjects($id,2,1),
    //             'marks' =>  $this->forms->getInternalMarks($id,2,1)
    //         ],
    //         'term2' => [
    //             'subjects' =>  $this->forms->getSubjects($id,2,2),
    //             'marks' =>  $this->forms->getInternalMarks($id,2,2)
    //         ]
    //     ],
    //   );
    //   //return $internals['theory'];
    //   $approvedprogramme = \App\Approvedprogramme::find($id);
    //   return view('nber/verify/classroomattendanceandinternals/show',compact(
    //       'attendances',
    //       'internals','internals',
    //       'approvedprogramme'
    //   ));
    // }

    
//     public function attendance_index(request $r){
//         $exam_id = $this->exam_id ;
//         $nber_id = Auth::user()->nberstaffs->first()->nber_id;
       
//         //dd($institutes);
      

//          $results = DB::select("
//                    SELECT 
//               approvedprogrammes.id,
//               institutes.rci_code,  
//               institutes.name, 
//               institutes.id as institute_id,
//               CONCAT(contactnumber1,'  ',contactnumber2) as contactnumber, 
//               CONCAT(institutes.email,'  ',institutes.email2) as email, 
//               programmes.abbreviation,
//               programmes.id as program_id ,   
//               academicyears.year
//           FROM approvedprogrammes 
//           INNER JOIN academicyears 
//               ON academicyears.id = approvedprogrammes.academicyear_id
//               INNER JOIN institutes 
//               ON institutes.id = approvedprogrammes.institute_id
//           INNER JOIN programmes 
//               ON programmes.id = approvedprogrammes.programme_id
//           INNER JOIN candidates on candidates.approvedprogramme_id = approvedprogrammes.id
//           INNER join attendances on attendances.candidate_id = candidates.id
//          where attendances.exam_id =$this->exam_id and programmes.nber_id=$nber_id
//           GROUP BY approvedprogrammes.id order by institutes.rci_code 
//   ");
    
//      //dd($results);
//       return view('nber.verify.classroomattendanceandinternals.attandanceVerification',compact('results'));
//     }

public function attendance_index(Request $r)
{
    ini_set('max_execution_time', 300);
    $exam_id = $this->exam_id;
    $nber_id = Auth::user()->nberstaffs->first()->nber_id;
    $institute_id = $r->institute;
    $status = $r->status; 

    $query = "
        SELECT 
            approvedprogrammes.id,
            institutes.rci_code,  
            institutes.name, 
            programmes.numberofterms,
            institutes.id as institute_id,
            CONCAT(contactnumber1,'  ',contactnumber2) as contactnumber, 
            CONCAT(institutes.email,'  ',institutes.email2) as email, 
            programmes.abbreviation,
            programmes.id as program_id ,   
            academicyears.year,
            attendances.enable_edit
        FROM approvedprogrammes 
        INNER JOIN academicyears 
            ON academicyears.id = approvedprogrammes.academicyear_id
        INNER JOIN institutes 
            ON institutes.id = approvedprogrammes.institute_id
        INNER JOIN programmes 
            ON programmes.id = approvedprogrammes.programme_id
        INNER JOIN candidates 
            ON candidates.approvedprogramme_id = approvedprogrammes.id
        INNER JOIN attendances 
            ON attendances.candidate_id = candidates.id
        WHERE attendances.exam_id = ? 
        AND programmes.nber_id = ?
    ";

    $bindings = [$exam_id, $nber_id];

    if (!empty($institute_id)) {
        $query .= " AND institutes.id = ?";
        $bindings[] = $institute_id;
    }

    if ($status !== null && $status !== '') {
        $query .= " AND attendances.enable_edit = ?";
        $bindings[] = $status;
    }

    $query .= " GROUP BY approvedprogrammes.id 
                ORDER BY institutes.rci_code";

    $results = DB::select($query, $bindings);

    return view('nber.verify.classroomattendanceandinternals.attandanceVerification', compact('results'));
}


    public function attendance_details($program_id ,$id){
        ini_set('max_execution_time', 300);
        $exam_id = $this->exam_id ;

        $internal_details = DB::select("
        select approvedprogrammes.id , candidates.enrolmentno , attendances.enable_edit, candidates.name  ,  programmes.numberofterms as terms, candidates.contactnumber , candidates.email , programmes.abbreviation  ,  attendances.document_t , attendances.document_p ,attendances.attendance_t , attendances.attendance_p   from approvedprogrammes
        INNER JOIN candidates on candidates.approvedprogramme_id =approvedprogrammes.id
        INNER JOIN attendances on attendances.candidate_id = candidates.id and attendances.exam_id =".$exam_id."
        INNER JOIN programmes on programmes.id = approvedprogrammes.programme_id
        WHERE attendances.exam_id =".$exam_id."  and approvedprogrammes.id =".$program_id." GROUP BY candidates.id

        ");
        return view('nber.verify.classroomattendanceandinternals.attendanceInternal' , compact('internal_details'));
    }

    public function verify_attendance($program_id, $term_id)
      {
         $exam_id = $this->exam_id ;
         //dd($exam_id);
          DB::table('attendances')
            ->whereIn('id', function ($query) use($program_id , $term_id ,$exam_id){
                $query->select('attendances.id')
                    ->from('attendances')
                    ->join('candidates', 'candidates.id', '=', 'attendances.candidate_id')
                    ->join('approvedprogrammes', 'approvedprogrammes.id', '=', 'candidates.approvedprogramme_id')
                    ->join('programmes','programmes.id', '=' ,'approvedprogrammes.programme_id')
                    ->where('attendances.exam_id', $exam_id)
                    ->where('approvedprogrammes.id', $program_id)
                    ->where('programmes.numberofterms', $term_id);
            })
            ->update(['enable_edit' => 1]);

          return redirect()->route('verifyattnninternal')
                 ->with([
                     'message' => 'Verify Successfully'
                 ]);
      }


      public function not_verify_attendance($program_id, $term_id)
      {
         $exam_id = $this->exam_id ;
         //dd($exam_id);
          DB::table('attendances')
            ->whereIn('id', function ($query) use($program_id , $term_id ,$exam_id){
                $query->select('attendances.id')
                    ->from('attendances')
                    ->join('candidates', 'candidates.id', '=', 'attendances.candidate_id')
                    ->join('approvedprogrammes', 'approvedprogrammes.id', '=', 'candidates.approvedprogramme_id')
                    ->join('programmes','programmes.id', '=' ,'approvedprogrammes.programme_id')
                    ->where('attendances.exam_id', $exam_id)
                    ->where('approvedprogrammes.id', $program_id)
                    ->where('programmes.numberofterms', $term_id);
            })
            ->update(['enable_edit' => 0]);

          return redirect()->route('verifyattnninternal')
                 ->with([
                     'message' => 'Not Verify'
                 ]);
      }

    

    public function index(){
        $notices =Notice::all()->sortByDesc('publish_date')->where('status','1');
        return view('notices.show',compact('notices'));
      }


    public function insert(){
        return view('notices.addnotice');
      }

    public function store(Request $request) 
        {
            $validator = Validator::make($request->all(), [
                'file_title'   => 'required|string|max:255',
                'file_name'    => 'required|file|mimes:pdf,doc,docx,txt|max:2048', 
                'publish_date' => 'required|date',
                'status'       => 'required|in:1,0',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                                ->withErrors($validator)  
                                ->withInput();            
            }

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


      public function edit($id){
            $notice = Notice::findOrFail($id);
            return view('notices.edite', compact('notice'));
        }

      public function update(Request $request, $id)
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

}
