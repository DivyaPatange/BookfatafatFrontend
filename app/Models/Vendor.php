<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Vendor extends Authenticatable
{
    use Notifiable;

    protected $guard = 'vendor';
    protected $table = "vendors";

    protected $fillable = [
        'business_owner_name', 'business_name', 'business_type', 'business_start_date', 'location', 'address', 'gst_no',
        'aadhar_img', 'pan_img', 'shop_img', 'username', 'password', 'show_pwd'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
