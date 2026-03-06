<?php

namespace App\Http\Controllers\Nber;

use App\Institute;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InstituteInformationController extends Controller
{
    //
    public function instituteProfile($institueId) {
        $institute = Institute::find($institueId);

        return view('nber.institutes.institute_profile', compact('institute'));
    }

    public function updateProfile(Request $request) {
        $institute = Institute::find($request->instituteId);

        $institute->user->update([
            "username" => $request->instituteCode,
            "password" => bcrypt($request->institutePassword),
            "confirmation_code" => $request->institutePassword
        ]);

        $institute->update([
            "code" => $request->instituteCode,
            "name" => $request->instituteName,
        ]);

        return redirect('nber/institute/profile/'.$institute->id)->with(["message" => "Profile Updated"]);
    }
}
