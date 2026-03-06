<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use File;

class Copyimages extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

	public $filename;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
           try{
	 $source = public_path().'/files/enrolment/photos/'.$this->filename;
            $destination = public_path().'/crr-images/'.$this->filename;
	if(!file_exists($destination)){
		File::copy($source,$destination);
	echo 'Copying ';
}else{
	echo 'Aready Copied';
}
}
Catch(Exaception $e){
	echo $e;
}
    }
}
