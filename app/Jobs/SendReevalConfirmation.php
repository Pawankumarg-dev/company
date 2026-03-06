<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Candidate;
use App\Reevaluationapplication;
use App\Nber;



use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

use \Mail;

class SendReevalConfirmation extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $reevaluationfee;
    public $reevaluationapplication;
    public $candidate;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($candidate,$reevaluationapplication,$reevaluationfee)
    {
        $this->reevaluationapplication = $reevaluationapplication;
        $this->candidate = $candidate;
        $this->reevaluationfee = $reevaluationfee;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $reevaluationfee = $this->reevaluationfee;
        $candidate = $this->candidate;
        $reevaluationapplication = $this->reevaluationapplication;
        $nber= Nber::find($candidate->approvedprogramme->programme->nber_id);
        try{
            Mail::send('emails.reevaluationapplication', ['candidate'=>$candidate,'reevaluationapplication' => $reevaluationapplication, 'reevaluationfee'=> $reevaluationfee], function ($m) use ($candidate,$nber,$reevaluationapplication) {
                $m->from('nber.notifications@gmail.com', $nber->name);
                $m->to($nber->email, $candidate->name)->subject('Re-evaluation Application '.$reevaluationapplication->application_number);
                $m->bcc($nber->email,$nber->name);
        });
    }
    catch(\Exception $e){
        echo $e;
    }
    }
}