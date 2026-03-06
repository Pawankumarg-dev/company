<?php

use Illuminate\Database\Seeder;
use App\Subject;
use App\updateSubject;
use App\updateSname;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $this->addSubjects();
        //$this->updateSubjectDetails();
    }

    public function addSubjects() {
        
        $subjectDetails = array(
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"01MDIT","sname" =>"Introduction to Disabilities","subjecttype_id" => "1","syear" => "1","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"12","imax_marks" =>"30", "emin_marks" =>"18","emax_marks" =>"45","total_marks" =>"75", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"1","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"01MDCC","sname" =>"Characteristics of Children with  Multiple Disabilities","subjecttype_id" => "1","syear" => "1","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"12","imax_marks" =>"30", "emin_marks" =>"18","emax_marks" =>"45","total_marks" =>"75", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"2","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"01MDAC","sname" =>"Assessment of Children with  Multiple Disabilities","subjecttype_id" => "1","syear" => "1","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"12","imax_marks" =>"30", "emin_marks" =>"18","emax_marks" =>"45","total_marks" =>"75", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"3","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"01MDDL","sname" =>"Child Development and   Learning","subjecttype_id" => "1","syear" => "1","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"12","imax_marks" =>"30", "emin_marks" =>"18","emax_marks" =>"45","total_marks" =>"75", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"4","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"01MDCD","sname" =>"Curriculum Development","subjecttype_id" => "1","syear" => "1","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"12","imax_marks" =>"30", "emin_marks" =>"18","emax_marks" =>"45","total_marks" =>"75", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"5","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"01MDTA","sname" =>"Teaching Approaches and   Strategies","subjecttype_id" => "1","syear" => "1","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"12","imax_marks" =>"30", "emin_marks" =>"18","emax_marks" =>"45","total_marks" =>"75", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"6","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"01MDCM","sname" =>"Assessment of Children with Multiple Disabilities","subjecttype_id" => "2","syear" => "1","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"38","imax_marks" =>"75", "emin_marks" =>"25","emax_marks" =>"50","total_marks" =>"125", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"1","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"01MDEP","sname" =>"Individualized Education Programme (CP, Db, MD)","subjecttype_id" => "2","syear" => "1","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"45","imax_marks" =>"90", "emin_marks" =>"30","emax_marks" =>"60","total_marks" =>"150", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"2","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"01MDAT","sname" =>"Preparation of TLM for assessment and teaching (including AAC) & information and communication technology (ICT)","subjecttype_id" => "2","syear" => "1","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"30","imax_marks" =>"60", "emin_marks" =>"20","emax_marks" =>"40","total_marks" =>"100", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"3","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"01MDSS","sname" =>"Group Teaching – Special schools CP, Db, MD","subjecttype_id" => "2","syear" => "1","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"45","imax_marks" =>"90", "emin_marks" =>"30","emax_marks" =>"60","total_marks" =>"150", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"4","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"01MDOM","sname" =>"Group Teaching – Resource room setting, (Orientation & Mobility), Sign Language & Braille","subjecttype_id" => "2","syear" => "1","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"45","imax_marks" =>"90", "emin_marks" =>"30","emax_marks" =>"60","total_marks" =>"150", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"5","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"01MDDS","sname" =>"Incorporation of technology and TLM in different settings","subjecttype_id" => "2","syear" => "1","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"23","imax_marks" =>"45", "emin_marks" =>"15","emax_marks" =>"30","total_marks" =>"75", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"6","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"02MDSA","sname" =>"Education in Emerging Indian  Society and School Administration","subjecttype_id" => "1","syear" => "2","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"12","imax_marks" =>"30", "emin_marks" =>"18","emax_marks" =>"45","total_marks" =>"75", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"1","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"02MDMT","sname" =>"Methods of Teaching in elementary school","subjecttype_id" => "1","syear" => "2","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"12","imax_marks" =>"30", "emin_marks" =>"18","emax_marks" =>"45","total_marks" =>"75", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"2","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"02MDTP","sname" =>"Therapeutics","subjecttype_id" => "1","syear" => "2","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"12","imax_marks" =>"30", "emin_marks" =>"18","emax_marks" =>"45","total_marks" =>"75", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"3","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"02MDIN","sname" =>"Inclusive Education","subjecttype_id" => "1","syear" => "2","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"12","imax_marks" =>"30", "emin_marks" =>"18","emax_marks" =>"45","total_marks" =>"75", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"4","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"02MDFC","sname" =>"Family and Community","subjecttype_id" => "1","syear" => "2","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"12","imax_marks" =>"30", "emin_marks" =>"18","emax_marks" =>"45","total_marks" =>"75", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"5","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"02MDSN","sname" =>"Management of groups with high support needs.","subjecttype_id" => "1","syear" => "2","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"12","imax_marks" =>"30", "emin_marks" =>"18","emax_marks" =>"45","total_marks" =>"75", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"6","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"02MDIS","sname" =>"Teaching in Regular / Inclusive School all subjects","subjecttype_id" => "2","syear" => "2","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"45","imax_marks" =>"90", "emin_marks" =>"30","emax_marks" =>"60","total_marks" =>"150", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"1","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"02MDBS","sname" =>"Therapeutics and Behavioural support","subjecttype_id" => "2","syear" => "2","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"45","imax_marks" =>"90", "emin_marks" =>"30","emax_marks" =>"60","total_marks" =>"150", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"2","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"02MDDT","sname" =>"Development of teaching Learning materials using ICT","subjecttype_id" => "2","syear" => "2","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"23","imax_marks" =>"45", "emin_marks" =>"15","emax_marks" =>"30","total_marks" =>"75", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"3","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"02MDIP","sname" =>"Inclusive Practices using UDL Principles","subjecttype_id" => "2","syear" => "2","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"45","imax_marks" =>"90", "emin_marks" =>"30","emax_marks" =>"60","total_marks" =>"150", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"4","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"02MDSD","sname" =>"Working with groups of people with high support needs and severe disabilities","subjecttype_id" => "2","syear" => "2","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"45","imax_marks" =>"90", "emin_marks" =>"30","emax_marks" =>"60","total_marks" =>"150", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"5","optional" => "0"),
            array("programme_id"  =>"42","pabbrvn"  =>"D.Ed.Spl.Ed.(MD)", "scode" =>"02MDPR","sname" =>"Project","subjecttype_id" => "2","syear" => "2","syllabus_type" => "New", "semester" => "Non-Semester","imin_marks" =>"23","imax_marks" =>"45", "emin_marks" =>"15","emax_marks" =>"30","total_marks" =>"75", "status" => "Active","remarks" => "SINCE 2022", "sortorder" =>"6","optional" => "0"),
            
        );

        foreach($subjectDetails as $subjectDetail) {
          \App\Subject::firstOrCreate([
            "programme_id" =>trim($subjectDetail["programme_id"]),
                "pabbrvn" =>trim($subjectDetail["pabbrvn"]),
               "scode" =>trim($subjectDetail["scode"]),
                "sname" =>trim($subjectDetail["sname"]),
                "subjecttype_id" =>trim($subjectDetail["subjecttype_id"]),
                "syear" =>trim($subjectDetail["syear"]),
                "syllabus_type" =>trim($subjectDetail["syllabus_type"]),
                "semester" =>trim($subjectDetail["semester"]),
                "imin_marks" =>trim($subjectDetail["imin_marks"]),
                "imax_marks" =>trim($subjectDetail["imax_marks"]),
                "emin_marks" =>trim($subjectDetail["emin_marks"]),
                "emax_marks" =>trim($subjectDetail["emax_marks"]),
                "total_marks" =>trim($subjectDetail["total_marks"]),
                "status" =>trim($subjectDetail["status"]),
                "remarks" =>trim($subjectDetail["remarks"]),
                "sortorder" =>trim($subjectDetail["sortorder"]),
                "optional" =>trim($subjectDetail["optional"]),
              ]);
          }
        }
    
}

   // public function updateSubject()
    {
       /* $marks = array(
            array("programme_id" => "31", "pabbrvn" => "D.Ed.Spl.Ed.(IDD)", "scode" => "01IDDAD", "sname" => "Assessment of Children with Developmental Disabilities", "subjecttype_id" => "2", "syear" => "1", "syllabus_type" => "New", "semester" => "Non-Semester", "imin_marks" => "38", "imax_marks" => "75", "emin_marks" => "25", "emax_marks" => "50", "total_marks" => "125", "status" => "Active", "remarks" => "SINCE 2021", "sortorder" => "1", "optional" => "0"),
            array("programme_id" => "31", "pabbrvn" => "D.Ed.Spl.Ed.(IDD)", "scode" => "01IDDIZ", "sname" => "Individualized Education Programme (ASD, ID, SLD)", "subjecttype_id" => "2", "syear" => "1", "syllabus_type" => "New", "semester" => "Non-Semester", "imin_marks" => "45", "imax_marks" => "90", "emin_marks" => "30", "emax_marks" => "60", "total_marks" => "150", "status" => "Active", "remarks" => "SINCE 2021", "sortorder" => "2", "optional" => "0"),
            array("programme_id" => "31", "pabbrvn" => "D.Ed.Spl.Ed.(IDD)", "scode" => "01IDDPL", "sname" => "Preparation of TLM for Assessment and Teaching & Information and Communication Technology (ICT)", "subjecttype_id" => "2", "syear" => "1", "syllabus_type" => "New", "semester" => "Non-Semester", "imin_marks" => "30", "imax_marks" => "60", "emin_marks" => "20", "emax_marks" => "40", "total_marks" => "100", "status" => "Active", "remarks" => "SINCE 2021", "sortorder" => "3", "optional" => "0"),
            array("programme_id" => "31", "pabbrvn" => "D.Ed.Spl.Ed.(IDD)", "scode" => "01IDDGS", "sname" => "Group Teaching - Special schools ASD, ID and Remedial Setting for SLD", "subjecttype_id" => "2", "syear" => "1", "syllabus_type" => "New", "semester" => "Non-Semester", "imin_marks" => "45", "imax_marks" => "90", "emin_marks" => "30", "emax_marks" => "60", "total_marks" => "150", "status" => "Active", "remarks" => "SINCE 2021", "sortorder" => "4", "optional" => "0"),
            array("programme_id" => "31", "pabbrvn" => "D.Ed.Spl.Ed.(IDD)", "scode" => "01IDDGR", "sname" => "Group Teaching - Resource Room Setting - ASD, ID, SLD", "subjecttype_id" => "2", "syear" => "1", "syllabus_type" => "New", "semester" => "Non-Semester", "imin_marks" => "45", "imax_marks" => "90", "emin_marks" => "30", "emax_marks" => "60", "total_marks" => "150", "status" => "Active", "remarks" => "SINCE 2021", "sortorder" => "5", "optional" => "0"),
            array("programme_id" => "31", "pabbrvn" => "D.Ed.Spl.Ed.(IDD)", "scode" => "01IDDIM", "sname" => "Incorporation of Technology and TLM in different settings", "subjecttype_id" => "2", "syear" => "1", "syllabus_type" => "New", "semester" => "Non-Semester", "imin_marks" => "23", "imax_marks" => "45", "emin_marks" => "15", "emax_marks" => "30", "total_marks" => "75", "status" => "Active", "remarks" => "SINCE 2021", "sortorder" => "6", "optional" => "0"),
            array("programme_id" => "31", "pabbrvn" => "D.Ed.Spl.Ed.(IDD)", "scode" => "02IDDTS", "sname" => "Teaching in Regular / Inclusive School - All Subjects", "subjecttype_id" => "2", "syear" => "2", "syllabus_type" => "New", "semester" => "Non-Semester", "imin_marks" => "45", "imax_marks" => "90", "emin_marks" => "30", "emax_marks" => "60", "total_marks" => "150", "status" => "Active", "remarks" => "SINCE 2021", "sortorder" => "1", "optional" => "0"),
            array("programme_id" => "31", "pabbrvn" => "D.Ed.Spl.Ed.(IDD)", "scode" => "02IDDTB", "sname" => "Therapeutics and Behavioural Support", "subjecttype_id" => "2", "syear" => "2", "syllabus_type" => "New", "semester" => "Non-Semester", "imin_marks" => "45", "imax_marks" => "90", "emin_marks" => "30", "emax_marks" => "60", "total_marks" => "150", "status" => "Active", "remarks" => "SINCE 2021", "sortorder" => "2", "optional" => "0"),
            array("programme_id" => "31", "pabbrvn" => "D.Ed.Spl.Ed.(IDD)", "scode" => "02IDDDT", "sname" => "Development of Teaching Learning Materials using ICT", "subjecttype_id" => "2", "syear" => "2", "syllabus_type" => "New", "semester" => "Non-Semester", "imin_marks" => "23", "imax_marks" => "45", "emin_marks" => "15", "emax_marks" => "30", "total_marks" => "75", "status" => "Active", "remarks" => "SINCE 2021", "sortorder" => "3", "optional" => "0"),
            array("programme_id" => "31", "pabbrvn" => "D.Ed.Spl.Ed.(IDD)", "scode" => "02IDDIP", "sname" => "Inclusive Practices using UDL Principles", "subjecttype_id" => "2", "syear" => "2", "syllabus_type" => "New", "semester" => "Non-Semester", "imin_marks" => "45", "imax_marks" => "90", "emin_marks" => "30", "emax_marks" => "60", "total_marks" => "150", "status" => "Active", "remarks" => "SINCE 2021", "sortorder" => "4", "optional" => "0"),
            array("programme_id" => "31", "pabbrvn" => "D.Ed.Spl.Ed.(IDD)", "scode" => "02IDDWG", "sname" => "Working with Groups with High Support Needs and Severe Disability", "subjecttype_id" => "2", "syear" => "2", "syllabus_type" => "New", "semester" => "Non-Semester", "imin_marks" => "45", "imax_marks" => "90", "emin_marks" => "30", "emax_marks" => "60", "total_marks" => "150", "status" => "Active", "remarks" => "SINCE 2021", "sortorder" => "5", "optional" => "0"),
            array("programme_id" => "31", "pabbrvn" => "D.Ed.Spl.Ed.(IDD)", "scode" => "02IDDPJ", "sname" => "Project", "subjecttype_id" => "2", "syear" => "2", "syllabus_type" => "New", "semester" => "Non-Semester", "imin_marks" => "23", "imax_marks" => "23", "emin_marks" => "15", "emax_marks" => "30", "total_marks" => "75", "status" => "Active", "remarks" => "SINCE 2021", "sortorder" => "6", "optional" => "0"),
            );
            foreach($marks as $mark){
                    Subject::where("subjecttype_id", $mark["subjecttype_id"])
                    ->where("programme_id", $mark["programme_id"])
                    ->where("pabbrvn", $mark["pabbrvn"])
                    ->where("scode", $mark["scode"])
                    ->where("sname", $mark["sname"])
                    ->update(["imin_marks"=> $mark["imin_marks"], "emin_marks" => $mark["emin_marks"]]);
                 
          }
    }*/
}

    //public function updateSubjectDetails()
    {
        /*$names = [
            
                ["subject_id" => "117", "pabbrvn" => "D.C.B.R.(old Pattern)", "scode" => "CBRPM", "sname" => "Principles and Methods of CBR Approach & Management of CBR Programme"],
                ["subject_id" => "118", "pabbrvn" => "D.C.B.R.(Old Pattern)", "scode" => "CBRIM",  "sname" => "Identification & Rehabilitation Mental Illness, Epilepsy & Other Disabilities"],
		        ["subject_id" => "153", "pabbrvn" => "D.C.B.R.(Old Pattern)", "scode" => "CBRVI ", "sname"  => "Identification & Rehabilitation of Persons with Visual Impairment"],
                ["subject_id" => "156", "pabbrvn" => "D.C.B.R.(Old Pattern)", "scode" => "CBRLD", "sname" => "Identification and Rehabilitation of Persons with Locomotor Disability"],
                ["subject_id" => "197", "pabbrvn" => "D.C.B.R.(Old Pattern)", "scode" => "CBRID", "sname" => "Identification and Rehabilitation of Persons with Intellectual Disability"],
                ["subject_id" => "319", "pabbrvn" => "D.Ed.Spl.Ed.(CP)", "scode" =>"02CPCC", "sname" => "Increasing Participation of Children with Cerebral Palsy"],
                ["subject_id" => "327", "pabbrvn" => "D.Ed.Spl.Ed.(ASD)", "scode" =>"02ASDTI1", "sname" => "Therapeutics & Interventions in ASD-1"],
                ["subject_id" => "328", "pabbrvn" => "D.Ed.Spl.Ed.(ASD)", "scode" =>"02ASDTI2", "sname" => "Therapeutics & Interventions in ASD-2"],
                ["subject_id" => "338", "pabbrvn" => "D.Ed.Spl.Ed.(MR)", "scode" => "02MRDM", "sname" => "Persons with Mental Retardation / Intellectual Disabilities and Associated Disabilities"],
                ["subject_id"  => "359", "pabbrvn" => "D.Ed.Spl.Ed.(ASD)", "scode" =>"01ASDIM", "sname" => "Methodology for Practicum - Development of Independent Living Skills & Teaching - Learning Material"],
                ["subject_id"  => "364", "pabbrvn" => "D.Ed.Spl.Ed.(MD)", "scode" =>"01MDAA", "sname" => "Training Adaptive Skills and Functional Academics"],
                ["subject_id" => "372", "pabbrvn" => "D.Ed.Spl.Ed.(MD)", "scode" =>"02MDEE", "sname" => "Education in the Emerging Indian Society and School Administration"],
                ["subject_id"  => "417", "pabbrvn" => "D.Ed.Spl.Ed.(MR)", "scode" =>"01MRMT", "sname" => "Educational Assessment, Teaching Strategies and Material Development"],
                ["subject_id" => "478", "pabbrvn" => "C.C.R.T.", "scode" =>"CRTCS", "sname" => "Clinical Studies (Disabled Conditions)"],
                ["subject_id" => "479", "pabbrvn" => "C.C.R.T.", "scode" =>"CRTRIT1", "sname" => "Rehabilitation Intervention-1"],
                ["subject_id" => "480", "pabbrvn" => "C.C.R.T.", "scode" =>"CRTRIT2", "sname" => "Rehabilitation Intervention-2"],
                ["subject_id"  => "495", "pabbrvn" => "D.P.O.", "scode" =>"01DPOBS", "sname" => "Life Basic Science"],
                ["subject_id"  => "496", "pabbrvn" => "D.P.O.", "scode" =>"01DPOTP", "sname" => "Workshop Technology & Practice"],
                ["subject_id"  => "497", "pabbrvn" => "D.P.O.", "scode" =>"01DPOSM", "sname" => "Applied Mechanics & Strength of Material Electronics & Bio Electricity"],
                ["subject_id" => "498", "pabbrvn" => "D.P.O.", "scode" =>"01DPOAS", "sname" => "Orthopedics, Amputation surgery kinesiology & Bio Mechanics"],
                ["subject_id" => "500", "pabbrvn" => "D.P.O.", "scode" =>"02DPOOE", "sname" => "Orthotic L.E."],
                ["subject_id" => "502", "pabbrvn" => "D.P.O.", "scode" =>"02DPOPE", "sname" => "Prosthetics L.E."],
                ["subject_id" => "504", "pabbrvn" => "D.P.O.", "scode" =>"02DPOAM", "sname" => "Introduction to PMR, Rehabilitation Psychology, Workshop Administration & Management"],
                ["subject_id" => "505", "pabbrvn" => "D.P.O.", "scode" =>"01DPOOU", "sname" => "Orthotic U.E."],
                ["subject_id" => "506", "pabbrvn" => "D.P.O.", "scode" =>"02DPOSO", "sname" => "Spinal Orthotic."],
                ["subject_id" => "507", "pabbrvn" => "D.P.O.", "scode" =>"01DPOPU", "sname" => "Prosthetics U.E."],
                ["subject_id" => "514", "pabbrvn" => "D.R.T.", "scode" =>"01DRTDR", "sname" => "Disability & Rehabilitation"],
                ["subject_id" => "515", "pabbrvn" => "D.R.T.", "scode" =>"01DRTID", "sname" => "Introduction to Disability"],
                ["subject_id" => "516", "pabbrvn" => "D.R.T.", "scode" =>"01DRTPE", "sname" => "Physical Agents & Exercise Therapy"],
                ["subject_id" => "524", "pabbrvn" => "D.R.T.",  "scode" =>"02DRTRT1", "sname" => "Rehabilitation Therapy in Cerebral Palsy & Other Neurological Conditions-1"],
                ["subject_id" => "525", "pabbrvn" => "D.R.T.", "scode" =>"02DRTRTI2", "sname" => "Rehabilitation Therapy in Cerebral Palsy & Other Neurological Conditions-2"],
                ["subject_id" => "599", "pabbrvn" => "D.Ed.Spl.Ed.(ID)", "scode" =>"02IDDM", "sname" => "Persons with Intellectual Disabilities  and Associated Disabilities"],
                ["subject_id" => "948", "pabbrvn" => "D.C.B.R.(New Pattern)", "scode" =>"01CBRBA", "sname" => "CBR and Approaches"],
                ["subject_id" => "948", "pabbrvn" => "D.C.B.R.(New Pattern)", "scode" =>"01CBRBA", "sname" => "CBR and Approaches"],
        ];
        

        foreach($names as $name) {
            Subject::where("id", $name["subject_id"])
                ->update(["sname" => trim($name["sname"]), "pabbrvn" => $name["pabbrvn"]]);
        }

    }*/

}
