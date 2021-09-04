<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function index(){
        return view('auth.forgot-password');
    }

    public function searchMobile(Request $request)
    {
        $user = User::where('mobile_no', $request->mobile)->first();
        if (!empty($user)) {
            return response()->json(['success' => 'Please set new password.', 'mobile_no' => $request->mobile]);
        } else {
            return response()->json(['error' => 'Mobile no. not exist.']);
        }
    }

    public function savePwd(Request $request)
    {
        $user = User::where('mobile_no', $request->mobile_no)->first();
        if (!empty($user)) {
            $result = User::where('mobile_no', $request->mobile_no)->update(['password' => Hash::make($request->new_pwd)]);
            return response()->json(['success' => 'Password Reset Successfully! Please Login now.']);
        } else {
            return response()->json(['error' => 'Password Reset failed. Something went wrong!']);
        }
    }
}
