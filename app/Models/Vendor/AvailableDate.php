<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableDate extends Model
{
    use HasFactory;

    protected $table = "available_dates";

    protected $fillable = ['vendor_id', 'service_id', 'available_date', 'total_quantity', 'remain_quantity', 'status'];
}
