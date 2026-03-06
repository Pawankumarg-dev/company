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

class RefreshPayment extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $rid;
    public $oid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($rid,$oid)
    {
        $this->rid = $rid;
        $this->oid = $oid;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $rid = $this->rid;
        $oid = $this->oid;

        $candidate = Candidate::find($cid);
      
    }
}