<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Candidate;
use App\Currentapplication;

use PDF;

use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

use \Mail;

class SendOTPEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $cid;
    public $otp;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cid,$otp)
    {
        $this->cid = $cid;
        $this->otp = $otp;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cid = $this->cid;

        $otp = $this->otp;

        $candidate = Candidate::find($cid);
        try{
        Mail::send('emails.otp', ['candidate'=>$candidate,'otp' => $otp], function ($m) use ($candidate,$otp) {
            $m->from('rcihelp.sje@nic.in', 'RCI NBER');
            $m->cc('rci-depwd@gov.in');
            $m->to($candidate->email, $candidate->name)->subject('RCI NBER - OTP to confirm email address');
            
        });
        echo 'SEND';
    }
    catch(\Exception $e){
        echo "FAILED";
        echo $e;
    }
    }
}
