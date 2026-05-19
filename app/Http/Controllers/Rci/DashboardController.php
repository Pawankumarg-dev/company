<?php

namespace App\Http\Controllers\Rci;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\Approvedprogramme;
use App\Candidate;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:rci']);
    }
//     public function index(){
//         $aps = \App\Approvedprogramme::where('academicyear_id','>',7)->where('academicyear_id','!=',11)->get();
       
// /*        foreach($aps as $ap){
//             $ap->registered_count = $ap->candidates->count();
//             $ap->save();
//         } */
//         return view('rci.dashboard.index');
//     }

public function index()
    {
        $academicYearId = Session::get('academicyear_id');

        /*
        |--------------------------------------------------------------------------
        | Load everything at once
        |--------------------------------------------------------------------------
        */
        $approvedprogrammes = Approvedprogramme::with([
            'programme.nber',
            'candidates'
        ])
        ->where('academicyear_id', $academicYearId)
        ->get();

        /*
        |--------------------------------------------------------------------------
        | NBER Wise Data
        |--------------------------------------------------------------------------
        */
        $nberData = [];

        foreach ($approvedprogrammes as $ap) {

            if (!$ap->programme || !$ap->programme->nber) {
                continue;
            }

            $nberId = $ap->programme->nber->id;
            $nberName = $ap->programme->nber->name_code;

            if (!isset($nberData[$nberId])) {

                $nberData[$nberId] = [
                    'name' => $nberName,
                    'applications' => 0,
                    'not_verified' => 0,
                    'verified' => 0,
                    'correction_required' => 0,
                    'incomplete' => 0,
                    'rejected' => 0,
                ];
            }

            $candidates = $ap->candidates;

            $nberData[$nberId]['applications'] += $candidates->count();

            /*
            |--------------------------------------------------------------------------
            | Candidate Status Counts
            |--------------------------------------------------------------------------
            |
            | Change field names according to your table structure
            |
            */

            $nberData[$nberId]['not_verified'] += $candidates
                ->where('is_verified', 0)
                ->count();

            $nberData[$nberId]['verified'] += $candidates
                ->where('status', 'verified')
                ->count();

            $nberData[$nberId]['correction_required'] += $candidates
                ->where('status', 'pending')
                ->count();

            $nberData[$nberId]['incomplete'] += $candidates
                ->where('status', 'incomplete')
                ->count();

            $nberData[$nberId]['rejected'] += $candidates
                ->where('status', 'rejected')
                ->count();
        }

        /*
        |--------------------------------------------------------------------------
        | Course Admissions Data
        |--------------------------------------------------------------------------
        */
        $programmeData = [];

        foreach ($approvedprogrammes as $ap) {

            if (!$ap->programme) {
                continue;
            }

            $programmeId = $ap->programme->id;

            if (!isset($programmeData[$programmeId])) {

                $programmeData[$programmeId] = [
                    'programme' => $ap->programme->name,
                    'abbreviation' => $ap->programme->course_name,
                    'nber' => $ap->programme->nber->name_code ?? '',
                    'max_intake' => 0,
                    'applications' => 0,
                ];
            }

            $programmeData[$programmeId]['max_intake'] += $ap->maxintake;

            $programmeData[$programmeId]['applications'] += $ap->candidates->count();
        }

        return view(
            'rci.dashboard.index',
            compact('nberData', 'programmeData')
        );
    }

    public function print(){
        return view('rci.dashboard.print');
    }
    public function intake(){
        return view('rci.reports.intake');
    }
    public function sms(){
        $approvedprogrammes   = Approvedprogramme::where('academicyear_id',11)->pluck('id');
        $candidates = Candidate::whereIn('approvedprogramme_id',$approvedprogrammes)->paginate(2000);
        
        return view('rci.master.sms',compact('candidates'));
    }
    public function issues(){
        return view('rci.issues.index');
    }
}
