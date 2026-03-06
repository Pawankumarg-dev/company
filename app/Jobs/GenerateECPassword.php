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

class GenerateECPassword extends Job implements ShouldQueue
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
        
        $examcenters  = \App\Examcenter::where('exam_id',27)->groupBy('externalexamcenter_id')->get();
        foreach($examcenters as $ec){
            $eec  = \App\Externalexamcenter::find($ec->externalexamcenter_id);
            if($eec->resend_mail == 3){
                $to = $eec->email1;
                $contactname = $eec->principal_name;
                $code = $eec->code;
                $address = $eec->name;
                $username = $eec->user->username;
                $password = $eec->password;
                $url = "https://rciregistration.nic.in/rehabcouncil/api/examcenter_email_send_nber.jsp?to=".urlencode($to)."&contactname=".urlencode($contactname)."&code=".urlencode($code)."&address=".urlencode($address)."&username=".urlencode($username)."&password=".urlencode($password);    
                $is_ok = $this->http_response($url);
                echo $is_ok.PHP_EOL;
                echo $is_ok; 
                echo $eec->code . " ".PHP_EOL;
            }
        }
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
