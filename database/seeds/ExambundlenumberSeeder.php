<?php

use Illuminate\Database\Seeder;
use App\Exam;
use App\Candidate;
use App\Subject;
use App\Application;

class ExambundlenumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $exam = Exam::where('name', 'December 2019')->first();
        $exam->update([
            'exambundle_status' => '1',
        ]);

        $details = array(

            /*
            array("enrolmentno"=> "211730516", "scode" => "01ASDAM", "bundle_number" => "01ASDAM002H", "dummy_number" => "D195751"),
            array("enrolmentno"=> "211830504", "scode" => "01ASDAM", "bundle_number" => "01ASDAM002H", "dummy_number" => "D195752"),
            array("enrolmentno"=> "211830505", "scode" => "01ASDAM", "bundle_number" => "01ASDAM002H", "dummy_number" => "D195753"),
            array("enrolmentno"=> "211830506", "scode" => "01ASDAM", "bundle_number" => "01ASDAM002H", "dummy_number" => "D195754"),
            array("enrolmentno"=> "211830507", "scode" => "01ASDAM", "bundle_number" => "01ASDAM002H", "dummy_number" => "D195755"),
            array("enrolmentno"=> "211830508", "scode" => "01ASDAM", "bundle_number" => "01ASDAM002H", "dummy_number" => "D195756"),
            array("enrolmentno"=> "211830512", "scode" => "01ASDAM", "bundle_number" => "01ASDAM002H", "dummy_number" => "D195757"),
            array("enrolmentno"=> "211830513", "scode" => "01ASDAM", "bundle_number" => "01ASDAM002H", "dummy_number" => "D195758"),
            array("enrolmentno"=> "211830514", "scode" => "01ASDAM", "bundle_number" => "01ASDAM002H", "dummy_number" => "D195759"),
            array("enrolmentno"=> "231822718", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194386"),
            array("enrolmentno"=> "231817201", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194387"),
            array("enrolmentno"=> "231817203", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194388"),
            array("enrolmentno"=> "231817204", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194389"),
            array("enrolmentno"=> "231817205", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194390"),
            array("enrolmentno"=> "231817207", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194391"),
            array("enrolmentno"=> "231817208", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194392"),
            array("enrolmentno"=> "231817210", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194393"),
            array("enrolmentno"=> "231817211", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194394"),
            array("enrolmentno"=> "231817212", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194395"),
            array("enrolmentno"=> "231821601", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194396"),
            array("enrolmentno"=> "231821604", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194397"),
            array("enrolmentno"=> "231821605", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194398"),
            array("enrolmentno"=> "231821606", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194399"),
            array("enrolmentno"=> "231821608", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194400"),
            array("enrolmentno"=> "231821609", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194401"),
            array("enrolmentno"=> "231821611", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194402"),
            array("enrolmentno"=> "231821612", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194403"),
            array("enrolmentno"=> "231821617", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194404"),
            array("enrolmentno"=> "231825127", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194405"),
            array("enrolmentno"=> "231825124", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194406"),
            array("enrolmentno"=> "231839507", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194407"),
            array("enrolmentno"=> "231821301", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194408"),
            array("enrolmentno"=> "231838522", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194409"),
            array("enrolmentno"=> "231838524", "scode" => "01MRLG", "bundle_number" => "01MRLG014H", "dummy_number" => "D194410"),
            array("enrolmentno"=> "231719116", "scode" => "02MRIC", "bundle_number" => "2MRIC005H", "dummy_number" => "D191226"),
            array("enrolmentno"=> "231718418", "scode" => "02MRDM", "bundle_number" => "2MRDM004H", "dummy_number" => "D191638"),
            array("enrolmentno"=> "231718418", "scode" => "02MRIC", "bundle_number" => "2MRIC005H", "dummy_number" => "D191129"),
            array("enrolmentno"=> "231818414", "scode" => "01MRAA", "bundle_number" => "1MRAA001E", "dummy_number" => "D191719"),
            array("enrolmentno"=> "211716119", "scode" => "02ASDES", "bundle_number" => "2ASDES001ML", "dummy_number" => "D192367"),
            array("enrolmentno"=> "211830506", "scode" => "01ASDIM", "bundle_number" => "1ASDIM001H", "dummy_number" => "D195823"),
            array("enrolmentno"=> "211820502", "scode" => "01ASDIT", "bundle_number" => "1ASDIT001H", "dummy_number" => "D195245"),
            array("enrolmentno"=> "221828022", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196148"),
            array("enrolmentno"=> "221828020", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196149"),
            array("enrolmentno"=> "221830802", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196150"),
            array("enrolmentno"=> "221807906", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196151"),
            array("enrolmentno"=> "221807923", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196152"),
            array("enrolmentno"=> "221825308", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196153"),
            array("enrolmentno"=> "221825316", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196154"),
            array("enrolmentno"=> "221825311", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196155"),
            array("enrolmentno"=> "221814518", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196156"),
            array("enrolmentno"=> "221707817", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196157"),
            array("enrolmentno"=> "221807822", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196158"),
            array("enrolmentno"=> "221807817", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196159"),
            array("enrolmentno"=> "221627327", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196160"),
            array("enrolmentno"=> "221821004", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196161"),
            array("enrolmentno"=> "221819301", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196162"),
            array("enrolmentno"=> "221819302", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196163"),
            array("enrolmentno"=> "221819305", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196164"),
            array("enrolmentno"=> "221819309", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196165"),
            array("enrolmentno"=> "221819311", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196166"),
            array("enrolmentno"=> "221819313", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196167"),
            array("enrolmentno"=> "221819315", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196168"),
            array("enrolmentno"=> "221819320", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196169"),
            array("enrolmentno"=> "221819321", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196170"),
            array("enrolmentno"=> "221819322", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196171"),
            array("enrolmentno"=> "221830603", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196172"),
            array("enrolmentno"=> "221830604", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D195843"),
            array("enrolmentno"=> "221830605", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D195844"),
            array("enrolmentno"=> "221830606", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D195845"),
            array("enrolmentno"=> "221830608", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D195846"),
            array("enrolmentno"=> "221830609", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D195847"),
            array("enrolmentno"=> "231837321", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195848"),
            array("enrolmentno"=> "231837322", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195849"),
            array("enrolmentno"=> "231837323", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195850"),
            array("enrolmentno"=> "231812301", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195851"),
            array("enrolmentno"=> "231812303", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195852"),
            array("enrolmentno"=> "231812305", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195853"),
            array("enrolmentno"=> "231812307", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195854"),
            array("enrolmentno"=> "231812310", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195855"),
            array("enrolmentno"=> "231812314", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195856"),
            array("enrolmentno"=> "231812316", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195857"),
            array("enrolmentno"=> "231812320", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195858"),
            array("enrolmentno"=> "231812328", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195859"),
            array("enrolmentno"=> "231811715", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195955"),
            array("enrolmentno"=> "231833307", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195981"),
            array("enrolmentno"=> "231833308", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195982"),
            array("enrolmentno"=> "231833314", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195983"),
            array("enrolmentno"=> "231833320", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195984"),
            array("enrolmentno"=> "231833324", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195985"),
            array("enrolmentno"=> "231816422", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195986"),
            array("enrolmentno"=> "231816423", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195987"),
            array("enrolmentno"=> "231816424", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195988"),
            array("enrolmentno"=> "231816425", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195989"),
            array("enrolmentno"=> "231838305", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195990"),
            array("enrolmentno"=> "231838306", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195991"),
            array("enrolmentno"=> "231838307", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195992"),
            array("enrolmentno"=> "231838309", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195993"),
            array("enrolmentno"=> "231838310", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195994"),
            array("enrolmentno"=> "231838311", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195995"),
            array("enrolmentno"=> "231838313", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195996"),
            array("enrolmentno"=> "231838314", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195997"),
            array("enrolmentno"=> "231838315", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D195999"),
            array("enrolmentno"=> "231838316", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D196000"),
            array("enrolmentno"=> "231838318", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D196001"),
            array("enrolmentno"=> "231838319", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D196002"),
            array("enrolmentno"=> "231838320", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D196003"),
            array("enrolmentno"=> "231838321", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D196004"),
            array("enrolmentno"=> "231838322", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D196005"),
            array("enrolmentno"=> "231838325", "scode" => "01MRIT", "bundle_number" => "1MRIT027H", "dummy_number" => "D196006"),
            array("enrolmentno"=> "221830602", "scode" => "01CPEC", "bundle_number" => "1CPEC001H", "dummy_number" => "D195905"),


            array("enrolmentno"=> "231819312", "scode" => "01MRIT", "bundle_number" => "1MRIT004H", "dummy_number" => "D192633"),
            array("enrolmentno"=> "221830603", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D195842"),
            array("enrolmentno"=> "221728601", "scode" => "02CPAA", "bundle_number" => "2CPAA001H", "dummy_number" => "D196297"),

            array("enrolmentno"=> "231841501", "scode" => "01MRLG", "bundle_number" => "01MRLG015H", "dummy_number" => "D194411"),
            array("enrolmentno"=> "231841502", "scode" => "01MRLG", "bundle_number" => "01MRLG015H", "dummy_number" => "D194412"),
            array("enrolmentno"=> "231841503", "scode" => "01MRLG", "bundle_number" => "01MRLG015H", "dummy_number" => "D194413"),
            array("enrolmentno"=> "231841504", "scode" => "01MRLG", "bundle_number" => "01MRLG015H", "dummy_number" => "D194414"),
            array("enrolmentno"=> "231841505", "scode" => "01MRLG", "bundle_number" => "01MRLG015H", "dummy_number" => "D194415"),
            array("enrolmentno"=> "231841507", "scode" => "01MRLG", "bundle_number" => "01MRLG015H", "dummy_number" => "D194416"),
            array("enrolmentno"=> "231841507", "scode" => "01MRLG", "bundle_number" => "01MRLG015H", "dummy_number" => "D194417"),
            array("enrolmentno"=> "231841508", "scode" => "01MRLG", "bundle_number" => "01MRLG015H", "dummy_number" => "D194418"),
            array("enrolmentno"=> "231841509", "scode" => "01MRLG", "bundle_number" => "01MRLG015H", "dummy_number" => "D194419"),
            array("enrolmentno"=> "231839013", "scode" => "01MRLG", "bundle_number" => "01MRLG015H", "dummy_number" => "D194420"),
            array("enrolmentno"=> "231839014", "scode" => "01MRLG", "bundle_number" => "01MRLG015H", "dummy_number" => "D194421"),
            array("enrolmentno"=> "231839008", "scode" => "01MRLG", "bundle_number" => "01MRLG015H", "dummy_number" => "D194422"),
            array("enrolmentno"=> "231839007", "scode" => "01MRLG", "bundle_number" => "01MRLG015H", "dummy_number" => "D194423"),
            array("enrolmentno"=> "231822719", "scode" => "01MRLG", "bundle_number" => "01MRLG015H", "dummy_number" => "D194424"),
            array("enrolmentno"=> "231830605", "scode" => "01MRLG", "bundle_number" => "01MRLG015H", "dummy_number" => "D194425"),
            array("enrolmentno"=> "221830603", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D195842"),
            array("enrolmentno"=> "221728601", "scode" => "02CPAA", "bundle_number" => "2CPAA001H", "dummy_number" => "D196297"),
            array("enrolmentno"=> "231822608", "scode" => "01MRLG", "bundle_number" => "1MRLG013H", "dummy_number" => "D194381"),
            array("enrolmentno"=> "231822609", "scode" => "01MRLG", "bundle_number" => "1MRLG013H", "dummy_number" => "D194382"),
            array("enrolmentno"=> "231822610", "scode" => "01MRLG", "bundle_number" => "1MRLG013H", "dummy_number" => "D194383"),
            array("enrolmentno"=> "231822612", "scode" => "01MRLG", "bundle_number" => "1MRLG013H", "dummy_number" => "D194384"),
            array("enrolmentno"=> "231822613", "scode" => "01MRLG", "bundle_number" => "1MRLG013H", "dummy_number" => "D194385"),
            array("enrolmentno"=> "231822623", "scode" => "01MRLG", "bundle_number" => "1MRLG013H", "dummy_number" => "D194381"),
            array("enrolmentno"=> "231822625", "scode" => "01MRLG", "bundle_number" => "1MRLG013H", "dummy_number" => "D194382"),
            array("enrolmentno"=> "231822626", "scode" => "01MRLG", "bundle_number" => "1MRLG013H", "dummy_number" => "D194383"),
            array("enrolmentno"=> "231822627", "scode" => "01MRLG", "bundle_number" => "1MRLG013H", "dummy_number" => "D194384"),
            array("enrolmentno"=> "231822628", "scode" => "01MRLG", "bundle_number" => "1MRLG013H", "dummy_number" => "D194385"),
            array("enrolmentno"=> "231822608", "scode" => "01MRLG", "bundle_number" => "1MRLG013H", "dummy_number" => "D194281"),
            array("enrolmentno"=> "231822609", "scode" => "01MRLG", "bundle_number" => "1MRLG013H", "dummy_number" => "D194282"),
            array("enrolmentno"=> "231822610", "scode" => "01MRLG", "bundle_number" => "1MRLG013H", "dummy_number" => "D194283"),
            array("enrolmentno"=> "231822612", "scode" => "01MRLG", "bundle_number" => "1MRLG013H", "dummy_number" => "D194284"),
            array("enrolmentno"=> "231822613", "scode" => "01MRLG", "bundle_number" => "1MRLG013H", "dummy_number" => "D194285"),
            array("enrolmentno"=> "231819312", "scode" => "01MREP", "bundle_number" => "1MREP004H", "dummy_number" => "D192688"),
            array("enrolmentno"=> "231841506", "scode" => "01MRLG", "bundle_number" => "01MRLG015H", "dummy_number" => "D194416"),


            array("enrolmentno"=> "231729507", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194562"),
            array("enrolmentno"=> "231729514", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194563"),
            array("enrolmentno"=> "231729520", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194564"),
            array("enrolmentno"=> "231729524", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194565"),
            array("enrolmentno"=> "231829104", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194566"),
            array("enrolmentno"=> "231829112", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194567"),
            array("enrolmentno"=> "231829113", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194568"),
            array("enrolmentno"=> "231829119", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194569"),
            array("enrolmentno"=> "231829121", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194570"),
            array("enrolmentno"=> "231835904", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194571"),
            array("enrolmentno"=> "231835908", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194572"),
            array("enrolmentno"=> "231835910", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194573"),
            array("enrolmentno"=> "231835915", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194574"),
            array("enrolmentno"=> "231835917", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194575"),
            array("enrolmentno"=> "231735916", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194576"),
            array("enrolmentno"=> "231735917", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194577"),
            array("enrolmentno"=> "231735919", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194578"),
            array("enrolmentno"=> "231833021", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194579"),
            array("enrolmentno"=> "231833020", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194580"),
            array("enrolmentno"=> "231833014", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194581"),
            array("enrolmentno"=> "231833010", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194582"),
            array("enrolmentno"=> "231833001", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194583"),
            array("enrolmentno"=> "231809823", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194584"),
            array("enrolmentno"=> "231822903", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194585"),
            array("enrolmentno"=> "231822906", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194586"),
            array("enrolmentno"=> "231822907", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194587"),
            array("enrolmentno"=> "231822908", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194588"),
            array("enrolmentno"=> "231822911", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194589"),
            array("enrolmentno"=> "231710921", "scode" => "01MRIT", "bundle_number" => "1MRIT001O", "dummy_number" => "D194590"),
            array("enrolmentno"=> "231703212", "scode" => "02MRIC", "bundle_number" => "2MRIC001H", "dummy_number" => "D196374"),
            array("enrolmentno"=> "231838403", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195121"),
            array("enrolmentno"=> "231838404", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195122"),
            array("enrolmentno"=> "231838408", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195123"),
            array("enrolmentno"=> "231838405", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195124"),
            array("enrolmentno"=> "231838409", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195125"),
            array("enrolmentno"=> "231838410", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195126"),
            array("enrolmentno"=> "231838411", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195127"),
            array("enrolmentno"=> "231838412", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195128"),
            array("enrolmentno"=> "231838414", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195129"),
            array("enrolmentno"=> "231838415", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195130"),
            array("enrolmentno"=> "231838416", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195131"),
            array("enrolmentno"=> "231838417", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195132"),
            array("enrolmentno"=> "231838418", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195133"),
            array("enrolmentno"=> "231838420", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195134"),
            array("enrolmentno"=> "231838421", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195135"),
            array("enrolmentno"=> "231814503", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195136"),
            array("enrolmentno"=> "231814511", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195137"),
            array("enrolmentno"=> "231814519", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195138"),
            array("enrolmentno"=> "231820301", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195139"),
            array("enrolmentno"=> "231820303", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195140"),
            array("enrolmentno"=> "231832406", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195141"),
            array("enrolmentno"=> "231832413", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195142"),
            array("enrolmentno"=> "231832414", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195143"),
            array("enrolmentno"=> "231832415", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195144"),
            array("enrolmentno"=> "231819607", "scode" => "01MRST", "bundle_number" => "01MRST009H", "dummy_number" => "D195145"),
            array("enrolmentno"=> "231817205", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194426"),
            array("enrolmentno"=> "231817211", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194427"),
            array("enrolmentno"=> "231803201", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194428"),
            array("enrolmentno"=> "231803207", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194429"),
            array("enrolmentno"=> "231803216", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194430"),
            array("enrolmentno"=> "231803221", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194431"),
            array("enrolmentno"=> "231814316", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194432"),
            array("enrolmentno"=> "231814317", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194433"),
            array("enrolmentno"=> "231814318", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194434"),
            array("enrolmentno"=> "231814319", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194435"),
            array("enrolmentno"=> "231825315", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194436"),
            array("enrolmentno"=> "231812216", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194437"),
            array("enrolmentno"=> "231807814", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194438"),
            array("enrolmentno"=> "231807504", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194439"),
            array("enrolmentno"=> "231813712", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194440"),
            array("enrolmentno"=> "231813716", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194441"),
            array("enrolmentno"=> "231813721", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194442"),
            array("enrolmentno"=> "231841904", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194443"),
            array("enrolmentno"=> "231841925", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194444"),
            array("enrolmentno"=> "231837610", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194445"),
            array("enrolmentno"=> "231837613", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194446"),
            array("enrolmentno"=> "231837616", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194447"),
            array("enrolmentno"=> "231837619", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194448"),
            array("enrolmentno"=> "231828101", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194449"),
            array("enrolmentno"=> "231828103", "scode" => "01MRST", "bundle_number" => "01MRST001H", "dummy_number" => "D194450"),
                      array("enrolmentno"=> "231835512", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194451"),
            array("enrolmentno"=> "231829610", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194452"),
            array("enrolmentno"=> "231829612", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194453"),
            array("enrolmentno"=> "231827322", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194454"),
            array("enrolmentno"=> "231840908", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194455"),
            array("enrolmentno"=> "231840925", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194456"),
            array("enrolmentno"=> "231838917", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194457"),
            array("enrolmentno"=> "231810328", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194458"),
            array("enrolmentno"=> "231810330", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194459"),
            array("enrolmentno"=> "231833801", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194460"),
            array("enrolmentno"=> "231833802", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194461"),
            array("enrolmentno"=> "231833804", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194462"),
            array("enrolmentno"=> "231833806", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194463"),
            array("enrolmentno"=> "231833308", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194464"),
            array("enrolmentno"=> "231833323", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194465"),
            array("enrolmentno"=> "231810503", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194466"),
            array("enrolmentno"=> "231810505", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194467"),
            array("enrolmentno"=> "231810506", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194468"),
            array("enrolmentno"=> "231810509", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194469"),
            array("enrolmentno"=> "231810510", "scode" => "01MRST", "bundle_number" => "01MRST002H", "dummy_number" => "D194470"),
            array("enrolmentno"=> "231838309", "scode" => "01MRST", "bundle_number" => "1MRST002H", "dummy_number" => "D194516"),
            array("enrolmentno"=> "231838310", "scode" => "01MRST", "bundle_number" => "1MRST002H", "dummy_number" => "D194517"),
            array("enrolmentno"=> "231838316", "scode" => "01MRST", "bundle_number" => "1MRST002H", "dummy_number" => "D194518"),
            array("enrolmentno"=> "231838321", "scode" => "01MRST", "bundle_number" => "1MRST002H", "dummy_number" => "D194519"),
            array("enrolmentno"=> "231811514", "scode" => "01MRST", "bundle_number" => "1MRST002H", "dummy_number" => "D194520"),
            array("enrolmentno"=> "231838623", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194521"),
            array("enrolmentno"=> "231821115", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194522"),
            array("enrolmentno"=> "231821106", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194523"),
            array("enrolmentno"=> "231825411", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194524"),
            array("enrolmentno"=> "231825414", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194525"),
            array("enrolmentno"=> "231825415", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194526"),
            array("enrolmentno"=> "231825419", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194527"),
            array("enrolmentno"=> "231816422", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194528"),
            array("enrolmentno"=> "231816423", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194529"),
            array("enrolmentno"=> "231816424", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194530"),
            array("enrolmentno"=> "231816425", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194531"),
            array("enrolmentno"=> "231812301", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194532"),
            array("enrolmentno"=> "231812303", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194533"),
            array("enrolmentno"=> "231812305", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194534"),
            array("enrolmentno"=> "231812307", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194535"),
            array("enrolmentno"=> "231812310", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194536"),
            array("enrolmentno"=> "231812314", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194537"),
            array("enrolmentno"=> "231812316", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194538"),
            array("enrolmentno"=> "231812320", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194539"),
            array("enrolmentno"=> "231812328", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194540"),
            array("enrolmentno"=> "231828313", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194541"),
            array("enrolmentno"=> "231833209", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194542"),
            array("enrolmentno"=> "231833225", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194543"),
            array("enrolmentno"=> "231732520", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194544"),
            array("enrolmentno"=> "231732522", "scode" => "01MRST", "bundle_number" => "1MRST003H", "dummy_number" => "D194545"),
            array("enrolmentno"=> "231838010", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194876"),
            array("enrolmentno"=> "231838012", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194877"),
            array("enrolmentno"=> "231842123", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194878"),
            array("enrolmentno"=> "231842106", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194879"),
            array("enrolmentno"=> "231842102", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194880"),
            array("enrolmentno"=> "231842025", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194881"),
            array("enrolmentno"=> "231815904", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194882"),
            array("enrolmentno"=> "231840509", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194883"),
            array("enrolmentno"=> "231840517", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194884"),
            array("enrolmentno"=> "231840518", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194885"),
            array("enrolmentno"=> "231812616", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194546"),
            array("enrolmentno"=> "231839505", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194547"),
            array("enrolmentno"=> "231839507", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194548"),
            array("enrolmentno"=> "231831517", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194549"),
            array("enrolmentno"=> "231831504", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194550"),
            array("enrolmentno"=> "231826912", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194551"),
            array("enrolmentno"=> "231816828", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194552"),
            array("enrolmentno"=> "231822021", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194553"),
            array("enrolmentno"=> "231822022", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194554"),
            array("enrolmentno"=> "231837408", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194555"),
            array("enrolmentno"=> "231837409", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194556"),
            array("enrolmentno"=> "231838003", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194557"),
            array("enrolmentno"=> "231838004", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194558"),
            array("enrolmentno"=> "231838008", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194559"),
            array("enrolmentno"=> "231838009", "scode" => "01MRST", "bundle_number" => "1MRST004H", "dummy_number" => "D194560"),
            array("enrolmentno"=> "231815601", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194886"),
            array("enrolmentno"=> "231815617", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194887"),
            array("enrolmentno"=> "231837508", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194888"),
            array("enrolmentno"=> "231837518", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194889"),
            array("enrolmentno"=> "231842409", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194890"),
            array("enrolmentno"=> "231831213", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194891"),
            array("enrolmentno"=> "231831223", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194892"),
            array("enrolmentno"=> "231841501", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194893"),
            array("enrolmentno"=> "231841502", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194894"),
            array("enrolmentno"=> "231841503", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194895"),
            array("enrolmentno"=> "231841504", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194896"),
            array("enrolmentno"=> "231841505", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194897"),
            array("enrolmentno"=> "231841506", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194898"),
            array("enrolmentno"=> "231841507", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194899"),
            array("enrolmentno"=> "231841508", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194900"),
            array("enrolmentno"=> "231841705", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194901"),
            array("enrolmentno"=> "231841708", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194902"),
            array("enrolmentno"=> "231841710", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194903"),
            array("enrolmentno"=> "231841711", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194904"),
            array("enrolmentno"=> "231841712", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194905"),
            array("enrolmentno"=> "231841714", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194906"),
            array("enrolmentno"=> "231841716", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194907"),
            array("enrolmentno"=> "231841718", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194908"),
            array("enrolmentno"=> "231841720", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194909"),
            array("enrolmentno"=> "231841722", "scode" => "01MRST", "bundle_number" => "1MRST005H", "dummy_number" => "D194910"),
            array("enrolmentno"=> "231822601", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D194911"),
            array("enrolmentno"=> "231822604", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D194912"),
            array("enrolmentno"=> "231822606", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D194913"),
            array("enrolmentno"=> "231822612", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D194914"),
            array("enrolmentno"=> "231822613", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D194915"),
            array("enrolmentno"=> "231822618", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D194916"),
            array("enrolmentno"=> "231822619", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D194917"),
            array("enrolmentno"=> "231822622", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D194918"),
            array("enrolmentno"=> "231822623", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D194919"),
            array("enrolmentno"=> "231822627", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D194920"),
            array("enrolmentno"=> "231822628", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D195056"),
            array("enrolmentno"=> "231831102", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D195057"),
            array("enrolmentno"=> "231831106", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D195058"),
            array("enrolmentno"=> "231831107", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D195059"),
            array("enrolmentno"=> "231831108", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D195060"),
            array("enrolmentno"=> "231831109", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D195061"),
            array("enrolmentno"=> "231831110", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D195062"),
            array("enrolmentno"=> "231831111", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D195063"),
            array("enrolmentno"=> "231831114", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D195064"),
            array("enrolmentno"=> "231831115", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D195065"),
            array("enrolmentno"=> "231831119", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D195066"),
            array("enrolmentno"=> "231831120", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D195067"),
            array("enrolmentno"=> "231831122", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D195068"),
            array("enrolmentno"=> "231831124", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D195069"),
            array("enrolmentno"=> "231831125", "scode" => "01MRST", "bundle_number" => "1MRST006H", "dummy_number" => "D195070"),
            array("enrolmentno"=> "231830103", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195071"),
            array("enrolmentno"=> "231830106", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195072"),
            array("enrolmentno"=> "231830108", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195073"),
            array("enrolmentno"=> "231830110", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195074"),
            array("enrolmentno"=> "231830113", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195075"),
            array("enrolmentno"=> "231830121", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195076"),
            array("enrolmentno"=> "231838505", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195077"),
            array("enrolmentno"=> "231838508", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195078"),
            array("enrolmentno"=> "231838514", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195079"),
            array("enrolmentno"=> "231838516", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195080"),
            array("enrolmentno"=> "231838519", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195081"),
            array("enrolmentno"=> "231838521", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195082"),
            array("enrolmentno"=> "231812401", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195083"),
            array("enrolmentno"=> "231812402", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195084"),
            array("enrolmentno"=> "231812403", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195085"),
            array("enrolmentno"=> "231812413", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195086"),
            array("enrolmentno"=> "231812414", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195087"),
            array("enrolmentno"=> "231812415", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195088"),
            array("enrolmentno"=> "231812418", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195089"),
            array("enrolmentno"=> "231812419", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195090"),
            array("enrolmentno"=> "231812420", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195091"),
            array("enrolmentno"=> "231812421", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195092"),
            array("enrolmentno"=> "231812422", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195093"),
            array("enrolmentno"=> "231812423", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195094"),
            array("enrolmentno"=> "231812425", "scode" => "01MRST", "bundle_number" => "1MRST007H", "dummy_number" => "D195095"),
            array("enrolmentno"=> "231839007", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195096"),
            array("enrolmentno"=> "231839008", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195097"),
            array("enrolmentno"=> "231839013", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195098"),
            array("enrolmentno"=> "231839014", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195099"),
            array("enrolmentno"=> "231821812", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195100"),
            array("enrolmentno"=> "231832604", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195101"),
            array("enrolmentno"=> "231832605", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195102"),
            array("enrolmentno"=> "231832609", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195103"),
            array("enrolmentno"=> "231832612", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195104"),
            array("enrolmentno"=> "231832614", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195105"),
            array("enrolmentno"=> "231832617", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195106"),
            array("enrolmentno"=> "231832618", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195107"),
            array("enrolmentno"=> "231832619", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195108"),
            array("enrolmentno"=> "231832620", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195109"),
            array("enrolmentno"=> "231832621", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195110"),
            array("enrolmentno"=> "231832624", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195111"),
            array("enrolmentno"=> "231833911", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195112"),
            array("enrolmentno"=> "231822103", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195113"),
            array("enrolmentno"=> "231822130", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195114"),
            array("enrolmentno"=> "231827803", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195115"),
            array("enrolmentno"=> "231827818", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195116"),
            array("enrolmentno"=> "231819626", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195117"),
            array("enrolmentno"=> "231830005", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195118"),
            array("enrolmentno"=> "231830008", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195119"),
            array("enrolmentno"=> "231830027", "scode" => "01MRST", "bundle_number" => "1MRST008H", "dummy_number" => "D195120"),

            array("enrolmentno"=> "151807828", "scode" => "ACCCA", "bundle_number" => "ACCCA001H", "dummy_number" => "D195738"),
            array("enrolmentno"=> "151807828", "scode" => "ACCCN", "bundle_number" => "ACCCN002H", "dummy_number" => "D195739"),
            array("enrolmentno"=> "151825309", "scode" => "ACCCN", "bundle_number" => "ACCCN001E", "dummy_number" => "D195740"),
            array("enrolmentno"=> "151807828", "scode" => "ACCDL", "bundle_number" => "ACCDL001H", "dummy_number" => "D195745"),
            array("enrolmentno"=> "151822529", "scode" => "ACCDL", "bundle_number" => "ACCDL001H", "dummy_number" => "D195746"),
            array("enrolmentno"=> "151807828", "scode" => "ACCPE", "bundle_number" => "ACCPE001H", "dummy_number" => "D195747"),

            array("enrolmentno"=> "231839008", "scode" => "01MRAA", "bundle_number" => "01MRAA012H", "dummy_number" => "D196205"),
            array("enrolmentno"=> "231819303", "scode" => "01MRAA", "bundle_number" => "01MRAA002H", "dummy_number" => "D194961"),
            array("enrolmentno"=> "231819304", "scode" => "01MRAA", "bundle_number" => "01MRAA002H", "dummy_number" => "D194962"),
            array("enrolmentno"=> "231819307", "scode" => "01MRAA", "bundle_number" => "01MRAA002H", "dummy_number" => "D194963"),
            array("enrolmentno"=> "231819312", "scode" => "01MRAA", "bundle_number" => "01MRAA002H", "dummy_number" => "D194964"),
            array("enrolmentno"=> "231819314", "scode" => "01MRAA", "bundle_number" => "01MRAA002H", "dummy_number" => "D194965"),
            array("enrolmentno"=> "231810330", "scode" => "01MRAA", "bundle_number" => "01MRAA002H", "dummy_number" => "D194966"),
            array("enrolmentno"=> "231837812", "scode" => "01MRAA", "bundle_number" => "01MRAA002H", "dummy_number" => "D194967"),
            array("enrolmentno"=> "231837813", "scode" => "01MRAA", "bundle_number" => "01MRAA002H", "dummy_number" => "D194968"),
            array("enrolmentno"=> "231837814", "scode" => "01MRAA", "bundle_number" => "01MRAA002H", "dummy_number" => "D194969"),
            array("enrolmentno"=> "231837815", "scode" => "01MRAA", "bundle_number" => "01MRAA002H", "dummy_number" => "D194970"),
            array("enrolmentno"=> "231837816", "scode" => "01MRAA", "bundle_number" => "01MRAA002H", "dummy_number" => "D194971"),
            array("enrolmentno"=> "231837817", "scode" => "01MRAA", "bundle_number" => "01MRAA002H", "dummy_number" => "D194972"),
            array("enrolmentno"=> "231837822", "scode" => "01MRAA", "bundle_number" => "01MRAA002H", "dummy_number" => "D194973"),
            array("enrolmentno"=> "211807401", "scode" => "01ASDAA", "bundle_number" => "01ASDAA002H", "dummy_number" => "D195799"),
            array("enrolmentno"=> "211807402", "scode" => "01ASDAA", "bundle_number" => "01ASDAA002H", "dummy_number" => "D195800"),
            array("enrolmentno"=> "9215323514", "scode" => "DEd_XII", "bundle_number" => "2NIMHDEDXII001H", "dummy_number" => "D193026"),
            array("enrolmentno"=> "231838008", "scode" => "01MREP", "bundle_number" => "1MREP005H", "dummy_number" => "D191510"),

            array("enrolmentno"=> "221828002", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196150"),
            array("enrolmentno"=> "221830802", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196151"),
            array("enrolmentno"=> "221807906", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196152"),
            array("enrolmentno"=> "221807923", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196153"),
            array("enrolmentno"=> "221825308", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196154"),
            array("enrolmentno"=> "221825316", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196155"),
            array("enrolmentno"=> "221825311", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196156"),
            array("enrolmentno"=> "221814518", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196157"),
            array("enrolmentno"=> "221707817", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196158"),
            array("enrolmentno"=> "221807822", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196159"),
            array("enrolmentno"=> "221807817", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196160"),
            array("enrolmentno"=> "221627327", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196161"),
            array("enrolmentno"=> "221821004", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196162"),
            array("enrolmentno"=> "221819301", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196163"),
            array("enrolmentno"=> "221819302", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196164"),
            array("enrolmentno"=> "221819305", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196165"),
            array("enrolmentno"=> "221819309", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196166"),
            array("enrolmentno"=> "221819311", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196167"),
            array("enrolmentno"=> "221819313", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196168"),
            array("enrolmentno"=> "221819315", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196169"),
            array("enrolmentno"=> "221819320", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196170"),
            array("enrolmentno"=> "221819321", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196171"),
            array("enrolmentno"=> "221819322", "scode" => "01CPEC", "bundle_number" => "01CPEC001H", "dummy_number" => "D196172"),
            array("enrolmentno"=> "231840506", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D19899"),
            array("enrolmentno"=> "231840507", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D19900"),
            array("enrolmentno"=> "231840509", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D19901"),
            array("enrolmentno"=> "231840512", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D19902"),
            array("enrolmentno"=> "231840513", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D19903"),
            array("enrolmentno"=> "231840515", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D19904"),
            array("enrolmentno"=> "231840516", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D19905"),
            array("enrolmentno"=> "231840517", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D19906"),
            array("enrolmentno"=> "231840518", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D19907"),
            array("enrolmentno"=> "231840519", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D19908"),
            array("enrolmentno"=> "231840520", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D19909"),
            array("enrolmentno"=> "231840521", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D19910"),
            array("enrolmentno"=> "231840523", "scode" => "01MREP", "bundle_number" => "1MREP0010H", "dummy_number" => "D196462"),
            array("enrolmentno"=> "231840524", "scode" => "01MREP", "bundle_number" => "1MREP0010H", "dummy_number" => "D196463"),
            array("enrolmentno"=> "231840525", "scode" => "01MREP", "bundle_number" => "1MREP0010H", "dummy_number" => "D196464"),
            array("enrolmentno"=> "231825120", "scode" => "01MREP", "bundle_number" => "1MREP0010H", "dummy_number" => "D196465"),
            array("enrolmentno"=> "231839105", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D196496"),
            array("enrolmentno"=> "231831115", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D196497"),
            array("enrolmentno"=> "231831120", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D196498"),
            array("enrolmentno"=> "231842106", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D196499"),
            array("enrolmentno"=> "231828101", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D196500"),
            array("enrolmentno"=> "231818406", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D196476"),
            array("enrolmentno"=> "231818413", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D196477"),
            array("enrolmentno"=> "231818409", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D196478"),
            array("enrolmentno"=> "231818414", "scode" => "01MREP", "bundle_number" => "1MREP010H", "dummy_number" => "D196479"),
            */

            array("enrolmentno"=> "231818409", "scode" => "01MRST", "bundle_number" => "1MRST012H", "dummy_number" => "D196480"),
            array("enrolmentno"=> "231818406", "scode" => "01MRST", "bundle_number" => "1MRST012H", "dummy_number" => "D196491"),
            array("enrolmentno"=> "231707202", "scode" => "02MRMT", "bundle_number" => "2MRMT010H", "dummy_number" => "D196492"),
            array("enrolmentno"=> "231718422", "scode" => "02MRMT", "bundle_number" => "2MRMT010H", "dummy_number" => "D196493"),
            array("enrolmentno"=> "231818413", "scode" => "01MRST", "bundle_number" => "1MRST012H", "dummy_number" => "D196511"),
            array("enrolmentno"=> "231841001", "scode" => "01MRST", "bundle_number" => "1MRST012H", "dummy_number" => "D196512"),
            array("enrolmentno"=> "231818414", "scode" => "01MRST", "bundle_number" => "1MRST012H", "dummy_number" => "D196513"),

        );

        $filename = base_path().'/logs/exambundles2.txt';

        $sno = 1;

        /*
        foreach ($details as $detail) {
            $candidate = Candidate::where('enrolmentno', $detail['enrolmentno'])->first();

            if(!is_null($candidate)) {

                $subject = Subject::where('scode', $detail['scode'])->first();

                if(!is_null($subject)) {
                    $application = Application::where('exam_id', $exam->id)->where('candidate_id', $candidate->id)
                        ->where('subject_id', $subject->id)->first();

                    if(!is_null($application)) {
                        $application->update([
                            'bundle_number' => $detail['bundle_number'],
                            'dummy_number'  => $detail['dummy_number'],
                        ]);
                    }
                    else {
                        $text = str_pad($sno,2,"0",STR_PAD_LEFT)." Dummy Number: ".$detail['dummy_number']."\t"." Error: Invalid Application"."\n";
                        if(file_exists($filename)) {
                            $file = fopen($filename, "a");
                        }
                        else {
                            $file = fopen($filename, "w");
                        }

                        fwrite($file, $text);
                        fclose($file);
                        $sno++;
                    }
                }
                else {
                    $text = str_pad($sno,2,"0",STR_PAD_LEFT)." Dummy Number: ".$detail['dummy_number']."\t"." Error: Invalid Subject Code"."\n";
                    if(file_exists($filename)) {
                        $file = fopen($filename, "a");
                    }
                    else {
                        $file = fopen($filename, "w");
                    }

                    fwrite($file, $text);
                    fclose($file);
                    $sno++;
                }


            }
            else {
                $text = str_pad($sno,2,"0",STR_PAD_LEFT)." Dummy Number: ".$detail['dummy_number']."\t"." Error: Invalid Enrolmentno"."\n";
                if(file_exists($filename)) {
                    $file = fopen($filename, "a");
                }
                else {
                    $file = fopen($filename, "w");
                }

                fwrite($file, $text);
                fclose($file);
                $sno++;
            }
        }
        */

        foreach ($details as $detail) {
            $candidate = Candidate::where('enrolmentno', $detail['enrolmentno'])->first();

            if(!is_null($candidate)) {
                $subjects = Subject::where('scode', $detail['scode'])->get();

                if($subjects->count() == '0') {
                    $text = str_pad($sno,2,"0",STR_PAD_LEFT)." Dummy Number: ".$detail['dummy_number']."\t"." Error: Invalid Subject Code"."\n";
                    if(file_exists($filename)) {
                        $file = fopen($filename, "a");
                    }
                    else {
                        $file = fopen($filename, "w");
                    }

                    fwrite($file, $text);
                    fclose($file);
                    $sno++;
                }
                else {

                    $application_count = 0;
                    foreach ($subjects as $subject) {
                        $application = Application::where('exam_id', $exam->id)->where('candidate_id', $candidate->id)
                            ->where('subject_id', $subject->id)->first();

                        if(!is_null($application)) {
                            $application_count++;

                            $application->update([
                                'bundle_number' => $detail['bundle_number'],
                                'dummy_number'  => $detail['dummy_number'],
                            ]);
                        }
                    }

                    if($application_count == 0) {
                        $text = str_pad($sno,2,"0",STR_PAD_LEFT)." Dummy Number: ".$detail['dummy_number']."\t"." Error: Invalid Application"."\n";
                        if(file_exists($filename)) {
                            $file = fopen($filename, "a");
                        }
                        else {
                            $file = fopen($filename, "w");
                        }

                        fwrite($file, $text);
                        fclose($file);
                        $sno++;
                    }
                }
            }
            else {
                $text = str_pad($sno,2,"0",STR_PAD_LEFT)." Dummy Number: ".$detail['dummy_number']."\t"." Error: Invalid Enrolmentno"."\n";
                if(file_exists($filename)) {
                    $file = fopen($filename, "a");
                }
                else {
                    $file = fopen($filename, "w");
                }

                fwrite($file, $text);
                fclose($file);
                $sno++;
            }
        }
    }
}
