<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Service;
use App\Models\Admin\Vendor;
use Illuminate\Support\Facades\Hash;

class VendorRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:vendor')->except('logout');
    }

    public function showRegisterForm()
    {
        $services = Service::where('status', 'Active')->get();
        return view('vendor.register', compact('services'));
    }

    public function register(Request $request)
    {
        $vendor = new Vendor();
        $vendor->business_owner_name = $request->owner_name;
        $vendor->business_name = $request->busi_name;
        $vendor->business_type = $request->busi_type;
        $vendor->business_start_date = $request->busi_start_date;
        $vendor->location = $request->busi_location;
        $vendor->address = $request->busi_address;
        $vendor->gst_no = $request->gst_no;
        $vendor->services = implode(",", $request->service);
        $image = $request->file('aadhar_img');
        // dd($request->file('photo'));
        if($image != '')
        {
            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('AadharImg'), $image_name);
            $vendor->aadhar_img =$image_name;
        }
        $image1 = $request->file('pan_img');
        // dd($request->file('photo'));
        if($image1 != '')
        {
            $image_name1 = rand() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('PanImg'), $image_name1);
            $vendor->pan_img =$image_name1;
        }
        $image2 = $request->file('shop_img');
        // dd($request->file('photo'));
        if($image2 != '')
        {
            $image_name2 = rand() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('ShopImg'), $image_name2);
            $vendor->shop_img =$image_name2;
        }
        $vendor->password = Hash::make($request->password);
        $vendor->show_pwd = $request->password;
        $id = mt_rand(10000,99999);
        $vendor->username = "ABC".$id;
        $vendor->save();
        return redirect('/vendors/login')->with('success', 'Vendor Registered Successfully!');
    }
}
