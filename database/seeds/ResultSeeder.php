<?php

use Illuminate\Database\Seeder;
use App\Candidate;
use App\Subject;
use App\Mark;
use App\Markcertificate;
use App\Application;
use App\Withheld;
use App\Examresultdate;
use App\Institute;
use App\User;
use App\Approvedprogramme;
use App\Programme;
use App\Examtimetable;
use App\Academicyear;
use App\Examcenter;
use App\Reevaluationresult;
use App\Reevaluation;

class ResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->withheldresults();
        //$this->notpublishresults();
        //$this->march2021_publishresults_14072021();


    }

    public function notpublishresults() {
        $approvedprogramme_ids = array(
            array("ap_id" => "2404"),
            array("ap_id" => "2246"),
            array("ap_id" => "2229"),
            array("ap_id" => "2264"),
            array("ap_id" => "2253"),
            array("ap_id" => "2241"),
            array("ap_id" => "120"),
            array("ap_id" => "1927"),
            array("ap_id" => "2117"),
            array("ap_id" => "2306"),
            array("ap_id" => "70"),
            array("ap_id" => "2281"),
            array("ap_id" => "2105"),
            array("ap_id" => "147"),
            array("ap_id" => "1830"),
            array("ap_id" => "338"),
            array("ap_id" => "2030"),
            array("ap_id" => "244"),
            array("ap_id" => "2151"),
            array("ap_id" => "1688"),
            array("ap_id" => "2032"),
            array("ap_id" => "2180"),
            array("ap_id" => "1919"),
            array("ap_id" => "1698"),
            array("ap_id" => "2400"),
            array("ap_id" => "225"),
            array("ap_id" => "2376"),
            array("ap_id" => "2299"),
            array("ap_id" => "2192"),
            array("ap_id" => "2112"),
            array("ap_id" => "1930"),
            array("ap_id" => "2248"),
            array("ap_id" => "2242"),
            array("ap_id" => "2307"),
            array("ap_id" => "2405"),
            array("ap_id" => "2290"),
        );

        foreach ($approvedprogramme_ids as $ap) {
            Application::where("approvedprogramme_id", $ap["ap_id"])->update([
                "publish_status" => 0
            ]);
            unset($ap);
        }
    }

    /*
    public function withheldresults(){
        $candidates = array(
            "231814518",
            "231814526",
            "231837603",
            "231837610",
            "231837618",
            "231837619",
            "231837602",
            "231837607",
            "231830207",
            "231719721"
        );

        foreach ($candidates as $candidate) {
            $c = Candidate::where('enrolmentno', $candidate)->first();

            if(!is_null($c)) {
                $withheld = Withheld::where('exam_id', '13')->where('candidate_id', $c->id)->first();

                if(!is_null($withheld)) {
                    Withheld::where('exam_id', '13')->where('candidate_id', $c->id)->update(['status'=>'1']);
                    unset($withheld);
                }
                else {
                    Withheld::create([
                        'exam_id'=>'13',
                        'approvedprogramme_id'=>$c->approvedprogramme_id,
                        'candidate_id'=>$c->id,
                        'status'=>'1'
                    ]);
                }

                unset($candidate);
                unset($c);
            }

        }
    }
    */

    public function march2021_publishresults_14072021() {
        $details = array(
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231910304"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231910310"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231910401"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231910407"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231911728"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211911802"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211911806"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231912410"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231912419"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231912429"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231914315"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231914318"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211916801"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211916811"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211916816"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231918523"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231918524"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231921603"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231921604"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231921702"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231921704"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231921705"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231921815"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231922007"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231922018"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231922019"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231922025"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231922106"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211922601"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211922603"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211922610"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211922613"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211922615"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231922706"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"221922502"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"221922503"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"221922506"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211922506"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231922503"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231922515"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231922527"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231926917"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231928111"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231928114"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231928122"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231928128"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"221928607"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"221928610"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231928601"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231928612"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231928627"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211931006"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211931007"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211931008"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231931007"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231933610"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231933614"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231933801"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231933808"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231934013"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231934015"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231934103"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231934105"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231934107"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231934116"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211934201"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211934208"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211934209"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211934212"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211934219"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231934404"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231934405"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231934407"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231934419"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231935516"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231937410"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231937423"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231937525"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231937909"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231937923"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231938003"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231938019"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231938022"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231938413"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231938513"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231939013"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231939017"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231939020"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231939101"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231939110"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231939116"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231939117"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231939118"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231939119"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231939121"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231939523"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231940001"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231940024"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231940607"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231940616"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231940621"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231940622"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231940624"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231941505"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231941506"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231941507"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231941508"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231941511"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231941513"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231941514"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231941516"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231941520"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231941612"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231941620"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231941703"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231941704"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231942204"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231942206"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231942215"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231942503"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231942504"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231942414"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231942701"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231942702"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231942707"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231942713"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231942714"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231942908"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211943510"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231943505"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231943513"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231943520"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231943524"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231943604"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231943617"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231943808"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231943818"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231907919"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231912215"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231924811"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231916819"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211928601"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211928602"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"211928603"),
            array("exam_id"=>"14","publish_date"=>"2021-07-14","enrolmentno"=>"231941515"),
        );

        foreach ($details as $detail) {
            $candidate = Candidate::where("enrolmentno", $detail["enrolmentno"])->first();

            if(!is_null($candidate)) {
                Application::where("exam_id", $detail["exam_id"])->where("candidate_id", $candidate->id)->update([
                    "publish_status" => 1,
                ]);
            }
        }
    }
}
