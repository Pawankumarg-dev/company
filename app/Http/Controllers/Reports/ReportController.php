<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Reportevaluationprogress;

use App\Reportevaluationprogrammeprogress;

use App\Reportaffiliationfee;

use App\Reportenrolmentfee;

use App\Reportcandidatedataverification;

use App\Reportconsolidatedcdverification;

use App\Institute;

use App\Reportattendancemarking;

use App\Reportcandidateattendanceandmark;

use App\Faculty;

use App\Reportenrolmentfeedetail;

use App\Supplimentaryapplicant;

use Illuminate\Support\Facades\DB;

use Auth;


class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:reports']);
    }

    public function maxapplications(Request $r){
        $programme = null;
        $summary =  DB::table('currentapplicants as a')
        ->join('approvedprogrammes as ap','ap.id', '=', 'a.approvedprogramme_id')
        ->join('programmes as p','p.id', '=', 'ap.programme_id')
        ->where('a.batch_completed',0)
        ->where('a.eligible_for_supplimentary',1)
        ->select(
           DB::raw('sum(if(p.nber_id = 1, 1, 0)) as niepmd,  sum(if(p.nber_id = 2, 1, 0)) as ayjshd,  sum(if(p.nber_id = 3, 1, 0)) as niepvd,  count(*) as total')
        );
        if($r->has('programme_id')){
        $summary = $summary->where('p.id',$r->programme_id);
        $programme = \App\Programme::find($r->programme_id);
        }
        if($r->has('nber_id')){
            $nber = \App\Nber::find($r->nber_id);
            $summary = $summary->where('p.nber_id',$r->nber_id);
        }
        $summary= $summary->get();
        
        $institutewise = DB::table('currentapplications as ca')
                ->join('currentapplicants as a','a.id','=','ca.currentapplicant_id')
                 ->join('approvedprogrammes as ap','ap.id', '=', 'a.approvedprogramme_id')
                 ->join('programmes as p','p.id', '=', 'ap.programme_id')
                 ->join('institutes as i','i.id', '=', 'ap.institute_id')
                 ->selectRaw('i.rci_code, i.name ,  count(*) as total')
                 ->groupby('i.id');
        if($r->has('programme_id')){
            $institutewise = $institutewise->where('p.id',$r->programme_id);
            $programme = \App\Programme::find($r->programme_id);
        }
        $institutewise = $institutewise->get();
        $districtwisedaywise = DB::table('currentapplications as ca')
                                ->join('currentapplicants as a','a.id','=','ca.currentapplicant_id')
                                ->join('approvedprogrammes as ap','ap.id', '=', 'a.approvedprogramme_id')
                                ->join('institutes as i','i.id', '=', 'ap.institute_id')
                                ->join('programmes as p','p.id', '=', 'ap.programme_id')
                                ->join('subjects as s','s.id','=','ca.subject_id')
                                ->where('a.batch_completed',0)
                                ->where('a.eligible_for_supplimentary',1)
                                ->select(
                                    DB::raw('SUBSTRING(i.rci_code,1,2) as state'), 
                                    DB::raw('rci_district, count(*) as total'),
                                    DB::raw('sum(if(s.sortorder =1 and s.syear = 1,1,0)) as day_one_first_year'),
                                    DB::raw('sum(if(s.sortorder =1 and s.syear = 2,1,0)) as day_one_second_year'),
                                    DB::raw('sum(if(s.sortorder =2 and s.syear = 1,1,0)) as day_two_first_year'),
                                    DB::raw('sum(if(s.sortorder =2 and s.syear = 2,1,0)) as day_two_second_year'),
                                    DB::raw('sum(if(s.sortorder =3 and s.syear = 1,1,0)) as day_three_first_year'),
                                    DB::raw('sum(if(s.sortorder =3 and s.syear = 2,1,0)) as day_three_second_year'),
                                    DB::raw('sum(if(s.sortorder =4 and s.syear = 1,1,0)) as day_four_first_year'),
                                    DB::raw('sum(if(s.sortorder =4 and s.syear = 2,1,0)) as day_four_second_year'),
                                    DB::raw('sum(if(s.sortorder =5 and s.syear = 1,1,0)) as day_five_first_year'),
                                    DB::raw('sum(if(s.sortorder =5 and s.syear = 2,1,0)) as day_five_second_year'),
                                    DB::raw('sum(if(s.sortorder =6 and s.syear = 1,1,0)) as day_six_first_year'),
                                    DB::raw('sum(if(s.sortorder =6 and s.syear = 2,1,0)) as day_six_second_year')
                                 )
                                 ->groupby('state','rci_district');
        if($r->has('programme_id')){
            $districtwisedaywise = $districtwisedaywise->where('p.id',$r->programme_id);
        }
        $districtwisedaywise = $districtwisedaywise->get();  
        $programmes = \App\Programme::all();
        return view('reports.examapplications.max',compact('summary','programme','programmes','districtwisedaywise','institutewise'));
                              
    }

    public function progress(Request $r){
        $supplimentaryapplicants = Supplimentaryapplicant::where('payment_status',0)->get();
        $programmes = \App\Programme::all();
        $nbers = \App\Nber::all();
        $programme = null;
        $nber = null;
        $summary =  DB::table('supplimentaryapplicants as sa')
        ->join('candidates as c','sa.candidate_id','=','c.id')
        ->join('approvedprogrammes as ap','ap.id', '=', 'c.approvedprogramme_id')
        ->join('programmes as p','p.id', '=', 'ap.programme_id')
        ->where('payment_status','=',1)
        ->select(
           DB::raw('sum(if(p.nber_id = 1, 1, 0)) as niepmd,  sum(if(p.nber_id = 2, 1, 0)) as ayjshd,  sum(if(p.nber_id = 3, 1, 0)) as niepvd,  count(*) as total')
        );
        if($r->has('programme_id')){
        $summary = $summary->where('p.id',$r->programme_id);
        $programme = \App\Programme::find($r->programme_id);
        }
        if($r->has('nber_id')){
            $nber = \App\Nber::find($r->nber_id);
            $summary = $summary->where('p.nber_id',$r->nber_id);
        }
        $summary= $summary->get();
        $datewise = DB::table('supplimentaryapplicants as sa')
                 ->join('candidates as c','sa.candidate_id','=','c.id')
                 ->join('approvedprogrammes as ap','ap.id', '=', 'c.approvedprogramme_id')
                 ->join('programmes as p','p.id', '=', 'ap.programme_id')
                 ->where('payment_status','=',1)
                 ->select(
                    DB::raw('DATE(sa.created_at) as sadate'),
                    DB::raw('sum(if(p.nber_id = 1, 1, 0)) as niepmd,  sum(if(p.nber_id = 2, 1, 0)) as ayjshd,  sum(if(p.nber_id = 3, 1, 0)) as niepvd,  count(*) as total')
                )
                 ->groupby('sadate');

        if($r->has('programme_id')){
            $datewise = $datewise->where('p.id',$r->programme_id);
            $programme = \App\Programme::find($r->programme_id);
        }
        if($r->has('nber_id')){
            $nber = \App\Nber::find($r->nber_id);
            $datewise = $datewise->where('p.nber_id',$r->nber_id);
        }
        $datewise = $datewise->get();

     
        $coursewise = DB::table('supplimentaryapplicants as sa')
                 ->join('candidates as c','sa.candidate_id','=','c.id')
                 ->join('approvedprogrammes as ap','ap.id', '=', 'c.approvedprogramme_id')
                 ->join('programmes as p','p.id', '=', 'ap.programme_id')
                 ->where('payment_status','=',1)
                 ->selectRaw('p.abbreviation ,  count(*) as total')
                 ->groupby('p.id');
        
        if($r->has('programme_id')){
            $coursewise = $coursewise->where('p.id',$r->programme_id);
        }
        if($r->has('nber_id')){
            $coursewise = $coursewise->where('p.nber_id',$r->nber_id);
        }
        $coursewise = $coursewise->get();

     
        $institutewise = DB::table('supplimentaryapplicants as sa')
                 ->join('candidates as c','sa.candidate_id','=','c.id')
                 ->join('approvedprogrammes as ap','ap.id', '=', 'c.approvedprogramme_id')
                 ->join('programmes as p','p.id', '=', 'ap.programme_id')
                 ->join('institutes as i','i.id', '=', 'ap.institute_id')
                 ->where('payment_status','=',1)
                 ->selectRaw('i.rci_code, i.name ,  count(*) as total')
                 ->groupby('i.id');
        if($r->has('programme_id')){
            $institutewise = $institutewise->where('p.id',$r->programme_id);
        }
        if($r->has('nber_id')){
            $institutewise = $institutewise->where('p.nber_id',$r->nber_id);
        }
        $institutewise = $institutewise->get();
     
        $statewise = DB::table('supplimentaryapplicants as sa')
                 ->join('candidates as c','sa.candidate_id','=','c.id')
                 ->join('approvedprogrammes as ap','ap.id', '=', 'c.approvedprogramme_id')
                 ->join('programmes as p','p.id', '=', 'ap.programme_id')
                 ->join('institutes as i','i.id', '=', 'ap.institute_id')
                 ->where('payment_status','=',1);
                 
        if($r->has('programme_id')){
            $statewise = $statewise->where('ap.programme_id',$r->programme_id);
        }
        if($r->has('nber_id')){
            $statewise = $statewise->where('p.nber_id',$r->nber_id);
        }
        $statewise = $statewise->get();
        
        $statewisedaywise = DB::table('supplimentaryapplications as sa')
                 ->join('supplimentaryapplicants as a', 'a.id','=','sa.supplimentaryapplicant_id')
                 ->join('candidates as c','sa.candidate_id','=','c.id')
                 ->join('approvedprogrammes as ap','ap.id', '=', 'c.approvedprogramme_id')
                 ->join('programmes as p','p.id', '=', 'ap.programme_id')
                 ->join('subjects as s','s.id','=','sa.subject_id')
                 ->join('institutes as i','i.id', '=', 'ap.institute_id')
                 ->where('a.payment_status','=',1)
                 ->select(
                    DB::raw('SUBSTRING(i.rci_code,1,2) as state'),
                    DB::raw('count(*) as total'),
                    DB::raw('count(distinct sa.supplimentaryapplicant_id) as total_students'),
                    DB::raw('sum(if(s.sortorder =1 and s.syear = 1,1,0)) as day_one_first_year'),
                    DB::raw('sum(if(s.sortorder =1 and s.syear = 2,1,0)) as day_one_second_year'),
                    DB::raw('sum(if(s.sortorder =2 and s.syear = 1,1,0)) as day_two_first_year'),
                    DB::raw('sum(if(s.sortorder =2 and s.syear = 2,1,0)) as day_two_second_year'),
                    DB::raw('sum(if(s.sortorder =3 and s.syear = 1,1,0)) as day_three_first_year'),
                    DB::raw('sum(if(s.sortorder =3 and s.syear = 2,1,0)) as day_three_second_year'),
                    DB::raw('sum(if(s.sortorder =4 and s.syear = 1,1,0)) as day_four_first_year'),
                    DB::raw('sum(if(s.sortorder =4 and s.syear = 2,1,0)) as day_four_second_year'),
                    DB::raw('sum(if(s.sortorder =5 and s.syear = 1,1,0)) as day_five_first_year'),
                    DB::raw('sum(if(s.sortorder =5 and s.syear = 2,1,0)) as day_five_second_year'),
                    DB::raw('sum(if(s.sortorder =6 and s.syear = 1,1,0)) as day_six_first_year'),
                    DB::raw('sum(if(s.sortorder =6 and s.syear = 2,1,0)) as day_six_second_year')
                 )
                 ->groupby('state');
            if($r->has('programme_id')){
                $statewisedaywise = $statewisedaywise->where('p.id',$r->programme_id);
            }
            if($r->has('nber_id')){
                $statewisedaywise = $statewisedaywise->where('p.nber_id',$r->nber_id);
            }
            $statewisedaywise = $statewisedaywise->get();            

     
        $districtwise = DB::table('supplimentaryapplicants as sa')
                 ->join('candidates as c','sa.candidate_id','=','c.id')
                 ->join('approvedprogrammes as ap','ap.id', '=', 'c.approvedprogramme_id')
                 ->join('institutes as i','i.id', '=', 'ap.institute_id')
                 ->join('programmes as p','p.id', '=', 'ap.programme_id')
                 ->where('payment_status','=',1)
                 ->select(
                    DB::raw('SUBSTRING(i.rci_code,1,2) as state'), 
                    DB::raw('rci_district, count(*) as total')
                 )
                 ->groupby('state','rci_district');
        if($r->has('programme_id')){
            $districtwise = $districtwise->where('p.id',$r->programme_id);
        }
        if($r->has('nber_id')){
            $districtwise = $districtwise->where('p.nber_id',$r->nber_id);
        }
        $districtwise = $districtwise->get();            
    
         
        $districtwisedaywise = DB::table('supplimentaryapplications as sa')
                ->join('supplimentaryapplicants as a', 'a.id','=','sa.supplimentaryapplicant_id')
                 ->join('candidates as c','sa.candidate_id','=','c.id')
                 ->join('approvedprogrammes as ap','ap.id', '=', 'c.approvedprogramme_id')
                 ->join('institutes as i','i.id', '=', 'ap.institute_id')
                 ->join('programmes as p','p.id', '=', 'ap.programme_id')
                 ->join('statedistricts as d','i.rci_district','=','d.name','left outer')
                 ->join('statezones as z','d.statezone_id','=','z.id','left outer')
                 ->join('subjects as s','s.id','=','sa.subject_id')
                 ->where('a.payment_status','=',1)
                 ->select(
                    DB::raw('SUBSTRING(i.rci_code,1,2) as state'), 
                    DB::raw('rci_district, count(*) as total'),
                    DB::raw('z.name as zone'),
                    DB::raw('sum(if(s.sortorder =1 and s.syear = 1,1,0)) as day_one_first_year'),
                    DB::raw('sum(if(s.sortorder =1 and s.syear = 2,1,0)) as day_one_second_year'),
                    DB::raw('sum(if(s.sortorder =2 and s.syear = 1,1,0)) as day_two_first_year'),
                    DB::raw('sum(if(s.sortorder =2 and s.syear = 2,1,0)) as day_two_second_year'),
                    DB::raw('sum(if(s.sortorder =3 and s.syear = 1,1,0)) as day_three_first_year'),
                    DB::raw('sum(if(s.sortorder =3 and s.syear = 2,1,0)) as day_three_second_year'),
                    DB::raw('sum(if(s.sortorder =4 and s.syear = 1,1,0)) as day_four_first_year'),
                    DB::raw('sum(if(s.sortorder =4 and s.syear = 2,1,0)) as day_four_second_year'),
                    DB::raw('sum(if(s.sortorder =5 and s.syear = 1,1,0)) as day_five_first_year'),
                    DB::raw('sum(if(s.sortorder =5 and s.syear = 2,1,0)) as day_five_second_year'),
                    DB::raw('sum(if(s.sortorder =6 and s.syear = 1,1,0)) as day_six_first_year'),
                    DB::raw('sum(if(s.sortorder =6 and s.syear = 2,1,0)) as day_six_second_year')
                 )
                 ->groupby('state','rci_district');
            
            if($r->has('programme_id')){
                $districtwisedaywise = $districtwisedaywise->where('p.id',$r->programme_id);
            }
            if($r->has('nber_id')){
                $districtwisedaywise = $districtwisedaywise->where('p.nber_id',$r->nber_id);
            }
            $districtwisedaywise = $districtwisedaywise->get();  
        return view('reports.examapplications.progress',compact('summary','nbers','nber','programme','programmes','supplimentaryapplicants','datewise','coursewise','institutewise','statewise','statewisedaywise','districtwise','districtwisedaywise'));
    }
    public function index(){
        return view('reports.index');
    }
    public function evaluationprogress(){
        /*
        delete from reportevaluationprogresses;
        insert into reportevaluationprogresses(evc_code,evc_name,no_of_papers,attendnace_marked, present, marks_entered, exam_centers)
        select  evc.code, evc.name, count(ca.id) as papers,sum(if(ca.`externalattendance_id` > 0, 1,0)) as attendance_marked, sum(if(ca.`externalattendance_id`=1,1,0)) as present,   sum(if(ca.`external_mark` is not null,1,0)) as marks_entered, group_concat(distinct ec.code) from currentapplications ca
        left join approvedprogrammes ap on ap.id = ca.approvedprogramme_id
        left join institutes i on i.id = ap.institute_id
        left join externalexamcenters ec on ec.id = i.`externalexamcenter_id`
        left join evaluationcenterdetails ecd on ecd.`externalexamcenter_id` = ec.id
        left join evaluationcenters evc on evc.id = ecd.evaluationcenter_id
        left join subjects s on s.id=ca.subject_id
        left join programmes p on p.id = s.programme_id
        left join nbers n on n.id = p.nber_id
        left join examtimetables tt on tt.subject_id= s.id
        where s.subjecttype_id = 1 and tt.exam_id=22 and tt.examdate <  '2023-09-28'
        group by ecd.evaluationcenter_id ;
        */
        $report = Reportevaluationprogress::all();
        return view('reports.evaluationprogress',compact('report'));
    }
    public function evaluationprogrammeprogress(){
        /*
        delete from reportevaluationprogrammeprogresses;
        insert into reportevaluationprogrammeprogresses (nber,programme,no_of_papers,attendnace_marked, present, marks_entered)
        select  n.name_code, p.abbreviation, count(ca.id) as papers,sum(if(ca.`externalattendance_id` > 0, 1,0)) as attendance_marked, sum(if(ca.`externalattendance_id`=1,1,0)) as present,   sum(if(ca.`external_mark` is not null,1,0)) as marks_entered from currentapplications ca
        left join approvedprogrammes ap on ap.id = ca.approvedprogramme_id
        left join subjects s on s.id=ca.subject_id
        left join programmes p on p.id = s.programme_id
        left join nbers n on n.id = p.nber_id
        left join examtimetables tt on tt.subject_id= s.id
        where s.subjecttype_id = 1 and tt.exam_id=22 and tt.examdate <  '2023-09-28'
        group by p.id;
        */
        $report = Reportevaluationprogrammeprogress::all();
        return view('reports.evaluationprogrammeprogress',compact('report'));
    }

    public function affiliationfee(){
        /*
        delete from reportaffiliationfees;
        insert into reportaffiliationfees (attribute,value)
        select 'paid_institutes', count(*) from affiliationfees where academicyear_id = 11 and orderstatus_id = 1;
        insert into reportaffiliationfees (attribute,value)
        select  'paid_amount', sum(actual_amount) from affiliationfees af
        left join orders o on o.id = af.order_id
        where academicyear_id = 11 and orderstatus_id = 1;
        insert into reportaffiliationfees (attribute,value)
        select 'un_paid_institutes', 720 - count(*) from affiliationfees where academicyear_id = 11 and orderstatus_id = 1;
        insert into reportaffiliationfees (attribute,value)
        select  'un_paid_amount', 20280000 - sum(actual_amount) from affiliationfees af
        left join orders o on o.id = af.order_id
        where academicyear_id = 11 and orderstatus_id = 1;
        */
        $report = Reportaffiliationfee::all();
        return view('reports.affiliationfee',compact('report'));
    }

    function enrolmentfee(){
        /*
        delete from reportenrolmentfees;
        insert into reportenrolmentfees (nber,attribute,value)
        select n.name_code, 'paid_institutes', count(*) from enrolmentfeepayments efp
        left join nbers n on n.id = efp.nber_id
        where academicyear_id = 11 and orderstatus_id = 1
        group by n.id;
        insert into reportenrolmentfees (nber,attribute,value)
        select n.name_code, 'paid_amount', sum(actual_amount) from enrolmentfeepayments efp
        left join orders o on o.id = efp.order_id
        left join nbers n on n.id = efp.nber_id
        where academicyear_id = 11 and orderstatus_id = 1
        group by n.id;
        insert into reportenrolmentfees (nber,attribute,value)
        select n.name_code, 'un_paid_institutes',numbers.total - count(*) from enrolmentfeepayments efp
        left join nbers n on n.id = efp.nber_id
        left join 
        (select p.nber_id, count(distinct ap.institute_id) as total from approvedprogrammes ap
        left join programmes p on p.id = ap.`programme_id`
        where ap.academicyear_id =11
        group by p.nber_id) as numbers on numbers.nber_id = n.id
        where academicyear_id = 11 and orderstatus_id = 1
        group by n.id;
        insert into reportenrolmentfees (nber,attribute,value)
        select n.name_code, 'un_paid_amount',  numbers.total -  sum(actual_amount) from enrolmentfeepayments efp
        left join orders o on o.id = efp.order_id
        left join nbers n on n.id = efp.nber_id
        left  join
        (
        select p.nber_id, count(*) * 500 as total from candidates c
        left join approvedprogrammes ap on ap.id = c.approvedprogramme_id
        left join programmes p on p.id = ap.programme_id
        where c.status_id !=3 and ap.academicyear_id = 11
        group by p.nber_id
        ) as numbers on numbers.nber_id = n.id
        where academicyear_id = 11 and orderstatus_id = 1
        group by n.id;

        */
        $report = Reportenrolmentfee::all();
        return view('reports.enrolmentfee',compact('report'));
    }

    function candidatedataverification(Request $r){
        /*
    delete from reportcandidatedataverifications;
        insert into reportcandidatedataverifications(
            nber,
            academicyear,
            rci_code,
            institute_id,
            programme,
            total_students,
            pending,
            verified,
            rejected,
            total,
            waiting_for_approval,
            verification_pending,
            data_change_requested,
            incomplete,
            discontinued,
            complete_data,
            mobile_nu_verified,
            data_confirmed_by_student
        )
        select 
            n.name_code,
            y.year, 
            i.rci_code, 
            i.id,
            p.abbreviation, 
            count(c.id) as total, 
            sum(if(c.status_id=1,1,0)) as pending,
            sum(if(c.status_id=2,1,0)) as verified,
            sum(if(c.status_id=3,1,0)) as rejected,
            sum(if(c.status_id=4,1,0)) as total,
            sum(if(c.status_id=5,1,0)) as waiting_for_approval,
            sum(if(c.status_id=6,1,0)) as verification_pending,
            sum(if(c.status_id=7,1,0)) as data_change_requested,
            sum(if(c.status_id=8,1,0)) as incomplete,
            sum(if(c.status_id=9,1,0)) as discontinued,
            sum(if(c.`aadhar` != '' and c.status_id != 9 ,1,0)) as data_changed,
            sum(if(c.`is_mobile_number_verified` = 'Yes' and c.status_id != 9 ,1,0)) as mobile_nu_verified,
            case when y.id = 11 then sum(if(c.`is_mobile_number_verified` = 'Yes' and c.status_id != 9 ,1,0)) else sum(if(c.`is_data_verified` = 'Yes' and c.status_id != 9 ,1,0)) end as data_confirmed_by_student
        from candidates c
        left join approvedprogrammes ap on ap.id = c.approvedprogramme_id
        left join institutes i on i.id = ap.institute_id
        left join programmes p on p.id = ap.programme_id
        left join nbers n on n.id = p.nber_id
        left join academicyears y on y.id = ap.academicyear_id
        where y.id = 10 or y.id = 9 or y.id = 11
        group by ap.id;
        */
        $nber_id = 0;
        if($r->has('nber_id') && $r->nber_id != 0){
            $nber = \App\Nber::find($r->nber_id);
            $report = Reportcandidatedataverification::where('nber',$nber->name_code)->orderBy('rci_code')->orderBy('programme')->orderBy('academicyear');
            $nber_id = $r->nber_id;
        }else{
            $report = Reportcandidatedataverification::orderBy('rci_code')->orderBy('nber')->orderBy('programme')->orderBy('academicyear');
        }
        if($r->has('academicyear')){
            $report = $report->where('academicyear',$r->academicyear)->get();
        }else{
            $report = $report->get();
        }
        $nbers = \App\Nber::all();
        
        return view('reports.candidatedataverification',compact('report','nbers','nber_id'));
    }
    function consolidatedcdverification(){
        /*
                delete from reportconsolidatedcdverifications;
        insert into reportconsolidatedcdverifications(
            nber,
            academicyear,
            total_students,
            pending,
            verified,
            rejected,
            total,
            waiting_for_approval,
            verification_pending,
            data_change_requested,
            incomplete,
            discontinued,
            complete_data,
            mobile_nu_verified,
            data_confirmed_by_student
        )
        select 
            nber,
            academicyear,
            sum(total_students),
            sum(pending),
            sum(verified),
            sum(rejected),
            sum(total),
            sum(waiting_for_approval),
            sum(verification_pending),
            sum(data_change_requested),
            sum(incomplete),
            sum(discontinued),
            sum(complete_data),
            sum(mobile_nu_verified),
            sum(data_confirmed_by_student)
        from reportcandidatedataverifications
        group by academicyear, nber;
        
        */
        $report = Reportconsolidatedcdverification::all();
        return view('reports.consolidatedcdverification',compact('report'));
    }

    function institutedetails(){
        $report = Institute::where('active_status',1)->orderBy('rci_code')->get();
        return view('reports.institutedetails',compact('report'));
    }

    function attendancemarking(){
        /*
        delete from reportattendancemarkings;

        insert into reportattendancemarkings (
            examcenter,
            examcenter_name,
            sep_09_10_students, 
            sep_09_10_marked,
            sep_09_14_students,
            sep_09_14_marked,
            sep_10_10_students,
            sep_10_10_marked,
            sep_10_14_students,
            sep_10_14_marked,
            sep_17_10_students,
            sep_17_10_marked,
            sep_17_14_students,
            sep_17_14_marked,
            sep_24_10_students,
            sep_24_10_marked,
            sep_24_14_students,
            sep_24_14_marked,
            oct_01_10_students,
            oct_01_10_marked,
            oct_01_14_students,
            oct_01_14_marked,
            oct_08_10_students,
            oct_08_10_marked,
            oct_08_14_students,
            oct_08_14_marked,
            total_students,
            total_marked
        )
        select  
            ec.code, 
            ec.address,
            sum(if(tt.examdate= '2023-09-09' and tt.starttime ='10:00:00', 1,0)), 
            sum(if(tt.examdate= '2023-09-09' and tt.starttime ='10:00:00' and ca.externalattendance_id>0,1,0)) as attendance_marked,
            sum(if(tt.examdate= '2023-09-09' and tt.starttime ='14:00:00', 1,0)), 
            sum(if(tt.examdate= '2023-09-09' and tt.starttime ='14:00:00' and ca.externalattendance_id>0,1,0)) as attendance_marked,
            sum(if(tt.examdate= '2023-09-10' and tt.starttime ='10:00:00', 1,0)), 
            sum(if(tt.examdate= '2023-09-10' and tt.starttime ='10:00:00' and ca.externalattendance_id>0,1,0)) as attendance_marked,
            sum(if(tt.examdate= '2023-09-10' and tt.starttime ='14:00:00', 1,0)), 
            sum(if(tt.examdate= '2023-09-10' and tt.starttime ='14:00:00' and ca.externalattendance_id>0,1,0)) as attendance_marked,
            sum(if(tt.examdate= '2023-09-17' and tt.starttime ='10:00:00', 1,0)), 
            sum(if(tt.examdate= '2023-09-17' and tt.starttime ='10:00:00' and ca.externalattendance_id>0,1,0)) as attendance_marked,
            sum(if(tt.examdate= '2023-09-17' and tt.starttime ='14:00:00', 1,0)), 
            sum(if(tt.examdate= '2023-09-17' and tt.starttime ='14:00:00' and ca.externalattendance_id>0,1,0)) as attendance_marked,
            sum(if(tt.examdate= '2023-09-24' and tt.starttime ='10:00:00', 1,0)), 
            sum(if(tt.examdate= '2023-09-24' and tt.starttime ='10:00:00' and ca.externalattendance_id>0,1,0)) as attendance_marked,
            sum(if(tt.examdate= '2023-09-24' and tt.starttime ='14:00:00', 1,0)), 
            sum(if(tt.examdate= '2023-09-24' and tt.starttime ='14:00:00' and ca.externalattendance_id>0,1,0)) as attendance_marked,
            sum(if(tt.examdate= '2023-10-01' and tt.starttime ='10:00:00', 1,0)), 
            sum(if(tt.examdate= '2023-10-01' and tt.starttime ='10:00:00' and ca.externalattendance_id>0,1,0)) as attendance_marked,
            sum(if(tt.examdate= '2023-10-01' and tt.starttime ='14:00:00', 1,0)), 
            sum(if(tt.examdate= '2023-10-01' and tt.starttime ='14:00:00' and ca.externalattendance_id>0,1,0)) as attendance_marked,
            sum(if(tt.examdate= '2023-10-08' and tt.starttime ='10:00:00', 1,0)), 
            sum(if(tt.examdate= '2023-10-08' and tt.starttime ='10:00:00' and ca.externalattendance_id>0,1,0)) as attendance_marked,
            sum(if(tt.examdate= '2023-10-08' and tt.starttime ='14:00:00', 1,0)), 
            sum(if(tt.examdate= '2023-10-08' and tt.starttime ='14:00:00' and ca.externalattendance_id>0,1,0)) as attendance_marked,
            count(*),
            sum(if(ca.externalattendance_id>0,1,0))
        from currentapplications ca
        left join subjects s on s.id = ca.subject_id
        left join examtimetables tt on tt.subject_id = s.id
        left join approvedprogrammes ap on ap.id = ca.approvedprogramme_id
        left join programmes p on p.id = ap.programme_id
        left join nbers n on n.id = p.nber_id
        left join institutes i on i.id = ap.institute_id
        left join externalexamcenters ec on ec.id = i.externalexamcenter_id
        group by i.externalexamcenter_id;
        */
        $report = Reportattendancemarking::all();
        return view('reports.attendancemarking',compact('report'));
    }

    public function candidateattendanceandmark(Request $r){
        /*
        delete from reportcandidateattendanceandmarks;
        insert into reportcandidateattendanceandmarks (
            approvedprogramme_id,
            nber,
            institute,
            programme,
            batch ,
            count_of_applications
        )
        select ca.approvedprogramme_id, n.name_code, i.rci_code, p.abbreviation, y.year, count(distinct ca.candidate_id) from currentapplications ca
        left join approvedprogrammes ap on ap.id = ca.approvedprogramme_id
        left join programmes p on p.id  = ap.programme_id
        left join nbers n on n.id = p.nber_id
        left join institutes i on i.id = ap.institute_id
        left join academicyears y on y.id = ap.academicyear_id
        group by ca.approvedprogramme_id;

        update reportcandidateattendanceandmarks ram
        left join(
        select 
            ap.id as apid, 
            sum(if(a.`attendance_t` is not null,1,0)) as attendance_t,
            sum(if(a.`attendance_t` < 75,1,0)) as attendance_t_less,
            sum(if(a.`attendance_p` is not null,1,0)) as attendance_p,
            sum(if(a.`attendance_p` <75,1,0)) as attendance_p_less
        from attendances a
        left join candidates c on c.id = a.candidate_id
        left join approvedprogrammes ap on ap.id= c.approvedprogramme_id
        left join currentapplications ca on ca.candidate_id = a.candidate_id
        where ap.id is not null ca.candidate_id is not null
        group by ap.id
        ) as attendance on ram.`approvedprogramme_id` = attendance.apid
        set 
            ram.`attendance_marked_t` = attendance.`attendance_t`,
            ram.`attendance_marked_t_less` = attendance.`attendance_t_less`,
            ram.`attendance_marked_p` = attendance.`attendance_p`,
            ram.`attendance_marked_p_less` = attendance.`attendance_p_less`;

        update reportcandidateattendanceandmarks ram
        left join(
        select 
            ca.approvedprogramme_id as apid, 
            count(ca.id) as no_of_papers,
            sum(if(s.subjecttype_id=1,1,0)) as no_of_theory_papers, 
            sum(if(s.subjecttype_id=2,1,0)) as no_of_practical_papers, 
            sum(if(s.subjecttype_id =1 and ca.`internal_mark` is not null and ca.`internalattendance_id` > 0, 1, 0)) as internal_practical,
            sum(if(s.subjecttype_id =2 and ca.`internal_mark` is not null and ca.`internalattendance_id` > 0, 1, 0)) as internal_theory,
            sum(if(s.subjecttype_id =2 and ca.`external_mark` is not null and ca.`externalattendance_id` > 0, 1, 0)) as external_practical
        from currentapplications ca 
        left join subjects s on s.id = ca.subject_id 
        group by ca.approvedprogramme_id
        ) as marks on marks.apid = ram.approvedprogramme_id
        set 
            ram.`internal_practical` = marks.internal_practical,
            ram.`internal_theory` = marks.internal_theory,
            ram.external_practical = marks.external_practical,
            ram.`no_of_papers` = marks.no_of_papers,
            ram.`no_of_theory_papers` = marks.no_of_theory_papers,
            ram.`no_of_practical_papers` = marks.no_of_practical_papers;

        update reportcandidateattendanceandmarks ram
        left join 
        (select 
            approvedprogramme_id as apid,
            if(internal_theory is null,0,1) as internal_theory , 
            if(internal_practical is null,0,1) as internal_practical , 
            if(external_practical is null,0,1) as external_practical 
        from markentries m ) as me on me.apid = ram.`approvedprogramme_id`
        set 
            ram.`doc_internal_theory` = me.internal_theory,
            ram.`doc_internal_practical` = me.internal_practical,
            ram.`doc_external_practical` = me.external_practical;
        update reportcandidateattendanceandmarks ram
        left join 
        (select 
            ap.id as apid, 
            if(a.document_t is null,0,1) as document_t , 
            if(a.document_p is null,0,1) as document_p 
        from attendances a
        left join candidates c on c.id = a.candidate_id
        left join approvedprogrammes ap on ap.id = c.approvedprogramme_id
        where ap.id is not null
        group by ap.id) as attn on attn.apid = ram.`approvedprogramme_id`
        set 
            ram.`doc_attendnace_p` = attn.`document_p`,
            ram.`doc_attendnace_t` = attn.`document_t`;

        */
        $nber_id = 0;
        if($r->has('nber_id') && $r->nber_id != 0){
            $nber = \App\Nber::find($r->nber_id);
            $report = Reportcandidateattendanceandmark::where('nber',$nber->name_code)->orderBy('institute')->orderBy('programme')->orderBy('batch')->get();
            $nber_id = $r->nber_id;
        }else{
            $report = Reportcandidateattendanceandmark::orderBy('institute')->orderBy('nber')->orderBy('programme')->orderBy('batch')->get();
        }
        $nbers = \App\Nber::all();
        return view('reports.candidateattendanceandmark',compact('report','nbers','nber_id'));
    }
    public function faculties(){
        $institutes = Institute::where('id','!=',1004)->get();
        $faculty_count = Faculty::where('institute_id','!=',1004)->count();
        return view('reports.faculties',compact('institutes','faculty_count'));
    }
    public function enrolmentfeedetails(Request $r){
        /*
        delete from reportenrolmentfeedetails;
        insert into reportenrolmentfeedetails (payment_date, rci_code, institute, nber, amount)
        select o.`payment_date`, i.rci_code, i.name,  n.name_code, o.`actual_amount` from orders o
        left join `enrolmentfeepayment_order` afo on afo.`order_id` = o.id
        left join enrolmentfeepayments af on afo.enrolmentfeepayment_id = af.id
        left join institutes i on i.id = af.`institute_id`
        left join nbers n on n.id = af.nber_id
        where `payment_remarks` ='Enrolment Fee' and i.id != 1004 and o.order_status ='Success';
        */
        $nber_id = 0;
        if($r->has('nber_id') && $r->nber_id != 0){
            $nber = \App\Nber::find($r->nber_id);
            $report = Reportenrolmentfeedetail::where('nber',$nber->name_code)->get();
            $nber_id = $r->nber_id;
        }else{
            
            $report = Reportenrolmentfeedetail::all();
        }
        $nbers = \App\Nber::all();
        return view('reports.enrolmentfeedetails',compact('report','nber_id','nbers'));
    }
}
