<?php

namespace App\Http\Controllers\Nber\Verify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\Exam\VerifyAttendanceNInternalsService;
use App\Services\Common\Downloadable;
use Session;
use DB;
use Auth;

class VerifyAttendanceNInternalsController extends Controller
{
    private $helperService;
     private $forms;
     private $type;
          private $nber_id;
          private $exam_id;

    public function __construct(HelperService $help)
    {
       $this->middleware(['role:nber']);
       $this->helperService = $help;
       $this->type = app()->request->has('type') ? app()->request->type : 'all';
      $this->forms =  (new VerifyAttendanceNInternalsService($this->helperService->getNberORRCIID(),$this->type));
              $this->nber_id = $this->helperService->getNberID();
        $this->exam_id = Session::get('exam_id');
    }
    public function index(Request $r){
      
      $results = $this->forms->getInstitutes();
      $title = $this->forms->getTitle();
      $type = $this->forms->getType($r);
      return (new Downloadable('nber/verify','classroomattendanceandinternals',compact(
        'results',
        'title',
        'type'
      ),$title))->load();
    }
    public function show($id){
      $attendances = $this->forms->getAttendances($id);
      
      $internals = array(
        'theory' => array(
            'term1' => array(
                'subjects' =>  $this->forms->getSubjects($id,1,1),
                'marks' =>  $this->forms->getInternalMarks($id,1,1)
            ),
            'term2' => array(
                'subjects' =>  $this->forms->getSubjects($id,1,2),
                'marks' =>  $this->forms->getInternalMarks($id,1,2)
            )
        ),
        'practical' => [
            'term1' => [
                'subjects' =>  $this->forms->getSubjects($id,2,1),
                'marks' =>  $this->forms->getInternalMarks($id,2,1)
            ],
            'term2' => [
                'subjects' =>  $this->forms->getSubjects($id,2,2),
                'marks' =>  $this->forms->getInternalMarks($id,2,2)
            ]
        ],
      );
      //return $internals['theory'];
      $approvedprogramme = \App\Approvedprogramme::find($id);
      return view('nber/verify/classroomattendanceandinternals/show',compact(
          'attendances',
          'internals','internals',
          'approvedprogramme'
      ));
    }

public function showInternalMarksheet(Request $request)
{



    $query = DB::table('internalmarksheets')
    ->join('approvedprogrammes', 'internalmarksheets.approvedprogramme_id', '=', 'approvedprogrammes.id')
    ->join('institutes', 'approvedprogrammes.institute_id', '=', 'institutes.id')
    ->join('academicyears', 'approvedprogrammes.academicyear_id', '=', 'academicyears.id')
    ->join('programmes', 'approvedprogrammes.programme_id', '=', 'programmes.id')
    ->where('internalmarksheets.exam_id', $this->exam_id)
    ->where('programmes.nber_id', $this->nber_id);

if ($request->has('institute_id') && $request->institute_id != '') {
    $query->where('institutes.id', $request->institute_id);
}

if ($request->has('status_id') && $request->status_id != '') {
    if($request->status_id==0){
        $query->where(function ($q) {
    $q->where('internalmarksheets.verified', 0)
      ->orWhereNull('internalmarksheets.verified',2)
            ->orWhereNull('internalmarksheets.verified');

});
    }else{
    $query->where('internalmarksheets.verified', $request->status_id);

    }

}else{
$query->where(function ($q) {
    $q->where('internalmarksheets.verified', 0)
      ->orWhereNull('internalmarksheets.verified',2)
            ->orWhereNull('internalmarksheets.verified');

});

}

$records = $query
    ->groupBy('approvedprogrammes.id')
    ->select(
        'institutes.rci_code',
        'institutes.name',
        'institutes.id as institute_id',
        'academicyears.year',
        'programmes.abbreviation',
        'programmes.numberofterms',
        DB::raw('GROUP_CONCAT(internalmarksheets.id) as marksheet_ids'),
        'internalmarksheets.approvedprogramme_id',
        'internalmarksheets.subjecttype_id',
        'internalmarksheets.term',

                DB::raw('GROUP_CONCAT(CONCAT(internalmarksheets.term, ":", internalmarksheets.subjecttype_id) ORDER BY internalmarksheets.term, internalmarksheets.subjecttype_id SEPARATOR ",") as term_subjecttypes')

    )
    ->orderBy('institutes.rci_code', 'asc') 
    ->get();

$institutes = DB::table('institutes')
    ->orderBy('rci_code', 'asc')
    ->get();

    return view('nber.verify.internalmarksheet.index', compact('records'));
}

public function showInternalMarksheet_details(Request $request)
{
$approvedprogrammeId = $request->approvedprogramme_id;
$term = $request->term;
$subjecttype_id = $request->subjecttype_id;
$exam_id =$this->exam_id;

    $datas = DB::table('newinternalmarks')
    ->join('subjects', 'newinternalmarks.subject_id', '=', 'subjects.id')
        ->join('candidates', 'candidates.id', '=', 'newinternalmarks.candidate_id')
    ->join('internalmarksheets', function($join) use ($subjecttype_id, $term, $exam_id) {
        $join->on('internalmarksheets.approvedprogramme_id', '=', 'newinternalmarks.approvedprogramme_id') // column to column
             ->where('internalmarksheets.subjecttype_id', '=', $subjecttype_id)
             ->where('internalmarksheets.term', '=', $term)
             ->where('internalmarksheets.exam_id', '=', $exam_id);
            //              ->where(function($query) {
            //      $query->whereIn('internalmarksheets.verified', [0, 2])
            //            ->orWhereNull('internalmarksheets.verified');
            //  });


    })
    ->where([
        ['newinternalmarks.approvedprogramme_id', $approvedprogrammeId],
        ['subjects.subjecttype_id', $subjecttype_id],
        ['subjects.syear', $term],
        ['newinternalmarks.exam_id', $exam_id],
    ])
    ->select(
        'newinternalmarks.candidate_id',
         'candidates.name',
            'candidates.enrolmentno',
            'internalmarksheets.filename',
            'internalmarksheets.id as verify_id',

        DB::raw("GROUP_CONCAT(
                    CONCAT(subjects.id, ':', newinternalmarks.internal)
                    ORDER BY subjects.id
                    SEPARATOR ','
                ) as subject_marks")
    )
    ->groupBy('newinternalmarks.candidate_id')
        ->orderBy('candidates.enrolmentno', 'asc')
    ->get();

$subjects = DB::table('approvedprogrammes')
    ->join('programmes', 'approvedprogrammes.programme_id', '=', 'programmes.id')
    ->join('subjects', 'programmes.id', '=', 'subjects.programme_id')
    
    ->where('approvedprogrammes.id', $request->approvedprogramme_id)
    ->where('subjects.syear', $term)
    
    ->where('subjects.is_internal', 1)
    ->where('subjects.subjecttype_id', $subjecttype_id)
    ->select(
        'subjects.id as subject_id',
        'subjects.scode',
        'subjects.sname',
        'subjects.imin_marks',
        'subjects.imax_marks',
        'subjects.emin_marks',
        'subjects.emax_marks',
        'subjects.subjecttype_id'
    )
    ->get();
 $Internalmarksheet = \App\Internalmarksheet::where('internalmarksheets.subjecttype_id', $subjecttype_id)->where('approvedprogramme_id', $request->approvedprogramme_id)
    ->where('internalmarksheets.term', $term)->where('internalmarksheets.exam_id', $exam_id)->first();


    return view('nber.verify.internalmarksheet.details', compact('datas','subjects','Internalmarksheet'));


}

public function InternalMarksheetverify(Request $request)
{


    $record = \App\Internalmarksheet::findOrFail($request->id);
    $record->verified = $request->verify_id;;
    $record->save();
    if ($request->verify_id == 1) {
    Session::put('messages','Marks verified successfully.');
    } else {
    Session::put('messages','Marks updated request submitted.');
    }
    return redirect('/nber/internal-marksheet');

}
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

