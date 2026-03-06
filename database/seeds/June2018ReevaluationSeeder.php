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

class June2018ReevaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //$reevaluation = Reevaluation::where('exam_id', '2')->first()->id;
        //$reevaluation = Reevaluation::where('exam_id', '3')->first()->id;

        /*
        Reevaluation::create([
            'exam_id'=>'3',
            'resultdate' => '2018-11-01',
            'publish_status' => '1'
        ]);
        */


        $revaluation_array = array(
             /*
            //-- List No.: 1 --//
            array("enrolmentno" => "231612919", "scode" => "02MRDM ", "exam_id" => "2", "reevaluated_external_mark" => "27", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "231615606", "scode" => "02MRDM", "exam_id" => "2", "reevaluated_external_mark" => "20", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "231621413", "scode" => "02MRDM", "exam_id" => "2", "reevaluated_external_mark" => "27", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "211625616", "scode" => "02ASDES", "exam_id" => "2", "reevaluated_external_mark" => "27", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "211716919", "scode" => "01ASDIM", "exam_id" => "2", "reevaluated_external_mark" => "26", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "211711821", "scode" => "01ASDNE", "exam_id" => "2", "reevaluated_external_mark" => "28", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "211616222", "scode" => "02ASDAF", "exam_id" => "2", "reevaluated_external_mark" => "26", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "211711812", "scode" => "01ASDIT", "exam_id" => "2", "reevaluated_external_mark" => "25", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "211616222", "scode" => "02ASDTI-1", "exam_id" => "2", "reevaluated_external_mark" => "23", "reevaluation_remarks" => "Change", "publish_status" => "1"),
            array("enrolmentno" => "211616222", "scode" => "02ASDIC", "exam_id" => "2", "reevaluated_external_mark" => "25", "reevaluation_remarks" => "Change", "publish_status" => "1"),

            array("enrolmentno"=>"231608006","scode"=>"02MRIC", "exam_id"=>"2", "reevaluated_external_mark"=>"17", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231621327","scode"=>"02MRIC", "exam_id"=>"2", "reevaluated_external_mark"=>"19", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231607718","scode"=>"02MRIC", "exam_id"=>"2", "reevaluated_external_mark"=>"21", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231608004","scode"=>"02MRIC", "exam_id"=>"2", "reevaluated_external_mark"=>"13", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231615604","scode"=>"02MRMT", "exam_id"=>"2", "reevaluated_external_mark"=>"18", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231612630","scode"=>"02MRSC", "exam_id"=>"2", "reevaluated_external_mark"=>"21", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231717018","scode"=>"01MRLG", "exam_id"=>"2", "reevaluated_external_mark"=>"33", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231612610","scode"=>"02MRES", "exam_id"=>"2", "reevaluated_external_mark"=>"21", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231625826","scode"=>"02MRMT", "exam_id"=>"2", "reevaluated_external_mark"=>"20", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231615011","scode"=>"02MRES ", "exam_id"=>"2", "reevaluated_external_mark"=>"23", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231624604","scode"=>"02MRES ", "exam_id"=>"2", "reevaluated_external_mark"=>"18", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231615919","scode"=>"02MRES ", "exam_id"=>"2", "reevaluated_external_mark"=>"8", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231716118","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"32", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231708004","scode"=>"01MRIT", "exam_id"=>"2", "reevaluated_external_mark"=>"12", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"241715904","scode"=>"ECSCT", "exam_id"=>"2", "reevaluated_external_mark"=>"44", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231717911","scode"=>"01MRMT", "exam_id"=>"2", "reevaluated_external_mark"=>"20", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"221728016","scode"=>"01CPIT", "exam_id"=>"2", "reevaluated_external_mark"=>"28", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),

            array("enrolmentno"=>"211730521","scode"=>"01ASDAM", "exam_id"=>"2", "reevaluated_external_mark"=>"31", "reevaluation_remarks"=>"Change", "publish_status"=>"1"), array("enrolmentno"=>"231725914","scode"=>"01MRIT", "exam_id"=>"2", "reevaluated_external_mark"=>"22", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231717006","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"9", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231607428","scode"=>"02MRDM", "exam_id"=>"2", "reevaluated_external_mark"=>"19", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231607428","scode"=>"02MRTP", "exam_id"=>"2", "reevaluated_external_mark"=>"20", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231616228","scode"=>"02MRMT", "exam_id"=>"2", "reevaluated_external_mark"=>"14", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"221605305","scode"=>"02CPES ", "exam_id"=>"2", "reevaluated_external_mark"=>"26", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"221602507","scode"=>"02CPES ", "exam_id"=>"2", "reevaluated_external_mark"=>"30", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"221603222","scode"=>"02CPES ", "exam_id"=>"2", "reevaluated_external_mark"=>"21", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231717911","scode"=>"01MRLG", "exam_id"=>"2", "reevaluated_external_mark"=>"7", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231624802","scode"=>"02MRES", "exam_id"=>"2", "reevaluated_external_mark"=>"17", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231717029","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"9", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231615606","scode"=>"02MRIC", "exam_id"=>"2", "reevaluated_external_mark"=>"23", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"211605506","scode"=>"02ASDTI-1", "exam_id"=>"2", "reevaluated_external_mark"=>"22", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231621404","scode"=>"02MRDM ", "exam_id"=>"2", "reevaluated_external_mark"=>"20", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231718708","scode"=>"01MRIT", "exam_id"=>"2", "reevaluated_external_mark"=>"36", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231728009","scode"=>"01MRAA", "exam_id"=>"2", "reevaluated_external_mark"=>"11", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231615019","scode"=>"02MRMT", "exam_id"=>"2", "reevaluated_external_mark"=>"14", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231615019","scode"=>"02MRTP", "exam_id"=>"2", "reevaluated_external_mark"=>"15", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231612109","scode"=>"02MRSC", "exam_id"=>"2", "reevaluated_external_mark"=>"15", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231612107","scode"=>"02MRSC", "exam_id"=>"2", "reevaluated_external_mark"=>"7", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"221603319","scode"=>"02CPES", "exam_id"=>"2", "reevaluated_external_mark"=>"12", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),
            array("enrolmentno"=>"221628012","scode"=>"02CPAA", "exam_id"=>"2", "reevaluated_external_mark"=>"23", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"221728019","scode"=>"01CPPM", "exam_id"=>"2", "reevaluated_external_mark"=>"22", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"211616225","scode"=>"02ASDTI-1", "exam_id"=>"2", "reevaluated_external_mark"=>"18", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231618427","scode"=>"02MRDM", "exam_id"=>"2", "reevaluated_external_mark"=>"15", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),

            array("enrolmentno"=>"231726702","scode"=>"01MRMT", "exam_id"=>"2", "reevaluated_external_mark"=>"17", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231721028","scode"=>"01MRST", "exam_id"=>"2", "reevaluated_external_mark"=>"8", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231717719","scode"=>"01MRST", "exam_id"=>"2", "reevaluated_external_mark"=>"3", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231729222","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"8", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231729221","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"9", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231729219","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"6", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231729211","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"9", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231729210","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"6", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231729206","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"7", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231729205","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"7", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231729204","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"5", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),

            //array("enrolmentno"=>"231729201","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"7", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),

            array("enrolmentno"=>"231728009","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"10", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231728024","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"2", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231711702","scode"=>"01MREP", "exam_id"=>"2", "reevaluated_external_mark"=>"6", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231723610","scode"=>"01MRLG", "exam_id"=>"2", "reevaluated_external_mark"=>"21", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231723623","scode"=>"01MRLG", "exam_id"=>"2", "reevaluated_external_mark"=>"20", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"211701406","scode"=>"01ASDIT", "exam_id"=>"2", "reevaluated_external_mark"=>"16", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231726701","scode"=>"01MRIT", "exam_id"=>"2", "reevaluated_external_mark"=>"16", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231712102","scode"=>"01MRIT", "exam_id"=>"2", "reevaluated_external_mark"=>"9", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231718004","scode"=>"01MRIT", "exam_id"=>"2", "reevaluated_external_mark"=>"33", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231733909","scode"=>"01MRIT", "exam_id"=>"2", "reevaluated_external_mark"=>"14", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"231720707","scode"=>"01MRIT", "exam_id"=>"2", "reevaluated_external_mark"=>"29", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"211705513","scode"=>"01ASDEP", "exam_id"=>"2", "reevaluated_external_mark"=>"23", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"211705506","scode"=>"01ASDEP", "exam_id"=>"2", "reevaluated_external_mark"=>"18", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"211705510","scode"=>"01ASDEP", "exam_id"=>"2", "reevaluated_external_mark"=>"13", "reevaluation_remarks"=>"No Change", "publish_status"=>"1"),
            array("enrolmentno"=>"211705502","scode"=>"01ASDEP", "exam_id"=>"2", "reevaluated_external_mark"=>"20", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),
            array("enrolmentno"=>"211705505","scode"=>"01ASDEP", "exam_id"=>"2", "reevaluated_external_mark"=>"16", "reevaluation_remarks"=>"Change", "publish_status"=>"1"),

            //-- List No.: 2 --//
            array('enrolmentno'=>'231729202','scode'=>'01MREP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'7', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231721329','scode'=>'01MREP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221627913','scode'=>'02CPIC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'45', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231712323','scode'=>'01MREP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231712323','scode'=>'01MRMT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231615011','scode'=>'02MRES ', 'exam_id'=>'2', 'reevaluated_external_mark'=>'16', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221703321','scode'=>'01CPIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231615919','scode'=>'02MRTP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'16', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211705507','scode'=>'01ASDEP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'20', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231733915','scode'=>'01MREP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'11', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231733909','scode'=>'01MRLG', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            */

            /*
            //-- List No.: 3 --//
            array('enrolmentno'=>'231617030','scode'=>'02MRES', 'exam_id'=>'2', 'reevaluated_external_mark'=>'14', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231629416','scode'=>'02MRIC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'21', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211711819','scode'=>'01ASDAA', 'exam_id'=>'2', 'reevaluated_external_mark'=>'11', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211716922','scode'=>'01ASDEP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'23', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211716919','scode'=>'01ASDEP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231712102','scode'=>'01MREP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'5', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221703323','scode'=>'01CPIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'20', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221703315','scode'=>'01CPIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'15', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221703317','scode'=>'01CPIT ', 'exam_id'=>'2', 'reevaluated_external_mark'=>'19', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221703318','scode'=>'01CPIT ', 'exam_id'=>'2', 'reevaluated_external_mark'=>'25', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221703307','scode'=>'01CPIT ', 'exam_id'=>'2', 'reevaluated_external_mark'=>'16', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221703303','scode'=>'01CPIT ', 'exam_id'=>'2', 'reevaluated_external_mark'=>'19', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221703304','scode'=>'01CPIT ', 'exam_id'=>'2', 'reevaluated_external_mark'=>'14', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221734001','scode'=>'01CPIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'26', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211630712','scode'=>'02ASDES', 'exam_id'=>'2', 'reevaluated_external_mark'=>'21', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211700301','scode'=>'01ASDIM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231731020','scode'=>'01MREP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'22', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231712323','scode'=>'01MRST', 'exam_id'=>'2', 'reevaluated_external_mark'=>'15', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231607718','scode'=>'02MRES ', 'exam_id'=>'2', 'reevaluated_external_mark'=>'15', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231615604','scode'=>'02MRES', 'exam_id'=>'2', 'reevaluated_external_mark'=>'19', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231615606','scode'=>'02MRES ', 'exam_id'=>'2', 'reevaluated_external_mark'=>'13', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231717911','scode'=>'01MRST', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231712323','scode'=>'01MRLG', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231615011','scode'=>'02MRMT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231625824','scode'=>'02MRMT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'19', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221727304','scode'=>'01CPIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'12', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221727316','scode'=>'01CPIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'16', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211716809','scode'=>'01ASDAM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'38', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221707802','scode'=>'01CPEC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221627315','scode'=>'02CPCC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'19', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221703316','scode'=>'01CPIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'27', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231718404','scode'=>'01MREP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'10', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231620307','scode'=>'02MRDM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231620313','scode'=>'02MRDM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'16', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231620317','scode'=>'02MRDM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'15', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231620321','scode'=>'02MRDM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'10', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231617927','scode'=>'02MRDM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'11', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231617921','scode'=>'02MRDM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'12', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231718408','scode'=>'01MREP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'7', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231610602','scode'=>'02MRES', 'exam_id'=>'2', 'reevaluated_external_mark'=>'20', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),


            //-- List No.: 4 --//
            array('enrolmentno'=>'221728019','scode'=>'01CPCM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221707811','scode'=>'01CPCM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231729609','scode'=>'01MRAA', 'exam_id'=>'2', 'reevaluated_external_mark'=>'19', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231729610','scode'=>'01MRAA', 'exam_id'=>'2', 'reevaluated_external_mark'=>'19', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231726701','scode'=>'01MRAA', 'exam_id'=>'2', 'reevaluated_external_mark'=>'11', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231718408','scode'=>'01MRAA', 'exam_id'=>'2', 'reevaluated_external_mark'=>'13', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231720713','scode'=>'01MRAA', 'exam_id'=>'2', 'reevaluated_external_mark'=>'14', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231718404','scode'=>'01MRLG', 'exam_id'=>'2', 'reevaluated_external_mark'=>'12', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231718418','scode'=>'01MRLG', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231718408','scode'=>'01MRLG', 'exam_id'=>'2', 'reevaluated_external_mark'=>'13', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221707920','scode'=>'01CPIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'28', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231718418','scode'=>'01MRIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'11', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231718427','scode'=>'01MRIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'5', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231718413','scode'=>'01MRIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'11', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231718423','scode'=>'01MRIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'10', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231729609','scode'=>'01MRIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'19', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),


            //-- List No.: 5 --//
            array('enrolmentno'=>'231718427','scode'=>'01MRMT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'9', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231729609','scode'=>'01MRMT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'3', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231612508','scode'=>'02MRMT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'15', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231625828','scode'=>'02MRMT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231615606','scode'=>'02MRMT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'20', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231718427','scode'=>'01MRST', 'exam_id'=>'2', 'reevaluated_external_mark'=>'11', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231610408','scode'=>'02MRIC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'8', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231629421','scode'=>'02MRIC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'11', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231615604','scode'=>'02MRIC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'13', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231620520','scode'=>'02MRMT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'22', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),


            //-- List No.: 6 --//
            array('enrolmentno'=>'241715904','scode'=>'ECSIA', 'exam_id'=>'2', 'reevaluated_external_mark'=>'38', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231615604','scode'=>'02MRDM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231615019','scode'=>'02MRDM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211600825','scode'=>'02ASDIC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'25', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211600830','scode'=>'02ASDES', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211600823','scode'=>'02ASDIC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211600817','scode'=>'02ASDIC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'19', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211600824','scode'=>'02ASDES', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211600820','scode'=>'02ASDIC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221628514','scode'=>'02CPIC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211711819','scode'=>'01ASDAM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'20', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231710602','scode'=>'01MREP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'33', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231618427','scode'=>'02MRES', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231617906','scode'=>'02MRES', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221707920','scode'=>'01CPEP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231710602','scode'=>'01MRLG', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),

            //-- List No.: 7 --//
            array('enrolmentno'=>'231621402','scode'=>'02MRDM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'21', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231629602','scode'=>'02MRSC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'7', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221707802','scode'=>'01CPPM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'26', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221707811','scode'=>'01CPPM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'19', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231619122','scode'=>'02MRES', 'exam_id'=>'2', 'reevaluated_external_mark'=>'17', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231621420','scode'=>'02MRES', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231621413','scode'=>'02MRES', 'exam_id'=>'2', 'reevaluated_external_mark'=>'28', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221728023','scode'=>'01CPEC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221603319','scode'=>'02CPCC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'22', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221707803','scode'=>'01CPEC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211711816','scode'=>'01ASDNE', 'exam_id'=>'2', 'reevaluated_external_mark'=>'22', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211705502','scode'=>'01ASDNE', 'exam_id'=>'2', 'reevaluated_external_mark'=>'21', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'251731602','scode'=>'DVRMT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'15', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'251731613','scode'=>'DVRMT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'15', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221707803','scode'=>'01CPPM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'23', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231621420','scode'=>'02MRDM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'22', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),

            //-- List No.: 8 --//
            array('enrolmentno'=>'231720407','scode'=>'01MRLG', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221707802','scode'=>'01CPEP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'21', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221707803','scode'=>'01CPEP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'28', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231720707','scode'=>'01MREP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'37', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231720410','scode'=>'01MRLG', 'exam_id'=>'2', 'reevaluated_external_mark'=>'8', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231720416','scode'=>'01MRLG', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231720405','scode'=>'01MRLG', 'exam_id'=>'2', 'reevaluated_external_mark'=>'11', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211605513','scode'=>'02ASDTI-1', 'exam_id'=>'2', 'reevaluated_external_mark'=>'19', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),


            //-- List No.: 9 --//
            array('enrolmentno'=>'231616819','scode'=>'02MRES', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231624109','scode'=>'02MRTP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'14', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'241715904','scode'=>'ECSEP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'50', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'221627315','scode'=>'02CPVE', 'exam_id'=>'2', 'reevaluated_external_mark'=>'22', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211716809','scode'=>'01ASDIM', 'exam_id'=>'2', 'reevaluated_external_mark'=>'42', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211620510','scode'=>'02ASDIC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'20', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211620512','scode'=>'02ASDAF', 'exam_id'=>'2', 'reevaluated_external_mark'=>'14', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231720525','scode'=>'01MRLG', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211620512','scode'=>'02ASDCP', 'exam_id'=>'2', 'reevaluated_external_mark'=>'20', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211614525','scode'=>'02ASDTI-2', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211614511','scode'=>'02ASDTI-2', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231720525','scode'=>'01MRMT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'7', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211720517','scode'=>'01ASDIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211720513','scode'=>'01ASDIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'16', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211720512','scode'=>'01ASDIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'14', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211720509','scode'=>'01ASDIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'17', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211720506','scode'=>'01ASDIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211714508','scode'=>'01ASDIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'16', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211714505','scode'=>'01ASDIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'28', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'211720518','scode'=>'01ASDIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'24', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231718404','scode'=>'01MRIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'10', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231629305','scode'=>'02MRIC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'25', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),


            array('enrolmentno'=>'1211705430','scode'=>'ACCCA', 'exam_id'=>'3', 'reevaluated_external_mark'=>'40', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),

            array('enrolmentno'=>'231607428','scode'=>'02MRSC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'21', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231607413','scode'=>'02MRSC', 'exam_id'=>'2', 'reevaluated_external_mark'=>'21', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231617907','scode'=>'02MRES', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231617904','scode'=>'02MRES', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231617918','scode'=>'02MRES', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231617908','scode'=>'02MRES', 'exam_id'=>'2', 'reevaluated_external_mark'=>'18', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231729905','scode'=>'01MRIT', 'exam_id'=>'2', 'reevaluated_external_mark'=>'11', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'231723610','scode'=>'01MRLG', 'exam_id'=>'2', 'reevaluated_external_mark'=>'21', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),

            array('enrolmentno'=>'1211713028','scode'=>'ACCDL', 'exam_id'=>'3', 'reevaluated_external_mark'=>'43', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'1211713028','scode'=>'ACCPE', 'exam_id'=>'3', 'reevaluated_external_mark'=>'41', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'1211713001','scode'=>'ACCDL', 'exam_id'=>'3', 'reevaluated_external_mark'=>'40', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'1211725308','scode'=>'ACCDL', 'exam_id'=>'3', 'reevaluated_external_mark'=>'30', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'1211712311','scode'=>'ACCCN', 'exam_id'=>'3', 'reevaluated_external_mark'=>'37', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'1211705430','scode'=>'ACCCA', 'exam_id'=>'3', 'reevaluated_external_mark'=>'40', 'reevaluation_remarks'=>'Change', 'publish_status'=>'1'),
            array('enrolmentno'=>'1211713001','scode'=>'ACCCN', 'exam_id'=>'3', 'reevaluated_external_mark'=>'22', 'reevaluation_remarks'=>'No Change', 'publish_status'=>'1'),
            */
        );

        foreach($revaluation_array as $rea) {
            $candidate_id = Candidate::where('enrolmentno', $rea["enrolmentno"])->first()->id;
            $subject_id = Subject::where('scode', $rea["scode"])->first()->id;
            $application = Application::where('exam_id', $rea["exam_id"])->where('candidate_id', $candidate_id)
                ->where('subject_id', $subject_id)->first()->id;

            if(!is_null($application)) {

                $mark = Mark::where('application_id', $application)->first();

                if(!is_null($mark)) {
                    $reevaluation = Reevaluation::where('exam_id', $rea["exam_id"])->first()->id;

                    $re = Reevaluationresult::where('reevaluation_id', $reevaluation)->where('candidate_id', $candidate_id)
                        ->where('subject_id', $subject_id)->first();

                    if(is_null($re)) {
                        Reevaluationresult::create([
                            'reevaluation_id' => $reevaluation,
                            'mark_id' => $mark->id,
                            'application_id' => $application,
                            'candidate_id' => $candidate_id,
                            'subject_id' => $subject_id,
                            'actual_external_mark' => (int) $mark->external + (int) $mark->grace,
                            'reevaluated_external_mark' => $rea["reevaluated_external_mark"],
                            'reevaluation_remarks' => $rea["reevaluation_remarks"],
                            'publish_status' => $rea["publish_status"]
                        ]);

                        $mark->external = $rea["reevaluated_external_mark"];
                        $mark->save();
                    }
                }
            }
        }

    }
}
