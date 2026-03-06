<?php

use Illuminate\Database\Seeder;

class DEdSEMR2017BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //----- Blocking All Institutes Result -----//
        $ay = Academicyear::where('year', '2017')->first();
        $p = Programme::where('abbreviation', 'DEd-SE-MR')->first();
        $ap_id = Approvedprogramme::where('programme_id', $p->id)->where('academicyear_id', $ay->id)->pluck('id')->toArray();
        $app = Application::where('exam_id', '2')->whereIn('approvedprogramme_id', $ap_id)->groupBy('candidate_id')->get();

        foreach($app as $a){
            if(Withheld::where('exam_id', $a->exam_id)->where('approvedprogramme_id', $a->approvedprogramme_id)
                    ->where('candidate_id', $a->candidate_id)->count() == 0) {
                Withheld::create(['exam_id'=>$a->exam_id, 'approvedprogramme_id'=>$a->approvedprogramme_id,
                    'candidate_id'=>$a->candidate_id, 'status'=>'1']);
            }
        }
        //----- ./Blocking All Institutes Result -----//

        //---- Publishing Results ---//
        $users = array(
            'AP01', 'AP02', 'AP04', 'AP05', 'AP09', 'AP11', 'AP13', 'AP15', 'AP16',
            'AS02',
            'BI01', 'BI02', 'BI03', 'BI06', 'BI08',
            'CA03',
            'CH02', 'CH03', 'CH04',
            'DL04', 'DL05', 'DL06', 'DL07', 'DL08', 'DL10', 'DL11', 'DL12', 'DL14',
            'GA02', 'GJ02', 'GJ05',
            'HP03',
            'HY19', 'HY23', 'JH01', 'JH04', 'JH11',
            'KA04', 'KA05',
            'KE01', 'KE05', 'KE06', 'KE07', 'KE08', 'KE09', 'KE10', 'KE11', 'KE12', 'KE13', 'KE14', 'KE16',
            'MH04', 'MH05', 'MH06', 'MH07', 'MH09', 'MH10',
            'MP05', 'MP07', 'MP08', 'MP09', 'MP10', 'MP12',
            'OR02', 'OR03', 'OR04', 'OR05', 'OR06',
            'PJ02', 'PJ03',
            'RJ01', 'RJ02', 'RJ03', 'RJ04', 'RJ05', 'RJ06', 'RJ07', 'RJ08', 'RJ09', 'RJ10', 'RJ11', 'RJ12', 'RJ13',
            'RJ14', 'RJ15', 'RJ16', 'RJ17',
            'TL06', 'TL08', 'TL09',
            'TN11', 'TN12', 'TN13', 'TN15', 'TN20',
            'UK01', 'UP02', 'UP11', 'UP14', 'UP15', 'UP16', 'UP18', 'UP19', 'UP20', 'UP21', 'UP22', 'UP24', 'UP44',
            'UP45', 'UP49', 'WB06', 'WB09', 'WB10', 'WB11', 'WB13', 'WB14', 'WB16', 'WB18', 'WB19', 'WB20', 'WB21',
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
        //---- ./Publishing Results ---//

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
    }
}
