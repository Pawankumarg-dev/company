<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\DBService;
use App\Services\Common\HelperService;
use Illuminate\Support\Facades\Hash;

class EmailController extends Controller
{
    private $helperService;

	public function __construct()
    {
        $this->helperService = new HelperService;
    }

	public function sendEmail(Request $request)

	{

		/* This method will call SendEmailJob Job*/

		dispatch(new SendEmailJob($request));
	}
	public function paractical_exam(Request $request)
	{
		
		// $job = (new \App\Jobs\checkIfPhotoExists())->onQueue('checkPhoto');
        //   $this->dispatch($job);
		//   return "JOB Created";
		 $job = (new \App\Jobs\GenerateEVCPassword())->onQueue('resetpwd');
         $this->dispatch($job);
		//  $job = (new \App\Jobs\GenerateECPassword())->onQueue('demoemail');
        //  $this->dispatch($job);
		  return "JOB Created";
		//  $job = (new \App\Jobs\GeneratePEPassword())->onQueue('gpepwd');
        //  $this->dispatch($job);
		//  return "JOB Created";
		// 	$job = (new \App\Jobs\GenerateJan2025SuppCBIDMarksheet())->onQueue('cbidms');
		// 	$this->dispatch($job);
		// return "CBID";
		// $exams  = \App\Examcenter::where('exam_id',27)->groupBy('externalexamcenter_id')->get();
        // $count = 0;
		// foreach($exams as $ec){
        //     $eec = \App\Externalexamcenter::find($ec->externalexamcenter_id);
        //     $password = $this->helperService->generateRandomString(6);
        //     $eec->password = $password;
        //     $user = \App\User::create([
        //         'username' => 'TE25'.$eec->code,
        //         'password' =>  Hash::make($password),
        //         'confirmed' => 0,
        //         'confirmation_code' => 123,
        //         'usertype_id' => 6,
        //         'email' => $ec->email1
        //     ]);
        //     $eec->user_id = $user->id;
        //     $eec->save();

        // }
        //echo ' '. $count . ' Created';
		//  $job = (new \App\Jobs\GenerateEVCPassword())->onQueue('gpepwd');
        //  $this->dispatch($job);
		//  return "JOB Created";
// 		$paractical = 'SELECT
// 	institutes.rci_code as exam_center, 
// 	courses.`name`,
//     practicalexams.start_date, 
// 	practicalexams.end_date,
//     f.`name` as faculty_name,
//     	f.`address`,
// 		f.email,
// 		f.crr_no as username,
// 		f.password as password
// FROM
// 	practicalexams
//     INNER JOIN
// 		faculties f 
// 	ON
// 		f.id = practicalexams.faculty_id
// 	INNER JOIN
// 		institutes
// 	ON 
// 		practicalexams.institute_id = institutes.id
// 	INNER JOIN
// 		courses
// 	ON 
// 		practicalexams.course_id = courses.id 
// 	WHERE 
// 		practicalexams.start_date is not null 
// 		and  f.id= ' . $request->id;

// 		$paractical =  (new DBService)->fetch($paractical);
		
// 		$nber = \App\Nber::where('id', $request->nber_id)->first();

// 		$to  = $paractical->first()->email;
// 		$logo =  asset('images/') . "/" . $nber->logo;

// 		$nbername = $nber->name . " ( " . $nber->short_name_code . " )";
// 		$nber_email = $nber->email;
// 		$address = $nber->address;
// 		$faculty_name  = $paractical->first()->faculty_name;
// 		$faculty_address = $paractical->first()->address;
// 		$date = \Carbon\Carbon::now()->format('d/m/Y');
// 		$practical_exam_contact_1 = $nber->practical_exam_contact_1;
// 		$practical_exam_contact_2 = $nber->practical_exam_contact_2;
// 		$practical_exam_contact_3 = $nber->practical_exam_contact_3;
// 		$username = $paractical->first()->username;
// 		$password = $paractical->first()->password;
// 		$table = "";

// 		foreach ($paractical as $exam) {
// 			$d = "";
// 			if (!empty($exam->start_date) && $exam->start_date > '2025-00-00') {
// 				$d .= " From " . \Carbon\Carbon::parse($exam->start_date)->format('d/m/Y');
// 			}
// 			if (!empty($exam->end_date && $exam->end_date > '2025-00-00')) {
// 				$d .= " To " . \Carbon\Carbon::parse($exam->end_date)->format('d/m/Y');
// 			}

// 			$table .= "<tr><td>" . $exam->exam_center . "</td><td>" .  $exam->name . "</td><td>" . $d . "</td></tr>";
// 		}
// 		$url = "https://rciregistration.nic.in/rehabcouncil/api/exam_email_send_nber_1.jsp?to=".urlencode($to)."&logo=".urlencode($logo)."&nbername=".urlencode($nbername)."&nber_email=".urlencode($nber_email)."&address=".urlencode($address)."&nber_email=".urlencode($nber_email)."&faculty_name=".urlencode($faculty_name)."&date=".urlencode($date)."&faculty_address=".urlencode($faculty_address)."&practical_exam_contact_1=".urlencode($practical_exam_contact_1)."&practical_exam_contact_2=".urlencode($practical_exam_contact_2)."&practical_exam_contact_3=".urlencode($practical_exam_contact_3)."&table=".urlencode($table)."&username=".urlencode($username)."&password=".urlencode($password);
// 		$is_ok = $this->http_response($url);
// 		return response()->json(['message' => $is_ok]);
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
}
