<?php

use Illuminate\Database\Seeder;

class August2018ExamTimetableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subject = Subject::where('scode','ACCDL')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-27 10:00:00', 'enddate'=>'2018-08-27 13:00:00']); }
        $subject = Subject::where('scode','ACCPE')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-28 10:00:00', 'enddate'=>'2018-08-28 13:00:00']); }
        $subject = Subject::where('scode','ACCCA')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-29 10:00:00', 'enddate'=>'2018-08-29 13:00:00']); }
        $subject = Subject::where('scode','ACCCN')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-30 10:00:00', 'enddate'=>'2018-08-30 13:00:00']); }

        $subject = Subject::where('scode','CRTGP')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-27 10:00:00', 'enddate'=>'2018-08-27 13:00:00']); }
        $subject = Subject::where('scode','CRTBR')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-28 10:00:00', 'enddate'=>'2018-08-28 13:00:00']); }
        $subject = Subject::where('scode','CRTCS')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-29 10:00:00', 'enddate'=>'2018-08-29 13:00:00']); }
        $subject = Subject::where('scode','CRTRI-T1')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-30 10:00:00', 'enddate'=>'2018-08-30 13:00:00']); }
        $subject = Subject::where('scode','CRTRI-T2')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-31 10:00:00', 'enddate'=>'2018-08-31 13:00:00']); }

        $subject=Subject::where('scode','CPOBC')->first();$et=Examtimetable::where('subject_id',$subject->id)->where('exam_id','3');if($et->count()=='0'){Examtimetable::create(['subject_id'=>$subject->id,'exam_id'=>'3','startdate'=>'2018-08-27 10:00:00','enddate'=>'2018-08-27 12:00:00']);}
        $subject=Subject::where('scode','CPOTM')->first();$et=Examtimetable::where('subject_id',$subject->id)->where('exam_id','3');if($et->count()=='0'){Examtimetable::create(['subject_id'=>$subject->id,'exam_id'=>'3','startdate'=>'2018-08-28 10:00:00','enddate'=>'2018-08-28 12:00:00']);}
        $subject=Subject::where('scode','CPOOR')->first();$et=Examtimetable::where('subject_id',$subject->id)->where('exam_id','3');if($et->count()=='0'){Examtimetable::create(['subject_id'=>$subject->id,'exam_id'=>'3','startdate'=>'2018-08-29 10:00:00','enddate'=>'2018-08-29 13:00:00']);}
        $subject=Subject::where('scode','CPOPR')->first();$et=Examtimetable::where('subject_id',$subject->id)->where('exam_id','3');if($et->count()=='0'){Examtimetable::create(['subject_id'=>$subject->id,'exam_id'=>'3','startdate'=>'2018-08-30 10:00:00','enddate'=>'2018-08-30 13:00:00']);}

        $subject = Subject::where('scode','01DPOBS')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-27 10:00:00', 'enddate'=>'27-08-2018  13:00:00 PM']); }
        $subject = Subject::where('scode','01DPOTP')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-28 10:00:00', 'enddate'=>'27-08-2018  13:00:00 PM']); }
        $subject = Subject::where('scode','01DPOSM')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-29 10:00:00', 'enddate'=>'27-08-2018  13:00:00 PM']); }
        $subject = Subject::where('scode','01DPOAS')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-30 10:00:00', 'enddate'=>'27-08-2018  13:00:00 PM']); }
        $subject = Subject::where('scode','01DPOPU')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-31 10:00:00', 'enddate'=>'27-08-2018  13:00:00 PM']); }
        $subject = Subject::where('scode','01DPOOU')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-09-01 10:00:00', 'enddate'=>'27-08-2018  13:00:00 PM']); }

        $subject = Subject::where('scode','02DPOAM')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-27 14:00:00', 'enddate'=>'2018-08-27 17:00:00']); }
        $subject = Subject::where('scode','02DPOPE')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-28 14:00:00', 'enddate'=>'2018-08-28 17:00:00']); }
        $subject = Subject::where('scode','02DPOOE')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-29 14:00:00', 'enddate'=>'2018-08-29 17:00:00']); }
        $subject = Subject::where('scode','02DPOSO')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-30 14:00:00', 'enddate'=>'2018-08-30 17:00:00']); }

        $subject = Subject::where('scode','01DRTHH')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-27 10:00:00', 'enddate'=>'2018-08-27 12:00:00']); }
        $subject = Subject::where('scode','01DRTPS')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-28 10:00:00', 'enddate'=>'2018-08-28 12:00:00']); }
        $subject = Subject::where('scode','01DRTDR')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-29 10:00:00', 'enddate'=>'2018-08-29 12:00:00']); }
        $subject = Subject::where('scode','01DRTID')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-30 10:00:00', 'enddate'=>'2018-08-30 12:00:00']); }
        $subject = Subject::where('scode','01DRTPE')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-31 10:00:00', 'enddate'=>'2018-08-31 12:00:00']); }
        $subject = Subject::where('scode','01DRTTF')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-09-01 10:00:00', 'enddate'=>'2018-09-01 12:00:00']); }

        $subject = Subject::where('scode','02DRTAA')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-27 14:00:00', 'enddate'=>'2018-08-27 16:00:00']); }
        $subject = Subject::where('scode','02DRTLS')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-28 14:00:00', 'enddate'=>'2018-08-28 16:00:00']); }
        $subject = Subject::where('scode','02DRTVR')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-29 14:00:00', 'enddate'=>'2018-08-29 16:00:00']); }
        $subject = Subject::where('scode','02DRTRM')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-30 14:00:00', 'enddate'=>'2018-08-30 16:00:00']); }
        $subject = Subject::where('scode','02DRTRT-I')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-08-31 14:00:00', 'enddate'=>'2018-08-31 16:00:00']); }
        $subject = Subject::where('scode','02DRTRT-II')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-09-01 14:00:00', 'enddate'=>'2018-09-01 16:00:00']); }

        //Special Exam for Kerala//
        $subject = Subject::where('scode','ACCDL')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3')->where('startdate', '2018-09-10 10:00:00');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-09-10 10:00:00', 'enddate'=>'2018-09-10 13:00:00']); }
        $subject = Subject::where('scode','ACCPE')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3')->where('startdate', '2018-09-11 10:00:00');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-09-11 10:00:00', 'enddate'=>'2018-09-11 13:00:00']); }
        $subject = Subject::where('scode','ACCCA')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3')->where('startdate', '2018-09-12 10:00:00');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-09-12 10:00:00', 'enddate'=>'2018-09-12 13:00:00']); }
        $subject = Subject::where('scode','ACCCN')->first();$et = Examtimetable::where('subject_id', $subject->id)->where('exam_id', '3')->where('startdate', '2018-09-13 10:00:00');if($et->count() == '0') {Examtimetable::create(['subject_id'=>$subject->id, 'exam_id'=>'3', 'startdate'=>'2018-09-13 10:00:00', 'enddate'=>'2018-09-13 13:00:00']); }
        //.Special Exam for Kerala//
    }
}
