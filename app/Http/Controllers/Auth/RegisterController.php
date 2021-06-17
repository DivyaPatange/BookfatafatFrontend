<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $otp = mt_rand(1000,9999);
        return $otp;
        // $user = User::where('mobile_no', $data['mobile_no'])->first();
        // if(empty($user)){
        //     $createUser = User::create([
        //         'name' => $data['name'],
        //         'email' => $data['email'],
        //         'password' => Hash::make($data['password']),
        //         'mobile_no' => $data['mobile_no'],
        //         'otp' => $otp,
        //     ]);
        //     $message = "Dear+Customer,+please+use+the+code+".$createUser->otp."+to+verify+your+bookfatafat+account.";
        //     $number = $createUser->mobile_no;
        //     $this->sendSms($message,$number);
        //     return response()->json(['success' => 'Registered Successfully!', 'mobile_no' => $createUser->mobile_no]);
        // }
        // else{
        //     if($user->verified == 1)
        //     {
        //         return response()->json(['error' => 'Mobile No. is already registered']);
        //     }
        //     else{
        //         $message = "Dear+Customer,+please+use+the+code+".$user->otp."+to+verify+your+bookfatafat+account.";
        //         $number = $user->mobile_no;
        //         $this->sendSms($message,$number);
        //         return response()->json(['success' => 'Verify Your Account!', 'mobile_no' => $user->mobile_no]);
        //     }
        // }
    }

    public function submitRegisterForm(Request $request)
    {
        $otp = mt_rand(1000,9999);
        // return $otp;
        $user = User::where('mobile_no', $request->mobile_no)->first();
        if(empty($user)){
            $createUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'mobile_no' => $request->mobile_no,
                'otp' => $otp,
            ]);
            $message = "Dear+Customer,+please+use+the+code+".$createUser->otp."+to+verify+your+bookfatafat+account.";
            $number = $createUser->mobile_no;
            $this->sendSms($message,$number);
            return response()->json(['success' => 'Registered Successfully!', 'mobile_no' => $createUser->mobile_no]);
        }
        else{
            if($user->verified == 1)
            {
                return response()->json(['error' => 'Mobile No. is already registered']);
            }
            else{
                $message = "Dear+Customer,+please+use+the+code+".$user->otp."+to+verify+your+bookfatafat+account.";
                $number = $user->mobile_no;
                // $this->sendSms($message,$number);
                return response()->json(['success' => 'Verify Your Account!', 'mobile_no' => $user->mobile_no]);
            }
        }
    }

    public function sendSms($message,$number)
    {
        $url = 'http://sms.bulksmsind.in/sendSMS?username=iceico&message='.$message.'&sendername=ICEICO&smstype=TRANS&numbers='.$number.'&apikey=24ae8ae0-b514-499b-8baf-51d55808a2c4';

        $ch = curl_init();  
        
    
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        curl_setopt($ch,CURLOPT_HEADER, false);
    
        $output=curl_exec($ch);
    
        curl_close($ch);
    
        return $output;
    }

    public function submitOtpForm(Request $request)
    {
        $user = User::where('mobile_no', $request->mobile_no)->where('otp', $request->otp)->first();
        if(!empty($user))
        {
            $result = User::where('mobile_no', $request->mobile_no)->where('otp', $request->otp)->update(['verified' => 1]);
            if(!empty($result))
            {
                if($result == 1)
                {  
                    Auth::login($user);
                    return response()->json(['success' => 'Mobile No. is Verified.']);
                }
                else{
                    return response()->json(['error' => 'Error! Something Went Wrong!']);
                }
            }
            else{
                return response()->json(['error' => 'Invalid OTP.']);
            }
        }
    }
}
