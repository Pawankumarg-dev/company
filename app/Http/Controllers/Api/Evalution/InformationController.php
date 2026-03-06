<?php

namespace App\Http\Controllers\Api\Evalution;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Subject;
use App\Programme;
use App\Approvedprogramme;
use App\Academicyear;
use App\Allapplicant;
use App\Institute;
use App\User;
use Validator;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use PDF;
use App\Utils\CustomPDF;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB as FacadesDB;
use App\Services\Common\HelperService;
use App\Token;
use App\Evaluationcenter;
use App\Services\DBService;
use Illuminate\Support\Str;
use Auth;
class InformationController extends Controller
{
    private $helperService;
    private $exam_id;
    public function __construct() {
        $this->helperService = new HelperService;
        $this->exam_id = $this->helperService->getScheduledExamID();
    }
    public function uploadImage(Request $r){
        try{
            $file = $r->answerbooklet;
            $application = \App\Allapplication::find($r->allapplication_id);
            $scan = \App\Answerbookletscan::where('allapplication_id',$r->allapplication_id)->first();
            if(is_null($scan)){
                return response()->json("failed");
            }
            if($scan->pages == $r->page){
                $scan->uploaded = 1;
                $scan->save();
            }
            move_uploaded_file($file,"files/answerbooklets/".$this->exam_id."/".$application->candidate_id."_".$application->subject_id."_".$application->id."_".$r->page.".png");
        }catch(\Exception $e){
            return response()->json("failed");
        }
        return response()->json('success');
    }

    public function updateVerification(Request $r){
        try{
            $ansbookletscanned = \App\Answerbookletscan::where('allapplication_id',$r->allapplication_id)->first();
            if(is_null($ansbookletscanned)){
                return response()->json('failed');
            }else{
                $ansbookletscanned->verified = 1;
                $ansbookletscanned->save();
            }
        }catch(\Error $e){
            return response()->json('failed');
        }
        return response()->json('success');
    }

