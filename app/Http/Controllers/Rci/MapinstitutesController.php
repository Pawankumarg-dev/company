<?php 
    namespace App\Http\Controllers\Rci;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use App\Services\DBService;

    use Session;

    class MapinstitutesController extends Controller{
        private $institutes ;
        private $examcenters;
        private $filter;
        private $status;
        private $ecstatus;
        private $allinstitutes;
        private $districtinstitutes;
        private $allexamcenters;
        private $districtexamcenters;
        private $exam_id;
        public function __construct()
        {
           $this->middleware(['role:nber']);
            $this->institutes = app()->request->has('institutes') ? app()->request->institutes : 'all';
            $this->examcenters = app()->request->has('examcenters') ? app()->request->examcenters : 'all';
            $this->filter = app()->request->has('filter') ? app()->request->filter : 'all';
            $this->status = app()->request->has('status') ? app()->request->status : 'all';
            $this->ecstatus = app()->request->has('ecstatus') ? app()->request->ecstatus : 'all';
            $this->exam_id = Session::get('exam_id');
        }

        public function filterExamCenters(){
            if($this->examcenters == 'all'){ 
                return $this->getExamCenterSQL(
                    "concat(d.districtName, ' - ', ec.id, ' - ',  ec.name, ' - uploaded By: '  , i.rci_code) ",
                    " ec.id "
                );
            }
            
            if($this->examcenters == 'districts'){ 
                return $this->getExamCenterSQL(
                    "concat(d.districtName, ' - No of EC: ', count(distinct ec.id) , '- No of Students:  ', count(distinct a.candidate_id)) ",
                    " d.id "
                );
            }

            if($this->examcenters == 'states'){
                return  $this->getExamCenterSQL(
                    "concat(d.districtName, ' - No of EC: ', count(distinct ec.id) , '- No of Students:  ', count(distinct a.candidate_id)) ",
                    " s.id "
                );
            }
        }
        public function index(Request $r)
        {
            $sp = '';
            if($this->institutes != 'none'){
                $sp = "getPivotDataOfStudentExamApplications(".$this->exam_id.",'".$this->institutes."','".$this->filter."','".$this->status."')";
                $instituteList  = (new DBService)->callSP($sp);
            }else{
                $instituteList = null;
            }
            if($this->examcenters != 'none'){
                $sp = "getPivotDataOfStudentExamCenters(".$this->exam_id.",'".$this->examcenters."','".$this->filter."','".$this->ecstatus."')";
                $examcenterList  = (new DBService)->callSP($sp);
            }else{
                $examcenterList = null;
            }
            
            $institutes = $this->institutes;
            $examcenters = $this->examcenters;
            $filter = $this->filter;
            $status = $this->status;
            $ecstatus = $this->ecstatus;

            return view('rci.mapinstitutes.index',compact(
                'instituteList','examcenterList','institutes','examcenters','filter','status','ecstatus'
            ));
        }

        public function getExamCenterSQL($text,$groupby){
            return "

           
	select 
                    ".$text."  as text,
                    ec.latitude,
                    ec.longitude
                from allapplicants a
                    left join candidates c on c.id = a.candidate_id
                    left join approvedprogrammes ap on ap.id = c.approvedprogramme_id
                    left join institutes i on i.id = ap.institute_id
                    left join districts d on d.id = i.district_id
                    left join lgstates s on s.id = i.state_id 
                    inner join externalexamcenters ec on ec.district  = d.id  and ec.institute_id is not null
										group by ".$groupby." ;  
            ";
        }

    }
    ?>