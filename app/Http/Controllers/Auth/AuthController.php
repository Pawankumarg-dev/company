<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Session;
class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Username field for login instead of email.
     *
     * @var string
     */
    protected $username = 'username';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {


    

    // $blockedIps = ['103.153.58.147'];

    // if (in_array($request->ip(), $blockedIps)) {
    //     return response('Access Denied', 403);
    // }





        $tab = $request->input('tab'); // 'student', 'institute', etc.
        $userInput = $request->input('captcha');

        $sessionCode = Session::get("captcha_code_$tab");        
        if (!$sessionCode || strtolower($userInput) !== strtolower($sessionCode)) {
             return back()->with('error', 'Invalid CAPTCHA');
        }

        
        \App\LoginAttempt::create([
        'user_name' => $request->username,  // No user ID on failed attempt
        'ip_address' => $request->ip(),
        'user_agent' => $request->header('User-Agent'),
    ]);






        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'username' => 'Invalid username or password.',
            ])->withInput($request->only('username'));
        }

        Auth::login($user);
        return redirect()->intended($this->redirectTo);
    }

    

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'captcha' => 'required|captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }



    public function captcha(Request $request){
    
    $tab = $request->query('tab', 'default'); 
    Session::forget("captcha_code_$tab");
    $code = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 5);
    Session::put("captcha_code_$tab", $code);
    $image = imagecreate(120, 35);
    $background_color = imagecolorallocate($image, 51, 122, 185); 
    $text_color = imagecolorallocate($image, 255, 255, 255);
    imagestring($image, 5, 30, 10, $code, $text_color);
    ob_start();
    imagepng($image);
    $imageData = ob_get_clean();

    return response($imageData)->header('Content-Type', 'image/png');
    
    }
}
