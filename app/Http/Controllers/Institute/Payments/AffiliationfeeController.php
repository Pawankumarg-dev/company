<?php

namespace App\Http\Controllers\Institute\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use Session;

use App\Services\Payments\PaymentService;

use App\Http\Requests;

class AffiliationfeeController extends Controller
{
    private $helperService;
    private $paymentService;

    public function __construct(HelperService $help)
    {
        $this->middleware(['role:institute']);
        $this->helperService = $help;
        $this->paymentService = new PaymentService('affiliation',$this->helperService->getInstituteID(),$this->helperService->getAcademicYearID());
    }

    public function index(){
        $affiliationfee = $this->paymentService->getRecord();
        $academicyear = $this->helperService->getAcademicYear();
        $institute = $this->helperService->getInstitute();
        return view('institute.incidentalpayments.showdetails', compact('academicyear','institute','affiliationfee'));
    }

    public function update(Request $r){
        return $this->paymentService->createRequest();

    }


}