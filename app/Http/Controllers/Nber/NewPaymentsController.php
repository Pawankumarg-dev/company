<?php

namespace App\Http\Controllers\Nber;

use App\Academicyear;
use App\Enrolmentfee;
use App\Enrolmentpayment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NewPaymentsController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index() {
        return view('nber.newpayments.index');
    }

    public function enrolmentpayment() {

        $year_ids = Enrolmentfee::groupBy('academicyear_id')->pluck('academicyear_id')->toArray();
        $academicyear_ids = Academicyear::whereIn('id', $year_ids)->pluck('year')->toArray();

        return view('nber.newpayments.enrolment.index');
    }
}