    public function updateScanned(Request $r){
        try{
            $ansbookletscanned = \App\Answerbookletscan::where('allapplication_id',$r->allapplication_id)->first();
            if(is_null($ansbookletscanned)){
                \App\Answerbookletscan::create([
                    'allapplication_id' => $r->allapplication_id,
                    'evaluationcenter_id' => $r->evaluationcenter_id,
                    'scanned' => 1,
                    'pages' => $r->pages,
                    'verified' => 0,
                    'uploaded' => 0
                ]);
            }else{
                $ansbookletscanned->scanned = $r->scanned;
                $ansbookletscanned->verified = 0;
                $ansbookletscanned->uploaded = 0;
                $ansbookletscanned->pages = $r->pages;
                $ansbookletscanned->save();
            }
        }catch(\Error $e){
            return response()->json('failed');
        }
        return response()->json('success');
    }
    public function login(Request $request)
    {
        
        $errors = [];
        try {
            if (!isset($request->username)) {
                $errors['username'] = 'Please input a valid username';
            }
            if (!isset($request->password)) {
                $errors['password'] = 'Please input a valid password';  
            }
    
            if (count($errors) > 0) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'Validation failed.',
                    'errors' => $errors
                ], 200);
            }
    
            $user = User::where('username', $request->username)
                        ->where('usertype_id', 7)
                        ->first();

                        $data = [
                            'username' => $request->username,
                            'password' => $request->password,
                        ];
                    
                        if (!$user || !Auth::attempt($data)) {

          //      if (!$user || !Hash::check($request->password, $user->password)) {
                $errors['Invalid User'] = 'Wrong user credentials';
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'Validation failed.',
                    'errors' => $errors
                ], 200); 
            }
            $evaluationcenter = DB::table('evaluationcenters')
            ->join('evaluationcenterdetails', 'evaluationcenterdetails.evaluationcenter_id', '=', 'evaluationcenters.id')
            ->where('evaluationcenterdetails.exam_id', '=', $this->exam_id)
            ->select('evaluationcenters.id')
            ->where('evaluationcenters.user_id', '=', $user->id)
            ->first();


            $evaluationcenter = Evaluationcenter::where('user_id', $user->id)->first();
            if (!$evaluationcenter) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'Evaluation center not found for the user.'
                ], 200);
            }
            $expiry = Carbon::now()->addDay(); 
            $token =rand(100000, 999999);

    
            Token::create([
                'user_id' => $user->id,
                'evaluationcenter_id' => $evaluationcenter->id,
                'token' => $token,
                'expiry' => $expiry,
            ]);
            return new JsonResponse([
                'status' => 'success',
                'token' => $token,
                'expires_at' => $expiry->toDateTimeString(),
                'evaluationcenter_id' => $evaluationcenter->id
            ], 200);
    
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 200); 
        }
    }
    public function studentlist(Request $r){
        $sql = 'select 
                    a.id,
                    i.id as institute_id,
                    eec.id as externalexamcenter_id,
                    s.id as subject_id,
                    c.id as candidate_id,
                    if( 
                        ep.attn_verification != 1,
                        "Attn Verification Pending",
                        if(
                        ab.scanned = 1,
                        "Scanned",
                        "Pending"
                        )
                    ) as scanning_status,
                    if(
                        ab.verified = 1,
                        "Verified",
                        "Pending"
                    ) as verification_status,
                    
                    if(
                        ab.uploaded = 1, 
                        "Uploaded",
                        "Pending"
                    ) as upload_status,
                    c.name as student_name,
                    c.enrolmentno,
                    a.answerbooklet_no,
                    s.scode as subjectcode,
                    eec.code as examcenter_code,
                    i.rci_code as institute_code, 
                    p.abbreviation as course,
                    eec.name as examcenter,
                    i.name as institute,
                    s.sname as subject,
                    ifnull(ab.pages,0) as pages
                from
                    allapplications a 
                inner join 
                    candidates c 
                on 
                    c.id = a.candidate_id
                inner join	
                    approvedprogrammes ap 
                on 
                    ap.id = c.approvedprogramme_id
                inner join
                    allexampapers ep
                on 
                    ep.approvedprogramme_id = ap.id and ep.subject_id = a.subject_id 
                inner join
                    institutes i
                on 
                    i.id = ap.institute_id
                inner join
                    externalexamcenters eec
                on
                    eec.id = ep.externalexamcenter_id
                inner join
                    evaluationcenterdetails evd
                on
                    evd.externalexamcenter_id = eec.id
                inner join
                    programmes p
                on
                    p.id  = ap.programme_id
                inner join
                    subjects s 
                on
                    s.id = a.subject_id
                left join
                    answerbookletscans ab
                on 
                    ab.allapplication_id = a.id
                where 
                    a.blocked = 0
                and
                    ep.examschedule_id = '. $r->examschedule_id .'
                and
                    a.attendance_ex = 1
                and
                    ep.externalexamcenter_id != 2697 
                and
                (
                    (
                    '. $r->evaluationcenter_id .' = 64 and
                        (evd.evaluationcenter_id = '. $r->evaluationcenter_id  .' or ap.programme_id = 57  )
                    ) or 
                    (
                    '. $r->evaluationcenter_id .' = 65 and
                        (evd.evaluationcenter_id = '. $r->evaluationcenter_id  .' and  ap.programme_id != 57  )

                    )
                )    ' ;
                if($r->has('scanned')){
                    $sql .= ' AND ab.scanned = 1 and ab.uploaded = 0 ';
                }
                $sql .='
                order by
                    eec.code, i.rci_code , p.course_id, c.enrolmentno;';
    
        $scheduldes = (new DBService())->fetch($sql);
        return response()->json($scheduldes);

    }

    public function schedules(){
        $sql = '
        SELECT 
            id,
            concat(examdate," - ", starttime, " to " , endtime , " - " , description) as name  
        FROM 
            examschedules
        WHERE
            exam_id = ' . $this->exam_id  . '
        AND
            examtype_id = 1
        ORDER BY
            examdate,
            starttime,
            endtime
        ';
        $scheduldes = (new DBService())->fetch($sql);
        return response()->json($scheduldes);
    }

    public function examcenters(Request $r){
        $sql = '
        SELECT 
            eec.id,
            concat(eec.code, " - " , eec.name) as name  
        FROM
            allapplications a 
        INNER JOIN
            candidates c 
        ON  
            c.id = a.candidate_id
        INNER JOIN
            approvedprogrammes ap
        ON
            ap.id = c.approvedprogramme_id
        INNER JOIN 
            allexampapers ep
        ON 
            a.subject_id = ep.subject_id and ap.id = ep.approvedprogramme_id
        INNER JOIN
            externalexamcenters eec
        ON
            eec.id = ep.externalexamcenter_id
        inner join
            evaluationcenterdetails evd
        on
             evd.externalexamcenter_id = eec.id
        WHERE
            a.attendance_ex = 1
        AND
            a.blocked = 0
        AND
            ep.exam_id = ' . $this->exam_id  . '
        AND
            ep.examschedule_id = '. $r->examschedule_id .'
        AND
            ep.externalexamcenter_id != 2697
        and
            (
                (
                    '. $r->evaluationcenter_id .' = 64 and
                    (evd.evaluationcenter_id = '. $r->evaluationcenter_id  .' or ap.programme_id = 57  )
                ) or 
                (
                    '. $r->evaluationcenter_id .' = 65 and
                    (evd.evaluationcenter_id = '. $r->evaluationcenter_id  .' and  ap.programme_id != 57  )

                )
            )    
        GROUP BY
            eec.id
        ORDER BY
            eec.code;
        ';
        $examcenters = (new DBService())->fetch($sql);
        return response()->json($examcenters);
    }
    
    public function institutes(Request $r)
    {
        $sql = '
            SELECT
                i.id,
                concat(i.rci_code, " - " , i.name) as name
            FROM
                 allapplications a 
            INNER JOIN
                candidates c 
            ON  
                c.id = a.candidate_id
            INNER JOIN
                approvedprogrammes ap
            ON
                ap.id = c.approvedprogramme_id
            INNER JOIN 
                allexampapers ep
            ON 
                a.subject_id = ep.subject_id and ap.id = ep.approvedprogramme_id
            INNER JOIN
                institutes i
            ON
                i.id = ep.institute_id
            WHERE
                a.attendance_ex = 1
            AND
                a.blocked != 1
            AND
                ep.examschedule_id =  ' . $r->examschedule_id .'
            AND
                ep.externalexamcenter_id = ' . $r->externalexamcenter_id .' 
            GROUP BY
                i.rci_code;
        ';
        $data = (new DBService())->fetch($sql);
        return response()->json($data);
    }
    public function candidates(Request $r){
        $sql = '
        
             SELECT
                aa.id,
                concat(c.name, " ( PRN: " , c.enrolmentno , ") ") as name
            FROM
                allexampapers ep
			INNER JOIN
				subjects s
			ON
				s.id = ep.subject_id
			INNER JOIN
				allapplications aa
			ON
				aa.subject_id = s.id
			INNER JOIN
				candidates c 
			ON 
				c.id = aa.candidate_id
            INNER JOIN
				approvedprogrammes ap
			ON
				ap.id =c.approvedprogramme_id AND ep.approvedprogramme_id = ap.id
            WHERE
                ep.examschedule_id =  ' . $r->examschedule_id .'
            AND
                ep.externalexamcenter_id =   ' . $r->externalexamcenter_id .'
			AND
				ap.institute_id = ' . $r->institute_id .' 
			AND 
				ep.subject_id = ' . $r->subject_id .' 
            AND
                aa.blocked = 0 
            AND
                aa.attendance_ex = 1
            ORDER BY
                c.enrolmentno
                ';
            
            $data = (new DBService())->fetch($sql);
            return response()->json($data);
    }
     
    public function subjects(Request $r)
    {
        $sql = '
            SELECT
                s.id,
                concat(p.abbreviation, " (" , y.year , " Batch) - " , s.scode, " - " , s.sname) as name
            FROM
                 allapplications a 
            INNER JOIN
                candidates c 
            ON  
                c.id = a.candidate_id
            INNER JOIN
                approvedprogrammes ap
            ON
                ap.id = c.approvedprogramme_id
            INNER JOIN 
                allexampapers ep
            ON 
                a.subject_id = ep.subject_id and ap.id = ep.approvedprogramme_id
            INNER JOIN
				subjects s
			ON
				s.id = ep.subject_id
			inner join
                evaluationcenterdetails evd
            on
                evd.externalexamcenter_id = ep.externalexamcenter_id
			INNER JOIN
				programmes p 
			ON 
				p.id = ap.programme_id
			INNER JOIN
				academicyears y
			ON
				y.id = ap.academicyear_id
            INNER JOIN
                institutes i
            ON
                i.id = ep.institute_id
            WHERE
                a.blocked = 0
            AND
                a.attendance_ex = 1
            AND
                ep.examschedule_id =  ' . $r->examschedule_id .'
            AND
                ep.externalexamcenter_id =  ' . $r->externalexamcenter_id .'
			AND
				ep.institute_id = ' . $r->institute_id .' 
            and
            (
                (
                    '. $r->evaluationcenter_id .' = 64 and
                    (evd.evaluationcenter_id = '. $r->evaluationcenter_id  .' or p.id = 57  )
                ) or 
                (
                    '. $r->evaluationcenter_id .' = 65 and
                    (evd.evaluationcenter_id = '. $r->evaluationcenter_id  .' and  p.id != 57  )

                )
            )    
                
            GROUP BY 
                ep.approvedprogramme_id
                ';

        $data = (new DBService())->fetch($sql);
        return response()->json($data);
    }

    public function course(Request $request)
    {

        $errors = [];
        if (!isset($request->institute_id) || !is_numeric($request->institute_id)) {
            $errors['institute_id'] = 'Please select institute';
        }
        if (count($errors) > 0) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $errors
            ], 422); 
        }
        try {
            $programmes = DB::table('allapplicants')
        ->join('candidates', 'candidates.id', '=', 'allapplicants.candidate_id')
        ->join('approvedprogrammes', 'approvedprogrammes.id', '=', 'candidates.approvedprogramme_id')
        ->join('programmes', 'programmes.id', '=', 'approvedprogrammes.programme_id')
        ->select('programmes.id', 'programmes.abbreviation')
        ->where('approvedprogrammes.institute_id', '=', $request->institute_id)
        ->groupBy('programmes.id')
        ->get();
    
            if (empty($programmes)) {  
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'No data found.'
                ], 404); 
            }
    
            return new JsonResponse([
                'status' => 'success',
                'data' => $programmes
            ], 200); 
    
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500); 
        }
    }
   

    public function batch(Request $request)
    {
        $errors = [];
        if (!isset($request->institute_id) || !is_numeric($request->institute_id)) {
            $errors['institute_id'] = 'Please select institute';
        }
    
        if (!isset($request->programme_id) || !is_numeric($request->programme_id)) {
            $errors['programme_id'] = 'Please select Course';
        }
    
        if (count($errors) > 0) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $errors
            ], 422); 
        }
        try {
            $acadmicyear = DB::table('allapplicants')
            ->join('candidates', 'candidates.id', '=', 'allapplicants.candidate_id')
            ->join('approvedprogrammes', 'approvedprogrammes.id', '=', 'candidates.approvedprogramme_id')
            ->join('academicyears', 'academicyears.id', '=', 'approvedprogrammes.academicyear_id')
            ->select('academicyears.id', 'academicyears.year')
            ->where('approvedprogrammes.institute_id', '=', $request->institute_id)
            ->where('approvedprogrammes.programme_id', '=', $request->programme_id)
            ->groupBy('academicyears.id')
            ->get();
    
            if (empty($acadmicyear)) {  
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'No data found.'
                ], 404); 
            }
    
            return new JsonResponse([
                'status' => 'success',
                'data' => $acadmicyear
            ], 200); 
    
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500); 
        }
    }

    public function enrollment(Request $request)
    {
        $errors = [];
        if (!isset($request->institute_id) || !is_numeric($request->institute_id)) {
            $errors['institute_id'] = 'Please select institute';
        }
    
        if (!isset($request->programme_id) || !is_numeric($request->programme_id)) {
            $errors['programme_id'] = 'Please select Course';
        }
    
        if (!isset($request->academicyear_id) || !is_numeric($request->academicyear_id)) {
            $errors['academicyear_id'] = 'Please select Acadmic Year';
        }
    
        if (count($errors) > 0) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $errors
            ], 422); 
        }
    
        try {
            $enrollment = DB::table('allapplicants')
                ->join('candidates', 'candidates.id', '=', 'allapplicants.candidate_id')
                ->join('approvedprogrammes', 'approvedprogrammes.id', '=', 'candidates.approvedprogramme_id')
                ->select('candidates.id', 'candidates.enrolmentno')
                ->where('approvedprogrammes.institute_id', '=', $request->institute_id)
                ->where('approvedprogrammes.programme_id', '=', $request->programme_id)
                ->where('approvedprogrammes.academicyear_id', '=', $request->academicyear_id)
                ->groupBy('candidates.id')
                ->get(); 
    
            if (empty($enrollment)) {  
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'No enrollments found for the specified criteria.'
                ], 404); 
            }
    
            return new JsonResponse([
                'status' => 'success',
                'data' => $enrollment
            ], 200); 
    
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500); 
        }
    }


    public function generatePDF()
    {
        // Define the path to save the PDF file
        $file = public_path('files/b.pdf'); // Ensure the 'files' folder exists inside 'public'
        
        // Create an instance of the custom PDF class
        $pdf = new CustomPDF();
        $pdf->SetCreator('TCPDF');
        $pdf->SetAuthor('Youdnklklfk;ewfk/nlewflkn;k/ek/kehwhhie;jk;jjjgir Name');
        $pdf->SetTitle('PDF with Watermark');
        
        // Set up the page (using your custom setupPage method)
        $pdf->setupPage(); 
        
        // Add content to the page
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, 'This is a test PDF with a watermark.', 0, 1, 'C');
        
        // Generate the PDF output (get the raw content)
        $output = $pdf->output(); 
        file_put_contents($file, $output);
        unset($pdf);
        unset($output); 
        // Debugging: Check if the output is correct (remove this after debugging)
        // dd($output); // Uncomment this if you want to see the raw output data in your browser
    
        // Save the PDF to the file system (public/files/b.pdf)
        // file_put_contents($file, $output); 
    
        // Optionally, return the PDF to the browser
        return response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="watermarked_pdf.pdf"',
        ]);
    }
    

   public function get_result(Request $request)
{
    $key = $request->input('key'); // You may validate this for security/auth
    if ($key!='123') {
        return response()->json(['message' => 'Something Went wrong'], 400);
    }
    $dob = $request->input('dob');

    if (!$dob) {
        return response()->json(['message' => 'Date of Birth is required'], 400);
    }


    $enrollmentNo = $request->input('enrollment');

    if (!$enrollmentNo) {
        return response()->json(['message' => 'Enrollment number is required'], 400);
    }
        $candidate = DB::table('allresults')
    ->join('candidates', 'allresults.candidate_id', '=', 'candidates.id')
    ->leftjoin('lgstates as sp', 'sp.id', '=', 'candidates.pstate_id')
    ->leftjoin('lgstates as sc', 'sc.id', '=', 'candidates.state_id')
    ->leftjoin('districts as dp', 'dp.id', '=', 'candidates.pdistrict_id')
    ->leftjoin('districts as dc', 'dc.id', '=', 'candidates.district_id')
    ->join('genders', 'candidates.gender_id', '=', 'genders.id')
    ->join('communities', 'candidates.community_id', '=', 'communities.id')
    ->join('approvedprogrammes', 'candidates.approvedprogramme_id', '=', 'approvedprogrammes.id')
    ->join('institutes', 'approvedprogrammes.institute_id', '=', 'institutes.id')
    ->join('exams', 'exams.id', '=', 'allresults.exam_id')
    ->join('programmes', 'approvedprogrammes.programme_id', '=', 'programmes.id')
    ->join('nbers', 'programmes.nber_id', '=', 'nbers.id')

    ->join('courses', 'programmes.course_id', '=', 'courses.id')
    ->where('candidates.enrolmentno', $enrollmentNo)
        ->where('candidates.dob', $dob)

    ->where('allresults.final_year_result', 1)
    ->select(
        'candidates.name',
        'candidates.fathername',
        'candidates.mothername',
        'candidates.enrolmentno',
        'candidates.contactnumber',
        'candidates.email',
        'candidates.aadhar',
        'candidates.paddress',
        'candidates.ppincode',
        'candidates.pvillage_id',
        'sp.state_code as pstate_id',
        'dp.districtCode as pdistrict_id',
        'candidates.address',
        'candidates.village_id',
        'sc.state_code as state_id',
        'dc.districtCode as district_id',
        'candidates.pincode',
        'candidates.dob',
        'genders.gender',
        'communities.community',
        'candidates.photo',
        'courses.code as course_code',
        'institutes.rci_code',
        'nbers.name_code as nber',
        DB::raw('YEAR(exams.date) as passing_year')
    )->limit(1)
    ->get();

    
    if (!$candidate) {

        $candidate = DB::table('allresults')
    ->join('candidates', 'allresults.candidate_id', '=', 'candidates.id')
    ->leftjoin('lgstates as sp', 'sp.id', '=', 'candidates.pstate_id')
    ->leftjoin('lgstates as sc', 'sc.id', '=', 'candidates.state_id')
    ->leftjoin('districts as dp', 'dp.id', '=', 'candidates.pdistrict_id')
    ->leftjoin('districts as dc', 'dc.id', '=', 'candidates.district_id')
    ->join('genders', 'candidates.gender_id', '=', 'genders.id')
    ->join('communities', 'candidates.community_id', '=', 'communities.id')
    ->join('approvedprogrammes', 'candidates.approvedprogramme_id', '=', 'approvedprogrammes.id')
    ->join('institutes', 'approvedprogrammes.institute_id', '=', 'institutes.id')
    ->join('exams', 'exams.id', '=', 'allresults.exam_id')
    ->join('programmes', 'approvedprogrammes.programme_id', '=', 'programmes.id')
    ->join('nbers', 'programmes.nber_id', '=', 'nbers.id')

    ->join('courses', 'programmes.course_id', '=', 'courses.id')
    ->where('candidates.enrolmentno', $enrollmentNo)
        ->where('candidates.dob', $dob)

    ->where('allresults.final_year_result_re', 1)
    ->select(
        'candidates.name',
        'candidates.fathername',
        'candidates.mothername',
        'candidates.enrolmentno',
        'candidates.contactnumber',
        'candidates.email',
        'candidates.aadhar',
        'candidates.paddress',
        'candidates.ppincode',
        'candidates.pvillage_id',
        'sp.state_code as pstate_id',
        'dp.districtCode as pdistrict_id',
        'candidates.address',
        'candidates.village_id',
        'sc.state_code as state_id',
        'dc.districtCode as district_id',
        'candidates.pincode',
        'candidates.dob',
        'genders.gender',
        'communities.community',
        'candidates.photo',
        'courses.code as course_code',
        'institutes.rci_code',
        'nbers.name_code as nber',
        DB::raw('YEAR(exams.date) as passing_year')
    )->limit(1)
    ->get();

    if (!$candidate) {


        return response()->json(['message' => 'Candidate not found'], 404);
    }
    }

    return response()->json([
        'success' => true,
        'data' => $candidate
    ]);
}


