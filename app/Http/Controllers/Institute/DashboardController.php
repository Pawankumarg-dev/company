<?php

namespace App\Http\Controllers\Institute;

use App\Institutecertificateincharge;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Institute;
use App\Institutehead;
use App\Coursecoordinator;
use App\Institutefacility;
use App\City;
use Auth;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['role:institute']);
    }

    public function index() {
        $title = 'Institute - Dashboard';
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        $instituteheads = Institutehead::where('institute_id', $institute->id)->first();
        //$coursecoordinators = Coursecoordinator::where('institute_id', $institute->id)->get();
        $institutefacility = Institutefacility::where('institute_id', $institute->id)->first();
        $institutecertificateincharge = Institutecertificateincharge::where('institute_id', $institute->id)->first();

        if($institute->edit_status == '1') {
            return redirect('/institute/center-information');
        }
        else {
            return view('institute.dashboards.index', compact('title', 'institute', 'instituteheads', 'institutefacility', 'institutecertificateincharge'));
        }
    }

    public function homepage() {
        $title = 'Institute - Dashboard';
        $institute = Institute::where('user_id',Auth::user()->id)->first();

        if(is_null($institute)) {
            return redirect('/');
        }
        else {
            return view('institute.dashboards.home', compact('title', 'institute'));
        }
    }

}
