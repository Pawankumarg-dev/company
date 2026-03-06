<?php

use Illuminate\Database\Seeder;
use App\Withheld;
use App\Candidate;
use App\Institute;
use App\User;
use App\Approvedprogramme;
use App\Application;
use App\Programme;
use App\Examresultdate;


class DedSEMR2DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*
        $withheld = Withheld::all();
        foreach ($withheld as $w){
            $candidate = Candidate::find($w->candidate_id);
            $w->approvedprogramme_id = $candidate->approvedprogramme_id;
            $w->save();
        }
        */

        /* MP13 */
        $user = User::where('username', 'MP13')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* UP03 */
        $user = User::where('username', 'UP03')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* HY21 */
        $user = User::where('username', 'HY21')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* JH12 */
        $user = User::where('username', 'JH12')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* HY13 */
        $user = User::where('username', 'HY13')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* AP12 */
        $user = User::where('username', 'AP12')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* UP43 */
        $user = User::where('username', 'UP43')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* UP13 */
        $user = User::where('username', 'UP13')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* JH05 */
        $user = User::where('username', 'JH05')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* MH18 */
        $user = User::where('username', 'MH18')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* UP41 */
        $user = User::where('username', 'UP41')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* HY27 */
        $user = User::where('username', 'HY27')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* UP33 */
        $user = User::where('username', 'UP33')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* HY07 */
        $user = User::where('username', 'HY07')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* TN17 */
        $user = User::where('username', 'TN17')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */


        /* MH20 */
        $user = User::where('username', 'MH20')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* MP11 */
        $user = User::where('username', 'MP11')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* MH15 */
        $user = User::where('username', 'MH15')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* MH14 */
        $user = User::where('username', 'MH14')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* TL11 */
        $user = User::where('username', 'TL11')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* UP31 */
        $user = User::where('username', 'UP31')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* AP06 */
        $user = User::where('username', 'AP06')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* UP12 */
        $user = User::where('username', 'UP12')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* AP07 */
        $user = User::where('username', 'AP07')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* HY16 */
        $user = User::where('username', 'HY16')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* UP09 */
        $user = User::where('username', 'UP09')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* HY15 */
        $user = User::where('username', 'HY15')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* DL06 */
        $user = User::where('username', 'DL06')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* UP38 - Blocking DEd-SE-ASD-IInd year */
        $user = User::where('username', 'UP38')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)
            ->where('programme_id', '3')->where('academicyear_id', '2')->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* KA03 - Blocking DEd-SE-ASD-IInd year */
        $user = User::where('username', 'KA03')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)
            ->where('programme_id', '3')->where('academicyear_id', '2')->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */

        /* HY16 */
        $user = User::where('username', 'HY16')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }
        /* */


        //DEd-SE-ASD - 1st year Result
        $p = Programme::where('abbreviation', 'DEd-SE-ASD')->first();
        $erd = Examresultdate::where('exam_id', '2')->where('programme_id', $p->id)
            ->where('academicyear_id', '1')->where('publish_date', '2018-08-18')->where('publish_status', '1')->get();
        if($erd->count() == 0)
            Examresultdate::create(['exam_id' => '2', 'programme_id' => $p->id, 'academicyear_id' => '1',
                'publish_date' => '2018-08-18', 'publish_status' => '1']);


        // JH06
        $user = User::where('username', 'JH06')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $p->id)
            ->where('academicyear_id', '1')->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }

        // MP04
        $user = User::where('username', 'MP04')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $p->id)
            ->where('academicyear_id', '1')->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }

        // TL06
        $user = User::where('username', 'TL06')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $p->id)
            ->where('academicyear_id', '1')->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }

        // TN02
        $user = User::where('username', 'TN02')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $p->id)
            ->where('academicyear_id', '1')->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }

        //-------------------------------------

        //DEd-SE-CP - 1st year Result
        $p = Programme::where('abbreviation', 'DEd-SE-CP')->first();
        $erd = Examresultdate::where('exam_id', '2')->where('programme_id', $p->id)
            ->where('academicyear_id', '1')->where('publish_date', '2018-08-18')->where('publish_status', '1')->get();
        if($erd->count() == 0)
            Examresultdate::create(['exam_id' => '2', 'programme_id' => $p->id, 'academicyear_id' => '1',
                'publish_date' => '2018-08-18', 'publish_status' => '1']);

        // DL13
        $user = User::where('username', 'DL13')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $p->id)
            ->where('academicyear_id', '1')->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }

        // HY01
        $user = User::where('username', 'HY01')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $p->id)
            ->where('academicyear_id', '1')->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }

        // HY03
        $user = User::where('username', 'HY03')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $p->id)
            ->where('academicyear_id', '1')->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }

        // UP34
        $user = User::where('username', 'UP34')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $p->id)
            ->where('academicyear_id', '1')->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                    'candidate_id'=>$app->candidate_id, 'status'=>'1']);
            }
        }


        ////---------------------------------------------------////
        //DEd-SE-MR - 2nd year Result
        $p = Programme::where('abbreviation', 'DEd-SE-MR')->first();
        if (Examresultdate::where('exam_id', '2')->where('programme_id', $p->id)
                ->where('academicyear_id', '2')->where('publish_date', '2018-08-18')->where('publish_status', '1')->count() == 0)
            Examresultdate::create(['exam_id' => '2', 'programme_id' => $p->id, 'academicyear_id' => '2',
                'publish_date' => '2018-08-18', 'publish_status' => '1']);

        $users = array(
            'AP01', 'AP05', 'AP06', 'AP07', 'AP10', 'AP12',
            'AS02',
            'BI01', 'BI02', 'BI03', 'BI05',
            'CH02',
            'DL03', 'DL05', 'DL06', 'DL07', 'DL09', 'DL10', 'DL11', 'DL12', 'DL13',
            'GJ02', 'GJ05', 'GJ06', 'GJ07',
            'HP01', 'HP02', 'HP03', 'HP04',
            'HY01', 'HY03', 'HY05', 'HY06', 'HY07', 'HY08', 'HY15', 'HY16', 'HY16', 'HY17', 'HY21',
            'JH05', 'JH09', 'JH11',
            'KA05', 'KA06',
            'KE01', 'KE06', 'KE10', 'KE12', 'KE13', 'KE16',
            'MH01', 'MH04', 'MH05', 'MH07', 'MH10', 'MH11', 'MH12', 'MH13', 'MH14', 'MH15', 'MH18', 'MH19', 'MH20', 'MH23',
            'MN01',
            'MP05', 'MP06', 'MP07', 'MP09', 'MP10', 'MP11', 'MP12', 'MP13',
            'PJ01',
            'RJ05', 'RJ06', 'RJ07', 'RJ12',
            'TL06', 'TL08', 'TL11',
            'TN11', 'TN15', 'TN16', 'TN17',
            'UK01',
            'UP02', 'UP03', 'UP04', 'UP09', 'UP10', 'UP12', 'UP13', 'UP14', 'UP15', 'UP16', 'UP18', 'UP19', 'UP20', 'UP21',
            'UP22', 'UP21', 'UP23', 'UP24', 'UP26', 'UP28', 'UP30', 'UP31', 'UP32', 'UP34', 'UP37', 'UP40', 'UP41', 'UP43',
            'WB09', 'WB10', 'WB16'
        );

        foreach ($users as $u) {
            $user = User::where('username', $u)->first();
            $institute = Institute::where('user_id', $user->id)->first();

            $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $p->id)
                ->where('academicyear_id', '2')->get();
            $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

            $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
                ->groupBy('candidate_id')->get();

            foreach ($applications as $app) {
                if (Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                        ->where('candidate_id', $app->candidate_id)->count() == 0) {
                    Withheld::create(['exam_id' => $app->exam_id, 'approvedprogramme_id' => $app->approvedprogramme_id,
                        'candidate_id' => $app->candidate_id, 'status' => '1']);
                }
            }
        }

        //Withheld all results
        $users = array(
            'UP30', 'UP38', 'UP39'
        );

        foreach ($users as $u) {
            $user = User::where('username', $u)->first();
            $institute = Institute::where('user_id', $user->id)->first();

            $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();;
            $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

            $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
                ->groupBy('candidate_id')->get();

            foreach($applications as $app){
                if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                        ->where('candidate_id', $app->candidate_id)->count() == 0) {
                    Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                        'candidate_id'=>$app->candidate_id, 'status'=>'1']);
                }
            }
        }

        //--- Malpractice ---//
        $users = array(
            'AP06', 'AP07', 'AP12',
            'HY07', 'HY13', 'HY15', 'HY16', 'HY21', 'HY27', 'HY29',
            'JH05', 'JH09', 'JH12',
            'MH14', 'MH15', 'MH18', 'MH20',
            'MP11', 'MP13', 'MP14',
            'TL11',
            'TN17',
            'UP03', 'UP09', 'UP12', 'UP13', 'UP30', 'UP31', 'UP33', 'UP38', 'UP39', 'UP41', 'UP43'
        );

        foreach ($users as $u) {
            $user = User::where('username', $u)->first();
            $institute = Institute::where('user_id', $user->id)->first();

            $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->get();;
            $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

            $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
                ->groupBy('candidate_id')->get();

            foreach($applications as $app){
                if(Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                        ->where('candidate_id', $app->candidate_id)->count() == 0) {
                    Withheld::create(['exam_id'=>$app->exam_id, 'approvedprogramme_id'=>$app->approvedprogramme_id,
                        'candidate_id'=>$app->candidate_id, 'status'=>'1']);
                }
            }
        }
        //--- ./Malpractice ---//


        //--- Publishing Results ---//
        $users = array(
            'AP01', 'AP05', 'AP10',
            'BI01', 'BI02', 'BI05',
            'CH02',
            'DL03', 'DL05', 'DL06', 'DL07', 'DL09', 'DL10', 'DL11',
            'GJ02', 'GJ06', 'GJ07', 'GJ05',
            'HP02', 'HP03', 'HP04', 'HY06',
            'HY04', 'HY05', 'HY08',
            'KA04', 'KA06',
            'KE01', 'KE06', 'KE10', 'KE12', 'KE16',
            'MH07', 'MH12', 'MH23', 'MH01', 'MH07', 'MH11', 'MH19',
            'MN01',
            'MP10', 'MP12',
            'RJ05', 'RJ12',
            'TL06', 'TL08',
            'TN11', 'TN16', 'TN15',
            'UP02', 'UP04', 'UP10', 'UP14', 'UP15', 'UP16', 'UP19', 'UP18', 'UP20', 'UP22',
            'UP24', 'UP26', 'UP28', 'UP32', 'UP34', 'UP37',
            'WB09',
            'UK01'

        );

        foreach ($users as $u) {
            $user = User::where('username', $u)->first();
            $institute = Institute::where('user_id', $user->id)->first();

            $programme = Programme::where('abbreviation', 'DEd-SE-MR')->first();

            $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $programme->id)
                ->where('academicyear_id', '2')->get();;
            $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

            $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
                ->groupBy('candidate_id')->get();

            foreach($applications as $app){
                $withheld = Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->get();
                if($withheld->count() > 0) {
                    Withheld::where('approvedprogramme_id', $app->approvedprogramme_id)
                        ->where('candidate_id', $app->candidate_id)->update(['status'=>'0']);
                }
            }
        }
        //--- ./Publishing Results ---//



        //--- Publishing Results ---//
        $users = array(
            'AS02'
        );

        foreach ($users as $u) {
            $user = User::where('username', $u)->first();
            $institute = Institute::where('user_id', $user->id)->first();

            $programme = Programme::where('abbreviation', 'DEd-SE-MR')->first();

            $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $programme->id)
                ->where('academicyear_id', '2')->get();;
            $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

            $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
                ->groupBy('candidate_id')->get();

            foreach($applications as $app){
                $withheld = Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->get();
                if($withheld->count() > 0) {
                    Withheld::where('approvedprogramme_id', $app->approvedprogramme_id)
                        ->where('candidate_id', $app->candidate_id)->update(['status'=>'0']);
                }
            }
        }
        //--- ./Publishing Results ---//

        //DL06 - DEd-SE-ASD -- Publishing Result
        $user = User::where('username', 'DL06')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $programme = Programme::where('abbreviation', 'DEd-SE-ASD')->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $programme->id)->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            $withheld = Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                ->where('candidate_id', $app->candidate_id)->get();
            if($withheld->count() > 0) {
                Withheld::where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->update(['status'=>'0']);
            }
        }
        // ./DL06 - DEd-SE-ASD -- Publishing Result

        //--  DEd-SE-CP - UP34 - 1st year -- Publishing Result --//
        $user = User::where('username', 'UP34')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $programme = Programme::where('abbreviation', 'DEd-SE-CP')->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $programme->id)
            ->where('academicyear_id', '1')->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            $withheld = Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                ->where('candidate_id', $app->candidate_id)->get();
            if($withheld->count() > 0) {
                Withheld::where('approvedprogramme_id', $app->approvedprogramme_id)
                    ->where('candidate_id', $app->candidate_id)->update(['status'=>'0']);
            }
        }
        //--  ./DEd-SE-CP - UP34 - 1st year -- Publishing Result --//


        //--  DEd-SE-ASD - TN02 - 1st year -- Publishing Result --//
        $user = User::where('username', 'TN02')->first();
        $institute = Institute::where('user_id', $user->id)->first();

        $programme = Programme::where('abbreviation', 'DEd-SE-ASD')->first();

        $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $programme->id)
            ->where('academicyear_id', '1')->get();
        $approvedprogramme_ids = $approvedprogrammes->pluck('id')->toArray();

        $applications = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $approvedprogramme_ids)
            ->groupBy('candidate_id')->get();

        foreach($applications as $app){
            $withheld = Withheld::where('exam_id', $app->exam_id)->where('approvedprogramme_id', $app->approvedprogramme_id)
                ->where('candidate_id', $app->candidate_id)->get();
            if($withheld->count() > 0) {
                $candidate = Candidate::find($app->candidate_id);
                if($candidate->enrolmentno != 211701414)
                    Withheld::where('approvedprogramme_id', $app->approvedprogramme_id)
                        ->where('candidate_id', $app->candidate_id)->update(['status'=>'0']);
            }
        }
        //--  DEd-SE-ASD - TN02 - 1st year -- Publishing Result --//

        //--- Blocking Individual Results ---//
        $candidates = array(
            '231720509', '231607424', '211701414', '211727303', '211727321', '221728018',
            '211614516', '231725108', '231720630', '231732420', '231720630', '231722715',
            '231732420', '231720630', '211614516', '231720630', '231710230',
        );

        foreach ($candidates as $candidate) {
            $c = Candidate::where('enrolmentno', $candidate)->first();

            if($c->count() > 0) {
                $withheld = Withheld::where('exam_id', '2')->where('candidate_id', $c->id)->get();
                if($withheld->count() > 0){
                    Withheld::where('exam_id', '2')->where('candidate_id', $c->id)->update(['status'=>'1']);
                }
            }
            else{
                Withheld::create([
                    'exam_id'=>'2',
                    'approvedprogramme_id'=>$c->approvedprogramme_id,
                    'candidate_id'=>$c->id,
                    'status'=>'1'
                ]);
            }
        }

        //--- ./Blocking Individual Results ---//


    }
}
