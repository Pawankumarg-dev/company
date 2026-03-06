<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\LocateInstitute\LocateInstituteService;


use App\Http\Requests;



use Session;

class InstituteController extends Controller
{

    private $locationService;

    public function __construct(Request $r) {

        $this->locationService = new LocateInstituteService($r);
    
    }

    public function index(){
        $selected =  $this->locationService->getSelected();
        $dropdowndata = $this->locationService->getDropdownData();
        $data = $this->locationService->getData();
        return view('public.listinstitutes.index',compact(
            'selected',
            'dropdowndata',
            'data'
        ));

    }
}
