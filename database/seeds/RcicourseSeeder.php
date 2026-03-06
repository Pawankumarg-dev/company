<?php

use Illuminate\Database\Seeder;
use App\Rcicourse;

class RcicourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $rcicourse = array(

            array("name" => "M.Ed. Special Education (Visual Impairment)", "abbreviation" => "M.Ed.Spl.Ed.(VI)", "mode" => "regular"),
            array("name" => "B.Ed.Special Education (Visual Impairment)", "abbreviation" => "B.Ed.Spl.Ed.(VI)", "mode" => "regular"),
            array("name" => "Bachelor in Mobility Science", "abbreviation" => "B.M.Sc.", "mode" => "regular"),
            array("name" => "D.Ed.Special Education (Visual Impairment)", "abbreviation" => "D.Ed.Spl.Ed.(VI)", "mode" => "regular"),
            array("name" => "D.Ed.Special Education (Deafblind)", "abbreviation" => "D.Ed.Spl.Ed.(Db)", "mode" => "regular"),
            array("name" => "B.Ed.Special Education (Deafblind) (on pilot basis)", "abbreviation" => "B.Ed.Spl.Ed.(Db)", "mode" => "regular"),
            array("name" => "Diploma in Computer Education (Visual Impairment)          ", "abbreviation" => "DCE(VI)", "mode" => "regular"),
            array("name" => "M.Ed. Special Education (Hearing Impairment)", "abbreviation" => "M.Ed.Spl.Ed.(HI)", "mode" => "regular"),
            array("name" => "B.Ed. Special Education (Hearing Impairment)", "abbreviation" => "B.Ed.Spl.Ed.(HI)", "mode" => "regular"),
            array("name" => "D.Ed. Special Education (Hearing Impairment)", "abbreviation" => "D.Ed.Spl.Ed.(HI)", "mode" => "regular"),
            array("name" => "Diploma in Early Childhood Special Education (Hearing Impairment).", "abbreviation" => "D.E.C.S.E.(HI)", "mode" => "regular"),
            array("name" => "Diploma in Indian Sign Language Interpretation", "abbreviation" => "D.I.S.L.I.", "mode" => "regular"),
            array("name" => "Diploma in Teaching Indian Sign Language", "abbreviation" => "D.T.I.S.L", "mode" => "regular"),
            array("name" => "M.Ed. Special Education (Mental Retardation)", "abbreviation" => "M.Ed.Spl.Ed.(MR)", "mode" => "regular"),
            array("name" => "B.Sc. (Special Education and Rehabilitation)", "abbreviation" => "B.Sc.(Spl.Ed.&.Reh.)", "mode" => "regular"),
            array("name" => "B.Ed. Special Education (Mental Retardation)", "abbreviation" => "B.Ed.Spl.Ed.(MR)", "mode" => "regular"),
            array("name" => "P.G. Diploma in Early Intervention", "abbreviation" => "P.G.D.E.I.", "mode" => "regular"),
            array("name" => "D.Ed. Special Education (Mental Retardation)", "abbreviation" => "D.Ed.Spl.Ed.(MR)", "mode" => "regular"),
            array("name" => "Diploma in Vocational Rehabilitation (Mental Retardation)", "abbreviation" => "D.V.R.(MR)", "mode" => "regular"),
            array("name" => "Diploma in Early Childhood Special Education (Mental Retardation)", "abbreviation" => "D.E.C.S.E.(MR)", "mode" => "regular"),
            array("name" => "Integrated Bachelor of Education-Master of Education-Special Education (Intellectual Disability)", "abbreviation" => "Integrated B.Ed.-M.Ed.Spl.Ed. (ID)", "mode" => "regular"),
            array("name" => "M.Ed. Special Education (Learning Disability)", "abbreviation" => "M.Ed.Spl.Ed.(LD)", "mode" => "regular"),
            array("name" => "B.Ed. Special Education (Learning Disability)", "abbreviation" => "B.Ed.Spl.Ed.(LD)", "mode" => "regular"),
            array("name" => "Integrated Bachelor of Education-Master of Education Special Education (Specific Learning Disability )", "abbreviation" => "Integrated B.Ed.-M.Ed.Spl.Ed.(SLD)", "mode" => "regular"),
            array("name" => "Master in Prosthetics & Orthotics", "abbreviation" => "M.P.O.", "mode" => "regular"),
            array("name" => "Bachelor in Prosthetics and Orthotics", "abbreviation" => "B.P.O.", "mode" => "regular"),
            array("name" => "Diploma in Prosthetics and Orthotics", "abbreviation" => "D.P.O.", "mode" => "regular"),
            array("name" => "Certificate Course in Prosthetics & Orthotic", "abbreviation" => "C.P.O.", "mode" => "regular"),
            array("name" => "Diploma in Community Based Rehabilitation", "abbreviation" => "D.C.B.R.", "mode" => "regular"),
            array("name" => "M.Phil (Rehabilitation Psychology)", "abbreviation" => "M.Phil.(R.P.)", "mode" => "regular"),
            array("name" => "P.G. Diploma in Rehabilitation Psychology(Revised March, 2017)", "abbreviation" => "P.G.D.R.P.", "mode" => "regular"),
            array("name" => "M.Phil (Clinical Psychology)", "abbreviation" => "M.Phil.(Cl.Psy.)", "mode" => "regular"),
            array("name" => "Professional Diploma in Clinical Psychology", "abbreviation" => "P.D. (Cl.Psy)", "mode" => "regular"),
            array("name" => "Psy.D in Clinical Psychology", "abbreviation" => "Psy.D (Cl.Psy)", "mode" => "regular"),
            array("name" => "M.Sc. in Audiology ", "abbreviation" => "M.Sc.(Aud.)", "mode" => "regular"),
            array("name" => "M.Sc. in Speech Language Pathology", "abbreviation" => "M.Sc.(S.L.P.)", "mode" => "regular"),
            array("name" => "Bachelor in Audiology and Speech-Language Pathology– Semester System", "abbreviation" => "B.A.S.L.P.", "mode" => "regular"),
            array("name" => "Diploma in Hearing Language and Speech", "abbreviation" => "D.H.L.S.", "mode" => "regular"),
            array("name" => "Diploma in Hearing Aid Repair and Ear Mould Technology", "abbreviation" => "D.H.A.R.E.M.T.", "mode" => "regular"),
            array("name" => "Post Graduate Diploma Course in Auditory Verbal Therapy ", "abbreviation" => "PGDAVT", "mode" => "regular"),
            array("name" => "Post Graduate Diploma in Alternative and Augmentative Communication (on Pilot basis)", "abbreviation" => "PGDAAC", "mode" => "regular"),
            array("name" => "D.Ed. Special Education (Multiple Disabilities) (on pilot basis)", "abbreviation" => "D.Ed.Spl.Ed.(MD)", "mode" => "regular"),
            array("name" => "B.Ed. Special Education (Multiple Disabilities)  ", "abbreviation" => "B.Ed.Spl.Ed.(MD)", "mode" => "regular"),
            array("name" => "M.Ed. Special Education (Multiple Disabilities)  (on pilot basis)  ", "abbreviation" => "M.Ed.Spl.Ed.(MD)", "mode" => "regular"),
            array("name" => "P.G. Dipl. in Developmental Therapy (Mult. Dis.:Physical and Neuro.)", "abbreviation" => "P.G.D.D.T.(MD:P&N)", "mode" => "regular"),
            array("name" => "D.Ed. Special Education (Cerebral Palsy)", "abbreviation" => "D.Ed.Spl.Ed.(CP)", "mode" => "regular"),
            array("name" => "D.Ed. Special Education (Autism Spectrum Disorders)", "abbreviation" => "D.Ed.Spl.Ed.(ASD)", "mode" => "regular"),
            array("name" => "B.Ed. Special Education (Autism Spectrum Disorder)", "abbreviation" => "B.Ed.Spl.Ed.(ASD)", "mode" => "regular"),
            array("name" => "M.Ed. Special Education (Autism Spectrum Disorder) (on pilot basis)", "abbreviation" => "M.Ed.Spl.Ed.(ASD)", "mode" => "regular"),
            array("name" => "Diploma in Rehabilitation Therapy", "abbreviation" => "D.R.T.", "mode" => "regular"),
            array("name" => "Certificate Course in Rehabilitation Therapy", "abbreviation" => "C.C.R.T.", "mode" => "regular"),
            array("name" => "Master in Rehabilitation Science ", "abbreviation" => "M.R.Sc.", "mode" => "regular"),
            array("name" => "M.Sc. (Psycho-Social  Rehabilitation )", "abbreviation" => "M.Sc.(Psycho-Social Rehab)", "mode" => "regular"),
            array("name" => "Master in Disability Rehabilitation Administration", "abbreviation" => "M.D.R.A.", "mode" => "regular"),
            array("name" => "M.A. Social Work in Disability Studies and Action", "abbreviation" => "M.A. (SWDS)", "mode" => "regular"),
            array("name" => "Bachelor in Rehabilitation Science", "abbreviation" => "B.R.Sc.", "mode" => "regular"),
            array("name" => "Post-Graduate Diploma in Disability Rehabilitation and Management", "abbreviation" => "P.G.D.D.R.M.", "mode" => "regular"),
            array("name" => "Advance Diploma in Child Guidance and Counselling", "abbreviation" => "ADCGC", "mode" => "regular"),
            array("name" => "Certificate Course in Care Giving", "abbreviation" => "C.C.C.G.", "mode" => "regular"),
            array("name" => "Bachelor of Art/Bachelor of Commerce/Bachelor of Science Bachelor of Education Special Education", "abbreviation" => "B.A./B.Com./B.Sc.B.Ed.Spl.Ed.", "mode" => "regular"),
            array("name" => "Advanced Certificate Course in Inclusive Education (Cross Disability)", "abbreviation" => "ACCIE (CD)", "mode" => "regular"),

            array("name" => "Foundation Course in Special Education", "abbreviation" => "FC-SE-DE", "mode" => "distance"),
            array("name" => "Foundation Course for Education of Children with Disabilities", "abbreviation" => "FCECD", "mode" => "distance"),
            array("name" => "Foundation Course on Education for Children with Learning Disabilities", "abbreviation" => "FCECLD", "mode" => "distance"),
            array("name" => "B.Ed. Special Education (Hearing Impairment) - Open and Distance Learning", "abbreviation" => "B.Ed.Spl.Ed.(HI) - ODL", "mode" => "distance"),
            array("name" => "B.Ed. Special Education (Visual Impairment) - Open and Distance Learning", "abbreviation" => "B.Ed.Spl.Ed.(VI) - ODL", "mode" => "distance"),
            array("name" => "B.Ed. Special Education (Mental Retardation) - Open and Distance Learning", "abbreviation" => "B.Ed.Spl.Ed.(MR) - ODL", "mode" => "distance"),
            array("name" => "B.Ed. Special Education (Learning Disability) - Open and Distance Learning", "abbreviation" => "B.Ed.Spl.Ed.(LD) - ODL", "mode" => "distance"),
            array("name" => "M.Ed. Special Education (Mental Retardation) - Open and Distance Learning", "abbreviation" => "M.Ed.Spl.Ed.(MR) - ODL", "mode" => "distance"),
            array("name" => "Post Graduate Professional Diploma in Special Education - Mental Retardation", "abbreviation" => "PGPDSE MR", "mode" => "distance"),

            );

        foreach ($rcicourse as $r) {
            $rci = Rcicourse::where('name', $r["name"])->where('abbreviation', $r["abbreviation"])->where('mode', $r["mode"])->first();

            if(is_null($rci)) {
                Rcicourse::create([
                    "name" => $r["name"],
                    "abbreviation" => $r["abbreviation"],
                    "mode" => $r["mode"],
                ]);
            }
        }

    }
}
