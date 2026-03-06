<?php

namespace App\Http\Controllers\Expert;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //
    public function index() {
        return view('expert.index');
    }

    public function register() {

    }
}
