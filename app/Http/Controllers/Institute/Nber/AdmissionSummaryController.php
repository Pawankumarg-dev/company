<?php

namespace App\Http\Controllers\Nber;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;

use DB;
use App\Http\Requests;

class AdmissionSummaryController extends Controller
{
    private $helperService;

    public function __construct(HelperService $help)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $help;
    }
    public function index(Request $r){
        $nber_id = $this->helperService->getNberID();
        $sql = '
        select ap.id, i.rci_code, i.name, p.abbreviation, ap.`maxintake` , count(c.id) as enrolled from approvedprogrammes ap
        left join institutes i on i.id = ap.institute_id
        left join programmes p on p.id = ap.programme_id
        left join candidates c on c.approvedprogramme_id = ap.id
        where p.nber_id = '. $nber_id.'  and ap.academicyear_id = 12
        group by ap.id order by i.id
        ';
        $result  = DB::select($sql);
        $summary = array_map(function ($value) {
            return (array)$value;
        }, $result); 
        
        return view('nber.admissionsummary.index',compact('summary'));
    }

  
}
