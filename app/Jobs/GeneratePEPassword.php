<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Candidate;
use App\Newresult;
use App\Newapplication;
use PDF;
use App\Services\Result\SupplementaryMarksheetService;
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use App\Services\Common\HelperService;
use Illuminate\Support\Facades\Hash;
use  App\Services\DBService;

class GeneratePEPassword extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    private $helperService;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->helperService = new HelperService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$this->resetPwd();
        $this->generatePassword();
        $this->emailloop();
        $this->sanitizeTable();
       }
       public function resetPwd(){
        $faculties = \App\Faculty::whereNotNull('password')->where('emailed','>',16)->get();
        foreach($faculties as $f){
            echo " Saving .. ". $f->crr_no;
            $user = \App\User::find($f->user_id);
            $anothercrrno = \App\User::where('username',$f->crr_no)->first();
            if(!is_null($anothercrrno) && $anothercrrno->id != $user->id){
                $f->user_id = $anothercrrno->id;
                $f->save();
                $user = $anothercrrno;
            }
            $user->usertype_id = 14;
            $user->username = $f->crr_no;
            $user->password = Hash::make($f->password);
            $user->save();
        }
        echo "DONE";
       }
    public function sanitizeTable(){
        $faculties = \App\Faculty::whereNotNull('password')->where('emailed',18)->get();
       echo $faculties->count();
       echo "Starting..";
       foreach($faculties as $f){
            if(!is_null($f->user_id)){
                $users = \App\User::where('id',$f->user_id)->get();
                foreach($users as $u){
                    $u->delete();
                }
            }
            $emails = \App\User::where('username',$f->email)->whereIn('usertype_id',[4,10,13])->first();
            if(!is_null($emails)){
                $emails->delete();
            }
            $emails = \App\User::where('email',$f->email)->whereIn('usertype_id',[4,10,13])->first();
            if(!is_null($emails)){
                $emails->delete();
            }
            $crrno = \App\User::where('username',$f->crr_no)->first();
            if(!is_null($crrno)){
                $crrno->delete();
            }
            $user = \App\User::create([
                'username' => $f->crr_no,
                'password' =>  Hash::make($f->password),
                'confirmed' => 0,
                'confirmation_code' => 123,
                'usertype_id' => 14,
                'email' => $f->email
            ]);
            $f->user_id = $user->id;
            $f->save();
            echo "Recreated" . $f->crr_no;
        }
        echo "Fixed..";
    }

    public function emailloop(){
        $practicalexaminers  = \App\Practicalexam::where('exam_id',27)->where('start_date','>','2025-01-01')->pluck('faculty_id')->unique()->toArray();
        $count = 0;
        foreach($practicalexaminers as $pe){
            $faculty = \App\Faculty::find($pe);
            echo $count;
            if(!is_null($faculty)){
                $course_id = \App\Practicalexam::where('exam_id',27)->where('start_date','>','2025-01-01')->where('faculty_id',$pe)->where('course_id','>',0)->first()->course_id;
                echo $pe . ' ';
                if($course_id == 23 || $course_id == 7){
                    $nber_id = \App\Practicalexam::where('exam_id',27)->where('start_date','>','2025-01-01')->where('faculty_id',$pe)->where('course_id','>',0)->first()->institute->idd_under_nber_id;
                }else{
                    $nber_id = \App\Practicalexam::where('exam_id',27)->where('start_date','>','2025-01-01')->where('faculty_id',$pe)->where('course_id','>',0)->first()->course->nber_id;
                }
                
                //echo $count;
                $faculty->nber_id = $nber_id;
                $faculty->save();
                if( !is_null($faculty->password) && $faculty->emailed < 2 && $nber_id > 0){
                    $this->email($faculty->id,$nber_id);
                    $faculty->emailed = 17;
                    $faculty->save();
                    echo "Emailed";
                $count += 1;

                }else{
                    echo "Not emailed";
                }
            }
        }
        echo ' '. $count . ' Emailed';
    }

    public function email($id,$nber_id){
        $paractical = 'SELECT
        practicalexams.id,
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
		practicalexams.start_date is not null 
		and  f.id= ' . $id;

		$paractical =  (new DBService)->fetch($paractical);
		
		$nber = \App\Nber::where('id', $nber_id)->first();

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
            $practicalexam = \App\Practicalexam::find($exam->id);
            $practicalexam->emailed = 5;
            $practicalexam->save();
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
		echo $is_ok;
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
    public function generatePassword(){
        $practicalexaminers  = \App\Practicalexam::where('exam_id',27)->pluck('faculty_id')->unique()->toArray();
        $practicalexams =  \App\Practicalexam::where('exam_id',27)->get();
        foreach($practicalexams as $prex){
            $prex->emailed = 1;
            $prex->save();
        }
        foreach($practicalexaminers as $pe){
            $faculty = \App\Faculty::find($pe);

            if(!is_null($faculty) && is_null($faculty->password) && $faculty->emailed < 2){
                $password = $this->helperService->generateRandomString(6);
                if(is_null($faculty->user_id)){
                    $emailalready = \App\User::where('username',$faculty->email)->first();
                    $crr_already = \App\User::where('username',$faculty->crr_no)->first();
                    if(is_null($emailalready)){
                        if(is_null($crr_already)){
                            $user = \App\User::create([
                                'username' => $faculty->crr_no,
                                'password' =>  Hash::make($password),
                                'confirmed' => 0,
                                'confirmation_code' => 123,
                                'usertype_id' => 14,
                                'email' => $faculty->email
                            ]);
                        }else{
                            $user = $crr_already;
                        }
                    }else{
                        $user = $emailalready;
                    }
                    $faculty->user_id = $user->id;
                    $faculty->save();
                }
                $user = \App\User::find($faculty->user_id);
                $user->password = Hash::make($password);
                $user->usertype_id = 14;
                $user->save();
                $faculty->password = $password;
                $faculty->user_id = $user->id;
                $faculty->emailed = 18;
                $faculty->save();
                
                echo "Saved ". $faculty->crr_no;
            }

        }
    }

}
