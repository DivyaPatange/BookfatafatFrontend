<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function submitLoginForm(Request $request)
    {
        $finduser = User::where('mobile_no', $request->mobile_no)->first();
        if($finduser){
            if($finduser->verified == 1)
            {
                Auth::login($finduser);
                return response()->json(['success' => 'Successfully Login!']);
            }
            else{
                return response()->json(['success' => 'Your mobile no. is not verified.']);
            }
        } 
        else{
            return response()->json(['error' => 'Error! Something Went Wrong']);
        }
    }
}
