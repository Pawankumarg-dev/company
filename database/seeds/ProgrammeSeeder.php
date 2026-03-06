<?php

use Illuminate\Database\Seeder;
use App\Programme;

class ProgrammeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Programme::create(['code'=>'519','abbreviation'=>'DECSE (MR)','name'=>'DIPLOMA IN EARLY CHILDHOOD SPECIAL EDUCATION (MENTAL RETARDATION)','numberofterms'=>'1','enrolmentcode'=>'24']);
		Programme::create(['code'=>'520','abbreviation'=>'DEd-SE-CP','name'=>'DIPLOMA IN EDUCATION - SPECIAL EDUCATION (CEREBRAL PALSY)','numberofterms'=>'2','enrolmentcode'=>'22']);
		Programme::create(['code'=>'527','abbreviation'=>'DEd-SE-ASD','name'=>'DIPLOMA IN EDUCATION - SPECIAL EDUCATION (AUTISM SPECTRUM DISORDERS)','numberofterms'=>'2','enrolmentcode'=>'21']);
		Programme::create(['code'=>'549','abbreviation'=>'DEd-SE-MR','name'=>'DIPLOMA IN EDUCATION - SPECIAL EDUCATION (MENTAL RETARDATION)','numberofterms'=>'2','enrolmentcode'=>'23']);
		Programme::create(['code'=>'551','abbreviation'=>'DVR (MR)','name'=>'DIPLOMA IN VOCATIONAL REHABILITATION (MENTAL RETARDATION)','numberofterms'=>'1','enrolmentcode'=>'25']);
		Programme::create(['code'=>'1301','abbreviation'=>'DCBR','name'=>'DIPLOMA IN COMMUNITY BASED REHABILITATION','numberofterms'=>'1','enrolmentcode'=>'26']);
		Programme::create(['code'=>'1301 (CG)','abbreviation'=>'CCCG','name'=>'CERTIFICATE COURSE IN CARE GIVING','numberofterms'=>'1','enrolmentcode'=>'11']);
		Programme::create(['code'=>'548','abbreviation'=>'DEd-SE-MD','name'=>'DIPLOMA IN EDUCATION SPECIAL EDUCATION MULTIPLE DISABILITIES','numberofterms'=>'2','enrolmentcode'=>'27']);

        //Newly created
		Programme::create(['code'=>'1401','abbreviation'=>'ACCIE(CD)','name'=>'ADVANCE CERTIFICATE COURSE IN INCLUSIVE EDUCATION (CROSS DISABILITY)','numberofterms'=>'1','enrolmentcode'=>'121']);
    }
}
