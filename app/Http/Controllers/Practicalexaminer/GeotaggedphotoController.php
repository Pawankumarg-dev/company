<?php

namespace App\Http\Controllers\Practicalexaminer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\Exam\GeotaggedphotouploadService;


use App\Http\Requests;

class GeotaggedphotoController extends Controller
{
    private $helperService;
    private $gtService;

    public function __construct(HelperService $help,GeotaggedphotouploadService $gt)
    {
        $this->middleware(['role:faculty']);
        $this->helperService = $help;
        $this->gtService = $gt;
    }
    public function store(Request $r){
       // return "Closed";
       //$practicalexaminer_id = $this->helperService->getPracticalExaminerID();

    //    if($practicalexaminer_id != 1894){
    //     return redirect('/logoff');
    //     }
        $this->gtService->uploadphoto($r);
        return back();
    }
}
