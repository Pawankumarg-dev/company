<?php

use Illuminate\Database\Seeder;

class SampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //


        /*
        //---- DEd-SE-MR - I Yr - Publishing Results ---//
        $users = array(
            'DL03', 'DL13',
            'GA01',
            'GJ08',
            'HP04',
            'HY01', 'HY08', 'HY07', 'HY18',
            'UP34', 'UP46', 'UP51',
            'WB08'
        );

        foreach ($users as $u) {
            $user = User::where('username', $u)->first();
            $institute = Institute::where('user_id', $user->id)->first();

            $programme = Programme::where('abbreviation', 'DEd-SE-MR')->first();

            $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $programme->id)
                ->where('academicyear_id', '1')->get();;
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
        //---- ./DEd-SE-MR - I Yr - Publishing Results ---//

        //---- DEd-SE-MR - II Yr - Publishing Results ---//
        $users = array(
            'DL12', 'UP40'
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
        //---- ./DEd-SE-MR - II Yr - Publishing Results ---//

        //---- DEd-SE-CP - II Yr - Publishing Results ---//
        $users = array(
            'DL13', 'HY01', 'HY16',
        );

        foreach ($users as $u) {
            $user = User::where('username', $u)->first();
            $institute = Institute::where('user_id', $user->id)->first();

            $programme = Programme::where('abbreviation', 'DEd-SE-CP')->first();

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
        //---- ./DEd-SE-CP - II Yr - Publishing Results ---//

        //---- DEd-SE-CP - I Yr - Publishing Results ---//
        $users = array(
            'HY01',
        );

        foreach ($users as $u) {
            $user = User::where('username', $u)->first();
            $institute = Institute::where('user_id', $user->id)->first();

            $programme = Programme::where('abbreviation', 'DEd-SE-CP')->first();

            $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $programme->id)
                ->where('academicyear_id', '1')->get();;
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
        //---- ./DEd-SE-CP - I Yr - Publishing Results ---//

        //---- DEd-SE-MR - II Yr - Publishing Results ---//
        $users = array(
            'UP21', 'MH05', 'KA05', 'MP05', 'JH11'
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
        //---- ./DEd-SE-MR - II Yr - Publishing Results ---//

        //--- Blocking Individual Results ---//
        $candidates = array(
            '231617929', '231617930'
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

        //---- DEd-SE-ASD - I Yr - Publishing Results ---//
        $users = array(
            'MP04'
        );

        foreach ($users as $u) {
            $user = User::where('username', $u)->first();
            $institute = Institute::where('user_id', $user->id)->first();

            $programme = Programme::where('abbreviation', 'DEd-SE-ASD')->first();

            $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $programme->id)
                ->where('academicyear_id', '1')->get();;
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
        //---- ./DEd-SE-ASD - I Yr - Publishing Results ---//

        //---- DEd-SE-MR - I Yr - Publishing Results ---//
        $users = array(
            'HY09', 'HY20', 'HY22', 'HY24', 'HY25', 'HY26',
            'JH06', 'MH12', 'MH16', 'MH19', 'MH23', 'MH27',
            'MN01', 'MP07', 'MP12',
            'MZ01',
            'UP10', 'UP36', 'UP42', 'UP47', 'UP48',
            'WB04'
        );

        foreach ($users as $u) {
            $user = User::where('username', $u)->first();
            $institute = Institute::where('user_id', $user->id)->first();

            $programme = Programme::where('abbreviation', 'DEd-SE-MR')->first();

            $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $programme->id)
                ->where('academicyear_id', '1')->get();;
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
        //---- ./DEd-SE-MR - I Yr - Publishing Results ---//

        //---- DEd-SE-MR - II Yr - Publishing Results ---//
        $users = array(
            'HP01',
            'KE13',
            'UP29',
        );

        foreach ($users as $u) {
            $user = User::where('username', $u)->first();
            $institute = Institute::where('user_id', $user->id)->first();

            $programme = Programme::where('abbreviation', 'DEd-SE-MR')->first();

            $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $programme->id)
                ->where('academicyear_id', '1')->get();;
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
        //---- ./DEd-SE-MR - II Yr - Publishing Results ---//

        $subject = Subject::where('scode','ACCDL')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3')->where('startdate', '2018-09-10 10:00:00');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-09-10 10:00:00', 'enddate'=>'2018-09-10 13:00:00']); }
        $subject = Subject::where('scode','ACCPE')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3')->where('startdate', '2018-09-11 10:00:00');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-09-11 10:00:00', 'enddate'=>'2018-09-11 13:00:00']); }
        $subject = Subject::where('scode','ACCCA')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3')->where('startdate', '2018-09-12 10:00:00');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-09-12 10:00:00', 'enddate'=>'2018-09-12 13:00:00']); }
        $subject = Subject::where('scode','ACCCN')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3')->where('startdate', '2018-09-13 10:00:00');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-09-13 10:00:00', 'enddate'=>'2018-09-13 13:00:00']); }

        //---- DEd-SE-MR - II Yr - Publishing Results ---//
        $users = array(
            'MP07',
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
        //---- ./DEd-SE-MR - II Yr - Publishing Results ---//


        $user = User::where('username','KE01')->first();$institute = Institute::where('user_id',$user->id)->first();$examuser = User::where('username','KE01')->first();$examcenter = Institute::where('user_id',$examuser->id)->first();$ec = Examcenter::where('exam_id', '3')->where('institute_id', $institute->id)->where('examcenter_id', $examcenter->id);if($ec->count() == 0) {Examcenter::create(['examcenter_id'=>$examcenter->id, 'institute_id'=>$institute->id, 'exam_id'=>'3']);}
        $user = User::where('username','KE04')->first();$institute = Institute::where('user_id',$user->id)->first();$examuser = User::where('username','KE04')->first();$examcenter = Institute::where('user_id',$examuser->id)->first();$ec = Examcenter::where('exam_id', '3')->where('institute_id', $institute->id)->where('examcenter_id', $examcenter->id);if($ec->count() == 0) {Examcenter::create(['examcenter_id'=>$examcenter->id, 'institute_id'=>$institute->id, 'exam_id'=>'3']);}
        $user = User::where('username','KE15')->first();$institute = Institute::where('user_id',$user->id)->first();$examuser = User::where('username','KE04')->first();$examcenter = Institute::where('user_id',$examuser->id)->first();$ec = Examcenter::where('exam_id', '3')->where('institute_id', $institute->id)->where('examcenter_id', $examcenter->id);if($ec->count() == 0) {Examcenter::create(['examcenter_id'=>$examcenter->id, 'institute_id'=>$institute->id, 'exam_id'=>'3']);}
        $user = User::where('username','KE05')->first();$institute = Institute::where('user_id',$user->id)->first();$examuser = User::where('username','KE05')->first();$examcenter = Institute::where('user_id',$examuser->id)->first();$ec = Examcenter::where('exam_id', '3')->where('institute_id', $institute->id)->where('examcenter_id', $examcenter->id);if($ec->count() == 0) {Examcenter::create(['examcenter_id'=>$examcenter->id, 'institute_id'=>$institute->id, 'exam_id'=>'3']);}
        $user = User::where('username','KE10')->first();$institute = Institute::where('user_id',$user->id)->first();$examuser = User::where('username','KE10')->first();$examcenter = Institute::where('user_id',$examuser->id)->first();$ec = Examcenter::where('exam_id', '3')->where('institute_id', $institute->id)->where('examcenter_id', $examcenter->id);if($ec->count() == 0) {Examcenter::create(['examcenter_id'=>$examcenter->id, 'institute_id'=>$institute->id, 'exam_id'=>'3']);}
        $user = User::where('username','KE16')->first();$institute = Institute::where('user_id',$user->id)->first();$examuser = User::where('username','KE16')->first();$examcenter = Institute::where('user_id',$examuser->id)->first();$ec = Examcenter::where('exam_id', '3')->where('institute_id', $institute->id)->where('examcenter_id', $examcenter->id);if($ec->count() == 0) {Examcenter::create(['examcenter_id'=>$examcenter->id, 'institute_id'=>$institute->id, 'exam_id'=>'3']);}
        $user = User::where('username','KE18')->first();$institute = Institute::where('user_id',$user->id)->first();$examuser = User::where('username','KE18')->first();$examcenter = Institute::where('user_id',$examuser->id)->first();$ec = Examcenter::where('exam_id', '3')->where('institute_id', $institute->id)->where('examcenter_id', $examcenter->id);if($ec->count() == 0) {Examcenter::create(['examcenter_id'=>$examcenter->id, 'institute_id'=>$institute->id, 'exam_id'=>'3']);}
        $user = User::where('username','KE19')->first();$institute = Institute::where('user_id',$user->id)->first();$examuser = User::where('username','KE19')->first();$examcenter = Institute::where('user_id',$examuser->id)->first();$ec = Examcenter::where('exam_id', '3')->where('institute_id', $institute->id)->where('examcenter_id', $examcenter->id);if($ec->count() == 0) {Examcenter::create(['examcenter_id'=>$examcenter->id, 'institute_id'=>$institute->id, 'exam_id'=>'3']);}
        */

        //---- DEd-SE-CP - II Yr - Publishing Results ---//
        $users = array(
            //'UP09'
        );

        foreach ($users as $u) {
            $user = User::where('username', $u)->first();
            $institute = Institute::where('user_id', $user->id)->first();

            $programme = Programme::where('abbreviation', 'DEd-SE-CP')->first();

            $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $programme->id)
                ->where('academicyear_id', '2')->get();
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
        //---- ./DEd-SE-CP - II Yr - Publishing Results ---//

        //---- DEd-SE-CP - I Yr - Publishing Results ---//
        $users = array(
            //'HP01', 'HP02', 'HY11', 'JH02', 'WB03', 'UP26', 'UP27', 'UP35',
            //'HY03'
            'DL13'
        );

        foreach ($users as $u) {
            $user = User::where('username', $u)->first();
            $institute = Institute::where('user_id', $user->id)->first();

            $programme = Programme::where('abbreviation', 'DEd-SE-CP')->first();

            $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $programme->id)
                ->where('academicyear_id', '1')->get();;
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
        //---- ./DEd-SE-CP - I Yr - Publishing Results ---//

        //---- DEd-SE-ASD - I Yr - Publishing Results ---//
        $users = array(
            //'MH13'
            //'UP03'
            //'HY13'
            //'UP09'
        );

        foreach ($users as $u) {
            $user = User::where('username', $u)->first();
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
                    Withheld::where('approvedprogramme_id', $app->approvedprogramme_id)
                        ->where('candidate_id', $app->candidate_id)->update(['status'=>'0']);
                }
            }
        }
        //---- ./DEd-SE-ASD - I Yr - Publishing Results ---//

        //---- .DEd-SE-ASD - II Yr - Publishing Results ---//
        $users = array(
            //'JH06'
            //'UP03'
            //'HY13'
            //'UP09'
        );

        foreach ($users as $u) {
            $user = User::where('username', $u)->first();
            $institute = Institute::where('user_id', $user->id)->first();

            $programme = Programme::where('abbreviation', 'DEd-SE-ASD')->first();

            $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $programme->id)
                ->where('academicyear_id', '2')->get();
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
        //---- ./DEd-SE-ASD - II Yr - Publishing Results ---//

        //---- ./DEd-SE-MR - II Yr - Publishing Results ---//
        $users = array(
            //'HY03', 'MH04'
            //'DL13', 'MP09'
            //'WB16'
            //'WB10'
            //'MP06'
            //'UP03', 'UP12', 'UP31', 'HY21', 'HY09'
            //'RJ06', 'BI03', 'JH04', 'HY07'
            //'MP11', 'UP23'
            //'HY13'
            //'UP09'
            'RJ07'
        );

        foreach ($users as $u) {
            $user = User::where('username', $u)->first();
            $institute = Institute::where('user_id', $user->id)->first();

            $programme = Programme::where('abbreviation', 'DEd-SE-MR')->first();

            $approvedprogrammes = Approvedprogramme::where('institute_id', $institute->id)->where('programme_id', $programme->id)
                ->where('academicyear_id', '2')->get();
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
        //---- ./DEd-SE-MR - II Yr - Publishing Results ---//

        //---- ./DEd-SE-MR - I Yr - Publishing Results ---//
        $users = array(
            //'JH03', 'JH07', 'MH21', 'UP28', 'TN16'
            //'KA06', 'HY03', 'JH08'
            //'HY30', 'TL05', 'HY10', 'HY28'
            //'HY12', 'HY05'
            //'UP03', 'UP12', 'HY09'
            //'HY17', 'HY07'
            //'MP11', 'BI04'
            //'MH26', 'HY13'
            //'UP09', 'TL11'
            //'HY27'
            'MH11', 'TL10', 'HY21'
        );

        foreach ($users as $u) {
            $user = User::where('username', $u)->first();
            $institute = Institute::where('user_id', $user->id)->first();

            $programme = Programme::where('abbreviation', 'DEd-SE-MR')->first();

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
        }
        //---- ./DEd-SE-MR - I Yr - Publishing Results ---//

        //--- Blocking Individual Results ---//
        $candidates = array(
            '231720509', '231607424', '211701414', '211727303', '211727321', '221728018',
            '211614516', '231725108', '231720630', '231732420', '231720630', '231722715',
            '231732420', '231720630', '211614516', '231720630', '231710230', '231617929',
            '231617930', '9215319302', '9215323501', '9215323512', '9215310901'
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
