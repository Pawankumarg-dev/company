<?php

namespace App\Http\Controllers\Evaluationcenter;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //
    protected $code = 'code';

    protected $redirectTo = '/evaluationcenter';

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function guard()
    {
        return Auth::guard('evaluationcenteruser');
    }

    // login from for teacher
    public function index()
    {
        return view('auth.evaluationcenterlogin');
    }
}
