<?php

use Illuminate\Database\Seeder;
use App\Coursecoordinatorcourse;

class CoursecoordinatorcourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = array(
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "M.Ed. Special Education (Visual Impairment)", "course_code" => "M.Ed.Spl.Ed.(VI)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "B.Ed.Special Education (Visual Impairment)", "course_code" => "B.Ed.Spl.Ed.(VI)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Bachelor in Mobility Science", "course_code" => "B.M.Sc."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "D.Ed.Special Education (Visual Impairment)", "course_code" => "D.Ed.Spl.Ed.(VI)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "D.Ed.Special Education (Deafblind)", "course_code" => "D.Ed.Spl.Ed.(Db)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "B.Ed.Special Education (Deafblind) (on pilot basis)", "course_code" => "B.Ed.Spl.Ed.(Db)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Diploma in Computer Education (Visual Impairment)", "course_code" => "DCE(VI)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "M.Ed. Special Education (Hearing Impairment)", "course_code" => "M.Ed.Spl.Ed.(HI)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "B.Ed. Special Education (Hearing Impairment)", "course_code" => "B.Ed.Spl.Ed.(HI)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "D.Ed. Special Education (Hearing Impairment)", "course_code" => "D.Ed.Spl.Ed.(HI)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Diploma in Early Childhood Special Education (Hearing Impairment).", "course_code" => "D.E.C.S.E.(HI)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Diploma in Indian Sign Language Interpretation", "course_code" => "D.I.S.L.I."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Diploma in Teaching Indian Sign Language", "course_code" => "D.T.I.S.L"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "M.Ed. Special Education (Mental Retardation)", "course_code" => "M.Ed.Spl.Ed.(MR)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "B.Sc. (Special Education and Rehabilitation)", "course_code" => "B.Sc.(Spl.Ed.&.Reh.)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "B.Ed. Special Education (Mental Retardation)", "course_code" => "B.Ed.Spl.Ed.(MR)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "P.G. Diploma in Early Intervention", "course_code" => "P.G.D.E.I."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "D.Ed. Special Education (Mental Retardation)", "course_code" => "D.Ed.Spl.Ed.(MR)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Diploma in Vocational Rehabilitation (Mental Retardation)", "course_code" => "D.V.R.(MR)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Diploma in Early Childhood Special Education (Mental Retardation)", "course_code" => "D.E.C.S.E.(MR)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Integrated Bachelor of Education-Master of Education-Special Education (Intellectual Disability)", "course_code" => "Integrated B.Ed.-M.Ed.Spl.Ed. (ID)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "M.Ed. Special Education (Learning Disability)", "course_code" => "M.Ed.Spl.Ed.(LD)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "B.Ed. Special Education (Learning Disability)", "course_code" => "B.Ed.Spl.Ed.(LD)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Integrated Bachelor of Education-Master of Education Special Education (Specific Learning Disability )", "course_code" => "Integrated B.Ed.-M.Ed.Spl.Ed.(SLD)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Master in Prosthetics & Orthotics", "course_code" => "M.P.O."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Bachelor in Prosthetics and Orthotics", "course_code" => "B.P.O."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Diploma in Prosthetics and Orthotics", "course_code" => "D.P.O."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Certificate Course in Prosthetics & Orthotic", "course_code" => "C.P.O."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Diploma in Community Based Rehabilitation", "course_code" => "D.C.B.R."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "M.Phil (Rehabilitation Psychology)", "course_code" => "M.Phil.(R.P.)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "P.G. Diploma in Rehabilitation Psychology(Revised March, 2017)", "course_code" => "P.G.D.R.P."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "M.Phil (Clinical Psychology)", "course_code" => "M.Phil.(Cl.Psy.)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Professional Diploma in Clinical Psychology", "course_code" => "P.D. (Cl.Psy)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Psy.D in Clinical Psychology", "course_code" => "Psy.D (Cl.Psy)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "M.Sc. in Audiology ", "course_code" => "M.Sc.(Aud.)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "M.Sc. in Speech Language Pathology", "course_code" => "M.Sc.(S.L.P.)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Bachelor in Audiology and Speech-Language & Pathology", "course_code" => "B.A.S.L.P."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Diploma in Hearing Language and Speech", "course_code" => "D.H.L.S."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Diploma in Hearing Aid Repair and Ear Mould Technology", "course_code" => "D.H.A.R.E.M.T."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Post Graduate Diploma Course in Auditory Verbal Therapy ", "course_code" => "PGDAVT"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Post Graduate Diploma in Alternative and Augmentative Communication (on Pilot basis)", "course_code" => "PGDAAC"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "D.Ed. Special Education (Multiple Disabilities) (on pilot basis)", "course_code" => "D.Ed.Spl.Ed.(MD)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "B.Ed. Special Education (Multiple Disabilities)  ", "course_code" => "B.Ed.Spl.Ed.(MD)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "M.Ed. Special Education (Multiple Disabilities)  (on pilot basis)  ", "course_code" => "M.Ed.Spl.Ed.(MD)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "P.G. Dipl. in Developmental Therapy (Mult. Dis.:Physical and Neuro.)", "course_code" => "P.G.D.D.T.(MD:P&N)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "D.Ed. Special Education (Cerebral Palsy)", "course_code" => "D.Ed.Spl.Ed.(CP)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "D.Ed. Special Education (Autism Spectrum Disorders)", "course_code" => "D.Ed.Spl.Ed.(ASD)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "B.Ed. Special Education (Autism Spectrum Disorder)", "course_code" => "B.Ed.Spl.Ed.(ASD)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "M.Ed. Special Education (Autism Spectrum Disorder) (on pilot basis)", "course_code" => "M.Ed.Spl.Ed.(ASD)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Diploma in Rehabilitation Therapy", "course_code" => "D.R.T."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Certificate Course in Rehabilitation Therapy", "course_code" => "C.C.R.T."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Master in Rehabilitation Science ", "course_code" => "M.R.Sc."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "M.Sc. (Psycho-Social  Rehabilitation )", "course_code" => "M.Sc.(Psycho-Social Rehab)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Master in Disability Rehabilitation Administration", "course_code" => "M.D.R.A."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "M.A. Social Work in Disability Studies and Action", "course_code" => "M.A. (SWDS)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Bachelor in Rehabilitation Science", "course_code" => "B.R.Sc."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Post-Graduate Diploma in Disability Rehabilitation and Management", "course_code" => "P.G.D.D.R.M."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Advance Diploma in Child Guidance and Counselling", "course_code" => "ADCGC"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Certificate Course in Care Giving", "course_code" => "C.C.C.G."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Bachelor of Art/Bachelor of Commerce/Bachelor of Science Bachelor of Education Special Education", "course_code" => "B.A./B.Com./B.Sc.B.Ed.Spl.Ed."),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Advanced Certificate Course in Inclusive Education (Cross Disability)", "course_code" => "ACCIE (CD)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Distance", "course_name" => "Foundation Course in Special Education", "course_code" => "FC-SE-DE"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Distance", "course_name" => "Foundation Course for Education of Children with Disabilities", "course_code" => "FCECD"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Distance", "course_name" => "Foundation Course on Education for Children with Learning Disabilities", "course_code" => "FCECLD"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Distance", "course_name" => "B.Ed. Special Education (Hearing Impairment) - Open and Distance Learning", "course_code" => "B.Ed.Spl.Ed.(HI) - ODL"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Distance", "course_name" => "B.Ed. Special Education (Visual Impairment) - Open and Distance Learning", "course_code" => "B.Ed.Spl.Ed.(VI) - ODL"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Distance", "course_name" => "B.Ed. Special Education (Mental Retardation) - Open and Distance Learning", "course_code" => "B.Ed.Spl.Ed.(MR) - ODL"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Distance", "course_name" => "B.Ed. Special Education (Learning Disability) - Open and Distance Learning", "course_code" => "B.Ed.Spl.Ed.(LD) - ODL"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Distance", "course_name" => "M.Ed. Special Education (Mental Retardation) - Open and Distance Learning", "course_code" => "M.Ed.Spl.Ed.(MR) - ODL"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Distance", "course_name" => "Post Graduate Professional Diploma in Special Education - Mental Retardation", "course_code" => "PGPDSE MR"),
            array("coursecoordinatorcoursetype_id" => "2", "course_mode" => "Regular", "course_name" => "Bachelor of Science in Nursing", "course_code" => "B.Sc.(Nursing)"),
            array("coursecoordinatorcoursetype_id" => "2", "course_mode" => "Regular", "course_name" => "Master of Science in Nursing", "course_code" => "M.Sc.(Nursing)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "M. Sc (Disability Studies) (Early Intervention)", "course_code" => "M.Sc.(DS)(EI)"),
            array("coursecoordinatorcoursetype_id" => "1", "course_mode" => "Regular", "course_name" => "Ph.D in Special Education", "course_code" => "Ph.D(SE)"),

        );

        foreach ($data as $d){
            $course = Coursecoordinatorcourse::where("coursecoordinatorcoursetype_id", $d["coursecoordinatorcoursetype_id"])
                ->where("course_mode", $d["course_mode"])->where("course_name", $d["course_name"])->where("course_code", $d["course_code"])->first();

            if(is_null($course)) {
                Coursecoordinatorcourse::create([
                    "coursecoordinatorcoursetype_id" => $d["coursecoordinatorcoursetype_id"],
                    "course_mode" => $d["course_mode"],
                    "course_name" => $d["course_name"],
                    "course_code" => $d["course_code"],
                ]);
            }
        }
    }
}
