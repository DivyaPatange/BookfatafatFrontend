<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = "services";

    protected $fillable = ['vendor_id', 'category_id', 'sub_category_id', 'service_name', 'service_img', 'service_cost', 'quantity'];
}
