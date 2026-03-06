<?php

namespace App\Http\Controllers\Examinerexpert;

use App\City;
use App\Examinerexperttype;
use App\Gender;
use App\Language;
use App\Paymentbank;
use App\Relationtype;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //
    public function index() {
        return view('examinerexperts.index');
    }

    public function register() {
        $relationtypes = Relationtype::all();
        $genders = Gender::all();
        $cities = City::all();
        $paymentbanks = Paymentbank::orderBy('bankname')->get();
        $languages = Language::orderBy('language')->get();
        $examinerexperttypes = Examinerexperttype::all();

        return view('examinerexperts.register', compact('relationtypes', 'genders', 'cities',
            'paymentbanks', 'languages', 'examinerexperttypes'));
    }
}
