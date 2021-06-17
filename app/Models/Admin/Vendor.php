<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $table = "vendors";

    protected $fillable = ['business_owner_name', 'business_name', 'business_type', 'business_start_date', 'location', 'address', 'gst_no',
    'aadhar_img', 'pan_img', 'shop_img', 'username', 'password', 'show_pwd'];
}
