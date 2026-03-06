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

class GenerateEVCPassword extends Job implements ShouldQueue
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
        $this->createUser();
        //$this->updatepwd();
       }


    public function updatepwd(){
        // $exams  = \App\Examcenter::where('exam_id',27)->groupBy('externalexamcenter_id')->get();
        // $count = 0;
        // foreach($exams as $ec){
            
        //     $count++;
        //     $eec = \App\Externalexamcenter::find($ec->externalexamcenter_id);
        //     if($eec->resend_mail == 2){
        //         echo $count . ' - '  . $eec->code . PHP_EOL;
        //         $password = $this->helperService->generateRandomString(6);
        //         $eec->password = $password;
        //         $eec->save();
        //         $user_id = $eec->user_id;
        //         $user = \App\User::find($user_id);
        //         $user->password = Hash::make($password);
        //         $user->save();
        //         sleep(3);
        //     }
        // }
        // echo ' '. $count . ' Completed';
    }


    public function createUser(){
        $exams = \App\Evaluationcenter::where('exam_id', 27)->get();
        $count = 0;

        foreach ($exams as $ec) {
if (empty($ec->user_id))
{
echo $count . PHP_EOL;
            $count++;
            $password = $this->helperService->generateRandomString(6);
            $user = \App\User::create([
                'username' => '25' . $ec->code,
                'password' => Hash::make($password),
                'confirmed' => 0,
                'confirmation_code' => 123,
                'usertype_id' => 7,
                'email' => $ec->email1
            ]);
            $ec->user_id = $user->id;
            $ec->password = $password;
            $ec->save();



// //deo

//             echo $count . PHP_EOL;
//             $count++;
//             $password = $this->helperService->generateRandomString(6);
//             $user = \App\User::create([
//                 'username' => '25' . $ec->code,
//                 'password' => Hash::make($password),
//                 'confirmed' => 0,
//                 'confirmation_code' => 123,
//                 'usertype_id' => 8,
//                 'email' => $ec->email1
//             ]);
//             $ec->deuser_id = $user->id;
//             $ec->de_password = $password;
//             $ec->save();
}


            
        }
        // $exams  = \App\Examcenter::where('exam_id',27)->where('externalexamcenter_id',4041)->groupBy('externalexamcenter_id')->get();
        // $count = 0;
        // foreach($exams as $ec){
        //     echo $count . PHP_EOL;
        //     $count++;
        //     $eec = \App\Externalexamcenter::find($ec->externalexamcenter_id);
        //     $password = $this->helperService->generateRandomString(6);
        //     echo $eec->password = $password;
        //     $user = \App\User::create([
        //         'username' => '25'.$eec->code,
        //         'password' =>  Hash::make($password),
        //         'confirmed' => 0,
        //         'confirmation_code' => 123,
        //         'usertype_id' => 6,
        //         'email' => $ec->email1
        //     ]);
        //     $eec->user_id = $user->id;
        //     $eec->save();

        // }
        echo ' '. $count . ' Created';
    }

}
