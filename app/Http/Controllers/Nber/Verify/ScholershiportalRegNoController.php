<?php

namespace App\Http\Controllers\Nber\Verify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\HelperService;
use App\Services\NSPRegNo\NSPRegNo;
use App\Services\Common\Downloadable;


use DB;


class ScholershiportalRegNoController extends Controller
{
    private $helperService;

    public function __construct(HelperService $help)
    {
       $this->middleware(['role:nber']);
        $this->helperService = $help;
    }
    public function index(Request $r){
      $type = $r->has('type') ? $r->type : 'all';
      $forms =  (new NSPRegNo($this->helperService->getNberORRCIID(),$type));
      $results = $forms->getInstitutes();
      $title = $forms->getTitle();
      $type = $forms->getType($r);
      return (new Downloadable('nber/verify','nsp',compact(
        'results',
        'title',
        'type'
      ),$title))->load();
    }
}