public function http_response($url, $status = null, $wait = 3)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Get response body as well
    curl_setopt($ch, CURLOPT_HEADER, TRUE);  // Include header in the output
    curl_setopt($ch, CURLOPT_NOBODY, FALSE); // Get body of the response
    curl_setopt($ch, CURLOPT_TIMEOUT, $wait); // Set timeout

    // Execute curl request and get the full response (headers + body)
    $response = curl_exec($ch);
    
    if(curl_errno($ch)) {
        // If there's an error in the curl request
        $error_message = curl_error($ch);
        curl_close($ch);
        return ['status' => 'error', 'message' => $error_message];
    }

    // Separate the headers and body (first response line, headers, and then the body)
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($response, 0, $header_size);
    $body = substr($response, $header_size);

    // Get HTTP status code
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    // Return an array with status code, headers, and body
    return [
        'http_code' => $httpCode,
        'headers' => $headers,
        'body' => $body
    ];
}



public function get_crr(Request $request)
{
    $enrollmentNo = $request->input('enrollment');
    $dob = $request->input('dob');

    
    $url = "https://rciregistration.nic.in/rehabcouncil/api/genrate_nber_crr-data.jsp?enrollment=" . urlencode($enrollmentNo)."&dob=". urlencode($dob);
    $response = $this->http_response($url);
    if ($response['http_code'] == 200) {
        $decodedBody = json_decode($response['body'], true); // Decode the JSON response
        if (isset($decodedBody['error'])) {
                return back()->with('error', $decodedBody['error']);

            // return response()->json([
            //     'status' => 'error',
            //     'message' => $decodedBody['error']
            // ], 400); 
        } else {

        $enrollmentNo= $decodedBody['enrollment'];
        $crr_no= $decodedBody['crr_no'];
        $candidate = \App\Candidate::where('enrolmentno', $enrollmentNo)->where('dob',$dob)->first();
        $candidate->crr =$crr_no;
        $candidate->save();
        return back()->with('messages', 'Your CRR No. is Generated. Please Download it');

            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Data processed successfully',
            //     'data' => $decodedBody 
            // ], 200); 
        }
    } else {
    return back()->with('error', 'Try after Some time');

    }
}





}