    public function nber_dashboard(Request $request)
            {
                $exam_id = $this->exam_id;
                $nber_id = Auth::user()->nberstaffs->first()->nber_id;

                $course = $request->course;
                $state = $request->states;

                $query = "
                    SELECT 
                        programmes.abbreviation, 
                        programmes.id as programme_id,
                        subjects.id as subject_id,
                        subjects.sname,
                        states.id as state_id,
                        states.state_name,
                        SUM(CASE WHEN subjects.subjecttype_id = 1 THEN 1 ELSE 0 END) AS theory_students,
                        SUM(CASE WHEN subjects.subjecttype_id = 2 THEN 1 ELSE 0 END) AS practical_students,
                        COUNT(allapplications.candidate_id) AS student_count  
                    FROM approvedprogrammes
                    INNER JOIN programmes 
                        ON programmes.id = approvedprogrammes.programme_id
                    INNER JOIN candidates
                        ON candidates.approvedprogramme_id = approvedprogrammes.id
                    INNER JOIN allapplicants
                        ON allapplicants.candidate_id = candidates.id
                    INNER JOIN subjects
                        ON subjects.programme_id = programmes.id
                    INNER JOIN states
                    ON states.id = candidates.state_id
                    INNER JOIN allapplications 
                        ON allapplications.applicant_id = allapplicants.id 
                        AND subjects.id = allapplications.subject_id
                    WHERE allapplications.exam_id = ?
                    AND allapplications.nber_id = ?
                ";

                $params = [$exam_id, $nber_id];

                if (!empty($course)) {
                    $query .= " AND programmes.id = ?";
                    $params[] = $course;
                }
                // State Filter
                if (!empty($state)) {
                    $query .= " AND states.id = ?";
                    $params[] = $state;
                }

                $query .= " GROUP BY  programmes.abbreviation, programmes.id, subjects.sname , states.id ORDER BY programmes.abbreviation ASC";

                $nber_details = DB::select($query, $params);

                return view('notices.nberDashbaord', compact('nber_details'));
            }



}
