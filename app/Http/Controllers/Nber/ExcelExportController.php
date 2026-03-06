<?php

namespace App\Http\Controllers\Nber;

use App\Academicyear;
use App\Application;
use App\Programme;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExcelExportController extends Controller
{
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function export() {
        Excel::create('clients', function ($excel){
            $excel->sheet('clients', function ($sheet){
                $sheet->loadview('sample');
            });
        })->export('xlsx');
    }
}
