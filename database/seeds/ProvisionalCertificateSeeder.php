<?php

use Illuminate\Database\Seeder;
use App\Candidate;
use App\Provisionalcertificate;
use App\Exam;

class ProvisionalCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->publishProvisionalCertificate();
        //$this->withheldProvisionalCertificate();
    }

    public function publishProvisionalCertificate() {
        $provisionalArray = array(
            array("enrolmentno" => "211907815","course_percentage" => "79.52","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "211925109","course_percentage" => "67.15","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "211916923","course_percentage" => "60.41","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "211916912","course_percentage" => "66.52","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "211927913","course_percentage" => "70.26","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "212041410","course_percentage" => "79.07","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "212000311","course_percentage" => "71.74","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "212007725","course_percentage" => "60.67","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "212028027","course_percentage" => "63.78","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "212028003","course_percentage" => "64.22","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "212030805","course_percentage" => "71.78","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "212040313","course_percentage" => "67.26","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "212025108","course_percentage" => "74.85","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "212016929","course_percentage" => "73.19","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "212016108","course_percentage" => "59.15","class" => "Second Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "212028612","course_percentage" => "59.48","class" => "Second Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "212028610","course_percentage" => "74.96","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "212028206","course_percentage" => "74.56","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "212028211","course_percentage" => "67.93","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "212028214","course_percentage" => "70.74","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "221821009","course_percentage" => "57.42","class" => "Second Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "221928010","course_percentage" => "60.69","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "222025313","course_percentage" => "73.58","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "222030817","course_percentage" => "81.04","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "222025105","course_percentage" => "66.77","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "222045404","course_percentage" => "80.81","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231829103","course_percentage" => "81.08","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231807819","course_percentage" => "56.76","class" => "Second Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231807814","course_percentage" => "53.40","class" => "Second Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231830002","course_percentage" => "72.96","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231810303","course_percentage" => "70.24","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231828113","course_percentage" => "66.20","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231828116","course_percentage" => "66.04","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231931610","course_percentage" => "68.16","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231912908","course_percentage" => "64.92","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231915809","course_percentage" => "67.40","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231915808","course_percentage" => "71.68","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231915806","course_percentage" => "70.84","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231915804","course_percentage" => "71.64","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231915816","course_percentage" => "73.68","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231932602","course_percentage" => "67.16","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231932604","course_percentage" => "78.96","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231932608","course_percentage" => "71.16","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231932617","course_percentage" => "70.96","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231939910","course_percentage" => "80.04","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231924025","course_percentage" => "77.60","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231924001","course_percentage" => "78.04","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231924022","course_percentage" => "77.44","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231929414","course_percentage" => "70.72","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231928111","course_percentage" => "78.72","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231938507","course_percentage" => "82.20","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231939012","course_percentage" => "82.56","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "231939115","course_percentage" => "74.84","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232006905","course_percentage" => "69.64","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232028403","course_percentage" => "73","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232029115","course_percentage" => "82.60","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232029124","course_percentage" => "82","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232029118","course_percentage" => "82.44","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232035908","course_percentage" => "81.28","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232026705","course_percentage" => "57.40","class" => "Second Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232026713","course_percentage" => "66.64","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232026710","course_percentage" => "59.92","class" => "Second Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232031601","course_percentage" => "68.72","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232007727","course_percentage" => "71.28","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232025324","course_percentage" => "70.84","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232012214","course_percentage" => "66.20","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232007508","course_percentage" => "56.80","class" => "Second Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232007609","course_percentage" => "65.12","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232007604","course_percentage" => "62.48","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232028008","course_percentage" => "69.96","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232030818","course_percentage" => "73.16","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232031828","course_percentage" => "55.76","class" => "Second Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232039817","course_percentage" => "62.20","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232043319","course_percentage" => "63.64","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232008120","course_percentage" => "62.96","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232021026","course_percentage" => "57.92","class" => "Second Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232021011","course_percentage" => "55.16","class" => "Second Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232021010","course_percentage" => "61.12","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232008504","course_percentage" => "70.12","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232025910","course_percentage" => "66.20","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232030320","course_percentage" => "67.48","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232025117","course_percentage" => "64.04","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232016928","course_percentage" => "77.36","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232015812","course_percentage" => "69.80","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232019601","course_percentage" => "61.60","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232030018","course_percentage" => "65.68","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232016020","course_percentage" => "62.16","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232016002","course_percentage" => "61.24","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232009221","course_percentage" => "73.24","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232014019","course_percentage" => "69.28","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232018723","course_percentage" => "74.16","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232020319","course_percentage" => "77.44","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232031306","course_percentage" => "82.60","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232031319","course_percentage" => "80.92","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232038818","course_percentage" => "83.24","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232038801","course_percentage" => "80.04","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232012025","course_percentage" => "70.44","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232021311","course_percentage" => "59.48","class" => "Second Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232027202","course_percentage" => "58.72","class" => "Second Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232027210","course_percentage" => "70.12","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232033408","course_percentage" => "72.12","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232037709","course_percentage" => "75.64","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232045524","course_percentage" => "72.20","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232010214","course_percentage" => "72.60","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232011802","course_percentage" => "80.64","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232014328","course_percentage" => "82.16","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232014320","course_percentage" => "83.76","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232014303","course_percentage" => "86.28","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232014329","course_percentage" => "85.44","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232014319","course_percentage" => "85.48","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232014311","course_percentage" => "82.48","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232017108","course_percentage" => "68.56","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232017103","course_percentage" => "72.44","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232027627","course_percentage" => "87.12","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232033708","course_percentage" => "73.32","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232034010","course_percentage" => "83.84","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232037529","course_percentage" => "79.52","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232038404","course_percentage" => "80.16","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232038511","course_percentage" => "87.68","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232038525","course_percentage" => "86.80","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232039012","course_percentage" => "90.92","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232042919","course_percentage" => "77.08","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232043109","course_percentage" => "82.24","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232043516","course_percentage" => "64.12","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232043508","course_percentage" => "67.68","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232043812","course_percentage" => "83.68","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232045321","course_percentage" => "74.16","class" => "First Division","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),
            array("enrolmentno" => "232011104","course_percentage" => "76.68","class" => "First Division with Distinction","authorised_sign" =>"Shri_NachiketaRout.png","exam_id" =>"20"),

        );

        foreach ($provisionalArray as $pc) {
            $examdateformat = Exam::find($pc["exam_id"])->date->format("Y");
            $candidate = Candidate::where('enrolmentno', $pc["enrolmentno"])->first();

            if(!is_null($candidate)) {
                $provisionalcertificate = Provisionalcertificate::where('candidate_id', $candidate->id)->first();

                $candidate->update([
                    "course_percentage" => $pc["course_percentage"],
                    "class" => $pc["class"],
                    "coursecompleted_status" => 1
                ]);

                if(is_null($provisionalcertificate)) {
                    $count = Provisionalcertificate::where('folio_number', 'like', $examdateformat."PC".'%')->get();
                    $filecount = $count->unique('folio_number')->count();
                    $filecount++;

                    $folio_number = $examdateformat."PC".str_pad($filecount, 4, '0', STR_PAD_LEFT);

                    Provisionalcertificate::create([
                        "exam_id" => $pc["exam_id"],
                        "candidate_id" => $candidate->id,
                        "folio_number" => $folio_number,
                        "authorised_sign" => $pc["authorised_sign"],
                        "publish_status" => "1",
                        "active_status" => "1",
                    ]);

                    unset($count);
                    unset($filecount);
                    unset($folio_number);
                }
            }
        }
    }

    public function withheldProvisionalCertificate() {
        $provisionalArray = array(
            array("enrolmentno" => "232020602"),
            array("enrolmentno" => "232020603"),
            array("enrolmentno" => "232020607"),
            array("enrolmentno" => "232020608"),
            array("enrolmentno" => "232020609"),
            array("enrolmentno" => "232020610"),
            array("enrolmentno" => "232020611"),
            array("enrolmentno" => "232020612"),
            array("enrolmentno" => "232020613"),
            array("enrolmentno" => "232020614"),
            array("enrolmentno" => "232020615"),
            array("enrolmentno" => "232020616"),
            array("enrolmentno" => "232020617"),
            array("enrolmentno" => "232020618"),
            array("enrolmentno" => "232020619"),
            array("enrolmentno" => "232020620"),
            array("enrolmentno" => "232020621"),
            array("enrolmentno" => "232020622"),
            array("enrolmentno" => "232020624"),
            array("enrolmentno" => "232020625"),
            array("enrolmentno" => "232022501"),
            array("enrolmentno" => "232022502"),
            array("enrolmentno" => "232022503"),
            array("enrolmentno" => "232022504"),
            array("enrolmentno" => "232022505"),
            array("enrolmentno" => "232022506"),
            array("enrolmentno" => "232022507"),
            array("enrolmentno" => "232022508"),
            array("enrolmentno" => "232022509"),
            array("enrolmentno" => "232022510"),
            array("enrolmentno" => "232022511"),
            array("enrolmentno" => "232022512"),
            array("enrolmentno" => "232022513"),
            array("enrolmentno" => "232022514"),
            array("enrolmentno" => "232022515"),
            array("enrolmentno" => "232022516"),
            array("enrolmentno" => "232022517"),
            array("enrolmentno" => "232022518"),
            array("enrolmentno" => "232022519"),
            array("enrolmentno" => "232022520"),
            array("enrolmentno" => "232022521"),
            array("enrolmentno" => "232022522"),
            array("enrolmentno" => "232022523"),
            array("enrolmentno" => "232022524"),
            array("enrolmentno" => "232022525"),
            array("enrolmentno" => "232022526"),
            array("enrolmentno" => "232022527"),
            array("enrolmentno" => "232022528"),
            array("enrolmentno" => "232022529"),
            array("enrolmentno" => "232022530"),
            array("enrolmentno" => "232034301"),
            array("enrolmentno" => "232034302"),
            array("enrolmentno" => "232034303"),
            array("enrolmentno" => "232034304"),
            array("enrolmentno" => "232034305"),
            array("enrolmentno" => "232034306"),
            array("enrolmentno" => "232034307"),
            array("enrolmentno" => "232034309"),
            array("enrolmentno" => "232034310"),
            array("enrolmentno" => "232042501"),
            array("enrolmentno" => "232042502"),
            array("enrolmentno" => "232042503"),
            array("enrolmentno" => "232042504"),
            array("enrolmentno" => "232042505"),
            array("enrolmentno" => "232042506"),
            array("enrolmentno" => "232042507"),
            array("enrolmentno" => "232042508"),
            array("enrolmentno" => "232042509"),
            array("enrolmentno" => "232042510"),
            array("enrolmentno" => "232042511"),
            array("enrolmentno" => "232042512"),
            array("enrolmentno" => "232042513"),
            array("enrolmentno" => "232042514"),
            array("enrolmentno" => "232042515"),
            array("enrolmentno" => "232042516"),
            array("enrolmentno" => "232042517"),
            array("enrolmentno" => "232042518"),
            array("enrolmentno" => "232042519"),
            array("enrolmentno" => "232042520"),
            array("enrolmentno" => "232042521"),
            array("enrolmentno" => "232042522"),
            array("enrolmentno" => "232042523"),
            array("enrolmentno" => "212012912"),

        );

        foreach ($provisionalArray as $pc) {
            $candidate = Candidate::where('enrolmentno', $pc["enrolmentno"])->first();

            if(!is_null($candidate)) {
                $candidate->update([
                    "course_percentage" => 0,
                    "class" => null,
                    "coursecompleted_status" => 0
                ]);

                $provisionalcertificate = Provisionalcertificate::where('candidate_id', $candidate->id)->first();

                if(!is_null($provisionalcertificate)) {
                    $provisionalcertificate->update([
                        "publish_status" => 0,
                        "active_status" => 0,
                    ]);

                    unset($candidate);
                    unset($provisionalcertificate);
                    unset($pc);
                }
            }
        }
    }
}
