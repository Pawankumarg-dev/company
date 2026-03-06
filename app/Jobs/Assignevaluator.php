<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Subjectofevaluator;
use Illuminate\Support\Facades\Hash;

class Assignevaluator extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

	public $exam_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($exam_id)
    {
        $this->exam_id = $exam_id;
    }

    /**
     * Execute the job.
     * 
     * @return void
     */

     public function generateRandomString($max) {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXY3456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $max; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function handle()
    {
        ini_set('memory_limit','-1');
        // $password = '';
        // $evaluators = Subjectofevaluator::where('exam_id',$this->exam_id)->get();
        // foreach($evaluators as $e){
        //     if(is_null($e->evaluator->password) && $e->evaluator->email != ''){
        //         $password = $this->generateRandomString(6);
        //         $user  = \App\User::where('username',$e->evaluator->email)->first();
        //         if(is_null($user)){
        //             $user = \App\User::create([
        //                 'username'=>$e->evaluator->email,
        //                 'password'=>Hash::make($password),
        //                 'usertype_id'=>13,
        //                 'confirmed'=>1
        //             ]);
        //         }else{
        //             $user->password = Hash::make($password);
        //             $user->usertype_id = 13;
        //             $user->save();
        //         }
        //         echo "Saving passwrod for ". $e->evaluator . PHP_EOL;
        //         $evaluator = \App\Evaluator::find($e->evaluator_id);
        //         $evaluator->user_id = $user->id;
        //         $evaluator->password = $password;
        //         $evaluator->save();
        //     }
        // }
        // echo "Password generated";
        $evaluators = Subjectofevaluator::where('exam_id',$this->exam_id)->groupBy('subject_id')->groupBy('language_id')->get();
        echo $evaluators->count();
        foreach($evaluators as $e){
           // if($e->subject_id ==  637 || true){
            echo " Assigning for subject_id ". $e->subject_id . PHP_EOL; 
            $eid = 0;
            $eps= \App\Allexampaper::where('subject_id',$e->subject_id)->groupBy('approvedprogramme_id')->get();
            
            foreach($eps as $ep){
                //if($ep->approvedprogramme_id == 3848 || true){
                $applications = \App\Allapplication::whereHas('candidate',function($c) use($ep){
                    $c->where('approvedprogramme_id',$ep->approvedprogramme_id);
                })->where('blocked',0)->where('attendance_ex',1)
                ->where('subject_id',$e->subject_id)
                ->whereNull('evaluator_id')
                ->where('language_id',$e->language_id)
                ->get();
                if($applications->count()> 0){
                    $evaluator = \App\Subjectofevaluator::where('id','>',$eid)->where('exam_id',$this->exam_id)->where('subject_id',$e->subject_id)->where('language_id',$e->language_id)->orderBy('id')->first();
                    if(is_null($evaluator) ||is_null($evaluator->evaluator_id)){
                        $eid = 0;
                        $evaluator = \App\Subjectofevaluator::where('id','>',$eid)->where('exam_id',$this->exam_id)->where('subject_id',$e->subject_id)->where('language_id',$e->language_id)->orderBy('id')->first();
                    }else{
                        $eid = $evaluator->id;
                    }
                    echo "E: ". $evaluator. PHP_EOL;
                    foreach($applications as $appln){
                        $appln->evaluator_id = $evaluator->evaluator_id;
                        $appln->save();
                    }
                }else{
                    echo "Count is zero" . PHP_EOL;
                }
              //  }

            }
          //  }
        }

        // $evaluators = \App\Evaluator::all();
        // foreach($evaluators as $e){
        //     if(!is_null($e->user_id)){
        //         $user = \App\User::find($e->user_id);
        //         $user->password = Hash::make($e->password);
        //         $user->save();
        //     }
        // }

        //     // $applications = \App\Allapplication::whereHas('applicant',function($q) use($e){
            //     $q->where('language_id',$e->language_id);
            // })->where('blocked',0)->where('attendance_ex',1)->groupBy('candidate.approvedprogramme_id')->get();
            // $otherevaluators = \App\Subjectofevaluator::where('exam_id',$this->exam_id)->where('subject_id',$e->subject_id)->where('language_id',$e->language_id)->get();
            // $evaluator = current($otherevaluators);
            // $noofapplications = $applications->count();
            // $noofevaluators = $otherevaluators->count();
            // $count = 0;
            // $ecount = 1;
            // $max = $noofapplications / $noofevaluators;
            // foreach($applications as $a){
            //     $count++;
            //     if($count > $max){
            //         $count = 0;
            //         $ecount++;
            //         $evaluator = next($otherevaluators);
            //     }else{
            //         $evaluator = current($otherevaluators);
            //     }
            //     try{
            //     $a->evaluator_id = $evaluator->id;
            //     $a->save();
            //     }catch (\Exception $ex) {
            //         $a->evaluator_id = $e->evaluator_id;
            //         $a->save();
            //     }   
            //     echo "assigned for ". $a->id. PHP_EOL;
            // }
        }
    }
    

